<?php

namespace App\Services\Auth;

use App\Contracts\Abstracts\BaseService;
use Illuminate\Support\Facades\Auth;

class AuthenticateService extends BaseService
{
    private bool $isRememberMe;
    /**
     * @return string[]
     */
    public function getLoginData(): array
    {
        return [
            "title" => "Login"
        ];
    }

    /**
     * @param array $requestedData
     * @return array
     */
    public function authenticate(array $requestedData): array
    {
        $this->checkRememberMe($requestedData);
        if (Auth::attempt($requestedData, $this->isRememberMe)) {
            request()->session()->regenerate();
            return ["success" => true];
        }

        return [
            "success" => false,
            "message" => "Email or password is invalid"
        ];
    }


    /**
     * @param array $requestedData
     * @return void
     */
    private function checkRememberMe(array &$requestedData): void
    {
        $this->isRememberMe = false;
        if (isset($requestedData["remember_me"]) && $requestedData["remember_me"] === "on") {
            $this->isRememberMe = true;
            unset($requestedData["remember_me"]);
        }
    }
}
