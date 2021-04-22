<?php

namespace App\Http\Controllers\Auth;
//use App\User;
use Illuminate\Http\Request;
use App\models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\models\Admin;
use App\models\BDM;
use App\models\LG;
use Session;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:admin');
        $this->middleware('guest:bdm');
        $this->middleware('guest:lg');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    /**
     * Create a new admin instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Admin
     */
    protected function createAdmin(Request $request)
    {
        try{
            $this->validator($request->all())->validate();
            $admin = Admin::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'is_super' =>1,
                'password' => Hash::make($request['password']),
            ]);
            return redirect()->intended('login/admin');

        }catch(\Exception $e){
            Session::flash('flash_error',"Dont try to register with exicting email id "); 
            return back();
        }
        
    }
    /**
     * Create a new bdm instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Admin
     */
    protected function createBdm(Request $request)
    {
        try{
            $this->validator($request->all())->validate();
            $admin = BDM::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'is_bdm' =>2,
                'password' => Hash::make($request['password']),
            ]);
            return redirect()->intended('login/bdm');
        }catch(\Exception $e){
            Session::flash('flash_error',"Dont try to register with exicting email id "); 
            return back();
        }
    }
    /**
     * Create a new lg instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Admin
     */
    protected function createLg(Request $request)
    {
        try{
            $this->validator($request->all())->validate();
            $admin = LG::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'is_lg' =>3,
                'password' => Hash::make($request['password']),
            ]);
            return redirect()->intended('login/lg');
        }catch(\Exception $e){
            Session::flash('flash_error',"Dont try to register with exicting email id "); 
            return back();
        }
    }

    #registration for admin
    public function showAdminRegisterForm()
    {
        return view('auth.register', ['url' => 'admin']);
    }
    # registeration for bdm
    public function showBdmRegisterForm()
    {
        return view('auth.register', ['url' => 'bdm']);
    }
    #registeration for lg
    public function showLgRegisterForm(){
        return view('auth.register', ['url' => 'lg']);
    }
}
