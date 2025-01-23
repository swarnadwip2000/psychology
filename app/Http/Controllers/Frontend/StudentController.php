<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\BookingNotification;
use App\Models\BookingSlot;
use App\Models\City;
use App\Models\MeetingHistory;
use App\Models\Slot;
use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{

    public function dashboard(Request $request)
    {
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";

        $data['teacher'] = BookingSlot::where('student_id', Auth::user()->id)->whereIn('meeting_status', [0, 1])
            ->whereDate('date', '>=', date('Y-m-d'))->orderBy('id', 'desc')
            ->with(['teacher', 'student'])->get()->map(function ($items) {
                $items->teacher_name = $items->teacher->name;
                return $items;
            });

        $data['booking_history'] = BookingSlot::where('student_id', Auth::user()->id)
            ->where('meeting_status', 2) // Filter by meeting_status = 2
            // ->whereDate('date', '<', date('Y-m-d'))->orderBy('id', 'desc')
            ->with(['teacher', 'student']) // Eager load related models
            ->paginate(10) // Paginate results first
            ->through(function ($item) { // Use through for transformation
                $item->teacher_name = $item->teacher->name; // Add teacher_name attribute
                return $item;
            });


        return view('frontend.student.dashboard')->with($data);
    }


    public function facultyBooking(Request $request)
    {
        // Find the slot
        $slot = Slot::findOrFail($request->booking_time);

        // Create the booking
        $booking = BookingSlot::create([
            'slot_id' => $slot->id,
            'teacher_id' => $request->teacher_id,
            'student_id' => Auth::guard('web')->id(),
            'date' => $request->booking_date,
            'time' => $slot->slot_time,
            'meeting_status' => 0,
        ]);

        // Get teacher and student information
        $teacher = User::findOrFail($request->teacher_id);
        $student = Auth::guard('web')->user();

        // Email data
        $emailData = [
            'date' => $request->booking_date,
            'time' => $slot->slot_time,
            'teacher_name' => $teacher->name,
            'student_name' => $student->name,
        ];

        // Send email to the teacher
        Mail::to($teacher->email)->send(new BookingNotification($emailData, 'teacher'));

        // Send email to the student
        Mail::to($student->email)->send(new BookingNotification($emailData, 'student'));

        return redirect()->route('front.student_dashboard')->with('successmsg', 'Booking created successfully!');
    }


    // public function facultyBooking(Request $request)
    // {

    //     // Find the slot
    //     $slot = Slot::findOrFail($request->booking_time);

    //     // Create the booking
    //     $booking = BookingSlot::create([
    //         'slot_id' => $slot->id,
    //         'teacher_id' => $request->teacher_id,
    //         'student_id' => Auth::guard('web')->id(),
    //         'date' => $request->booking_date,
    //         'time' => $slot->slot_time,
    //         'meeting_status' => 0,
    //     ]);

    //     // Prepare data for meeting creation
    //     $meetingData = [
    //         'booking_id' => $booking->id,
    //         'topic' => $slot->topic ?? 'Default Topic',
    //         'start_time' => $booking->time,
    //         'start_date' => $booking->date,
    //     ];

    //     // Create the meeting
    //     $meeting = new MeetingController();
    //     $response = $meeting->createMeeting(new Request($meetingData));

    //     // // Handle the meeting response
    //     $zoomResponse = json_decode($response, true);

    //     // Extract the start_url or provide a fallback
    //     $start_url = $zoomResponse['start_url'] ?? null;

    //     if (!$start_url) {
    //         // Log the issue or notify the admin if start_url is missing
    //         \Log::error('Zoom meeting creation failed or start_url missing', [
    //             'response' => $zoomResponse,
    //             'booking_id' => $booking->id,
    //         ]);

    //         // Provide a fallback message to the user
    //         return redirect()->route('front.student_dashboard')->with('errmsg', 'Booking created, but meeting link is unavailable. Please contact support.');
    //     }

    //     // Update booking with meeting details
    //     $booking->update([
    //         'meeting_status' => 1,
    //         'meeting_start_time' => $booking->time,
    //         'zoom_response' => $response, // Save the raw Zoom response if needed
    //     ]);

    //     // Redirect to student dashboard

    //     return redirect()->route('front.student_dashboard')->with('successmsg', 'Booking created successfully!');
    // }


    public function bookTeacher(Request $request)
    {
        $date = $request->date ?? null;
        $facultyName = $request->faculty_name; // Get the faculty name from the form
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";

        // If a faculty name is provided, filter the teachers based on the name
        $data['teacher'] = User::role('FACULTY')
            ->when($facultyName, function ($query) use ($facultyName) {
                return $query->where('name', 'like', '%' . $facultyName . '%');
            })
            ->with(['slot' => function ($q) {
                $q->select('teacher_id', 'slot_date')
                    ->whereDate('slot_date', '>=', date('Y-m-d'))
                    ->groupBy('teacher_id', 'slot_date');
            }])
            ->get();

        return view('frontend.student.book_now')->with($data);
    }


    public function getAvailableSlot(Request $request)
    {
        $date = date('Y-m-d', strtotime($request->date)) ?? null;
        $teacher = $request->teacher_id ?? null;
        $time = Carbon::now()->format('H:i');  // Get current time in 24-hour format
        $now_date = date('Y-m-d');
        //    dd( date('H:i'));
        // If there are bookings from previous dates, show only future slots for today
        if ($date == $now_date) {
            $slot = Slot::whereDate('slot_date', $date)  // For the current date
                ->where('slot_time', '>', $time)  // Only show future times for today
                ->where('teacher_id', $teacher)
                ->whereDoesntHave('bookingSlot')  // Ensure no bookings exist for this slot
                ->get();
        } else {
            // If no previous bookings exist, show all slots for the day
            $slot = Slot::whereDate('slot_date', $date)  // For the current date
                ->where('teacher_id', $teacher)
                ->whereDoesntHave('bookingSlot')  // Ensure no bookings exist for this slot
                ->get();
        }

        $option = "<option>Select</option>";
        foreach ($slot as $val) {
            $option .= "<option value='" . $val->id . "'>" . date('H:i', strtotime($val->slot_time)) . "</option>";
        }
        return response()->json($option);
    }

    public function liveClass(Request $request)
    {
        if (Auth::user()) {
            $data['page_title'] = "Live class";
            $data['page_description'] = "Live class";
            $data['page_keyword'] = "Live class";

            // Get the meeting details from the database
            $data['meeting'] = BookingSlot::where('zoom_id', $request->meeting_id)->get()->map(function ($items) {
                $meetingResponse = json_decode($items->zoom_response);
                $items->password = $meetingResponse->password;
                $items->full_name = "John Doe"; // Example name, replace with actual
                return $items;
            })->first();

            // Zoom API Key and Secret
            $apiKey = env('ZOOM_CLIENT_ID');
            $apiSecret = env('ZOOM_CLIENT_SECRET');
            $meetingNumber = $data['meeting']->zoom_id;
            $password = $data['meeting']->password;

            // Generate Zoom Signature
            $signature = $this->generateZoomSignature($apiKey, $apiSecret, $meetingNumber);
            // dd($data);
            $meeting = new MeetingController();
            return view('frontend.student.live_class', [
                'page_title' => $data['page_title'],
                'data' => $data,
                'signature' => $signature,
                'meetingNumber' => $meetingNumber,
                'password' => $password,
                'userName' => $data['meeting']->full_name, // User's name
                'sdkKey' => $apiKey,
                'zakToken' => $meeting->getHostZAKToken('aSKCRY3sS2OpEeExLEvbkg'), // Replace with actual host ZAK token
                'outhtoken' => $meeting->generateToken()
            ]);
            // return view('frontend.student.live_class')->with($data);
        } else {
            return redirect()->route('front.student_login');
        }
    }



    private function generateZoomSignature($apiKey, $apiSecret, $meetingNumber)
    {
        $role = 1; // 0 = attendee, 1 = host
        $timestamp = time() * 1000 - 30000; // Current timestamp in milliseconds
        $expireTime = $timestamp + 5000; // Signature expires in 5 seconds

        $data = [
            'app_key' => env('ZOOM_SDK_CLIENT_ID'),
            'm' => $meetingNumber,
            't' => $timestamp,
            'e' => $expireTime,
            'r' => $role,
        ];

        // The third argument is the algorithm, in this case, we use 'HS256'
        return JWT::encode($data, $apiSecret, 'HS256');
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

    public function checkMeeting(Request $request)
    {
        $booking = BookingSlot::findOrFail($request->booking_id);

        // Combine the date and time to create a full start datetime
        $scheduledStart = Carbon::parse($booking->date . ' ' . $booking->time);

        // Check if the current time is before the scheduled start time
        if (Carbon::now()->lt($scheduledStart)) {
            return response()->json([
                'status' => false,
                'message' => 'Cannot start the session before the scheduled time and date.'
            ]);
        }

        // Check if the meeting start URL is available
        $zoomResponse = json_decode($booking->zoom_response);
        if (isset($zoomResponse->start_url) && !empty($zoomResponse->start_url)) {
            return response()->json([
                'start_url' => $zoomResponse->join_url,
                'status'    => true
            ]);
        }

        // If the start URL is not available
        return response()->json([
            'status' => false,
            'message' => 'Faculty not available to start call. Please try again later.'
        ]);
    }

}
