<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Mail\MyTestEmail;
use App\Models\Country;
use App\Models\Teacher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Mail\SendCodeStudentResetPassword;
use App\Mail\SendCodeFacultyResetPassword;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    public function index()
    {

        $data['page_title'] = "Psychology";
        $data['page_description'] = "E-learning platform";
        $data['page_keyword'] = "Psychology";
        return view('frontend.home')->with($data);
    }

    public function student_login(Request $request)
    {
        $data['page_title'] = "Login";
        $data['page_description'] = "Login";
        $data['page_keyword'] = "Login";
        return view('frontend.student.login')->with($data);
    }


    public function student_login_success(Request $request)
    {

        $emailId = $request->email ?? null;
        $password = $request->password ?? null;

        $model = User::where(['email' => $emailId])->whereIn('register_as', [1, 2])->first();

        if ($model) {
            if ($model->email_verified_at != null) {
                if (Auth::guard('web')->attempt(['email' => $emailId, 'password' => $password])) {
                    if (auth()->user()->hasRole('STUDENT')) {
                        if (auth()->user()->status == 1) {
                            User::where(['email' => $emailId])->whereIn('register_as', [1, 2])->update(['time_zone' => $request->timezone]);
                            return redirect()->route('front.student_dashboard');
                        } else {
                            auth()->logout();
                            return redirect()->back()->with('errmsg', 'Your account is not active!');
                        }
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('errmsg', 'You entered wrong password');
                    }
                } else {
                    return redirect()->back()->with('errmsg', 'You entered wrong password');
                }
            } else {
                return redirect()->back()->with('errmsg', 'Registered Email id yet not verified');
            }
        } else {
            return redirect()->back()->with('errmsg', 'Please enter a registered email id');
        }
    }

    public function faculty_login(Request $request)
    {
        $data['page_title'] = "Login as Faculty";
        $data['page_description'] = "login as faculty";
        $data['page_keyword'] = "Login as Faculty";
        return view('frontend.faculty_login')->with($data);
    }

    public function faculty_registration(Request $request)
    {
        $data['page_title'] = "Register as faculty";
        $data['page_description'] = "register as faculty";
        $data['page_keyword'] = "Register as faculty";
        $data['city'] = City::get();
        $data['countries'] = Country::get();
        return view('frontend.faculty_registration')->with($data);
    }

    public function school_registration(Request $request)
    {
        $data['page_title'] = "Register as School";
        $data['page_description'] = "register as School";
        $data['page_keyword'] = "Register as School";
        $data['city'] = City::get();
        $data['countries'] = Country::get();
        return view('frontend.school_registration')->with($data);
    }

    public function college_registration(Request $request)
    {
        $data['page_title'] = "Register as College";
        $data['page_description'] = "register as College";
        $data['page_keyword'] = "Register as College";
        $data['city'] = City::get();
        $data['countries'] = Country::get();
        return view('frontend.college_registration')->with($data);
    }

    public function registrationSuccess(Request $request)
    {

        $data = $request->all();
        session()->put('student_data', $data);

        return redirect()->route('front.student_personal_details');
    }

    public function studentRegisterSubmit(Request $request)
    {
        if (session()->has('student_data')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
            ], [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'email.unique' => 'This email is already taken.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 8 characters.',
                'confirm_password.same' => 'The passwords do not match.',
                'confirm_password.required' => 'Please confirm your password.',
            ]);

            $data = session()->get('student_data');
            // dd($data);
            $studentAge = $data['student_age'] ?? null;
            $studentClass = $data['student_class'] ?? null;
            $countryName = $data['country_name'] ?? null;
            $cityName = $data['city_name'] ?? null;
            $schoolName = $data['school_name'] ?? null;

            $studentName = $request->name ?? null;
            $password = Hash::make($request->password) ?? null;
            $emailId = $request->email ?? null;
            $registerAs = $data['register_as'] ?? null;



            $remember_token = Str::random(4);
            $userDetails = User::updateOrCreate(['email' => $emailId], [
                'student_age' => $studentAge,
                'student_class' => $studentClass,
                'country_id' => $countryName,
                'city_id' => $cityName,
                'name' => $studentName,
                'email' => $emailId,
                'password' => $password,
                'institute_name' => $schoolName,
                'register_as' => $registerAs,
                'status' => 0,
                'remember_token' => $remember_token,
            ]);

            $userDetails->assignRole('STUDENT');
            Mail::to($emailId)->send(new MyTestEmail($remember_token));
            session()->forget('student_data');
            return redirect()->route('front.student_login')->with('successmsg', 'Please check your mail for verified your account.');
        } else {
            abort(404);
        }
    }

    public function studentPersonalDetails()
    {
        if (session()->has('student_data')) {
            $page_title = "Register as School";
            $data['page_description'] = "register as School";
            $data['page_keyword'] = "Register as School";
            return view('frontend.personal_details')->with(compact('page_title'));
        } else {
            abort(404);
        }
    }

    public function faculty_registration_success(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email_id' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'country_name' => 'nullable|string|max:255',
            'city_name' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'register_as' => 'required|in:1,2,3',
        ]);

        $name = $request->name ?? null;
        $emailId = $request->email_id;
        $password = Hash::make($request->password) ?? null;
        $countryName = $request->country_name ?? null;
        $cityName = $request->city_name ?? null;
        $degree = $request->degree ?? null;
        $registerAs = $request->register_as;
        $remember_token = Str::random(4);

        $userDetails = User::updateOrCreate(['email' => $emailId, 'register_as' => 3], [
            'country_id' => $countryName,
            'city_id' => $cityName,
            'name' => $name,
            'email' => $emailId,
            'password' => $password,
            'register_as' => $registerAs,
            'degree' => $degree,
            'remember_token' => $remember_token,
            'status' => 0,

        ]);

        $userDetails->assignRole('FACULTY');
        Mail::to($emailId)->send(new MyTestEmail($remember_token));
        $data['id'] = $userDetails->id;
        $data['page_title'] = "Email Confirmation";
        $data['page_description'] = "Email Confirmation";
        $data['page_keyword'] = "Email Confirmation";
        return redirect()->route('front.faculty_login')->with('successmsg', 'Please check your mail for verified your account.');
    }

    public function faculty_login_success(Request $request)
    {

        $emailId = $request->email ?? null;
        $password = $request->password ?? null;

        $model = User::where(['email' => $emailId])->whereIn('register_as', [3])->first();

        if ($model) {
            if ($model->email_verified_at != null) {

                if (Auth::attempt(['email' => $emailId, 'password' => $password])) {
                    if (auth()->user()->hasRole('FACULTY')) {
                        if (auth()->user()->status == 1) {
                            User::where(['email' => $emailId])->whereIn('register_as', [3])->update(['time_zone' => $request->timezone]);
                            return redirect()->route('auth_teacher_dashboard');
                        } else {
                            auth()->logout();
                            return redirect()->back()->with('errmsg', 'Your account is not active!');
                        }
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('errmsg', 'You entered wrong password');
                    }
                } else {
                    return redirect()->back()->with('errmsg', 'You entered wrong password');
                }
            } else {
                return redirect()->back()->with('errmsg', 'Registered Email id yet not verified');
            }
        } else {
            return redirect()->back()->with('errmsg', 'Please enter a registered email id');
        }
    }

    public function checkDuplicateEmail(Request $request)
    {
        $emailId = $request->email_id ?? null;
        $registerAs = $request->register_as ?? null;
    }

    public function emailConfirmation(Request $request)
    {
        $data['page_title'] = "Email Confirmation";
        $data['page_description'] = "Email Confirmation";
        $data['page_keyword'] = "Email Confirmation";
        return view('frontend.email_confirmation')->with($data);
    }

    public function subscription(Request $request)
    {
        $data['page_title'] = "Subscription";
        $data['page_description'] = "Subscription";
        $data['page_keyword'] = "Subscription";
        return view('frontend.our_subscriptions')->with($data);
    }

    public function payment(Request $request)
    {
        $data['page_title'] = "Payment";
        $data['page_description'] = "Payment";
        $data['page_keyword'] = "Payment";
        return view('frontend.payment')->with($data);
    }

    public function aboutus()
    {
        $data['page_title'] = "krishna tax consultancy";
        $data['page_description'] = "krishna tax consultancy";
        $data['page_keyword'] = "IT Frame";
        $data['service_category'] = Category::serviceCategory()->where('status', 1)->limit(6)->get();
        $data['about_us'] = Aboutus::first();
        return view('frontend.about-us')->with($data);
    }

    public function emailVerification(Request $request)
    {
        $user = User::role('STUDENT')->where(['remember_token' => $request->toke_code])->first();
        $teacher = User::role('FACULTY')->where(['remember_token' => $request->toke_code])->first();
        $page_title = "Email confirmation";
        if ($user) {
            $type = "student";
            User::where(['remember_token' => $request->toke_code])->update(['email_verified_at' => date('Y-m-d H:i:s'), 'status' => 1]);
            return view('frontend.email_confirmation')->with(compact('page_title', 'type'));
        } else if ($teacher) {
            $type = "teacher";
            User::where(['remember_token' => $request->toke_code])->update(['email_verified_at' => date('Y-m-d H:i:s'), 'status' => 1]);
            return view('frontend.email_confirmation')->with(compact('page_title', 'type'));
        } else {
            return redirect()->route('front.home')->with('errmsg', 'Token does not match. Please try again');
        }
    }
    // student forget password
    public function forget_password()
    {
        $data['page_title'] = "Psychology";
        $data['page_description'] = "E-learning platform";
        $data['page_keyword'] = "Psychology";
        return view('frontend.student.auth.forget_password')->with($data);
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|exists:users,email',
        ]);
        // return $validator->errors();
        $count = User::where('email', $request->email)->role('STUDENT')->count();
        if ($count > 0) {
            $user = User::where('email', $request->email)->select('id', 'name', 'email')->first();
            PasswordReset::where('email', $request->email)->delete();
            $id = Crypt::encrypt($user->id);
            $token = Str::random(20) . 'pass' . $user->id;
            PasswordReset::create([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $details = [
                'id' => $id,
                'token' => $token
            ];

            Mail::to($request->email)->send(new SendCodeStudentResetPassword($details));
            return redirect()->back()->with('message', "Please! check your mail to reset your password.");
        } else {
            return redirect()->back()->with('error', "Couldn't find your account!");
        }
    }




    public function resetPassword($id, $token)
    {
        $page_title = "Reset Password";
        $user = User::findOrFail(Crypt::decrypt($id));
        $resetPassword = PasswordReset::where('email', $user->email)->first();

        if (!$resetPassword) {
            abort(404);
        }

        // Get the expiration time (1 hour after creation)
        $expiryTime = $resetPassword->created_at->addHour();

        // Compare with current time
        if (Carbon::now()->lessThan($expiryTime)) {
            return view('frontend.student.auth.reset', compact('id', 'page_title'));
        } else {
            abort(404);
        }
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password'
        ]);

        try {
            if (!empty($request->id)) {
                // Ensure the ID is properly decrypted
                $id = Crypt::decrypt($request->id);

                // Check if user exists before updating
                $user = User::find($id);
                if (!$user) {
                    return redirect()->route('front.student_login')->with('error', 'User not found.');
                }

                // Update password using bcrypt
                $user->password = bcrypt($request->password);
                $user->save();

                return redirect()->route('front.student_login')->with('message', 'Password has been changed successfully.');
            } else {
                abort(404);
            }
        } catch (\Throwable $th) {
            return redirect()->route('front.student_login')->with('error', 'Something went wrong. Please try again.');
        }
    }




    // faculty forget password

    public function faculty_forget_password()
    {
        $data['page_title'] = "Psychology";
        $data['page_description'] = "E-learning platform";
        $data['page_keyword'] = "Psychology";
        return view('frontend.faculty_forget_password')->with($data);
    }

    public function faculty_forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|exists:users,email',
        ]);

        $count = User::where('email', $request->email)->role('FACULTY')->count();

        if ($count > 0) {
            $user = User::where('email', $request->email)->select('id', 'name', 'email')->first();
            PasswordReset::where('email', $request->email)->delete();
            $id = Crypt::encrypt($user->id);
            $token = Str::random(20) . 'pass' . $user->id;
            PasswordReset::create([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $details = [
                'id' => $id,
                'token' => $token
            ];

            Mail::to($request->email)->send(new SendCodeFacultyResetPassword($details));
            return redirect()->back()->with('message', "Please! check your mail to reset your password.");
        } else {
            return redirect()->back()->with('error', "Couldn't find your account!");
        }
    }

    public function faculty_resetPassword($id, $token)
    {
        // return "dfs";

        $page_title = "Reset Password";
        $user = User::findOrFail(Crypt::decrypt($id));
        $resetPassword = PasswordReset::where('email', $user->email)->first();

        if (!$resetPassword) {
            abort(404);
        }

        // Get the expiration time (1 hour after creation)
        $expiryTime = $resetPassword->created_at->addHour();

        // Compare with current time
        if (Carbon::now()->lessThan($expiryTime)) {
            return view('frontend.faculty_reset', compact('id', 'page_title'));
        } else {
            abort(404);
        }
    }

    public function faculty_changePassword(Request $request)
    {

        $request->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password'
        ]);
        // return $request->all();
        try {
            if ($request->id != '') {
                $id = Crypt::decrypt($request->id);

                User::where('id', $id)->update(['password' => bcrypt($request->password)]);
                $now_time = Carbon::now()->toDateTimeString();
                Session::flash('message', 'Password has been changed successfully.');
                return redirect()->route('front.faculty_login');
            } else {
                abort(404);
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong.');
            return redirect()->route('front.faculty_login');
        }
    }
}
