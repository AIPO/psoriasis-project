<?php

namespace App\Social;

use App\User;
use Laravel\Socialite\Facades\Socialite;

abstract class AbstractServiceProvider
{
    protected $provider;

    public function __construct()
    {
        $this->provider = Socialite::driver(
            str_replace(
                'serviceprovider', '', mb_strtolower((new \ReflectionClass($this))->getShortName())
            )
        );
    }

    protected function login($user)
    {
        auth()->login($user);
        return redirect()->intended('/');
    }

    protected function register(array $user)
    {
        $password = bcrypt(str_random(10));
        $newUser = User::create(array_merge($user, ['password' => $password]));
        return $newUser;
    }

    public function redirect()
    {
        return $this->provider->redirect();
    }

    abstract public function handle();
}