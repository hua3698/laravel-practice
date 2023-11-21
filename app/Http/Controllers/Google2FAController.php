<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;

class Google2FAController extends Controller
{
    //
    
    public function Google2FA () {
        $google2fa  = new Google2FA();
        
        $companyName = 'a';
        $companyEmail = 'a';
        $secretKey = $google2fa->generateSecretKey();
    
        $inlineUrl = $google2fa->getQRCodeInline(
            $companyName,
            $companyEmail,
            $secretKey
        );
    dd($inlineUrl);
        return view('home', $inlineUrl);
    }

}
