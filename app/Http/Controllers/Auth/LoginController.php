<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Session;

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
    //protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //dd($request->all());
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:bdm')->except('logout');
        $this->middleware('guest:lg')->except('logout');
    }
    #login for admin 
    public function showAdminLoginForm()
    {
       return view('auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
         //dd($request->email." ".$request->password);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            $request->session()->put('isAdmin', 'Admin');
            return redirect()->route('admin_dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    
    #login for BDM
    public function showBdmLoginForm()
    {
        return view('auth.login', ['url' => 'bdm']);
    }

    public function bdmLogin(Request $request)
    {
        //dd($request->email." --".$request->password);
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('bdm')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            $request->session()->put('isBdm', 'BDM');
            return redirect()->route('bdm_dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    #login for lg
    public function showLgLoginForm()
    {
        return view('auth.login', ['url' => 'lg']);
    }

    public function lgLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('lg')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
             
                $request->session()->put('isLg', 'Lg');
                // return redirect()->intended('/dashboard');
                return redirect()->route('lg_dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
}
