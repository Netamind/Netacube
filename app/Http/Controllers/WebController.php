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
    public function loginview(){

        return view('web.login');
    }

    public function forgotpassword(){
        return view('web.forgotpassword');
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


   

}
