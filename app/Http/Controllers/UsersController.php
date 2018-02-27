<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\User;
use Excel;

class UsersController extends Controller
{
    public function index()
    {
        $data = Input::all();

        $results = User::searchFilter($data);
        $countries = User::getCountryList();
        $emotions = User::getEmotionList();

        return view('userslist',[
			'results' => $results, 
			'countries'=>$countries->toArray(),
			'emotions'=>$emotions->toArray(),
        ]);
    }

    public function show($module)
    {
        $checker = $this->methodCheckCms($module, [
           'userFilter', 'userProfile', 'upmoodCalendar', 'downloadFile', 'moodStream', 'moodForTheDay'
        ]);

        if($checker['status'] == 204) return $checker;

        return $this->$module();
    }

    public function update(Request $request, $module)
    {
        $checker = $this->methodCheckCms($module, [
           'userFilter', 'userProfile', 'upmoodCalendar'
        ]);

        if($checker['status'] == 204) return $checker;

        $result = $this->$module();
    }

    public function userFilter()
    {
        $data = Input::all();
        
        $res = [];

        $res['content'] = User::searchFilter($data)->paginate(10);
        $res['counts'] = User::advCardCounts($data)->first();

        return $res;
    }

    public function userProfile($id)
    {
        $data = Input::all();

        $profile = User::getProfile($id);
        $records = User::getRecords($id);
        $featured = User::getFeatured($id);

        return view('userprofile',[
            'profile'=>$profile,
            'records'=>$records->toArray(),
            'featured'=>$featured->toArray()
        ]);

    }

    public function upmoodCalendar(){
        $data = Input::all();

        $upmood_calendar = User::getCalendar($data);

        return $upmood_calendar;
    }

    public function moodForTheDay(){
        $data = Input::all();

        $moodForTheDay = User::getMoodForTheDay($data);
        // print_r($moodForTheDay);
        return $moodForTheDay->toArray();
    }

    public function moodStream($id)
    {
        $records = User::getRecords($id);

        return $records;
    }

    public function downloadFile(){
        $data = Input::all();

        $content = User::searchFilter($data)->get()->toArray();

        Excel::create('Upmood Users', function($excel) use($content){

            $excel->sheet('Users', function($sheet) use($content){

                $header = ['Name', 'Gender', 'Age', 'Current Emotion', 'Stress Level', 'BPM', 'Status', 'Upmood Meter','Location', 'Active Level'];

                $sheet->row(1, $header);

                foreach ($content as $key => $value) {

                    if($value->upmood_meter == null){
                        $upmood_meter = "No Record Found";
                    }elseif($value->upmood_meter <= -61){
                        $upmood_meter = 'Sad';
                    }elseif($value->upmood_meter <= -21){
                        $upmood_meter = 'Unpleasant';
                    }elseif($value->upmood_meter <= 20){
                        $upmood_meter = 'Calm';
                    }elseif($value->upmood_meter <= 60){
                        $upmood_meter = 'Pleasant';
                    }elseif($value->upmood_meter <= 100){
                        $upmood_meter = 'Happy';
                    }

                    $dataContent = [$value->name, $value->gender, $value->age, $value->emotion_value, $value->stress_level, $value->heartbeat_count, $value->profile_post, $upmood_meter,$value->country, $value->active_level ];

                    $sheet->row($key+3, $dataContent);

                }

            });

        })->export('xls');
    }
}
