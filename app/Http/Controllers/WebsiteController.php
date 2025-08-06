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
public function changeWebsiteStatus(Request $request)
{
    $password = $request->password;
    $hashedPassword = DB::table('users')->where('id', Auth::user()->id)->value('password');

    if (Hash::check($password, $hashedPassword)) {
        $currentStatus = DB::table('websitestatus')->value('status');
        $newStatus = $currentStatus == 1 ? 0 : 1;

        $updateStatus = DB::table('websitestatus')->update(['status' => $newStatus]);

        if ($updateStatus) {
            return response()->json([
                'success' => 'Website status updated successfully',
                'status' => $newStatus,
                'code' => 200
            ]);
        } else {
            return response()->json([
                'error' => 'No data update was made',
                'code' => 400
            ]);
        }
    } else {
        return response()->json([
            'error' => 'Invalid password entered',
            'code' => 401
        ]);
    }
}



    
}
