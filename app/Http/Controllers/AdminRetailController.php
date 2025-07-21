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

    public function     adminretaildeliverynotes(){

        return view('admin.retail.retaildeliverynotes');
        
    }

    public function    adminretailpricechanges(){

        return view('admin.retail.retailpricechanges');
        
    }
   

    public function     adminretaildeliverynotedetails(){

        return view('admin.retail.retaildeliverynotedetails');
        
    }
   

    public function adminretailproductlogs(){
     return view('admin.retail.retailproductlogs');
    }
   
   
    public function adminretailproductlogsdatewise(){
        return view('admin.retail.retailproductlogsdatewise');
       }


       public function adminretailstocktaking(){

        return view('admin.retail.retailstocktaking');

       }
      


       public function    retailfullstocktaking(){

        return view('admin.retail.retailfullstocktaking');

       }
      
    

       public function adminretailfullstocktakingmerged(){

        return view('admin.retail.retailfullstocktakingmerged');
       }

       public function  retailfullstocktakingmissingproducts(){
 

        return view('admin.retail.retailfullstocktakingmissingproducts');

       }


       public function retailfullstocktakingactionsandinfo(){

        return view('admin.retail.retailfullstocktakingactionsandinfo');
       }

       public function retailpartialstocktaking(){

      return view('admin.retail.retailpartialstocktaking');

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

  public function editretailbaseproduct(Request $request){
    $data = array();
    $data['product'] = $request->product;
    $data['supplier'] = $request->supplier;
    $data['unit'] = $request->unit;
    $data['orderprice'] = $request->orderprice;
    $data['sellingprice'] = $request->sellingprice;
    $data['vat'] = $request->vat;

    $messages = [
        'product.unique' => 'Product name must be unique (You can separate by brands).',
        'product.required' => 'Product name is required.',
        'supplier.required' => 'Supplier is required.',
        'unit.required' => 'Unit is required.',
        'orderprice.required' => 'Order price is required',
        'sellingprice.required' => 'Selling price is required',
    ];

    $validator = $request->validate([
        'product' => 'required|unique:retailbaseproducts,product,'.$request->id,
        'supplier' => 'required',
        'unit' => 'required',
        'orderprice' => 'required',
        'sellingprice' => 'required',
    ], $messages);

    if($validator){
        $existingData = DB::table('retailbaseproducts')->where('id', $request->id)->first();

        $updateData = DB::table('retailbaseproducts')->where('id', $request->id)->update($data);

        if($updateData){
            // Check if selling price has changed
            if($existingData->sellingprice != $request->sellingprice){
                $today = Carbon::today()->toDateString();
                $existingPriceChange = DB::table('retailpricechanges')->where('productid', $request->id)->where('date', $today)->first();

                if($existingPriceChange){
                    // Update existing record
                    DB::table('retailpricechanges')->where('productid', $request->id)->where('date', $today)->update([
                        'newprice' => $request->sellingprice,
                    ]);
                } else {
                    // Insert new record
                    DB::table('retailpricechanges')->insert([
                        'date' => $today,
                        'productid' => $request->id,
                        'unit' => $request->unit,
                        'oldprice' => $existingData->sellingprice,
                        'newprice' => $request->sellingprice,
                    ]);
                }
            }

            return response()->json(['success' => 'Data updated succesfully','status'=>201]);
        }else{
            return response()->json(['error' => 'An error occured no data change detected','status'=>422]);
        }
    } else{
        return back()->withErrors($validator)->withInput();
    }
}


  public function deleteretailbaseproduct(Request $request){
    $id = $request->id;
    $checkinventory = DB::table('retailbranchproducts')->where('product', $request->id)->count();

    if ($checkinventory > 0) {
        return response()->json(['error' => 'Cannot delete product. Some branches are currently stocking this product.', 'status' => 422]);
    }else{

        $deleteData = DB::table('retailbaseproducts')->where('id', $id)->delete();

        if ($deleteData) {
            return response()->json(['success' => 'Data deleted successfully', 'status' => 201]);
        } else {
            return response()->json(['error' => 'An error occurred. Try again later.', 'status' => 422]);
        }

    }

   
}




public function uploadRetailBaseProductsCsvFile(Request $request)
{
    $csvData = json_decode($request->data, true);
    $supplier = DB::table('selection')->where('user',Auth::user()->id)->value('rsupplier');
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

      $existingDeliveryNote = DB::table('retaildeliverynotes')
      ->where('branchid', $request->branch)
      ->where('productid', $request->productid)
      ->where('added_to_branch', 'Yes')
      ->whereDate('date', Carbon::today()->toDateString())
      ->first();

  if ($existingProduct) {
      $qtybefore = $existingProduct->quantity;
      $qtyafter = $qtybefore + $request->quantity;

DB::transaction(function () use ($request, $existingProduct, $existingDeliveryNote, $dnote, $history, $qtybefore, $qtyafter, $devicedetails, $time) {
    DB::table('retailbranchproducts')
        ->where('branch', $request->branch)
        ->where('product', $request->productid)
        ->update(['quantity' => $qtyafter]);

    if ($existingDeliveryNote) {
        DB::table('retaildeliverynotes')
            ->where('branchid', $request->branch)
            ->where('productid', $request->productid)
            ->where('added_to_branch', 'Yes')
            ->whereDate('date', Carbon::today()->toDateString())
            ->update([
                'quantity' => $existingDeliveryNote->quantity + $request->quantity,
            ]);
    } else {
        DB::table('retaildeliverynotes')->insert($dnote);
    }

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
    DB::transaction(function () use ($data, $dnote, $existingDeliveryNote, $history, $request, $devicedetails, $time) {
        DB::table('retailbranchproducts')->insert($data);
    
        if ($existingDeliveryNote) {
            DB::table('retaildeliverynotes')
                ->where('branchid', $request->branch)
                ->where('productid', $request->productid)
                ->where('added_to_branch', 'Yes')
                ->whereDate('date', Carbon::today()->toDateString())
                ->update([
                    'quantity' => $existingDeliveryNote->quantity + $request->quantity,
                ]);
        } else {
            DB::table('retaildeliverynotes')->insert($dnote);
        }
    
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
    $branch = DB::table('selection')->where('user',Auth::user()->id)->value('rbranch')??0;
    $date = DB::table('selection')->where('user',Auth::user()->id)->value('rdate');
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

    $price =DB::table('retailbaseproducts')->where('id',$request->productid)->value('sellingprice');
    $data = array();
    $data['date'] = $request->date;
    $data['branchid'] = $request->branchid;
    $data['productid'] = $request->productid;
    $data['productname'] = $request->productname;
    $data['unit'] = $request->unit;
    $data['price'] = $price;
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
                'price' => $price,
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
            'price' => $price,
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

    $date = DB::table('selection')->where('user',Auth::user()->id)->value('rdate');
    $productId = DB::table('selection')->where('user',Auth::user()->id)->value('rproduct');

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


public function retailaddallproductstobranches(Request $request)
{
    // Get the date from the request
       // Get the date and product ID from the request
       $date = DB::table('selection')->where('user',Auth::user()->id)->value('rdate');
     

    // Get the delivery notes where date matches and status is 'no'
    $deliveryNotes = DB::table('retaildeliverynotes')
        ->where('date', $date)
        ->where('added_to_branch', 'No')
        ->get();

    // Check if there are delivery notes to process
    if ($deliveryNotes->isNotEmpty()) {
        // Loop through each delivery note
        foreach ($deliveryNotes as $deliveryNote) {
            // Get the branch ID, product ID, and quantity
            $branchId = $deliveryNote->branchid;
            $productId = $deliveryNote->productid;
            $quantity = $deliveryNote->quantity;

            try {
                DB::transaction(function () use ($branchId, $productId, $quantity, $deliveryNote) {
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

                    // Update the status of the current delivery note to 'yes'
                    DB::table('retaildeliverynotes')
                        ->where('id', $deliveryNote->id)
                        ->update(['added_to_branch' => 'Yes']);
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
    // Get the date and product ID from the request
    $date = DB::table('selection')->where('user',Auth::user()->id)->value('rdate');
    $productId = DB::table('selection')->where('user',Auth::user()->id)->value('rproduct');

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

public function retailpricechange(Request $request) {
    // Check if product exists
    $productExists = DB::table('retailbaseproducts')->where('id', $request->id)->exists();

    if (!$productExists) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    // Get the old retail price
    $oldRetailPrice = DB::table('retailbaseproducts')
        ->where('id', $request->id)
        ->value('sellingprice');

    
    $date = DB::table('selection')->where('user',Auth::user()->id)->value('rdate');

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

    if ($updateBaseData) {
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

            // Check if a price change has already been recorded 
            $checkPriceChangeToday = DB::table('retailpricechanges')
                ->where('date', $date)
                ->where('productid', $request->id)
                ->count();

            if ($checkPriceChangeToday > 0) {
                // Update the existing price change record
                DB::table('retailpricechanges')
                    ->where('date', $date)
                    ->where('productid', $request->id)
                    ->update($priceChangeData2);
            } else {
                // Insert a new price change record
                DB::table('retailpricechanges')
                    ->insertOrIgnore($priceChangeData);
            }
        }

        return response()->json([
            'success' => 'Data updated successfully',
            'product' => $request->product,
            'price' => $request->price,
            'unit' => $request->unit,
        ]);
    } else {
        return response()->json(['error' => 'No updates made'], 400);
    }
}


public function retailaddproductstospecificbranch(Request $request)
{
    // Get the date and branch from the request
    $date = $request->date;
    $branch = $request->branch;

    // Get the delivery notes where date and branch match and status is 'no'
    $deliveryNotes = DB::table('retaildeliverynotes')
        ->where('date', $date)
        ->where('branchid', $branch)
        ->where('added_to_branch', 'No')
        ->get();

    // Check if there are delivery notes to process
    if ($deliveryNotes->isNotEmpty()) {
        // Loop through each delivery note
        foreach ($deliveryNotes as $deliveryNote) {
            // Get the product ID and quantity
            $productId = $deliveryNote->productid;
            $quantity = $deliveryNote->quantity;

            try {
                DB::transaction(function () use ($branch, $productId, $quantity, $deliveryNote) {
                    // Check if the product exists in the retail branch products table
                    $existingBranchProduct = DB::table('retailbranchproducts')
                        ->where('branch', $branch)
                        ->where('product', $productId)
                        ->first();

                    if ($existingBranchProduct) {
                        // Update existing product quantity
                        DB::table('retailbranchproducts')
                            ->where('branch', $branch)
                            ->where('product', $productId)
                            ->increment('quantity', $quantity);
                    } else {
                        // Insert new product
                        DB::table('retailbranchproducts')
                            ->insert([
                                'branch' => $branch,
                                'product' => $productId,
                                'quantity' => $quantity,
                            ]);
                    }

                    // Update the status of the current delivery note to 'yes'
                    DB::table('retaildeliverynotes')
                        ->where('id', $deliveryNote->id)
                        ->update(['added_to_branch' => 'Yes']);
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



public function mergeretailfullstocktaking(Request $request)
{
    $dataArray = json_decode($request->input('data'), true);
    $password = $dataArray[0];
    $productData = json_decode($dataArray[1], true);
    $hashedPassword = Auth::user()->password;
    $branch = DB::table('selection')->where('user', Auth::user()->id)->value('rfstockbranch');
    $date = DB::table('selection')->where('user', Auth::user()->id)->value('rfstockdate');

    if (Hash::check($password, $hashedPassword)) {
        $maxCounter = DB::table('retailfullstocktaking')->max('counter');
        $newCounter = $maxCounter ? $maxCounter + 1 : 1;

        foreach ($productData as $data) {
           
            $expectedQuantity = DB::table('retailbranchproducts')
                ->where('branch', $data['Branch'])
                ->where('product', $data['Productid'])
                ->value('quantity')??0;

                
            $rate = DB::table('retailbranchproducts')
            ->where('branch', $data['Branch'])
            ->where('product', $data['Productid'])
            ->value('rate')??1.00;

            $existingData = DB::table('retailfullstocktaking')
                ->where('date', $date)
                ->where('branch', $data['Branch'])
                ->where('productid', $data['Productid'])
                ->first();

            if ($existingData) {
                DB::table('retailfullstocktaking')
                    ->where('date', $date)
                    ->where('branch', $data['Branch'])
                    ->where('productid', $data['Productid'])
                    ->update([
                        'found' => $existingData->found + $data['Quantity'],
                        'counter' => $newCounter,
                    ]);
            } else {
                DB::table('retailfullstocktaking')->insert([
                    'date' => $date,
                    'branch' => $data['Branch'],
                    'productid' => $data['Productid'],
                    'product' => $data['Product'],
                    'unit' => $data['Unit'],
                    'price' => $data['Price'],
                    'expected' => $expectedQuantity,
                    'found' => $data['Quantity'],
                    'rate' => $data['Rate'],
                    'counter' => $newCounter,
                ]);
            }

            $newCounter++;
        }

        return response()->json(2);
    } else {
        return response()->json(1);
    }
}



public function deleteretailfullstocktaking(request $request){

    $id = $request->id;
    $deleteData = DB::table('retailfullstocktaking')->where('id',$id)->delete();  
    if($deleteData){
      return response()->json(['success' => 'Data deleted succesifully','status'=>201]);
    }else{
      return response()->json(['error' => 'An error occured try again later','status'=>422]);
    }
}







public function updateretailfullstocktaking(Request $request)
{
    $data = array();
    $data['expected'] = $request->expected;
    $data['found'] = $request->found;

    $messages = [
        'expected.required' => 'Expected quantity is required.',
        'expected.gte' => 'Expected quantity should be greater than or equal to 0.',
        'found.required' => 'Found quantity is required.',
        'found.gte' => 'Found quantity should be greater than or equal to 0.',
    ];

    $validator = Validator::make($request->all(), [
        'expected' => 'required|gte:0',
        'found' => 'required|gte:0',
    ], $messages);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->messages(), 'status' => 422]);
    } else {
        $updateData = DB::table('retailfullstocktaking')->where('id', $request->id)->update($data);
        if ($updateData) {
            return response()->json(['success' => 'Data updated successfully', 'status' => 201]);
        } else {
            return response()->json(['error' => 'An error occurred or no data change detected', 'status' => 422]);
        }
    }
}

public function submitretailstockfullrectification(Request $request)
{
    $countedProducts = DB::table('retailfullstocktaking')
        ->where('branch', $request->branch)
        ->where('date', $request->date)
        ->pluck('productid');

    $missingproducts = DB::table('retailbranchproducts')
        ->where('branch', $request->branch)
        ->whereNotIn('product', $countedProducts)
        ->get();

    $stocktakingdata = DB::table('retailfullstocktaking')
        ->where('branch', $request->branch)
        ->where('date', $request->date)
        ->get();

    $stoktakingHistory = [
        'date' => $request->date,
        'branch' => $request->branch,
        'expected' => $request->expectedvalue,
        'found' => $request->foundvalue,
        'missingvalue' => $request->missingvalue,
    ];

    $hashedPassword = Auth::user()->password;
    $password = $request->password;

    $messages = [
        'password.required' => 'Password is required to complete this action',
    ];

    $validator = $request->validate([
        'password' => 'required',
    ], $messages);

    if ($validator) {
        if (Hash::check($password, $hashedPassword)) {
            try {
                DB::transaction(function () use ($request, $missingproducts, $stocktakingdata, $stoktakingHistory) {
                    $missingDataChunks = $missingproducts->chunk(100);
                    $stocktakingDataChunks = $stocktakingdata->chunk(100);

                    foreach ($missingDataChunks as $chunk) {
                        $productIds = $chunk->pluck('product');
                        $productDetails = DB::table('retailbaseproducts')
                            ->whereIn('id', $productIds)
                            ->get()
                            ->keyBy('id');

                        $missingDataToInsert = [];

                        foreach ($chunk as $missing) {
                            if (isset($productDetails[$missing->product])) {
                                $product = $productDetails[$missing->product];
                                $missingDataToInsert[] = [
                                    'date' => $request->date,
                                    'branch' => $request->branch,
                                    'productid' => $missing->product,
                                    'product' => $product->product,
                                    'unit' => $product->unit,
                                    'price' => $product->sellingprice,
                                    'quantity' => $missing->quantity,
                                    'rate' => $missing->rate,
                                ];
                            }
                        }

                        DB::table('retailfullstocktakingmissingproducts')
                            ->insertOrIgnore($missingDataToInsert);
                    }

                    DB::table('retailbranchproducts')
                        ->where('branch', $request->branch)
                        ->delete();

                    foreach ($stocktakingDataChunks as $chunk) {
                        $dataToInsert = [];

                        foreach ($chunk as $stock) {
                            $dataToInsert[] = [
                                'branch' => $request->branch,
                                'product' => $stock->productid,
                                'quantity' => $stock->found,
                                'rate' => $stock->rate,
                            ];
                        }

                        DB::table('retailbranchproducts')
                            ->insertOrIgnore($dataToInsert);
                    }

                    DB::table('retailfullstocktakinghistory')
                        ->insertOrIgnore($stoktakingHistory);
                });

                return response()->json(['success' => 'Stock rectification completed successfully!', 'status' => 201]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'A transaction error occurred during stock rectification: ' . $e->getMessage(), 'status' => 500]);
            }
        } else {
            return response()->json(['error' => 'The password you entered is incorrect', 'status' => 422]);
        }
    } else {
        return response()->json(['error' => 'Validation failed', 'status' => 400]);
    }
}






public function retailinsertretailpartialstocktaking(request $request){
    $counter1 =   DB::table('retailpartialstocktaking')->where('date',$request->date)->where('branch',$request->branch)->max('counter');
    
    $counter =  $counter1 + 1;
    
    $data = array();

    $data['date']=$request->date;
    $data['branch']=$request->branch;
    $data['product']=$request->product;
    $data['productid']=$request->productid;
    $data['unit']=$request->unit;
    $data['price']=$request->price;
    $data['expected']=$request->expected;
    $data['found']=$request->found;
    $data['counter']=$counter;
   
    $checkproduct = DB::table('retailpartialstocktaking')->where('date',$request->date)->where('branch',$request->branch)->where('productid',$request->productid)->count();
   
    if($checkproduct>0){
     $found1 =   DB::table('retailpartialstocktaking')->where('date',$request->date)->where('branch',$request->branch)->where('productid',$request->productid)->value('found');
     $found2 =  $request->found; 
     $newfound = $found1+$found2;
      $datay = array();
      $datay['expected']=$request->expected;;
      $datay['found']=$newfound;
      $datay['counter']=$counter;
      DB::table('retailpartialstocktaking')->where('date',$request->date)->where('branch',$request->branch)->where('productid',$request->productid)->update($datay);
    return json_encode(2);
    }
    else{
     DB::table('retailpartialstocktaking')->insertOrIgnore($data);
     return json_encode(4);
    }

}

public function editretailpartialstocktaking(request $request){
    $data = array();
    $data['expected']=$request->expected;
    $data['found']=$request->found;
    $updateData = DB::table('retailpartialstocktaking')->where('id',$request->id)->update($data);

  if($updateData){
    return json_encode(2);
  }else{
    return json_encode(1);

  }


}

public function submitretailstockpartialrectification(Request $request)
{
    $messages = [
        'password.required' => 'Password is required to complete this action',
    ];

    $validator = $request->validate([
        'password' => 'required',
    ], $messages);

    $hashedPassword = Auth::user()->password;

    $password = $request->password;

    if ($validator) {

        if (Hash::check($password, $hashedPassword)) {
            try {
                DB::transaction(function () use ($request) {
                    $partialstocktakingdata = DB::table('retailpartialstocktaking')
                        ->where('branch', $request->branch)
                        ->where('date', $request->date)
                        ->get();

                    foreach ($partialstocktakingdata as $stock) {
                        $existingProduct = DB::table('retailbranchproducts')
                            ->where('branch', $request->branch)
                            ->where('product', $stock->productid)
                            ->first();

                        if ($existingProduct) {
                            DB::table('retailbranchproducts')
                                ->where('branch', $request->branch)
                                ->where('product', $stock->productid)
                                ->update([
                                    'quantity' => $stock->found,
                                ]);
                        } else {
                            DB::table('retailbranchproducts')
                                ->insert([
                                    'branch' => $request->branch,
                                    'product' => $stock->productid,
                                    'quantity' => $stock->found,
                                ]);
                        }
                    }

                    $partialstocktakingHistory = [
                        'date' => $request->date,
                        'branch' => $request->branch,
                        'expected' => $request->expectedvalue,
                        'found' => $request->foundvalue,
                    ];

                    DB::table('retailpartialstocktakinghistory')
                        ->insertOrIgnore($partialstocktakingHistory);
                });

                return response()->json(['success' => 'Stock rectification completed successfully!', 'status' => 201]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'A transaction error occurred during stock rectification: ' . $e->getMessage(), 'status' => 500]);
            }
        } else {
            return response()->json(['error' => 'The password you entered is incorrect', 'status' => 422]);
        }
    } else {
        return response()->json(['error' => 'Validation failed', 'status' => 400]);
    }
}



}
