<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PragmaRX\Google2FAQRCode\Google2FA;

class MemberController extends Controller
{
    const DATA_PER_PAGE = 5;

    public function showMemberList()
    {
        $users = User::paginate(self::DATA_PER_PAGE);
        // ->get();

        $arrUsers = $users->toArray();

        $google2fa  = new Google2FA();

        foreach ($arrUsers['data'] as $key => $user) {
            $UserName = $user['name'];
            $UserEmail = $user['email'];
            $secretKey = $user['google2fa_secret'];

            $inlineUrl = $google2fa->getQRCodeInline(
                $UserName,
                $UserEmail,
                $secretKey,
                100
            );

            $arrUsers['data'][$key]['qrcode'] = $inlineUrl;
        }

        $response = [];
        $response['lists'] = $arrUsers['data'];
        $response['from'] = $arrUsers['from'];
        $response['total'] = $arrUsers['total'];
        $response['current_page'] = $arrUsers['current_page'];
        $response['last_page'] = $arrUsers['last_page'];

        return view('member', $response);
    }
}
