<?php

namespace App\Services\Auth;

use App\Contracts\Abstracts\BaseService;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordService extends BaseService
{
    protected $repository;

    public function __construct()
    {
        // $this->repository
    }


    /**
     * @return string[]
     */
    public function getShowForgetPasswordData(): array
    {
        return [
            "title" => "Forgot Password"
        ];
    }


    /**
     * @param array $requestedData
     * @return true[]
     */
    public function requestForgotPassword(array $requestedData): array
    {
        try {
            $status = Password::sendResetLink($requestedData);
            if ($status !== Password::RESET_LINK_SENT) {
                return [
                    "success" => false,
                    "message" => __($status)
                ];
            }
            $response = [
                "success" => true
            ];
        } catch (Exception $e) {
            $response = getDefaultErrorResponse($e);
        }

        return $response;
    }

    /**
     * @return string[]
     */
    public function getResetPasswordData(): array
    {
        return [
            "title" => "Reset Password"
        ];
    }

    /**
     * @return true[]
     */
    public function resetPassword(array $requestedData):array
    {
        try{
            $response = [
                "success" => true
            ];

            $status = Password::reset(
                $requestedData,
                function (User $user, string $password){
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status !== Password::PASSWORD_RESET) {
                return [
                    "success" => false,
                    "message" => __($status),
                ];
            }
        }catch(Exception $e){
            $response = getDefaultErrorResponse($e);
        }

        return $response;
    }
}
