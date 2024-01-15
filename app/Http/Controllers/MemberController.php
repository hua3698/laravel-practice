<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Auth;
use Exception;
use stdClass;

class MemberController extends Controller
{
    const DATA_PER_PAGE = 5;
    const _HASNOT_SHOW_ = 0;
    const _NORMAL_ROLE_ = 'normal';
    const _ADMIN_ROLE_ = 'admin';

    public function showMemberList()
    {
        $users = User::paginate(self::DATA_PER_PAGE);

        $arrUsers = $users->toArray();

        $google2fa  = new Google2FA();

        foreach ($arrUsers['data'] as $key => $user) 
        {
            $role = $this->switchColumnName('role', $user['role']);
            $is_enable = $this->switchColumnName('is_qrcode_show', $user['is_qrcode_show']);

            $arrUsers['data'][$key]['role'] = $role;
            $arrUsers['data'][$key]['is_enable_qrcode'] = $is_enable;

        }

        $response = [];
        $response['list'] = $arrUsers['data'];
        $response['from'] = $arrUsers['from'];
        $response['total'] = $arrUsers['total'];
        $response['current_page'] = $arrUsers['current_page'];
        $response['last_page'] = $arrUsers['last_page'];

        return view('member.list', $response);
    }

    public function createMember(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|max:255',
            'role' => 'required|string'
        ]);

        $google2fa  = new Google2FA();
        $google2fa_key = $google2fa->generateSecretKey();

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => password_hash($validated['password'], PASSWORD_DEFAULT ),
            'google2fa_secret' => $google2fa_key,
            'is_qrcode_show' => self::_HASNOT_SHOW_,
            'role' => $validated['role']
        ]);

        $user->save();

        $re = [];
        $re['status'] = 'ok';

        return response($re, 201);
    }

    public function getMemberRightList()
    {
        $users = User::all();
        
        $arrUsers = $users->toArray();

        $response = [];
        $response['list'] = [];

        foreach ($arrUsers as $key => $user) {
            $data = [];

            $data['name'] = $user['name'];
            $data['email'] = $user['email'];
            $data['role'] = $user['role'];

            $response['list'][] = $data;
        }

        return view('member.right', $response);
    }

    public function modifyMemberRight(Request $request)
    {
        try
        {
            if(!$this->verifyUserRole()) {
                throw new Exception();
            } else {
                User::where('email', $request['email'])->update(['role' => $request['modify_role']]);
            }
        }
        catch (Exception $e)
        {
            abort(404);
        }
    }

    public function renewMemberKey()
    {
        $user = new User();

        $user->removeGoogleKeyALL();
        $user->generateGoogleKeyALL();
    }

    private function switchColumnName($column, $value)
    {
        $name = '';
        switch ($column) {
            case 'role':
                if($value == 'normal') {
                    $name = '一般使用者';
                } else {
                    $name = '管理員';
                }
                break;

            case 'is_qrcode_show':
                if($value == 1) {
                    $name = '已啟用';
                } else {
                    $name = '未啟用';
                }
            break;
        }
        return $name;
    }

    private function verifyUserRole()
    {
        $session_email = session()->get('email');

        $user = User::where('email', $session_email)->first();

        $user = $user->toArray();

        if($user['role'] == self::_ADMIN_ROLE_) {
            return true;
        } else {
            return false;
        }
    }
}
