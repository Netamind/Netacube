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

class AdminWholesaleController extends Controller
{
    

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

}
