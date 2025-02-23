<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use DB;
use Auth;

class WholesaleController extends Controller
{
    public function adminwholesalebaseproducts(){
        return view('wholesale.adminbaseproducts');
    }

    public function adminwholesalebranchproducts(){
      return view('wholesale.adminwholesalebranchproducts');
  }

  public function  insertwholesalebaseproduct(request $request){
    $data = array();
    $data['product'] = $request->product;
    $data['supplier'] = $request->supplier;
    $data['unit'] = $request->unit;
    $data['orderprice'] = $request->orderprice;
    $data['sellingprice'] = $request->sellingprice;
    $data['batchnumber'] = $request->batchnumber;
    $data['expirydate'] = $request->expirydate;
    $data['vat'] = $request->vat;

    $messages = [
      'product.unique' => 'Product name must be unique (You can separate by brands).',
      'proudct.required' => 'product name is required.',
      'supplier.required' => 'Supplier is required.',
      'unit.required' => 'Unit is required.',
      'orderprice.required' => 'Order price  is required',
      'sellingprice.required' => 'Selling price  is required',
    ];
  $validator = $request->validate([
    'product' => 'required|unique:wholesalebaseproducts,product',
    'supplier' => 'required',
    'unit' => 'required',
    'orderprice' => 'required',
    'sellingprice' => 'required',
  ], $messages);
  
  if($validator){
  $insertData =  DB::table('wholesalebaseproducts')->insert($data);
  if($insertData){
   return response()->json(['success' => 'Data submitted successfully','status'=>201]);
  }else{
    return response()->json(['error' => 'An error occured try again later','status'=>422]);
  }
  }
  else{
    return back()->withErrors($validator)->withInput();
  }
  } 



  public function  editwholesalebaseproduct(request $request){
    $data = array();
    $data['product'] = $request->product;
    $data['supplier'] = $request->supplier;
    $data['unit'] = $request->unit;
    $data['orderprice'] = $request->orderprice;
    $data['sellingprice'] = $request->sellingprice;
    $data['batchnumber'] = $request->batchnumber;
    $data['expirydate'] = $request->expirydate;
    $data['vat'] = $request->vat;

    $messages = [
      'product.unique' => 'Product name must be unique (You can separate by brands).',
      'proudct.required' => 'product name is required.',
      'supplier.required' => 'Supplier is required.',
      'unit.required' => 'Unit is required.',
      'orderprice.required' => 'Order price  is required',
      'sellingprice.required' => 'Selling price  is required',
    ];
  $validator = $request->validate([
    'product' => 'required|unique:wholesalebaseproducts,product,'.$request->id,
    'supplier' => 'required',
    'unit' => 'required',
    'orderprice' => 'required',
    'sellingprice' => 'required',
  ], $messages);
  
  if($validator){

    $updateData =DB::table('wholesalebaseproducts')->where('id',$request->id)->update($data);

    if($updateData ){
        return response()->json(['success' => 'Data updated succesfully','status'=>201]);
    }else{
        return response()->json(['error' => 'An error occured no data change detected','status'=>422]);
    }

  }
  else{
    return back()->withErrors($validator)->withInput();
  }
  } 

  


public function deletewholesalebaseproduct(request $request){
  $id = $request->id;
  $deleteData = DB::table('wholesalebaseproducts')->where('id',$id)->delete();  
  if($deleteData){
    return response()->json(['success' => 'Data deleted succesifully','status'=>201]);
  }else{
    return response()->json(['error' => 'An error occured try again later','status'=>422]);
  }
}


public function uploadWholesaleBaseProductsCsvFile(Request $request) 
{
    $csvData = json_decode($request->data, true);
    $supplier = Cookie::get('supplier') ?? "NA";
    $vat = "EX";
    $defaultExpiryDate = Carbon::today()->addYears(2);
    $chunkSize = 50;
    $chunks = array_chunk($csvData, $chunkSize);

    $imported = 0;
    $errors = [];

    foreach ($chunks as $chunk) {
        foreach ($chunk as $row) {
            if (!empty($row)) {
                $values = array_values($row);
                if (!empty($values[0])) {
                    $orderPrice = $this->extractNumber($values[2]);
                    $sellingPrice = $this->extractNumber($values[3]);
                    $expiryDate = $values[5];
                    if (strtotime($expiryDate)) {
                        $expiryDate = date('Y-m-d', strtotime($expiryDate));
                    } else {
                      $expiryDate = $defaultExpiryDate; 
                    }

                    if (!is_numeric($orderPrice)) {
                        $orderPrice = 0;
                    }
                    if (!is_numeric($sellingPrice)) {
                        $sellingPrice = 0;
                    }
                    $baseProduct = [
                        'product' => $values[0] ?? null,
                        'unit' => $values[1] ?: "Each",
                        'orderprice' => $orderPrice,
                        'sellingprice' => $sellingPrice,
                        'batchnumber' => $values[4] ?: "NA",
                        'expirydate' =>$expiryDate,
                        'vat' => $vat,
                        'supplier' => $supplier,
                    ];
                    try {
                        $importData = DB::table('wholesalebaseproducts')->insertOrIgnore($baseProduct);
                        if( $importData){
                          $imported++;
                        }
                    } catch (\Exception $e) {
                        $errors[] = "Error importing record: " . $e->getMessage();
                    }
                } else {
                    // Log or handle the case where the product name is empty
                }
            }
        }
    }

    return response()->json([
        'message' => 'Processing complete',
        'success' => count($errors) == 0,
        'imported' => $imported,
        'errors' => $errors,
    ]);
}

private function extractNumber($value)
{
    $value = str_replace(',', '', $value); // Remove commas
    preg_match_all('/\d+/', $value, $matches);
    return implode('', $matches[0]) ?? 0;
}

public function hy(request $request){
 $data = array();
 $data['product'] = $request->productid;
 $data['branch'] = $request->branch;
 $data['quantity'] = $request->quantity;

 DB::table('wholesalebranchproducts')->insert($data);
  
}




public function insertwholesalebranchproduct(Request $request) {
      $data = array();
      $data['product'] = $request->productid;
      $data['branch'] = $request->branch;
      $data['quantity'] = $request->quantity;

      $messages = [
          'quantity.required' => 'Quantity is required.',
          'quantity.numeric' => 'Quantity must be a number.',
          'branch.gt' => 'Select a sipecific branch.',
      ];

      $validator = $request->validate([
          'quantity' => 'required|numeric',
          'branch' => 'gt:0',
      ], $messages);

      if ($validator) {
          $insertData = DB::table('wholesalebranchproducts')->insert($data);
          if ($insertData) {
              return response()->json(['success' => 'Data submitted successfully', 'status' => 201]);
          } else {
              return response()->json(['error' => 'An error occurred. Try again later', 'status' => 422]);
          }
      } else {
          return back()->withErrors($validator)->withInput();
      }

}













}
