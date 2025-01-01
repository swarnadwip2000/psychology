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
use App\Models\Teacher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
                    if (auth()->user()->hasRole('FACULTY')) {
                        if (auth()->user()->status == 1) {
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
        return view('frontend.faculty_registration')->with($data);
    }

    public function school_registration(Request $request)
    {
        $data['page_title'] = "Register as School";
        $data['page_description'] = "register as School";
        $data['page_keyword'] = "Register as School";
        $data['city'] = City::get();
        return view('frontend.school_registration')->with($data);
    }

    public function college_registration(Request $request)
    {
        $data['page_title'] = "Register as College";
        $data['page_description'] = "register as College";
        $data['page_keyword'] = "Register as College";
        $data['city'] = City::get();
        return view('frontend.college_registration')->with($data);
    }

    public function registrationSuccess(Request $request)
    {

        $studentAge = $request->student_age ?? null;
        $studentClass = $request->student_class ?? null;
        $countryName = $request->country_name ?? null;
        $cityName = $request->city_name ?? null;
        $studentName = $request->name ?? null;
        $password = Hash::make($request->password) ?? null;
        $emailId = $request->email ?? null;
        $schoolName = $request->school_name ?? null;
        $row_id = $request->row_id ?? null;
        $registerAs = $request->register_as ?? null;
        $data['page_title'] = "Register as School";
        $data['page_description'] = "register as School";
        $data['page_keyword'] = "Register as School";
        if ($row_id) {
            $remember_token = Str::random(4);
            $userDetails = User::where(['id' => $row_id])->update([
                'name' => $studentName,
                'email' => $emailId,
                'password' => $password,
                'remember_token' => $remember_token,
            ]);

            Mail::to($emailId)->send(new MyTestEmail($remember_token));
            $data['id'] = $row_id;
            return view('frontend.email_verification')->with($data);
        } else {
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
                'status' => 1
            ]);
            $userDetails->assignRole('STUDENT');
            $data['id'] = $userDetails->id;

            return view('frontend.personal_details')->with($data);
        }
    }

    public function faculty_registration_success(Request $request)
    {
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
            'status' => 1

        ]);

        $userDetails->assignRole('FACULTY');
        Mail::to($emailId)->send(new MyTestEmail($remember_token));
        $data['id'] = $userDetails->id;
        $data['page_title'] = "Email Confirmation";
        $data['page_description'] = "Email Confirmation";
        $data['page_keyword'] = "Email Confirmation";
        return view('frontend.faculty_email_verification')->with($data);
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
        $user = User::where(['remember_token' => $request->toke_code])->first();
        $teacher = Teacher::where(['remember_token' => $request->toke_code])->first();

        if ($user) {
            User::where(['remember_token' => $request->toke_code])->update(['email_verified_at' => date('Y-m-d H:i:s')]);
            echo "Email id verified successfully!!";
        } else if ($teacher) {
            Teacher::where(['remember_token' => $request->toke_code])->update(['email_verified_at' => date('Y-m-d H:i:s')]);
            echo "Email id verified successfully!!";
        } else {
            echo "Token does not match. Please try again";
        }
    }
}
