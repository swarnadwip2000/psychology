<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BookingSlot;
use App\Models\City;
use App\Models\Slot;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard(Request $request)
    {

        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";

        $my_time_zone = auth()->user()->time_zone; // User's timezone


        $today_date = Carbon::now($my_time_zone)->format('Y-m-d H:i'); // Today's date in user's timezone

        $data['booking_slot'] = BookingSlot::where('teacher_id', Auth::user()->id)
            // ->whereDate('date', '>=', date("Y-m-d"))
            ->whereIn('meeting_status', [0, 1])  // Filter by meeting_status being null or 1 (in-progress)
            ->with(['student', 'teacher'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($items) use ($my_time_zone, $today_date) {
                // Convert slot time from teacher's timezone to user's timezone
                $slot_date_time_in_user_timezone = Carbon::parse($items->date . ' ' . $items->time)
                    ->setTimezone($my_time_zone)->addMinutes(40)
                    ->format('Y-m-d H:i'); // Format as 24-hour time

                if ($slot_date_time_in_user_timezone >= $today_date) {
                    $items->teacher_name = $items->teacher->name;
                    return $items;
                }
            })->filter(); // Remove null values from the collection

        $data['booking_history'] = BookingSlot::where('teacher_id', Auth::user()->id)
            // ->whereDate('date', '<', date('Y-m-d'))->orderBy('id', 'desc')
            ->whereIn('meeting_status', [2])  // Filter by meeting_status being null or 1 (in-progress)
            ->with(['student', 'teacher'])
            ->latest()
            ->paginate(10);

            $bookings = BookingSlot::where('teacher_id', Auth::user()->id)
            ->whereIn('meeting_status', [0, 1])
            ->with(['teacher', 'student'])
            ->orderBy('id', 'desc')
            ->get();

            foreach ($bookings as $booking) {
                // Convert slot time from teacher's timezone to user's timezone
                $slot_date_time_in_user_timezone = Carbon::parse($booking->date . ' ' . $booking->time)
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

        return view('frontend.teacher.dashboard')->with($data);
    }

    public function session(Request $request)
    {
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";
        $data['slots']        = Slot::where('teacher_id', Auth::user()->id)->latest()->get();
        return view('frontend.teacher.session')->with($data);
    }

    public function addsession(Request $request)
    {
        $date = date('Y-m-d', strtotime($request->slot_date));
        $time = date('H:i', strtotime($request->slot_time));
        $data =  [
            'teacher_id' => Auth::user()->id,
            'slot_date' => $date,
            'slot_time' => $time,
            'topic' => $request->topic
        ];


        $isDuplicate = Slot::where($data)->count();

        if ($isDuplicate == 0) {
            $data = array_merge($data, [
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $slot = Slot::create($data);
        }

        return redirect()->route('auth_teacher_session')->with('successmsg', 'Session create successfully');
    }

    public function deletesession(Request $request)
    {
        $slotId = $request->id;
        Slot::where('id', $slotId)->delete();
        return redirect()->route('auth_teacher_session')->with('errmsg', 'Session create successfully');
    }

    public function createMeeting(Request $request)
    {
        $meeting = new MeetingController();
        $booking = BookingSlot::findOrFail($request->booking_id);
        $my_timezone = auth()->user()->time_zone;
        // Check if the meeting has already been started
        if ($booking->zoom_id) {
            return response()->json([
                'status' => false,
                'message' => 'Meeting has already started. Please reload the page to join now.'
            ]);
        }

        // Combine the date and time to create a full start datetime
        $scheduledStart = Carbon::parse($booking->date . ' ' . $booking->time);
        // dd(now());
        // Check if the current time is before the scheduled start time
        if (Carbon::now($my_timezone)->lt($scheduledStart)) {
            return response()->json([
                'status' => false,
                'message' => 'Cannot start the session before the scheduled time and date.'
            ]);
        }

        // Prepare the request object for creating a meeting
        $requestObj = new Request([
            'booking_id'  => $request->booking_id,
            'topic'       => $booking->slot->topic,
            'start_time'  => $booking->time,
            'start_date'  => $booking->date,
        ]);

        // Create the meeting
        $meeting_json = $meeting->createMeeting($requestObj);
        $start_url = $meeting_json['start_url'] ?? '';

        $booking->update([
            'meeting_status' => 1,
            'meeting_start_time' => Carbon::now(),
        ]);

        return response()->json([
            'start_url' => $start_url,
            'status'    => true
        ]);
    }


    public function endMeeting(Request $request)
    {
        $booking = BookingSlot::findOrFail($request->booking_id);

        // Set the meeting status to ended (2)
        $booking->meeting_status = 2;
        $booking->meeting_end_time = Carbon::now();  // Store the meeting end time
        $booking->save();

        return response()->json(['status' => true]);
        // Proceed with your logic to end the Zoom call or finalize the meeting
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('front.faculty_login');
    }

    public function liveClass(Request $request)
    {
        $data['page_title'] = "Live class";
        $data['page_description'] = "Live class";
        $data['page_keyword'] = "Live class";

        $data['meeting'] = BookingSlot::where('zoom_id', $request->meeting_id)->get()->map(function ($items) {
            $meetingResponse = json_decode($items->zoom_response);
            $items->password = $meetingResponse->password;
            $items->full_name = "Sankar Bera";
            $items->start_url = $meetingResponse->start_url;
            return $items;
        })->first();

        // dd($data);
        return view('frontend.teacher.live_class')->with($data);
    }

    public function renderFaculity()
    {
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";
        $data['county_name']  = collect(config('class.dropdown_country'));
        $data['city_name']  = City::get();
        $data['degree']  = collect(config('class.dropdown_fuclaty_degree'));
        return view('admin.faculity.list')->with($data);
    }

    public function getFaculity(Request $request)
    {
        try {
            $countryName = config('class.allow_country');
            $studentName = $request->name ?? null;
            $countryId = $request->country_id ?? null;
            $cityId = $request->city_id ?? null;
            $degree = collect(config('class.dropdown_fuclaty_degree'))->pluck('name', 'id');

            $model = Teacher::when($countryId, function ($q) use ($countryId) {
                $q->where('country_id', $countryId);
            })
                ->when($cityId, function ($q) use ($cityId) {
                    $q->where('city_id', $cityId);
                })
                ->when($studentName, function ($q) use ($studentName) {
                    $q->where('name', $studentName);
                })
                ->whereIn('register_as', [3])
                ->with('cities')->get()->map(function ($items, $key) use ($countryName, $degree) {

                    $items->country_name = $countryName[$items->country_id];
                    $items->degree_name = $degree[$items->degree];
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
}
