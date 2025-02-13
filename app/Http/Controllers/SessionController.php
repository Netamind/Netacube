<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use DB;
use Auth;

class SessionController extends Controller
{
   
public function selectCategory(Request $request) {
    $user = Auth::user()->id;
    $checkuser = DB::table('session')->where('user',$user)->count();
    if($checkuser){
    $updateSupplier = DB::table('session')->where('user',$user)->update(["category"=>$request->category]);
    if($updateSupplier){
     Cookie::queue(Cookie::forget('supplier'));
    } 
    return Redirect()->back();
    }
    else{
    $insertSupplier=DB::table('session')->insert(["category"=>$request->category ,"user"=>$user]);
     if($insertSupplier){
        Cookie::queue(Cookie::forget('supplier'));
        }
     return Redirect()->back();
    }
}
public function selectSupplier(Request $request) 
{ 
    $sup = $request->supplier;
    Cookie::queue('supplier', $sup, 14400); // expires in 100 days ( converted to minutes )
    return Redirect()->back();
}

public function selectBranch(Request $request) 
{ 
    $branch = $request->branch;
    Cookie::queue('branch', $branch, 14400); 
    return Redirect()->back();
}







}
