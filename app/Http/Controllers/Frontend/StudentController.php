<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BookingSlot;
use App\Models\City;
use App\Models\MeetingHistory;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    public function dashboard(Request $request)
    {
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";

        $data['teacher'] = BookingSlot::where('student_id', Auth::user()->id)
            ->whereDate('date', '>=', date('Y-m-d'))
            ->with(['teacher', 'student'])->get()->map(function ($items) {
                $items->teacher_name = $items->teacher->name;
                return $items;
            });

        return view('frontend.student.dashboard')->with($data);
    }


    public function facultyBooking(Request $request)
    {
        $slot_id = $request->booking_time;
        $slot = Slot::findOrFail($slot_id);

        BookingSlot::create([
            'slot_id'  => $slot_id,
            'teacher_id' => $request->teacher_id,
            'student_id' => Auth::guard('web')->user()->id,
            'date' => $request->booking_date,
            'time' => $slot->slot_time,
        ]);
        return redirect()->route('front.student_dashboard');
    }

    public function bookTeacher(Request $request)
    {
        $date = $request->date ?? null;
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";

        $data['teacher'] = User::role('FACULTY')->with(['slot' => function ($q) {
            $q->select('teacher_id', 'slot_date') // Select only necessary columns
                ->whereDate('slot_date', '>=', date('Y-m-d'))
                ->groupBy('teacher_id', 'slot_date'); // Group by relevant columns
        }])->get();

        return view('frontend.student.book_now')->with($data);
    }

    public function getAvailableSlot(Request $request)
    {
        $date = $request->date ?? null;
        $teacher = $request->teacher_id ?? null;
    //    dd( date('H:i'));
        $slot = Slot::whereDate('slot_date', $date)
            ->where('slot_time', '>', date('H:i:s')) // Use 24-hour format for time comparison
            ->where('teacher_id', $teacher)
            ->whereDoesntHave('bookingSlot') // Exclude slots with a bookingSlot
            ->get();

        $option = "<option>Select</option>";
        foreach ($slot as $val) {
            $option .= "<option value='" . $val->id . "'>" . date('H:i A', strtotime($val->slot_time)) . "</option>";
        }
        return response()->json($option);
    }

    public function liveClass(Request $request)
    {
        if (Auth::user()) {
            $data['page_title'] = "Live class";
            $data['page_description'] = "Live class";
            $data['page_keyword'] = "Live class";

            $data['meeting'] = BookingSlot::where('zoom_id', $request->meeting_id)->get()->map(function ($items) {
                $meetingResponse = json_decode($items->zoom_response);
                $items->password = $meetingResponse?->password;
                $items->full_name = "Sankar Bera";
                return $items;
            })->first();
            // dd($data);
            return view('frontend.student.live_class')->with($data);
        } else {
            return redirect()->route('front.student_login');
        }
    }

    public function renderStudent(Request $request)
    {
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";
        $data['county_name'] = collect(config('class.dropdown_country'));
        $data['city_name'] = City::get();
        $data['school_class'] = collect(config('class.dropdown_school_class'));
        return view('admin.student.list')->with($data);
    }

    public function getStudent(Request $request)
    {
        try {
            $countryName = config('class.allow_country');
            $className = config('class.school_class');
            $studentName = $request->name ?? null;
            $countryId = $request->country_id ?? null;
            $cityId = $request->city_id ?? null;

            $model = User::when($countryId, function ($q) use ($countryId) {
                    $q->where('country_id', $countryId);
                })
                ->when($cityId, function ($q) use ($cityId) {
                    $q->where('city_id', $cityId);
                })
                ->when($studentName, function ($q) use ($studentName) {
                    $q->where('name', $studentName);
                })
                ->whereIn('register_as', [1, 2])
                ->with('cities')->get()->map(function ($items, $key) use ($countryName, $className) {
                    $items->country_name = $countryName[$items->country_id];
                    $items->class_name = $className[$items->student_class];
                    $items->city_name = $items->cities?->name;
                    $items->serial_no = ++$key;
                    return $items;
                });

            $data['totalCount'] = $model->count();
            $data['data'] = $model;
            return response()->json($data, 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }

    public function addStudent(Request $request) {}

    public function updateStudent(Request $request)
    {
        try {
            $updateId = $request->id;
            $data['name'] = $request->name ?? null;
            $data['email'] = $request->email;
            $data['student_age'] = $request->student_age;
            $data['student_class'] = $request->student_class;
            $data['city_id'] = $request->city_id;
            $data['country_id'] = $request->country_id;
            $data['institute_name'] = $request->institute_name;

            User::where('id', $updateId)->update($data);

            $data['success'] = true;
            $data['message'] = "Data has been added successfully";
            return response()->json($data, 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }

    public function deleteStudent(Request $request)
    {
        $deleteId = $request->id;
        User::where('id', $deleteId)->delete();
        $data['success'] = true;
        $data['message'] = "Data has been deleted successfully";
        return response()->json($data, 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('front.student_login');
    }
}
