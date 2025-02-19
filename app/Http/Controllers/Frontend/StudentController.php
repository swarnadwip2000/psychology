<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\BookingNotification;
use App\Models\BookingSlot;
use App\Models\City;
use App\Models\Country;
use App\Models\MeetingHistory;
use App\Models\Slot;
use App\Models\User;
use App\Models\UserSubscription;
use App\Traits\ImageTrait;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    use ImageTrait;
    public function dashboard(Request $request)
    {
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";

        $my_time_zone = auth()->user()->time_zone; // User's timezone


        $today_date = Carbon::now($my_time_zone)->format('Y-m-d H:i'); // Today's date in user's timezone

        $data['teacher'] = BookingSlot::where('student_id', Auth::user()->id)
            ->whereIn('meeting_status', [0, 1])
            // ->whereDate('date', '>=', $today_date) // Slot date is today or future
            ->orderBy('id', 'desc')
            ->with(['teacher', 'student'])
            ->get()
            ->map(function ($items) use ($my_time_zone, $today_date) {
                // Convert slot time from teacher's timezone to user's timezone
                $slot_date_time_in_user_timezone = Carbon::parse($items->date . ' ' . $items->time, $items->teacher->time_zone)
                    ->setTimezone($my_time_zone)->addMinutes(40)
                    ->format('Y-m-d H:i'); // Format as 24-hour time

                if ($slot_date_time_in_user_timezone >= $today_date) {
                    $items->teacher_name = $items->teacher->name;
                    return $items;
                }
            })->filter(); // Remove null values from the collection


        $data['booking_history'] = BookingSlot::where('student_id', Auth::user()->id)
            ->where('meeting_status', 2) // Filter by meeting_status = 2
            // ->whereDate('date', '<', date('Y-m-d'))->orderBy('id', 'desc')
            ->with(['teacher', 'student']) // Eager load related models
            ->orderBy('id', 'desc')
            ->paginate(10) // Paginate results first
            ->through(function ($item) { // Use through for transformation
                $item->teacher_name = $item->teacher->name; // Add teacher_name attribute
                return $item;
            });



        // Get all relevant booking slots
        $bookings = BookingSlot::where('student_id', Auth::user()->id)
            ->whereIn('meeting_status', [0, 1])
            ->with(['teacher', 'student'])
            ->orderBy('id', 'desc')
            ->get();
        // dd($bookings->toArray());
        // Loop through each booking slot and update status
        foreach ($bookings as $booking) {
            // Convert slot time from teacher's timezone to user's timezone
            $slot_date_time_in_user_timezone = Carbon::parse($booking->date . ' ' . $booking->time, $booking->teacher->time_zone)
                ->setTimezone($my_time_zone)->addMinutes(40)
                ->format('Y-m-d H:i'); // Format as 24-hour time

            if ($slot_date_time_in_user_timezone < $today_date) {
                // dd($slot_date_time_in_user_timezone, $current_date_time_plus_40);
                $booking->update(['meeting_status' => 2]);

                // If meeting_start_time is not null, update meeting_end_time
                if ($booking->meeting_start_time) {
                    $meeting_end_time = Carbon::parse($booking->meeting_start_time)
                        ->addMinutes(40) // Add 40 minutes
                        ->format('Y-m-d H:i'); // Format as full datetime

                    $booking->update(['meeting_end_time' => $meeting_end_time]);
                }
            }
        }



        return view('frontend.student.dashboard')->with($data);
    }


    public function facultyBooking(Request $request)
    {
        $token = auth()->user()->session_token;
        // Get teacher and student information
        $teacher = User::findOrFail($request->teacher_id);
        $student = User::findOrFail(auth()->id());

        $last_user_subscription = UserSubscription::where('user_id', auth()->id())->orderBy('id', 'desc')->first();

        if ($last_user_subscription) {
            if ($last_user_subscription->membership_expiry_date >=  now()->toDateString()) {
                if ($token <= 0) {
                    return redirect()->back()->with('error', 'No session token available in your bucket! Please upgrade your plan');
                }
                // Find the slot
                $slot = Slot::findOrFail($request->booking_time);

                // Create the booking
                $booking = BookingSlot::create([
                    'slot_id' => $slot->id,
                    'teacher_id' => $request->teacher_id,
                    'student_id' => Auth::guard('web')->id(),
                    'date' => $slot->slot_date,
                    'time' => $slot->slot_time,
                    'meeting_status' => 0,
                ]);


                // Email data
                $emailDataTeacher = [
                    'date' => $slot->slot_date,
                    'time' => $slot->slot_time,
                    'teacher_name' => $teacher->name,
                    'student_name' => $student->name,
                ];
                $my_time_zone = auth()->user()->time_zone;
                $date_time = Carbon::parse($slot->date . ' ' . $slot->time, $slot->teacher->time_zone)
                    ->setTimezone($my_time_zone)
                    ->format('Y-m-d H:i');

                $emailDataStudent = [
                    'date' => date('Y-m-d', strtotime($date_time)),
                    'time' => date('H:i', strtotime($date_time)),
                    'teacher_name' => $teacher->name,
                    'student_name' => $student->name,
                ];

                $student->session_token  = $student->session_token - 1;
                $student->save();
                // Send email to the teacher
                Mail::to($teacher->email)->send(new BookingNotification($emailDataTeacher, 'teacher'));

                // Send email to the student
                Mail::to($student->email)->send(new BookingNotification($emailDataStudent, 'student'));

                return redirect()->route('front.student_dashboard')->with('message', 'Booking created successfully!');
            } else {
                return redirect()->route('subscription')->with('error', 'Please upgrade your Subscription');
            }
        } else {
            return redirect()->route('subscription')->with('error', 'Please upgrade your Subscription');
        }
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
    //         return redirect()->route('front.student_dashboard')->with('error', 'Booking created, but meeting link is unavailable. Please contact support.');
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
        $page_title = "Book Faculty";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";

        $my_time_zone = auth()->user()->time_zone; // User's timezone

        $teacher = User::role('FACULTY')->where('status', 1)
            ->when($facultyName, function ($query) use ($facultyName) {
                return $query->where('name', 'like', '%' . $facultyName . '%');
            })
            ->with(['slot' => function ($q) use ($my_time_zone) {
                $q->select('teacher_id', 'slot_date', 'slot_time') // Ensure you select time_zone
                    ->whereDate('slot_date', '>=', Carbon::now()->toDateString())
                    ->groupBy('teacher_id', 'slot_date', 'slot_time');
            }])
            ->get()
            ->map(function ($teacher) use ($my_time_zone) {
                // Convert each slot date/time to the authenticated user's timezone
                $teacher->slot = $teacher->slot->map(function ($slot) use ($my_time_zone) {
                    $slot->slot_date_time = Carbon::parse($slot->slot_date . ' ' . $slot->slot_time, $slot->teacher->time_zone)
                        ->setTimezone($my_time_zone)
                        ->format('Y-m-d'); // Convert to user's timezone
                    return $slot;
                });
                return $teacher;
            });

            $last_user_subscription = UserSubscription::where('user_id', auth()->id())->orderBy('id', 'desc')->first();

            if ($last_user_subscription) {
                if ($last_user_subscription->membership_expiry_date >=  now()->toDateString()) {
                    $bio_show = true;
                } else{
                    $bio_show = false;
                }
            } else{
                $bio_show = false;
            }

        // dd($data['teacher']->toArray());
        return view('frontend.student.book_now')->with(compact('page_title', 'bio_show', 'teacher'));
    }



    // public function getAvailableSlot(Request $request)
    // {
    //     $date = date('Y-m-d', strtotime($request->date)) ?? null;
    //     $teacher = $request->teacher_id ?? null;
    //     $now_date = date('Y-m-d');
    //     $current_time_in_user_tz = Carbon::now(auth()->user()->time_zone)->format('H:i'); // Current time in user's timezone

    //     $my_timezone = auth()->user()->time_zone; // User's timezone
    //     $teacher_data = User::find($teacher);
    //     $teacher_time_zone = $teacher_data->time_zone; // Teacher's timezone

    //     if ($date == $now_date) {
    //         // Convert current user's time to the teacher's timezone for accurate filtering
    //         $current_time_in_teacher_tz = Carbon::now($my_timezone)
    //             ->setTimezone($teacher_time_zone)
    //             ->format('H:i');

    //         $slot = Slot::whereDate('slot_date', $date)
    //             ->whereTime('slot_time', '>', $current_time_in_teacher_tz) // Use converted time
    //             ->where('teacher_id', $teacher)
    //             ->whereDoesntHave('bookingSlot')
    //             ->get();
    //     } else {
    //         $slot = Slot::whereDate('slot_date', $date)
    //             ->where('teacher_id', $teacher)
    //             ->whereDoesntHave('bookingSlot')
    //             ->get();
    //     }

    //     $option = "<option>Select</option>";
    //     foreach ($slot as $val) {
    //         // Convert slot time from teacher's timezone to user's timezone for display
    //         $slot_time_in_user_timezone = Carbon::createFromFormat(
    //             'Y-m-d H:i:s',
    //             $val->slot_date . ' ' . $val->slot_time, // Combine date and time
    //             $teacher_time_zone // Assuming the slot times are stored in the teacher's timezone
    //         )->setTimezone($my_timezone); // Convert to user's timezone

    //         $option .= "<option value='" . $val->id . "'>" . $slot_time_in_user_timezone->format('H:i') . "</option>";
    //     }

    //     return response()->json($option);
    // }


    public function getAvailableSlot(Request $request)
    {
        $date = date('Y-m-d', strtotime($request->date)) ?? null;
        $teacher = $request->teacher_id ?? null;

        $my_time_zone = auth()->user()->time_zone; // User's timezone
        $teacher_data = User::find($teacher);
        $teacher_time_zone = $teacher_data->time_zone; // Teacher's timezone
        $current_time_in_user_timezone = Carbon::now($my_time_zone)->format('H:i'); // Current time in user's timezone
        $current_date_in_user_timezone = Carbon::now($my_time_zone)->format('Y-m-d');
        $slots = Slot::where('teacher_id', $teacher)
            ->whereDoesntHave('bookingSlot') // Exclude booked slots
            ->get();

        $available_slots = $slots->filter(function ($slot) use ($my_time_zone, $current_time_in_user_timezone, $current_date_in_user_timezone, $date) {
            // Convert slot date and time from UTC to user's timezone
            $slot_date_time = Carbon::parse($slot->slot_date . ' ' . $slot->slot_time, $slot->teacher->time_zone)
                ->setTimezone($my_time_zone);

            // If checking today's date, only include future slots
            if ($slot_date_time->format('Y-m-d') == $date) {

                if ($slot_date_time->format('Y-m-d') == $current_date_in_user_timezone) {
                    return $slot_date_time->format('H:i') > $current_time_in_user_timezone;
                }
                return true;
            }

            // If future date, always available
        });

        $option = "<option>Select</option>";
        foreach ($available_slots as $val) {
            // Convert slot time from teacher's timezone to user's timezone for display
            $slot_time_in_user_timezone = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $val->slot_date . ' ' . $val->slot_time, // Combine date and time
                $teacher_time_zone // Assuming the slot times are stored in the teacher's timezone
            )->setTimezone($my_time_zone); // Convert to user's timezone

            $option .= "<option value='" . $val->id . "'>" . $slot_time_in_user_timezone->format('H:i') . "</option>";
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
        $my_timezone = auth()->user()->time_zone;
        // Combine the date and time to create a full start datetime

        $scheduledStart = Carbon::parse($booking->date . ' ' . $booking->time, $booking->teacher->time_zone)
        ->setTimezone($my_timezone); // Format as 24-hour time

        // $scheduledStart = Carbon::parse($booking->date . ' ' . $booking->time);
        // dd($scheduledStart, Carbon::now($my_timezone));
        // Check if the current time is before the scheduled start time
        if (Carbon::now($my_timezone)->lt($scheduledStart)) {
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

    public function profile()
    {
        $page_title  = "Profile";
        $countries   = Country::get();
        $student = User::find(auth()->id());
        return view('frontend.student.profile')->with(compact('countries', 'page_title', 'student'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif', // If profile picture is uploaded
            'address' => 'nullable|string|max:255',
            'city_id' => 'required|string|max:255',
            'country_id' => 'required|string|max:255',
            'student_age' => 'required|integer|min:1|max:120',
            'student_class' => 'required|string|max:255',
            'institute_name' => 'required|string|max:255',
        ]);

        $data = User::find(auth()->user()->id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->country_id = $request->country_id;
        $data->student_age = $request->student_age;
        $data->student_class = $request->student_class;
        $data->institute_name = $request->institute_name;
        if ($request->profile_picture) {
            $data->profile_picture = $this->imageUpload($request->file('profile_picture'), 'profile');
        }
        $data->save();
        return redirect()->back()->with('message', 'Student updated successfully.');
    }
}
