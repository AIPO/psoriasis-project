<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Social\FacebookServiceProvider;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Two\InvalidStateException;
use League\OAuth1\Client\Credentials\CredentialsException;

class SocialController extends Controller
{
    protected $providers = [
        'facebook' => FacebookServiceProvider::class,
    ];

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectToProvider($driver)
    {
        return (new $this->providers[$driver])->redirect();
    }

    public function handleProviderCallback($driver)
    {
        try {
            return (new $this->providers[$driver])->handle();
        } catch (InvalidStateException $e) {
            return $this->redirectToProvider($driver);
        } catch (ClientException $e) {
            return $this->redirectToProvider($driver);
        } catch (CredentialsException $e) {
            return $this->redirectToProvider($driver);
        }

    }
}
