<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
		// return session()->exists('TMP_WBSESSID');
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

 		// $validate = $this->validateUser($request);

 		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();
	
			return redirect()->to('/');
		} else {
            return back()->withErrors([
                'general' => 'The provided credentials do not match our records.',
            ])->onlyInput('general');
        }
    }

    public function signOut() {
        Session::flush();
		Session::forget('TMP_WBSESSID');
        Auth::logout();
  
        return redirect()->route('login');
    }
}