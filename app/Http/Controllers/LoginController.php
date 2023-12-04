<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; //引入user model
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;

class LoginController extends Controller
{
    const ENABLE_MEMBER = 1;

    public function createAccount(request $request) {
        echo 'aaaaaaaaa';
    }

    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|max:255'
        ]);

        $google2fa  = new Google2FA();
        $google2fa_key = $google2fa->generateSecretKey();

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => password_hash($validated['password'], PASSWORD_DEFAULT ),
            'google2fa_secret' => $google2fa_key,
            'member_status' => self::ENABLE_MEMBER
        ]);

        $user->save();

        $qrcode_img = $google2fa->getQRCodeInline(
            $validated['name'],
            $validated['email'],
            $google2fa_key,
            200
        );

        $re = [];
        $re['status'] = 'ok';
        $re['qrcode_img'] = $qrcode_img;

        return response($re, 201);
        // return redirect()->back();
        // return redirect()->route('login');
    }

    public function signIn(Request $request)
    {
        try
        {
            $validated = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
                'google2fa_otp' => 'required|max:6'
            ]);

            if(!Auth::attempt(['name' => $validated['name'], 'password' => $validated['password']]))
            {
                throw new \Exception();
            }

            $User = User::where('name', $validated['name'])
                        ->first();

            $User = $User->toArray();
            $valid = $this->verifyGoogle2FA($User, $validated['google2fa_otp']);

            if($valid === false) {
                throw new \Exception();
            }

            session()->put('username', $request->name);
            
            return response('success', 200);
        }
        catch (\Exception $e) 
        {
            return response('login failed', 400);
        }
    }

    public function logout()
    {
        session()->forget('username');
        return redirect('/home');
    }

    private function verifyGoogle2FA($User, $otp) 
    {
        $secretKey = $User['google2fa_secret'];

        $google2fa  = new Google2FA();
        $window = 8;

        return $google2fa->verifyKey($secretKey, $otp, $window);
    }

}
