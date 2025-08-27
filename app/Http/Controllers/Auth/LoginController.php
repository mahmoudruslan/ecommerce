<?php

namespace App\Http\Controllers\Auth;

use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;



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
    protected $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();
//        $cart = $request->session()->get('cart_cart_items');///
        $request->session()->invalidate();
        $request->session()->regenerateToken();
//        session()->put('cart_cart_items', $cart);///


        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->back();
    }

    public function showLoginForm()
    {
        return view('store.auth.login');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('store.auth.password_confirmed_at', time());
            }
            if(Auth::check()){
                $guestCart = \Cart::session('cart')->getContent();
                if ($guestCart->isNotEmpty()) {
                    foreach ($guestCart as $item) {
                        \Cart::session(Auth::id())->add([
                            'id' => $item->id,
                            'name' => $item->name,
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'attributes' => $item->attributes,
                            'associatedModel' => $item->associatedModel,
                        ]);
                    }
                    \Cart::session('cart')->clear();
                }
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('store.auth.failed')],
        ]);
    }
}
