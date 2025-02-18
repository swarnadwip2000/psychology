<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use App\Models\City;
use App\Models\Country;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\fileExists;

class CustomerController extends Controller
{
    use ImageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = User::Role('STUDENT')->orderBy('name', 'desc')->paginate(15);

        return view('admin.student.list')->with(compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get();
        $cities = City::get();
        return view('admin.student.create')->with(compact('countries', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'register_as' => 'required|in:1,2,3', // Must match enum values
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:15',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048', // If profile picture is uploaded
            'address' => 'nullable|string|max:255',
            'city_id' => 'required|string|max:255',
            'country_id' => 'required|string|max:255',
            'student_age' => 'required|integer|min:1|max:120',
            'student_class' => 'required|string|max:255',
            'institute_name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $data = new User();
        $data->register_as = $request->register_as;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->password = bcrypt($request->password);
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->country_id = $request->country_id;
        $data->student_age = $request->student_age;
        $data->student_class = $request->student_class;
        $data->institute_name = $request->institute_name;
        $data->status = $request->status ?? 0; // Default to 0 if not provided
        $data->email_verified_at = date('Y-m-d H:i:s');
        $data->save();

        $data->assignRole('STUDENT'); // Assuming you have roles set up

        $maildata = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'type' => 'Student',
        ];

        // Mail::to($request->email)->send(new RegistrationMail($maildata));

        return redirect()->route('students.index')->with('message', 'Student created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries = Country::get();
        $cities = City::get();
        $student = User::findOrFail($id);
        $selectedCountryId = $student->country_id;
        $selectedCityId = $student->city_id;
        return view('admin.student.edit')->with(compact('student', 'countries', 'cities', 'selectedCountryId','selectedCityId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'email' => [
                'required',
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                Rule::unique('users')->ignore($id), // Exclude the current user's email
            ],
            'register_as' => 'required|in:1,2,3', // Must match enum values
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|min:8',
            'confirm_password' => 'nullable|min:8|same:password',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048', // If profile picture is uploaded
            'address' => 'nullable|string|max:255',
            'city_id' => 'required|string|max:255',
            'country_id' => 'required|string|max:255',
            'student_age' => 'required|integer|min:1|max:120',
            'student_class' => 'required|string|max:255',
            'institute_name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);


        $data = User::findOrFail($id);
        $data->register_as = $request->register_as;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->country_id = $request->country_id;
        $data->student_age = $request->student_age;
        $data->student_class = $request->student_class;
        $data->institute_name = $request->institute_name;
        $data->status = $request->status ?? 0; // Default to 0 if not provided
        if ($request->password != null) {
            $request->validate([
                'password' => 'min:8',
                'confirm_password' => 'min:8|same:password',
            ]);
            $data->password = bcrypt($request->password);
        }

        $data->save();
        return redirect()->route('students.index')->with('message', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeCustomersStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();
        return response()->json(['success' => 'Status change successfully.']);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('students.index')->with('error', 'Student has been deleted successfully.');
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);

            // Eager load city and country relationships
            $students = User::with(['city', 'country'])
                ->where('id', 'like', '%' . $query . '%')
                ->orWhere('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orWhere('phone', 'like', '%' . $query . '%')
                ->orWhere('address', 'like', '%' . $query . '%')
                ->orWhereHas('city', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->orWhereHas('country', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->orderBy($sort_by, $sort_type)
                ->Role('STUDENT')
                ->paginate(15);

            return response()->json(['data' => view('admin.student.table', compact('students'))->render()]);
        }
    }
    public function getClasses(Request $request)
    {
        $registerAs = $request->input('register_as');
        $classes = [];

        if ($registerAs == 1) {
            $classes = config('class.school_class');
        } elseif ($registerAs == 2) {
            $classes = config('class.college_class');
        }

        return response()->json($classes);
    }
    public function getCities(Request $request)
    {
        $countryId = $request->input('country_id');

        // Fetch cities based on country id
        $cities = City::where('country_id', $countryId)->get();

        // Return cities as JSON response
        return response()->json($cities);
    }

}
