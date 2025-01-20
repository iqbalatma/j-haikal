<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\ForgotPasswordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForgotPasswordController extends Controller
{

    /**
     * @param ForgotPasswordService $service
     * @return Response
     */
    public function showForgotPassword(ForgotPasswordService $service): Response
    {
        viewShare($service->getShowForgetPasswordData());
        return response()->view("auth.forgot-password.show-forgot-password");
    }


    /**
     * @param ForgotPasswordService $service
     * @param ForgotPasswordRequest $request
     * @return RedirectResponse
     */
    public function requestForgotPassword(ForgotPasswordService $service, ForgotPasswordRequest $request): RedirectResponse
    {
        $response = $service->requestForgotPassword($request->validated());
        if ($this->isError($response)) return $this->getErrorResponse();

        return redirect()->route("login")->with("success", "Your reset password link has been sent to your email");
    }


    /**
     * @param ForgotPasswordService $service
     * @param string $email
     * @param string $token
     * @return Response
     */
    public function showResetPassword(ForgotPasswordService $service, string $email, string $token): Response
    {
        viewShare(array_merge($service->getResetPasswordData(), [
            "email" => $email,
            "token" => $token,
        ]));
        return response()->view("auth.forgot-password.show-reset-password");
    }


    /**
     * @param ForgotPasswordService $service
     * @param ResetPasswordRequest $request
     * @return RedirectResponse
     */
    public function resetPassword(ForgotPasswordService $service, ResetPasswordRequest $request): RedirectResponse
    {
        $response = $service->resetPassword($request->validated());

        if ($this->isError($response)) return $this->getErrorResponse();

        return redirect()->route("login")->with("success", "Reset password successfully, please login using your new password");
    }
}
