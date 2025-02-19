<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use App\Models\BookingSlot;
use App\Models\City;
use App\Models\Country;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Validation\Rule;

class FacultyController extends Controller
{

    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculty = User::Role('FACULTY')->orderBy('name', 'desc')->paginate(15);

        return view('admin.faculty.list')->with(compact('faculty'));
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
        return view('admin.faculty.create')->with(compact('countries', 'cities'));
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
            // 'register_as' => 'required|in:1,2,3', // Must match enum values
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:15',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048', // If profile picture is uploaded
            'address' => 'nullable|string|max:255',
            'city_id' => 'required|string|max:255',
            'country_id' => 'required|string|max:255',
            'degree'=>'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $data = new User();
        $data->register_as = 3;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->password = bcrypt($request->password);
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->country_id = $request->country_id;
        $data->degree = $request->degree;
        $data->status = $request->status ?? 0; // Default to 0 if not provided

        $data->email_verified_at = date('Y-m-d H:i:s');
        // dd($data);
        $data->save();

        $data->assignRole('FACULTY'); // Assuming you have roles set up

        $maildata = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'type' => 'Faculty',
        ];

        // Mail::to($request->email)->send(new RegistrationMail($maildata));

        return redirect()->route('faculty.index')->with('message', 'Faculty created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['booking_slot'] = BookingSlot::whereDate('date', '>=', date("Y-m-d"))
        ->where('teacher_id', $id)
        ->whereIn('meeting_status', [0, 1])  // Filter by meeting_status being null or 1 (in-progress)
        ->with(['student', 'teacher'])
        ->latest()
        ->get();

        $data['booking_history'] = BookingSlot::where('teacher_id', $id)
        ->whereIn('meeting_status', [2])  // Filter by meeting_status being null or 1 (in-progress)
        ->with(['student', 'teacher'])
        ->latest()
        ->paginate(10);

        return view('admin.faculty.view')->with($data);
    }

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
        $faculty = User::findOrFail($id);
        $selectedCountryId = $faculty->country_id;
        $selectedCityId = $faculty->city_id;
        return view('admin.faculty.edit')->with(compact('faculty', 'countries', 'cities', 'selectedCountryId','selectedCityId'));
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

            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|min:8',
            'confirm_password' => 'nullable|min:8|same:password',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048', // If profile picture is uploaded
            'address' => 'nullable|string|max:255',
            'city_id' => 'required|string|max:255',
            'country_id' => 'required|string|max:255',
            'degree'=> 'required|string|max:255',
            'status' => 'required|boolean',
        ]);


        $data = User::findOrFail($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->country_id = $request->country_id;
        $data->degree=$request->degree;

        $data->status = $request->status ?? 0; // Default to 0 if not provided
        if ($request->password != null) {
            $request->validate([
                'password' => 'min:8',
                'confirm_password' => 'min:8|same:password',
            ]);
            $data->password = bcrypt($request->password);
        }

        $data->save();
        return redirect()->route('faculty.index')->with('message', 'Faculty updated successfully.');
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

    public function changeFacultyStatus(Request $request)
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
        return redirect()->route('faculty.index')->with('error', 'Faculty has been deleted successfully.');
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);

            // Eager load city and country relationships
            $faculty = User::with(['city', 'country'])
                ->where('id', 'like', '%' . $query . '%')
                ->orWhere('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orWhere('phone', 'like', '%' . $query . '%')
                ->orWhere('address', 'like', '%' . $query . '%')
                ->orWhereHas('city', function($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->orWhereHas('country', function($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->orderBy($sort_by, $sort_type)
                ->Role('FACULTY')
                ->paginate(15);

            return response()->json(['data' => view('admin.faculty.table', compact('faculty'))->render()]);
        }
    }
}
