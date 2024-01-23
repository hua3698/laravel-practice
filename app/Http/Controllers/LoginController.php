<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; //引入user model
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;
use stdClass;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    const _WEBSITE_NAME_ = "管理後台";

    // create a new account
    public function signUp()
    {

    }

    // 驗證登入資訊
    public function signIn(Request $request)
    {
        try
        {
            $validated = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
                // 'google2fa_otp' => 'required|max:6'
            ]);

            if(!Auth::attempt(['name' => $validated['name'], 'password' => $validated['password']]))
            {
                throw new \Exception();
            }
            $User = User::where('name', $validated['name'])->first();

            $User = $User->toArray();

            $response = new stdClass();
            if($User['is_qrcode_show'] === 1) 
            {
                $response->show_div = 'otp';
            } 
            else 
            {
                $google2fa  = new Google2FA();
                $google2fa_key = $User['google2fa_secret'];

                $qrcode_img = $google2fa->getQRCodeInline(
                    $User['email'],
                    self::_WEBSITE_NAME_,
                    $google2fa_key,
                    200
                );

                $this->updateUserQrcode($User);

                $response->show_div = 'qrcode';
                $response->qrcode_img = $qrcode_img;

                session()->put('username', $request->name);
                session()->put('email', $User['email']);
                session()->put('role', $User['role']);

            }

            return response(json_encode($response), 200);
        }
        catch (\Exception $e) 
        {
            echo $e;
            // return response('login failed', 400);
        }
    }

    public function validOTP(Request $request) 
    {
        try
        {
            $validated = $request->validate([
                'name' => 'required|string',
                'otp' => 'required|max:6'
            ]);

            $User = User::where('name', $validated['name'])->first();

            $User = $User->toArray();

            $valid = $this->verifyGoogle2FA($User, $validated['otp']);

            if($valid === false) {
                throw new \Exception();
            }

            session()->put('username', $request->name);
            session()->put('email', $User['email']);
            session()->put('role', $User['role']);

            return response('ok', 200);
        }
        catch (\Exception $e) 
        {
            Log::error(sprintf('[%s] %s', __METHOD__, $e->getMessage()));
            return response('login failed', 400);
        }
    }

    public function checkIsLogin() {
        return view('login');
        
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

    private function updateUserQrcode ($User)
    {
        User::where('name', $User['name'])
                ->update(['is_qrcode_show' => 1]);
    }

}
