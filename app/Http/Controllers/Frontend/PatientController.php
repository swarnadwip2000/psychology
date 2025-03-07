<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    use ImageTrait;
    public function dashboard(Request $request)
    {
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";


        return view('frontend.patient.dashboard')->with($data);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('front.patient_login');
    }

    public function profile()
    {
        $page_title  = "Profile";
        $countries   = Country::get();
        $patient = User::find(auth()->id());
        return view('frontend.patient.profile')->with(compact('countries', 'page_title', 'patient'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp', // If profile picture is uploaded
            'address' => 'nullable|string|max:255',
            'city_id' => 'required|string|max:255',
            'country_id' => 'required|string|max:255',
            'student_age' => 'required|max:120',
            'student_class' => 'required|string|max:255',
        ]);

        $data = User::find(auth()->user()->id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->country_id = $request->country_id;
        $data->student_age = $request->student_age;
        $data->student_class = $request->student_class;
        $data->problem_face = $request->problem_face;
        if ($request->profile_picture) {
            $data->profile_picture = $this->imageUpload($request->file('profile_picture'), 'profile');
        }
        $data->save();
        return redirect()->back()->with('message', 'Profile updated successfully.');
    }
}
