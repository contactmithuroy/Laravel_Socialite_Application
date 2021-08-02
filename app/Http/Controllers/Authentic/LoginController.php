<?php

namespace App\Http\Controllers\Authentic;
use App\Models\Admin;
use App\Models\Blogger;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function __construct()
    {
            $this->middleware('guest')->except('logout');
            $this->middleware('guest:admin')->except('logout');
            $this->middleware('guest:blogger')->except('logout');
    }

     public function showAdminLoginForm()
    {
        return view('Authentic.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            
            // return response()->json(Auth::user());

            return redirect()->intended('/admin');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

     public function showBloggerLoginForm()
    {
        return view('Authentic.login', ['url' => 'blogger']);
    }

    public function bloggerLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('blogger')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/blogger');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    // logout
    public function logout(){
        
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}