<?php

namespace App\Core;

use App\Models\UserModel;

trait Authenticator
{
    public function authenticate(): bool
    {
        return isset($_SESSION[KWRD_TOKEN]);
    }

    public function inside(): void
    {
        if (!$this->authenticate())
        {
            header('Location: /');
        }
    }

    public function setSession(UserModel $userModel): void
    {
        $_SESSION[KWRD_TOKEN] = random_bytes(12);
        $_SESSION[KWRD_USERID] = $userModel->getUserId();
        $_SESSION[KWRD_CURPLANET] = $userModel->getUserCurrentPlanetId();
    }

    public function logout(): void
    {
        $_SESSION[KWRD_TOKEN] = null;
        unset($_SESSION);
        session_destroy();
        header(sprintf('Location: %s', ROUTE_HOME));
    }
}