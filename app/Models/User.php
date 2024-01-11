<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DateTimeInterface;
use PragmaRX\Google2FAQRCode\Google2FA;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google2fa_secret',
        'is_qrcode_show',
        'member_status',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function removeGoogleKeyALL()
    {
        $array = [
            'google2fa_secret' => '', 
            'is_qrcode_show' => 0,
        ];

        return $this::query()->update($array);

    }

    public function generateGoogleKeyALL()
    {
        foreach ($this::all() as $user) {

            $google2fa  = new Google2FA();
            $google2fa_key = $google2fa->generateSecretKey();

            $user->update([
                'google2fa_secret' => $google2fa_key
            ]);
        }
    }
}
