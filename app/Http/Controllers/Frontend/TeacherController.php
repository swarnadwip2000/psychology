<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BookingSlot;
use App\Models\City;
use App\Models\Slot;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard(Request $request){

        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";
        $data['booking_slot'] = BookingSlot::whereDate('date', '>=', date("Y-m-d"))
        ->where('teacher_id', Auth::user()->id )
        ->with(['student', 'teacher'])
        ->latest()
        ->get();
        return view('frontend.teacher.dashboard')->with($data);

    }

    public function session(Request $request){
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Dashboard";
        $data['page_keyword'] = "Dashboard";
        $data['slots']        = Slot::where('teacher_id', Auth::user()->id)->latest()->get();
        return view('frontend.teacher.session')->with($data);
    }

    public function addsession(Request $request){
        $date = date('Y-m-d', strtotime($request->slot_date));
        $time = date('H:i', strtotime($request->slot_time));
        $data =  [
            'teacher_id' => Auth::user()->id,
            'slot_date' => $date,
            'slot_time' => $time,
        ];


        $isDuplicate = Slot::where($data)->count();

        if($isDuplicate == 0){
            $data = array_merge($data, [
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $slot = Slot::create($data);
        }

        return redirect()->route('auth_teacher_session');

    }

    public function deletesession(Request $request){
        $slotId = $request->id;
        Slot::where('id', $slotId)->delete();
        return redirect()->route('auth_teacher_session');
    }

    public function createMeeting(Request $request){
            $meeting = new MeetingController();
            $requestObj = new Request([
                'agenda' => "Start New Class",
                'booking_id'  => $request->booking_id
            ]);
            $meeting->createMeeting($requestObj);
            return redirect()->route('auth_teacher_dashboard');
    }

    public function logout(Request $request){
        Auth::guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('front.faculty_login');
    }

    public function liveClass(Request $request)
    {
            $data['page_title'] = "Live class";
            $data['page_description'] = "Live class";
            $data['page_keyword'] = "Live class";

            $data['meeting'] = BookingSlot::where('zoom_id', $request->meeting_id)->get()->map(function($items){
                $meetingResponse = json_decode($items->zoom_response);
                $items->password = $meetingResponse->password;
                $items->full_name = "Sankar Bera";
                return $items;
            })->first();
            return view('frontend.teacher.live_class')->with($data);
    }

    public function renderFaculity(){
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
            $studentName = $request->name??null;
            $countryId = $request->country_id??null;
            $cityId = $request->city_id??null;
            $degree = collect(config('class.dropdown_fuclaty_degree'))->pluck('name', 'id');

            $model = Teacher::
                when($countryId, function($q) use($countryId){
                    $q->where('country_id', $countryId);
                })
                ->when($cityId, function($q) use($cityId){
                    $q->where('city_id', $cityId);
                })
                ->when($studentName, function($q) use($studentName){
                    $q->where('name', $studentName);
                })
                ->whereIn('register_as', [3])
                ->with('cities')->get()->map(function ($items, $key) use($countryName, $degree) {

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
