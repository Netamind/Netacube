<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Hash;
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Auth;
use Illuminate\Support\Str;
class WebController extends Controller
{
    public function homeview(){
        $webstatus = DB::table('websitestatus')->value('status');
        if($webstatus==0){
         return view('web.login');
        }
        else{
           return view('website.home'); 
        }
      
    }
    public function loginview(){
        return view('web.login');
    }

    public function forgotpassword(){
        return view('web.forgotpassword');
    }

    public function resetpasswordview(){

        return view('web.resetpasswordview');

    }

public function requestpasswordresetlink(Request $request)
{
    $data = array();
    $messages = [
        'email.required' => 'Email is required.',
        'email.email' => 'Email must be valid.',
        'email.exists' => 'Email not found in our records.',
    ];

    $validator = $request->validate([
        'email' => 'required|email|exists:users',
    ], $messages);

    if ($validator) {
        $token = Str::random(64);
      
        $passwordResetData = [
            'email' => $request->email,
            'token' => $token,
            'date' => Carbon::now(),
        ];
        DB::table('password_resets')->insert($passwordResetData);
        $data = ['token' => $token];
        try {
            Mail::send('web.passwordresetlink', ['data' => $data], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Password Reset');
            });
        return response()->json(['success' => 'Password reset link sent successfully! If you dont receive the email, please check your spam folder', 'status' => 201]);
        } catch (\Exception $e) {
            DB::table('password_resets')->where('email', $request->email)->where('token', $token)->delete();
            return response()->json([
                'error' => 'Failed to send password reset link. Refresh the page and  try again.',
                'message' => $e->getMessage(),
                'status' => 400
            ]);
      }
    } else {
        return response()->json(['error' => 'Validation failed', 'status' => 422, 'errors' => $validator->errors()]);
    }
}


public function resetpassword(Request $request)
{

    $data = array();

    $data['password'] = Hash::make($request->password);

    $token = $request->token;

    $messages = [
        'password.required' => 'Password is required.',
        'password_confirmation.required' => 'Password confirmation is required.',
    ];

    $validator = $request->validate([
        'password' => 'required|min:4|confirmed',
        'password_confirmation' => 'required',
    ], $messages);
    if ($validator) {
        $tokenData = DB::table('password_resets')->where('token', $token)->first();
        if ($tokenData) {
            if ($tokenData->status == 1) {
                $tokenDate = date('Y-m-d', strtotime($tokenData->date));
                $currentDate = date('Y-m-d');
                if ($tokenDate == $currentDate) {
                    $updateData = DB::table('users')->where('email', $tokenData->email)->update($data);
                    if ($updateData) {
                        DB::table('password_resets')->where('token', $token)->where('email', $tokenData->email)->update(['status' => 0]);
                        return response()->json(['success' => 'Password reset successfully', 'status' => 201]);
                    } else {
                        return response()->json(['error' => 'An error occurred try again later', 'status' => 422]);
                    }
                } else {
                    return response()->json(['error' => 'Link has expired', 'status' => 400]);
                }
            } else {
                return response()->json(['error' => 'Link already used', 'status' => 400]);
            }
        } else {
            return response()->json(['error' => 'Invalid token'.$token, 'status' => 400]);
        }
    } else {
        return back()->withErrors($validator)->withInput();
    }
}




}
