<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Auth;class WebsiteController extends Controller
{
    public function websitestatus(){
        return view('website.status');
    }

    public function changewebsitestatus(request $request){


    }



    
public function rselecteditemschangedate(request $request){
    $data = json_decode($request->data, true);
    $password =  end($data);
    $date = $data[0];
    $hashedPassword=DB::table('users')->where('id',Auth::user()->id)->value('password');
    $dateData = Array();
    $dateData['date'] = $date;
    if(Hash::check($password, $hashedPassword)) {
        for($i=0;$i<count($data)-1;$i++){
            $oldqty = DB::table('retailsales')->where('id',$data[$i])->update($dateData); 
        }
        return 2;
        }
        else{
          return 1;
        }
}

}
