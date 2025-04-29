<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Auth;
class SelectionController extends Controller
{
    public function makeselection(Request $request)
{
    $user = Auth::user()->id;
    $checkuser = DB::table('selection')->where('user', $user)->count();

    // Validate date fields
    if ($request->has('startdate') && $request->has('enddate')) {
        $startDate = Carbon::parse($request->startdate);
        $endDate = Carbon::parse($request->enddate);
        if ($startDate->gt($endDate)) {
            $notification = array(
                'message' => 'Error!. Startdate must be less than enddate and the range should be not more than 124 days',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
        if ($endDate->diffInDays($startDate) > 124) {
            $notification = array(
                'message' => 'Error!. Startdate and enddate range should not be more than 124 days',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    } elseif ($request->has('rdate') || $request->has('wdate')) {
        $dateField = $request->has('rdate') ? $request->rdate : $request->wdate;
        $date = Carbon::parse($dateField);
        $diffInDays = $date->diffInDays(Carbon::now());
        if ($diffInDays > 124) {
            $notification = array(
                'message' => 'Error!. Date cannot be more than 124 days away',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    // Update or insert data
    $data = $request->except('_token');
    if (isset($data['rcategory']) && $data['rcategory'] != '') {
        $data['rsupplier'] = 'All';
    }
    if (isset($data['wcategory']) && $data['wcategory'] != '') {
        $data['wsupplier'] = 'All';
    }

    if ($checkuser > 0) {
        DB::table('selection')->where('user', $user)->update($data);
    } else {
        $data['user'] = $user;
        DB::table('selection')->insert($data);
    }

    $notification = array(
        'message' => 'Selection updated successfully',
        'alert-type' => 'success'
    );
    return Redirect()->back()->with($notification);
}

}
