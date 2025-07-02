<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Jobs\DeleteToken;
use App\Jobs\SendRegisterEmailJob;
use App\Jobs\SendResetPasswordEmail;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function adminLogin()
    {
        return view('admin.adminLogin');
    }

    public function userLogin()
    {
        return view('auth.userLogin');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function forgotPassword()
    {
        return view("resetPassword.forgotPassword");
    }

    public function verifyOtp($token)
    {
        return view("resetPassword.verifyOtp", compact('token'));
    }

    public function setNewPassword($otp)
    {
        return view("resetPassword.setNewPassword", compact('otp'));
    }


    public function registerPost(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'password_confirmation' => 'required|same:password',
            'role' => 'required',
        ]);

        $user = new User();
        $user->name = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->role;

        

        if ($user->save()) {
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->save();
            dispatch(new SendRegisterEmailJob($request->email, $request->username, $request->role));
            return redirect(route("userLogin"))->with("success", "Registration Successful");
        }
        return redirect(route("register"))->with("error", "Registration failed. Some error occured.");
    }
    
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->remember;
        if (Auth::attempt($credentials,$remember)) {
            if(Auth::user()->status == 'blocked'){
                return redirect(route('userLogin'))->with('error','You are blocked by admin');
            }
            if(Auth::user()->role == "customer"){
            return redirect(route('customers.dashboard'))->with("success", "Welcome " . Auth::user()->name . " Here are your events and bookings");
            }

            if(Auth::user()->role == 'organizer'){
            return redirect(route('organizers.dashboard'))->with("success", "Welcome " . Auth::user()->name . " Here are your events and bookings");
            }
        } else {
            return redirect(route("userLogin"))->with(
                "error",
                "Invalid email or password"
            );
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route("home"))->with("success","Logged out successfully");
    }

    public function dashboard(Request $request){
        if($request->user()->role == "customer"){
            return redirect(route('customers.dashboard'));
        }
        if($request->user()->role == "organizer"){
            return redirect(route('organizers.dashboard'));
        }
        
    }

    public function forgotPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email'
        ]);
        $otp = random_int(100000, 999999);
        session(['email' => $request->email, 'otp' => $otp]);
        $tokenExists = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if ($tokenExists) {
            session(['token' => $tokenExists->token]);
            dispatch(new SendResetPasswordEmail($request->email, $otp)); //Send email to user
            return redirect(route('verifyOtp', ['token' => $tokenExists->token]))->with(['success' => 'Otp sent successfully to your email']);
        } else {
            //Generating a random token
            $token = Str::random(16);
            session(['token' => $token]);

            DB::table('password_reset_tokens')->insert([ //Insert a now record
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            dispatch(new SendResetPasswordEmail($request->email, $otp)); //Send email to user
            dispatch(new DeleteToken($token))->delay(now()->addMinutes(10)); //Deleting token after ten minutes

            return redirect(route('verifyOtp', ['token' => $token]))->with(['success' => 'Otp sent successfully to your email']);
        }
    }

    public function verifyOtpPost(Request $request)
    {
        $request->validate([
            'userotp' => 'required|min:6|max:6',
            'token' => 'required'
        ]);
        $user = DB::table('password_reset_tokens')->where('token', session('token'))->first();

        if ($request->userotp == session('otp')) {
            if ($user && $request->token == $user->token) {
                return redirect(route('setNewPassword', ['email' => session('email')]))->with(['success' => 'otp is matched']);
            }
            else{
                return redirect(route('verifyOtp', ['token' => $request->token]))->with('error', 'otp is expired');
            }
        }
        return redirect(route('verifyOtp', ['token' => $request->token]))->with('error', 'otp is not matched');
    }

    public function setNewPasswordPost(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        if (DB::table('password_reset_tokens')->where("email", session('email'))->exists()) {
            $update = DB::table('users')->where('email', session('email'))->update(['password' => Hash::make($request->password)]);

            if ($update > 0) {
                DB::table('password_reset_tokens')->where("email", session('email'))->delete();
                return redirect(route('userLogin'))->with("success", "Password reset successfull " . session()->get('email'));
            } else {
                return redirect()->back()->with("error", "Password reset not successfull.");
            }
        } else {
            return redirect()->back()->with("error", "You are unauthorized.");
        }
    }

    public function editProfile(){
        return view('editProfile');
    }
}
