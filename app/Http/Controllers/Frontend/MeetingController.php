<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BookingSlot;
use Illuminate\Http\Request;
use App\Models\MeetingHistory;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Zoom;
use Illuminate\Support\Facades\Auth;
class MeetingController extends Controller
{
    // public function createMeeting(Request $request){

    //     try {
    //     $agenda = $request->agenda??null;
    //     $topic  = $request->topic??null;
    //     $password  = $request->password??null;
    //     $startTime  = $request->start_time??null;
    //     $studentId  = $request->student_id??null;
    //     $teacherId  = $request->teacher_id??Auth::user()->id;

    //     $meetings = Zoom::createMeeting([
    //         "agenda" => $agenda,
    //         "topic" => $topic,
    //         "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
    //         "duration" => 60, // in minutes
    //         "timezone" => 'Asia/Calcutta', // set your timezone
    //         "password" => $password,
    //         "start_time" => $startTime, // set your start time
    //         // "template_id" => 'set your template id', // set your template id  Ex: "Dv4YdINdTk+Z5RToadh5ug==" from https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingtemplates
    //         // "pre_schedule" => false,  // set true if you want to create a pre-scheduled meeting
    //         // "schedule_for" => 'set your schedule for profile email ', // set your schedule for
    //         "settings" => [
    //             'join_before_host' => false, // if you want to join before host set true otherwise set false
    //             'host_video' => false, // if you want to start video when host join set true otherwise set false
    //             'participant_video' => false, // if you want to start video when participants join set true otherwise set false
    //             'mute_upon_entry' => false, // if you want to mute participants when they join the meeting set true otherwise set false
    //             'waiting_room' => false, // if you want to use waiting room for participants set true otherwise set false
    //             'audio' => 'both', // values are 'both', 'telephony', 'voip'. default is both.
    //             'auto_recording' => 'none', // values are 'none', 'local', 'cloud'. default is none.
    //             'approval_type' => 0, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
    //         ],

    //     ]);


    //     $meetingResponse = $meetings['data'];

    //     MeetingHistory::create([
    //         'student_id' => $studentId,
    //         'teacher_id' => $teacherId,
    //         'agenda'     => $agenda,
    //         'topic'     => $topic,
    //         'password'  => $password,
    //         'start_time' => date('Y-m-d H:i:s', strtotime($startTime)),
    //         'zoom_response' => $meetings['data'],
    //         'created_by'    => Auth::user()->id
    //      ]);

    //      $data['success'] = true;
    //      $data['message'] = "Meeting has been created successfully";
    //      return response()->json($data, 200);

    //     } catch (\Exception $error) {
    //         return response()->json(['error' => $error->getMessage()], 500);
    //     }


    // }

    public function createMeeting(Request $request)
    {
        // Validate input

        $agenda = $request->agenda??'Online Tutorial';
        $topic  = $request->topic??"Chapter 11";
        $password  = $request->password??null;
        $startTime  = date('Y-m-d H:i:s', strtotime($request->start_time))??date("Y-m-d H:i:s");
        $startTime  = "2024-12-17 23:55:00";

        $bookingId  = $request->booking_id;

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' .self::generateToken(),
                'Content-Type' => 'application/json',
            ])->post("https://api.zoom.us/v2/users/me/meetings", [
                'topic' => $topic,
                "agenda" => $agenda,
               // 'type' => 2, // 2 for scheduled meeting
                'start_time' => $startTime,
                'duration' => 30,
                //"password" => $password,
                "settings" => [
                    'show_share_button' => false,
                    'join_before_host' => true, // if you want to join before host set true otherwise set false
                    'host_video' => true, // if you want to start video when host join set true otherwise set false
                    'participant_video' => false, // if you want to start video when participants join set true otherwise set false
                    'mute_upon_entry' => false, // if you want to mute participants when they join the meeting set true otherwise set false
                    'waiting_room' => false, // if you want to use waiting room for participants set true otherwise set false
                    'audio' => 'both', // values are 'both', 'telephony', 'voip'. default is both.
                    'auto_recording' => 'none', // values are 'none', 'local', 'cloud'. default is none.
                    'approval_type' => 1, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
                    'registration_type' => 2,
                    'enforce_login' => false,
                ],
            ]);

            $meetingResponse = $response->json();

            BookingSlot::where([
                'id' => $bookingId,
             ])->update([
                'zoom_id' => $meetingResponse['id'],
                'zoom_response' => $meetingResponse
             ]);

             $data['success'] = true;
             $data['message'] = "Meeting has been created successfully";
             return response()->json($data, 200);

    }

    public function generateToken()
    {

            $base64String = base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'));
            $accountId = env('ZOOM_ACCOUNT_ID');

            $responseToken = Http::withHeaders([
                "Content-Type"=> "application/x-www-form-urlencoded",
                "Authorization"=> "Basic {$base64String}"
            ])->post("https://zoom.us/oauth/token?grant_type=account_credentials&account_id={$accountId}");



            return $responseToken->json()['access_token'];


    }

    public function getMeeting(Request $request){
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";
        $data['students']       = User::whereIn('register_as', [1, 2])->get();
        return view('meeting.meeting_list')->with($data);
    }

    public function fetchMeeting(Request $request){

        $studentId = $request->student_id??null;
        $teacherId = $request->teacher_id??null;
        $createdBy = $request->created_by??null;

        $responseData = MeetingHistory::with(['student', 'teacher', 'createdBy'])
        ->when($studentId, function($q) use ($studentId){
            $q->where('student_id', $studentId);
        })
        ->when($teacherId, function($q) use ($teacherId){
            $q->where('teacher_id', $teacherId);
        })
        ->when($createdBy, function($q) use ($createdBy){
            $q->where('created_by', $createdBy);
        })
        ->latest()
        ->get()->map(function($items, $key){
            $items->serial_no = ++$key;
            $items->student_name = $items->student->name;
            $items->email = $items->student->email;
            $items->created_by_name = $items->createdBy->name;
            $items->join_link = $items->join_link;
            $items->start_link = $items->start_link;
            return $items;
        });

        $data['totalCount'] = $responseData->count();
        $data['data'] = $responseData;
        return response()->json($data, 200);


    }
}
