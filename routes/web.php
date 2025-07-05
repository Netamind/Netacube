<?php
use Illuminate\Support\Facades\Route;
Route::get('/', 'WebController@loginview')->name('login');
Route::post('/user-login', 'AuthController@userlogin');
Route::get('/forgot-password', 'WebController@forgotpassword');
Route::post('/request-password-reset-link', 'WebController@requestpasswordresetlink');
Route::get('/reset-password-view', 'WebController@resetpasswordview');
Route::post('/reset-password', 'WebController@resetpassword');
Route::post('/make-selection', 'SelectionController@makeselection');

/*==========================================Start Website ==========================================*/
Route::get('website-status', 'WebsiteController@websitestatus');
/*==========================================End Website ==========================================*/


/*========================================== Start of Admin Dashboard Routes=================================================================*/
Route::get('admin-dashboard', 'AdminController@admindashboard');
Route::get('business-category', 'AdminController@businesscategory');
Route::get('company-info', 'AdminController@appdata');
Route::post('update-app-data-general', 'AdminController@updateappdatageneral');
Route::post('update-app-data-contact', 'AdminController@updateappdatacontact');
Route::post('update-app-data-logo', 'AdminController@updateappdatalogo');
Route::post('update-app-data-letterhead', 'AdminController@updateappdataletterhead');
Route::post('update-app-data-terms', 'AdminController@updateappdataterms');
Route::get('user-roles', 'AdminController@userroles');
Route::get('employees', 'AdminController@employees');
Route::post('insert-employee', 'AdminController@insertemployee');
Route::post('delete-employee', 'AdminController@deleteemployee');
Route::post('edit-employee', 'AdminController@editemployee');
Route::get('branches', 'AdminController@branches');
Route::post('insert-branch', 'AdminController@insertbranch');
Route::post('delete-branch', 'AdminController@deletebranch');
Route::post('edit-branch', 'AdminController@editbranch');
Route::get('business-sector', 'AdminController@businesssector');
Route::get('admin-profile', 'AdminController@profile');
Route::get('users', 'AdminController@users');
Route::post('insert-user', 'AdminController@insertuser');
Route::post('delete-user', 'AdminController@deleteuser');
Route::post('edit-user', 'AdminController@edituser');
Route::post('admin-change-password', 'AdminController@changepassword');
Route::get('vat-statuses', 'AdminController@vatstatuses');
Route::get('business-categories', 'AdminController@businesscategories');
Route::post('insert-business-category', 'AdminController@insertbusinesscategory');
Route::post('delete-business-category', 'AdminController@deletebusinesscategory');
Route::post('edit-business-category', 'AdminController@editbusinesscategory');
Route::get('business-categories', 'AdminController@businesscategories');
Route::post('insert-business-category', 'AdminController@insertbusinesscategory');
Route::post('delete-business-category', 'AdminController@deletebusinesscategory');
Route::post('edit-business-category', 'AdminController@editbusinesscategory');
Route::get('suppliers', 'AdminController@suppliers');
Route::post('insert-supplier', 'AdminController@insertsupplier');
Route::post('delete-supplier', 'AdminController@deletesupplier');
Route::post('edit-supplier', 'AdminController@editsupplier');
/*========================================== End of Admin Dashboard Routes=================================================================*/


/*==========================================Start of Admin Wholesale Routes=================================================================*/
Route::get('admin-wholesale-baseproducts', 'AdminWholesaleController@adminwholesalebaseproducts');
Route::get('admin-wholesale-branch-products', 'AdminWholesaleController@adminwholesalebranchproducts');
Route::get('admin-wholesale-product-logs', 'AdminWholesaleController@adminwholesaleproductlogs');
Route::get('admin-wholesale-product-logs-datewise', 'AdminWholesaleController@adminwholesaleproductlogsdatewise');
Route::get('admin-wholesale-supplies', 'AdminWholesaleController@adminwholesalesupplies');
Route::get('admin-wholesale-clients', 'AdminWholesaleController@adminwholesaleclients');



Route::post('insert-wholesale-baseproduct', 'AdminWholesaleController@insertwholesalebaseproduct');
Route::post('delete-wholesale-baseproduct', 'AdminWholesaleController@deletewholesalebaseproduct');
Route::post('edit-wholesale-baseproduct', 'AdminWholesaleController@editwholesalebaseproduct');
Route::post('upload-wholesale-baseproducts-csvfile', 'AdminWholesaleController@uploadwholesalebaseproductscsvfile');

Route::post('insert-wholesale-branch-product', 'AdminWholesaleController@insertwholesalebranchproduct');
Route::post('delete-wholesale-branch-product', 'AdminWholesaleController@deletewholesalebranchproduct');
Route::post('update-wholesale-branch-product', 'AdminWholesaleController@updatewholesalebranchproduct');


Route::post('insert-wholesale-client', 'AdminWholesaleController@insertwholesaleclient');
Route::post('delete-wholesale-client', 'AdminWholesaleController@deletewholesaleclient');
Route::post('update-wholesale-client', 'AdminWholesaleController@updatewholesaleclient');
/*==========================================Start of Admin Wholesale Routes=================================================================*/


/*==========================================Start of Admin Retail Routes=================================================================*/
Route::get('admin-retail-baseproducts', 'AdminRetailController@adminretailbaseproducts');
Route::post('insert-retail-baseproduct', 'AdminRetailController@insertretailbaseproduct');
Route::post('delete-retail-baseproduct', 'AdminRetailController@deleteretailbaseproduct');
Route::post('edit-retail-baseproduct', 'AdminRetailController@editretailbaseproduct');
Route::post('upload-retail-baseproducts-csvfile', 'AdminRetailController@uploadretailbaseproductscsvfile');
Route::post('insert-retail-branch-product', 'AdminRetailController@insertretailbranchproduct');
Route::post('delete-retail-branch-product', 'AdminRetailController@deleteretailbranchproduct');
Route::post('update-retail-branch-product', 'AdminRetailController@updateretailbranchproduct');
Route::post('insert-retail-client', 'AdminRetailController@insertretailclient');
Route::post('delete-retail-client', 'AdminRetailController@deleteretailclient');
Route::post('update-retail-client', 'AdminRetailController@updateretailclient');
Route::get('admin-retail-branch-products', 'AdminRetailController@adminretailbranchproducts');
Route::get('admin-retail-product-tracker', 'AdminRetailController@adminretailproducttracker');
Route::get('admin-retail-product-logs', 'AdminRetailController@adminretailproductlogs');
Route::get('admin-retail-product-logs-datewise', 'AdminRetailController@adminretailproductlogsdatewise');
Route::get('admin-retail-product-supplies', 'AdminRetailController@adminretailproductsupplies');
Route::get('admin-retail-clients', 'AdminRetailController@adminretailclients');
Route::get('admin-retail-openingstock', 'AdminRetailController@adminretailopeningstock');
Route::get('admin-retail-action-center', 'AdminRetailController@adminretailactioncenter');
Route::get('admin-retail-deliverynote-details', 'AdminRetailController@adminretaildeliverynotedetails');
Route::post('save-retail-openingstock', 'AdminRetailController@saveretailopeingstock');
Route::get('admin-retail-openingstock-data', 'AdminRetailController@adminretailopeningstockdata');
Route::get('submit-retail-openingstock-to-branch', 'AdminRetailController@submitretailopeningstocktobranch');
Route::get('admin-retail-system-sales', 'AdminRetailController@adminretailsystemsales');
Route::get('admin-retail-deliverynotes', 'AdminRetailController@adminretaildeliverynotes');
Route::get('admin-retail-price-changes', 'AdminRetailController@adminretailpricechanges');
Route::post('edit-system-sales-retail','AdminRetailController@editsystemsalesretail');
Route::post('reserve-sold-items','AdminRetailController@reservesolditems');
Route::post('rselected-items-change-date','AdminRetailController@rselecteditemschangedate');
Route::post('insert-retail-deliverynote','AdminRetailController@insertretaildeliverynote');
Route::post('retail-add-product-to-branches','AdminRetailController@retailaddproducttobranches');
Route::post('retail-cancel-distributed-product','AdminRetailController@retailcanceldistributedproduct');
Route::post('retail-price-change','AdminRetailController@retailpricechange');
Route::post('retail-add-allproducts-to-branches','AdminRetailController@retailaddallproductstobranches');
Route::post('retail-add-products-to-specific-branch','AdminRetailController@retailaddproductstospecificbranch');
Route::get('admin-retail-stocktaking','AdminRetailController@adminretailstocktaking');
Route::get('retail-full-stocktaking','AdminRetailController@retailfullstocktaking');
Route::get('admin-retail-full-stocktaking-merged','AdminRetailController@adminretailfullstocktakingmerged');
Route::post('merge-retail-full-stocktaking','AdminRetailController@mergeretailfullstocktaking');
Route::post('delete-retail-full-stocktaking','AdminRetailController@deleteretailfullstocktaking');
Route::post('update-retail-full-stocktaking','AdminRetailController@updateretailfullstocktaking');
Route::get('retail-full-stocktaking-missing-products','AdminRetailController@retailfullstocktakingmissingproducts');
Route::get('retail-full-stocktaking-actions-and-info','AdminRetailController@retailfullstocktakingactionsandinfo');
Route::post('submit-retail-stock-fullrectification','AdminRetailController@submitretailstockfullrectification');
Route::get('retail-partial-stocktaking','AdminRetailController@retailpartialstocktaking');
Route::post('insert-retail-partial-stocktaking','AdminRetailController@retailinsertretailpartialstocktaking');
Route::post('edit-retail-partial-stocktaking','AdminRetailController@editretailpartialstocktaking');
Route::post('submit-retail-stock-partialrectification','AdminRetailController@submitretailstockpartialrectification');
/*==========================================End of Admin Retail Routes=================================================================*/


/*==========================================Retail Sales Routes=================================================================*/
Route::get('retail-sales-dashboard', 'RetailSalesController@retailsalesdashboard');
Route::get('retail-sales-profile', 'RetailSalesController@retailsalesprofile');
Route::post('rsales-change-password', 'RetailSalesController@changepassword');
Route::get('retail-sales-terminal1', 'RetailSalesController@retailsalesterminal1');
Route::post('upload-sales','RetailSalesController@submitsolddata');
Route::post('insert-interval-sales','RetailSalesController@insertintervalsales');
Route::post('edit-interval-sales','RetailSalesController@editintervalsales');
/*==========================================End Retail Sales Routes=================================================================*/

