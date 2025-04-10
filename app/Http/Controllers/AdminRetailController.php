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

class AdminRetailController extends Controller
{

  
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('isadmin');

  }

    public function adminretailbaseproducts(){
        return view('admin.retail.retailbaseproducts');
    }

    public function adminretailbranchproducts(){
      return view('admin.retail.retailbranchproducts');
  }

  public function  adminretailproducttracker(){
    return view('admin.retail.retailproducttracker');
}


public function  adminretailproductsupplies(){
  return view('admin.retail.retailproductsupplies');
}


public function  adminretailclients(){
  return view('admin.retail.retailclients');
}




public function  adminretailopeningstock(){
  return view('admin.retail.retailopeningstock');
}


public function adminretailopeningstockdata(){

return view('admin.retail.retailopeningstockdata');

}


public function adminretailsystemsales(){

    return view('admin.retail.retailsystemsales');
    
    }
    

    public function  adminretailactioncenter(){

        return view('admin.retail.retailactioncenter');
        
    }

   

  public function  insertretailbaseproduct(request $request){
    $data = array();
    $data['product'] = $request->product;
    $data['supplier'] = $request->supplier;
    $data['unit'] = $request->unit;
    $data['orderprice'] = $request->orderprice;
    $data['sellingprice'] = $request->sellingprice;
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
    'product' => 'required|unique:retailbaseproducts,product',
    'supplier' => 'required',
    'unit' => 'required',
    'orderprice' => 'required',
    'sellingprice' => 'required',
  ], $messages);
  
  if($validator){
  $insertData =  DB::table('retailbaseproducts')->insert($data);
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



  public function  editretailbaseproduct(request $request){
    $data = array();
    $data['product'] = $request->product;
    $data['supplier'] = $request->supplier;
    $data['unit'] = $request->unit;
    $data['orderprice'] = $request->orderprice;
    $data['sellingprice'] = $request->sellingprice;
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
    'product' => 'required|unique:retailbaseproducts,product,'.$request->id,
    'supplier' => 'required',
    'unit' => 'required',
    'orderprice' => 'required',
    'sellingprice' => 'required',
  ], $messages);
  
  if($validator){

    $updateData =DB::table('retailbaseproducts')->where('id',$request->id)->update($data);

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

  


public function deleteretailbaseproduct(request $request){
  $id = $request->id;
  $deleteData = DB::table('retailbaseproducts')->where('id',$id)->delete();  
  if($deleteData){
    return response()->json(['success' => 'Data deleted succesifully','status'=>201]);
  }else{
    return response()->json(['error' => 'An error occured try again later','status'=>422]);
  }
}


public function uploadRetailBaseProductsCsvFile(Request $request)
{
    $csvData = json_decode($request->data, true);
    $supplier = Cookie::get('rsupplier') ?? "NA";
    $vat = "EX";
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
                        'vat' => $vat,
                        'supplier' => $supplier,
                    ];

                    try {
                        $importData = DB::table('retailbaseproducts')->insertOrIgnore($baseProduct);
                        if ($importData) {
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





public function insertretailbranchproduct(Request $request) {
  $data = array();
  $data['product'] = $request->productid;
  $data['branch'] = $request->branch;
  $data['quantity'] = $request->quantity;

  $dnote = array();
  $dnote['branchid'] = $request->branch;
  $dnote['productid'] = $request->productid;
  $dnote['date'] = Carbon::today()->toDateString();
  $dnote['quantity'] = $request->quantity;
  $dnote['productname'] = DB::table('retailbaseproducts')->where('id', $request->productid)->value('product');
  $dnote['unit'] = DB::table('retailbaseproducts')->where('id', $request->productid)->value('unit') ?? "each";
  $dnote['price'] = DB::table('retailbaseproducts')->where('id', $request->productid)->value('sellingprice') ?? 0;
  $dnote['added_to_branch'] = "Yes";

  $history = array();
  $time = Carbon::now()->toTimeString();
  $devicedetails = "User Agent: " . $request->header('User-Agent');
                  
        $messages = [
          'quantity.required' => 'Quantity is required.',
          'quantity.numeric' => 'Quantity must be a number.',
          'quantity.gt' => 'Quantity must be gretaer than 0.',
          'branch.gt' => 'Select a specific branch.',
      ];

      $validator = $request->validate([
          'quantity' => 'required|numeric|gt:0',
          'branch' => 'gt:0',
      ], $messages);

if($validator){
  
  $existingProduct = DB::table('retailbranchproducts')
      ->where('branch', $request->branch)
      ->where('product', $request->productid)
      ->first();

  if ($existingProduct) {
      $qtybefore = $existingProduct->quantity;
      $qtyafter = $qtybefore + $request->quantity;

      DB::transaction(function () use ($request, $existingProduct, $dnote, $history, $qtybefore, $qtyafter, $devicedetails, $time) {
          DB::table('retailbranchproducts')
              ->where('branch', $request->branch)
              ->where('product', $request->productid)
              ->update(['quantity' => $qtyafter]);
          DB::table('retaildeliverynotes')->insert($dnote);
          $history['date'] = Carbon::today()->toDateString();
          $history['branchid'] = $request->branch;
          $history['productid'] = $request->productid;
          $history['qtyadded'] = $request->quantity;
          $history['username'] = Auth::user()->username;
          $history['devicedetails'] = $devicedetails;
          $history['qtybefore'] = $qtybefore;
          $history['qtyafter'] = $qtyafter;
          $history['description'] = "Directly added (update)";
          $history['time'] = $time;
          DB::table('retailproducthistory')->insert($history);
      });
  } else {
      DB::transaction(function () use ($data, $dnote, $history, $request, $devicedetails,$time) {
          DB::table('retailbranchproducts')->insert($data);
          DB::table('retaildeliverynotes')->insert($dnote);

          $history['date'] = Carbon::today()->toDateString();
          $history['branchid'] = $data['branch'];
          $history['productid'] = $data['product'];
          $history['qtyadded'] = $data['quantity'];
          $history['username'] = Auth::user()->username;
          $history['devicedetails'] = $devicedetails;
          $history['qtybefore'] = 0;
          $history['qtyafter'] = $data['quantity'];
          $history['description'] = "Directly added (insert)";
          $history['time'] = $time;

          DB::table('retailproducthistory')->insert($history);
      });
  }

  return response()->json(['success' => 'Data submitted successfully', 'status' => 201]);

}

else{

  return back()->withErrors($validator)->withInput();

}


}

public function deleteretailbranchproduct(Request $request)
{
    $history = array();
    $baseproductid = DB::table('retailbranchproducts')->where('id', $request->id)->value('product');
    $branchid = DB::table('retailbranchproducts')->where('id', $request->id)->value('branch');
    $qtyafter = 0;
    $qtybefore = DB::table('retailbranchproducts')->where('id', $request->id)->value('quantity');
    $description = "Deleted by " . Auth::user()->username;
    $date = Carbon::today()->toDateString();
    $devicedetails = "User Agent: " . $request->header('User-Agent');
    $time = Carbon::now()->toTimeString();

    $history['date'] = Carbon::today()->toDateString();
    $history['branchid'] = $branchid;
    $history['productid'] = $baseproductid;
    $history['qtyadded'] = -$qtybefore;
    $history['username'] = Auth::user()->username;
    $history['devicedetails'] = $devicedetails;
    $history['qtybefore'] = $qtybefore;
    $history['qtyafter'] = $qtyafter;
    $history['description'] = $description;
    $history['time'] = $time;
    try {
      DB::transaction(function () use ($history, $request) {
          DB::table('retailproducthistory')->insert($history);
          DB::table('retailbranchproducts')->where('id', $request->id)->delete();
      });
      return response()->json(['success' => 'Data deleted successfully', 'status' => 201]);
  } catch (\Exception $e) {
      return response()->json(['error' => 'An error occurred, try again later', 'status' => 422]);
  }



}

public function updateretailbranchproduct(Request $request){
  $data = array();
  $data['quantity'] = $request->quantity;
  $data['batchnumber'] = $request->batchnumber;
  $data['expirydate'] = $request->expirydate;
  $data['status'] = $request->status;
  $data['snumber'] = $request->shelfnumber;

  $baseproductid = DB::table('retailbranchproducts')->where('id', $request->id)->value('product');
  $branchid = DB::table('retailbranchproducts')->where('id', $request->id)->value('branch');
  $qtybefore = DB::table('retailbranchproducts')->where('id', $request->id)->value('quantity');

  $messages = [
      'quantity.gte:0' => 'Quantity must be greater than or equal to 0',
  ];

  $validator = $request->validate([
      'quantity' => 'required|gte:0',
  ], $messages);

  if($validator){
      try {
          DB::transaction(function () use ($request, $data, $qtybefore, $baseproductid, $branchid) {
              DB::table('retailbranchproducts')->where('id', $request->id)->update($data);

              if($qtybefore != $request->quantity){
                  $history = array();
                  $qtyafter = $request->quantity;
                  $qtyadded = $qtyafter-$qtybefore;
                  $description = $request->description;
                  $date = Carbon::today()->toDateString();
                  $devicedetails = "User Agent: " . $request->header('User-Agent');
                  $time = Carbon::now()->toTimeString();

                  $history['date'] = Carbon::today()->toDateString();
                  $history['branchid'] = $branchid;
                  $history['productid'] = $baseproductid;
                  $history['qtyadded'] = $qtyadded;
                  $history['username'] = Auth::user()->username;
                  $history['devicedetails'] = $devicedetails;
                  $history['qtybefore'] = $qtybefore;
                  $history['qtyafter'] = $qtyafter;
                  $history['description'] = $description;
                  $history['time'] = $time;

                  DB::table('retailproducthistory')->insert($history);
              }
          });

          return response()->json(['success' => 'Data updated succesfully','status'=>201]);
      } catch (\Exception $e) {
          return response()->json(['error' => 'An error occurred, try again later', 'status' => 422]);
      }
  } else{
      return back()->withErrors($validator)->withInput();
  }
}



public function insertretailclient(request $request){
  $data = array();
  $data['client']=$request->client;
  $data['address']=$request->address;
  $data['contact']=$request->contact;
  $data['email']=$request->email;  
  $data['date']=Carbon::today()->toDateString();
  $messages = [
    'client.required' => 'Client name is required.',
    'client.unique' => 'Client name must be unique.',
    'email.unique' => 'Email must be unique.',
    'email.required' => 'Email  is required.',
    'email.email' => 'Email must be valid.',
    'contact.required' => 'Contact is required.',
    'address.required' => 'Address is required.',
];

$validator = $request->validate([
    'client' => 'required|unique:retailclients,client',
    'email' => 'required|email|unique:retailclients,email',
    'contact' => 'required|unique:retailclients,contact',
    'address' => 'required',
  
], $messages);
if($validator){
  $insertData = DB::table('retailclients')->insert($data);
  if($insertData){
    return response()->json(['success' => 'Data submitted succesifully','status'=>201]);
  }
  else{

    return response()->json(['error' => 'An error occured try again later','status'=>422]);
  } 
}else{
  return  back()->withErrors($validator)->withInput();
}

}



public function deleteretailclient(request $request){
  $id = $request->id;
  $deleteData = DB::table('retailclients')->where('id',$id)->delete();  
  if($deleteData){
    return response()->json(['success' => 'Data deleted succesifully','status'=>201]);
  }else{
    return response()->json(['error' => 'An error occured try again later','status'=>422]);
  }
}


public function updateretailclient(Request $request)
{
    $data = array();
    $data['client'] = $request->client;
    $data['address'] = $request->address;
    $data['contact'] = $request->contact;
    $data['email'] = $request->email;
    $data['date'] = Carbon::today()->toDateString();

    $messages = [
        'client.required' => 'Client name is required.',
        'email.required' => 'Email is required.',
        'email.email' => 'Email must be valid.',
        'contact.required' => 'Contact is required.',
        'address.required' => 'Address is required.',
    ];

    $validator = $request->validate([
        'client' => 'required|unique:retailclients,client,' . $request->id,
        'email' => 'required|email|unique:retailclients,email,' . $request->id,
        'contact' => 'required|unique:retailclients,contact,' . $request->id,
        'address' => 'required',
    ], $messages);

    if ($validator) {
        $updateData = DB::table('retailclients')->where('id', $request->id)->update($data);
        if ($updateData) {
            return response()->json(['success' => 'Data updated succesfully', 'status' => 201]);
        } else {
            return response()->json(['error' => 'An error occured no data change detected', 'status' => 422]);
        }
    } else {
        return back()->withErrors($validator)->withInput();
    }
}


public function saveretailopeingstock(Request $request)
{
    $csvData = json_decode($request->data, true);
    $chunkSize = 50;
    $chunks = array_chunk($csvData, $chunkSize);
    $imported = 0;
    $errors = [];

    foreach ($chunks as $chunk) {
        foreach ($chunk as $row) {
            if (!empty($row)) {
                $values = array_values($row);
                $quantity = 0;
                if (is_numeric($values[6])) {
                  $quantity = $values[6];
              }

                if (!empty($values[0])) {
                    $stocklist = [
                        'productid' => $values[0],
                        'product' => $values[1],
                        'unit' => $values[2],
                        'price' => $values[3],
                        'branchid' => $values[4],
                        'date' => $values[5],
                        'quantity' => $quantity,
                    ];

                    try {
                        $existingRecord = DB::table('retailnewstocktaking')
                            ->where('productid', $stocklist['productid'])
                            ->where('branchid', $stocklist['branchid'])
                            ->first();

                        if ($existingRecord) {
                            // Update existing record
                            DB::table('retailnewstocktaking')
                                ->where('productid', $values[0])
                                ->where('branchid', $values[4])
                                ->update([
                                    'quantity' => $existingRecord->quantity + $quantity,
                                ]);
                        } else {
                            // Insert new record
                            DB::table('retailnewstocktaking')->insert($stocklist);
                        }

                        $imported++;
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


public function submitretailopeningstocktobranch()
{
    $branchId = Cookie::get('rbranch');
    $date = Cookie::get('rdate');

    $data = DB::table('retailnewstocktaking')
        ->where('branchid', $branchId)
         ->where('date', $date)
        ->where('status', 'Pending')
        ->get();

    if ($data->isEmpty()) {
        return response()->json([
            'success' => false,
            'isEmpty' => true,
            'message' => 'No pending stock data found',
        ]);
    }

    $chunkSize = 50;
    $chunks = array_chunk($data->toArray(), $chunkSize);

    $imported = 0;
    $errors = [];

    foreach ($chunks as $chunk) {
        foreach ($chunk as $item) {
            if (!empty($item)) {
                try {
                    DB::transaction(function () use ($branchId, $item) {
                        $existingProduct = DB::table('retailbranchproducts')
                            ->where('branch', $branchId)
                            ->where('product', $item->productid)
                            ->first();

                        if ($existingProduct) {
                            // Update existing product quantity
                            $newQuantity = $existingProduct->quantity + $item->quantity;
                            DB::table('retailbranchproducts')
                                ->where('branch', $branchId)
                                ->where('product', $item->productid)
                                ->update(['quantity' => $newQuantity]);
                        } else {
                            // Insert new product
                            DB::table('retailbranchproducts')
                                ->insert([
                                    'branch' => $branchId,
                                    'product' => $item->productid,
                                    'quantity' => $item->quantity,
                                ]);
                        }

                        // Update status to Submitted
                        DB::table('retailnewstocktaking')
                            ->where('id', $item->id)
                            ->update(['status' => 'Submitted']);
                    });

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Error importing record: " . $e->getMessage();
                }
            }
        }
    }

    return response()->json([
        'success' => count($errors) == 0,
        'isEmpty' => false,
        'imported' => $imported,
        'errors' => $errors,
    ]);
}


public function editsystemsalesretail(request $request){

    
    $stabilizedqty = 0;
    $salesData = array();
    $productsData = array();
  

    $price = $request->price;
    $quantity = $request->quantity;
    $date = $request->date;

    $currentstock = DB::table('retailbranchproducts')->where('id',$request->productid)->where('branch',$request->branch)->value("quantity");

    $stabilizedqty = $currentstock + $request->oldquantity;

    $newqty =  $stabilizedqty - $request->quantity;

    $productsData['quantity'] = $newqty;



    $salesData['price']=$price;
    $salesData['quantity']=$quantity;
    $salesData['date']=$date;
    $salesData['rquantity']=$newqty;

 
   if($newqty>=0){

        DB::table('retailsales')->where('id',$request->id)->update($salesData);

        DB::table('retailbranchproducts')->where('id',$request->productid)->where('branch',$request->branch)->update($productsData);
        if($quantity == 0){
         DB::table('retailsales')->where('id',$request->id)->delete();
        }
     
      return json_encode(-1);
    }else{

       return json_encode($stabilizedqty);
       
    }
   



  

}

public function reservesolditems(request $request){
    $data = json_decode($request->data, true);
    $password =  end($data);
    $hashedPassword=DB::table('users')->where('id',Auth::user()->id)->value('password');
    $branch = Cookie::get('rbranch') ?? "0";
    $date = Cookie::get('rdate') ?? "0";
    $dataSales = array();
    $productid=0;
if(Hash::check($password, $hashedPassword)) {
    for($i=0;$i<count($data)-1;$i++){
        $productid = DB::table('retailsales')->where('id',$data[$i])->value('productid');
        $oldqty = DB::table('retailsales')->where('id',$data[$i])->value('quantity');
        $sysqty = DB::table('retailbranchproducts')->where('branch',$branch)->where('id',$productid)->value('quantity'); 
        $dataSales['quantity'] = $oldqty+$sysqty;
        DB::table('retailbranchproducts')->where('branch',$branch)->where('id',$productid)->update($dataSales);
        DB::table('retailsales')->where('id',$data[$i])->delete();
    }
    return 2;
    }
    else{
      return 1;
    }
  
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

public function insertretaildeliverynote(Request $request)
{
    $data = array();
    $data['date'] = $request->date;
    $data['branchid'] = $request->branchid;
    $data['productid'] = $request->productid;
    $data['productname'] = $request->productname;
    $data['unit'] = $request->unit;
    $data['price'] = $request->price;
    $data['quantity'] = $request->quantity;

    $checkproduct = DB::table('retaildeliverynotes')
        ->where('date', $request->date)
        ->where('branchid', $request->branchid)
        ->where('productid', $request->productid)
        ->first();

    if ($checkproduct) {
        if ($checkproduct->added_to_branch == 'Yes') {
            // insert new record with status 'no'
            DB::table('retaildeliverynotes')->insert([
                'date' => $request->date,
                'branchid' => $request->branchid,
                'productid' => $request->productid,
                'productname' => $request->productname,
                'unit' => $request->unit,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'added_to_branch' => 'No'
            ]);

            return response()->json([
                'success' => 'New delivery note created successfully',
                'status' => 201
            ]);
        } else {
            // update existing record with new quantity and status 'no'
            DB::table('retaildeliverynotes')
                ->where('date', $request->date)
                ->where('branchid', $request->branchid)
                ->where('productid', $request->productid)
                ->update([
                    'quantity' =>  $request->quantity,
                    'added_to_branch' => 'No'
                ]);

            return response()->json([
                'success' => 'Existing delivery note updated successfully',
                'status' => 202
            ]);
        }
    } else {
        // insert new record with status 'no'
        DB::table('retaildeliverynotes')->insert([
            'date' => $request->date,
            'branchid' => $request->branchid,
            'productid' => $request->productid,
            'productname' => $request->productname,
            'unit' => $request->unit,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'added_to_branch' => 'No'
        ]);

        return response()->json([
            'success' => 'New delivery note created successfully',
            'status' => 200
        ]);
    }
}


 


public function retailaddproducttobranches(Request $request)
{
    // Get the date and product ID from the request
    $date = Cookie::get('rdate') ?? "0";
    $productId = Cookie::get('rproduct') ?? "0";

    // Get the delivery notes where date matches, product ID matches, and status is 'no'
    $deliveryNotes = DB::table('retaildeliverynotes')
        ->where('date', $date)
        ->where('productid', $productId)
        ->where('added_to_branch', 'No')
        ->get();

    // Check if there are delivery notes to process
    if ($deliveryNotes->isNotEmpty()) {
        // Loop through each delivery note
        foreach ($deliveryNotes as $deliveryNote) {
            // Get the branch ID and quantity
            $branchId = $deliveryNote->branchid;
            $quantity = $deliveryNote->quantity;

            // Check if there's a delivery note with status 'yes' for the same product
            $existingDeliveryNote = DB::table('retaildeliverynotes')
                ->where('date', $date)
                ->where('branchid', $branchId)
                ->where('productid', $productId)
                ->where('added_to_branch', 'Yes')
                ->first();

            try {
                DB::transaction(function () use ($branchId, $productId, $quantity, $deliveryNote, $existingDeliveryNote) {
                    // Check if the product exists in the retail branch products table
                    $existingBranchProduct = DB::table('retailbranchproducts')
                        ->where('branch', $branchId)
                        ->where('product', $productId)
                        ->first();

                    if ($existingBranchProduct) {
                        // Update existing product quantity
                        DB::table('retailbranchproducts')
                            ->where('branch', $branchId)
                            ->where('product', $productId)
                            ->increment('quantity', $quantity);
                    } else {
                        // Insert new product
                        DB::table('retailbranchproducts')
                            ->insert([
                                'branch' => $branchId,
                                'product' => $productId,
                                'quantity' => $quantity,
                            ]);
                    }

                    // Check if there's a delivery note with status 'yes' for the same product
                    if ($existingDeliveryNote) {
                        DB::table('retaildeliverynotes')
                            ->where('id', $existingDeliveryNote->id)
                            ->increment('quantity', $quantity);
                        DB::table('retaildeliverynotes')
                            ->where('id', $deliveryNote->id)
                            ->delete();
                    } else {
                        // If there's no existing delivery note with status 'yes', update the status of the current delivery note to 'yes'
                        DB::table('retaildeliverynotes')
                            ->where('id', $deliveryNote->id)
                            ->update(['added_to_branch' => 'Yes']);
                    }
                });
            } catch (\Exception $e) {
                // Return error response
                return response()->json(['error' => 'Failed to process delivery note: ' . $e->getMessage()], 500);
            }
        }

        // Return success response
        return response()->json(['success' => 'Delivery notes processed successfully']);
    } else {
        // Return response if no delivery notes were processed
        return response()->json(['success' => 'No delivery notes to process']);
    }
}
public function retailcanceldistributedproduct()
{
    // Get the date and product ID from the cookies
    $date = Cookie::get('rdate') ?? "0";
    $productId = Cookie::get('rproduct') ?? "0";

    try {
        // Check if there are any delivery notes to delete
        $deliveryNotes = DB::table('retaildeliverynotes')
            ->where('date', $date)
            ->where('productid', $productId)
            ->where('added_to_branch', 'No')
            ->exists();

        if ($deliveryNotes) {
            // Delete from retaildeliverynotes where date and product ID match and status is 'No'
            DB::table('retaildeliverynotes')
                ->where('date', $date)
                ->where('productid', $productId)
                ->where('added_to_branch', 'No')
                ->delete();

            // Return success response
            return response()->json(['success' => 'Delivery notes cancelled successfully']);
        } else {
            // Return message if no delivery notes were found
            return response()->json(['info' => 'No delivery notes to cancel']);
        }
    } catch (\Exception $e) {
        // Return error response if delete operation fails
        return response()->json(['error' => 'Failed to cancel delivery notes'], 500);
    }
}


public function retailpricechange(Request $request)
{
    // Get the old retail price
    $oldRetailPrice = DB::table('retailbaseproducts')
        ->where('id', $request->id)
        ->value('sellingprice');

    // Get the date from the cookie
    $date = Cookie::get('rdate') ?? "0";

    // Prepare the base data for update
    $baseData = [
        'product' => $request->product,
        'unit' => $request->unit,
        'sellingprice' => $request->price,
    ];

    // Update the retail base product
    $updateBaseData = DB::table('retailbaseproducts')
        ->where('id', $request->id)
        ->update($baseData);

    // Prepare the delivery note data for update
    $dnoteData = [
        'productid' => $request->id,
        'unit' => $request->unit,
        'price' => $request->price,
    ];

    // Update the delivery notes
    DB::table('retaildeliverynotes')
        ->where('productid', $request->id)
        ->where('date', $date)
        ->update($dnoteData);

    // Check if the retail price has changed
    if ($oldRetailPrice != $request->price) {
        // Prepare the price change data
        $priceChangeData = [
            'date' => $date,
            'productid' => $request->id,
            'unit' => $request->unit,
            'oldprice' => $oldRetailPrice,
            'newprice' => $request->price,
        ];

        // Prepare the price change data for update
        $priceChangeData2 = [
            'newprice' => $request->price,
            'unit' => $request->unit,
        ];

        // Check if a price change has already been recorded for today
        $checkPriceChangeToday = DB::table('retailpricechanges')
            ->where('date', Carbon::today()->toDateString())
            ->where('productid', $request->id)
            ->count();

        if ($checkPriceChangeToday > 0) {
            // Update the existing price change record
            DB::table('retailpricechanges')
                ->where('date', Carbon::today()->toDateString())
                ->where('productid', $request->id)
                ->update($priceChangeData2);

            return response()->json(['success' => 'Data updated successfully']);
        } else {
            // Insert a new price change record
            DB::table('retailpricechanges')
                ->insertOrIgnore($priceChangeData);

            return response()->json(['success' => 'Data updated successfully']);
        }
    }

    return response()->json(['success' => 'Data updated successfully']);
}



}
