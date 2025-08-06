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
use Auth;
class WholesaleSalesController extends Controller
{
   
  public function __construct()
  {
      $this->middleware('auth');

  }

    public function wholesalesalesdashboard(){
        return view('wholesale.dashboard');
    }
    public function wholesalesalesprofile(){
        return view('wholesale.profile');
    }

    public function wholesalebranchinfo(){
     
      return view('wholesale.branchinfo');

    }

    
public function changepassword(Request $request)
{
    $messages = [
        'currentpassword.required' => 'Current password is required.',
        'newpassword.required' => 'New password is required.',
        'newpassword.min' => 'New password must be at least 4 characters',
        'comfirmpassword.required' => 'Confirming new password is mandatory.',
        'comfirmpassword.same' => 'New password and confirm password do not match.',
    ];
    $validator = $request->validate([
        'currentpassword' => 'required',
        'newpassword' => 'required|min:4',
        'comfirmpassword' => 'required|same:newpassword',
    ], $messages);

    if ($validator) {
        $hashedPassword = DB::table('users')->where('id', Auth::user()->id)->value('password');
        if (Hash::check($request->currentpassword, $hashedPassword)) {
            $data = array();
            $data['password'] = Hash::make($request->newpassword);
            $updatePassword = DB::table('users')->where('id', Auth::user()->id)->update($data);
            if ($updatePassword) {
                return response()->json(['success' => 'Password changed successfully', 'status' => 201]);
            } else {
                return response()->json(['error' => 'An unexpected error occurred while updating your password', 'status' => 422]);
            }
        } else {
            return response()->json(['error' => 'The current password you entered is incorrect. Please try again', 'status' => 422]);
        }
    } else {
        return back()->withErrors($validator)->withInput();
    }
}


  


}
