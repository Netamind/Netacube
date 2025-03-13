<?php
use Illuminate\Support\Facades\Route;
Route::get('/', 'WebController@loginview')->name('login');
Route::post('user-authentication', 'AuthController@userauthentication');

/*========================================== Start of Admin Dashboard Routes=================================================================*/
Route::get('admin-dashboard', 'AdminController@admindashboard');
Route::get('business-category', 'AdminController@businesscategory');
Route::get('app-data', 'AdminController@appdata');
Route::post('update-app-data-general', 'AdminController@updateappdatageneral');
Route::post('update-app-data-contact', 'AdminController@updateappdatacontact');
Route::post('update-app-data-logo', 'AdminController@updateappdatalogo');
Route::post('update-app-data-letterhead', 'AdminController@updateappdataletterhead');
Route::post('update-app-data-terms', 'AdminController@updateappdataterms');
Route::get('users-roles', 'AdminController@userroles');
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
Route::post('change-password', 'AdminController@changepassword');
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
Route::get('admin-wholesale-baseproducts', 'WholesaleController@adminwholesalebaseproducts');
Route::get('admin-wholesale-branch-products', 'WholesaleController@adminwholesalebranchproducts');
Route::get('admin-wholesale-product-tracker', 'WholesaleController@adminwholesaleproducttracker');
Route::get('admin-wholesale-product-supplies', 'WholesaleController@adminwholesaleproductsupplies');
Route::get('admin-wholesale-clients', 'WholesaleController@adminwholesaleclients');

/*==========================================Start of Admin Wholesale Routes=================================================================*/



/*==========================================Wholesale Oper Routes=================================================================*/
Route::post('insert-wholesale-baseproduct', 'WholesaleController@insertwholesalebaseproduct');
Route::post('delete-wholesale-baseproduct', 'WholesaleController@deletewholesalebaseproduct');
Route::post('edit-wholesale-baseproduct', 'WholesaleController@editwholesalebaseproduct');
Route::post('upload-wholesale-baseproducts-csvfile', 'WholesaleController@uploadwholesalebaseproductscsvfile');

Route::post('insert-wholesale-branch-product', 'WholesaleController@insertwholesalebranchproduct');
Route::post('delete-wholesale-branch-product', 'WholesaleController@deletewholesalebranchproduct');
Route::post('update-wholesale-branch-product', 'WholesaleController@updatewholesalebranchproduct');


Route::post('insert-wholesale-client', 'WholesaleController@insertwholesaleclient');
Route::post('delete-wholesale-client', 'WholesaleController@deletewholesaleclient');
Route::post('update-wholesale-client', 'WholesaleController@updatewholesaleclient');



/*==========================================Wholesale  Wholesale Routes=================================================================*/




/*==========================================Session=================================================================*/
Route::post('select-category', 'SessionController@selectCategory');
Route::post('select-supplier', 'SessionController@selectSupplier');
Route::post('select-branch', 'SessionController@selectBranch');
Route::post('change-date-interval', 'SessionController@changedateinterval');
Route::post('select-product', 'SessionController@selectproduct');

Route::post('select-wdate', 'SessionController@selectwdate');

/*==========================================End Session=================================================================*/



/*==========================================Settings=================================================================*/
Route::get('admin-homepage-settings', 'SettingsController@adminhomepagesettings');
Route::post('set-admin-homepage', 'SettingsController@setadminhomepage');

/*==========================================End Settings=================================================================*/







/*========================================== Start of Admin Dashboard Routes=================================================================*/
Route::get('operations-dashboard', 'OperationsController@operationsdashboard');



/*========================================== End of Admin Dashboard Routes=================================================================*/