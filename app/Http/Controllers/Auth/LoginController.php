<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\MarketService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Exception\ClientException;
use App\Services\MarketAuthenticationService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $marketAuthenticationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MarketAuthenticationService $marketAuthenticationService, MarketService $marketService)
    {
        $this->middleware('guest')->except('logout');
        $this->marketAuthenticationService = $marketAuthenticationService;
        parent::__construct($marketService);
    }

    public function showLoginForm()
    {
        $authorizationUrl = $this->marketAuthenticationService->resolveAuthorizationUrl();
        return view('auth.login')->with(['authorizationUrl' => $authorizationUrl]);
    }

    public function authorization(Request $request)
    {
        if($request->has('code'))
        {
            $tokenData = $this->marketAuthenticationService->getCodeToken($request->code);
            $userData = $this->marketService->getUserInformation();

            $user = $this->registerOrUpdateUser($userData, $tokenData);
            $this->loginUser($user);
            return redirect()->intended('home');
        }

        return redirect()->route('login')->withErrors(['Has cancelado el proceso de autorización']);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        try
        {
            $tokenData = $this->marketAuthenticationService->getPasswordToken($request->email, $request->password);
            $userData = $this->marketService->getUserInformation();

            $user = $this->registerOrUpdateUser($userData, $tokenData);
            $this->loginUser($user, $request->has('remember'));
            return redirect()->intended('home');
        }
        catch (ClientException $ex)
        {
            $message = $ex->getResponse()->getBody();
            // dd($ex->getMessage());
            if(Str::contains($message, 'invalid_credentials'))
            {
                $this->incrementLoginAttempts($request);
                return $this->sendFailedLoginResponse($request);
            }

            // throw $ex;
        }

    }

    public function registerOrUpdateUser($userData, $tokenData)
    {
        return User::updateOrCreate(['service_id' => $userData->identifier], [
            'grant_type' => $tokenData->grant_type,
            'access_token' => $tokenData->access_token,
            'refresh_token' => $tokenData->refresh_token,
            'token_expires_at' => $tokenData->token_expires_at
        ]);
    }

    public function loginUser(User $user, $remember = true)
    {
        Auth::login($user, $remember);
        session()->regenerate();
    }
}
