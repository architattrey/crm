<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/storagess', function () {
    Artisan::call('storage:link');
    return "jkh";
 });
 
Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
});


Auth::routes();







//Route::get('/add-remarks', ['as'=>'add-remarks','uses' => 'AdminController@clientRemarkView']);
//Route::get('/home', 'HomeController@index')->name('home');
# export import excel file





#-------------------------------------- COMMON ROUTES -----------------------------------#
Route::get('/clients-registraion', ['as'=>'clients-registraion','uses' => 'CommonController@clientRegistrationView']);
Route::post('/data-submition', ['as'=>'data-submition','uses' => 'CommonController@clientRegistered']);
Route::get('/show-leads/{id}/{user_type}','CommonController@ShowAllLeads')->name('show-leads');


#------------------------------------- FOR USER ROUTES -----------------------------------#

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

 

#------------------------------------- FOR ADMIN ROUTES ------------------------------------#

    //register admin 
    Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
    Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
    #clients registration 
    Route::get('/clients-registraion-admin', ['as'=>'clients-registraion-admin','uses' => 'AdminController@clientRegistrationView']);
    Route::post('/data-submition-admin', ['as'=>'data-submition-admin','uses' => 'AdminController@clientRegistered']);
    //login admin
    Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
    Route::post('/login/admin', 'Auth\LoginController@adminLogin');
    Route::get('/dashboard/admin','CommonController@index')->name('admin_dashboard');
    # get data of clients
    Route::get('/show-leads-admin/{id}/{user_type}','AdminController@ShowAllLeads')->name('show-leads');
    Route::get('/get-live-clients', ['as'=>'get-live-clients','uses' => 'AdminController@getLiveClients']);
    Route::get('/get-deleted-clients', ['as'=>'get-deleted-clients','uses' => 'AdminController@getDeletedClients']);
    #action for delete and update clients
    Route::get('/delete-live-client/{client_id}/{delete_status}', ['uses' => 'AdminController@deletetLiveClients']);
    Route::get('/update-live-client/{client_id}/{delete_status}', ['uses' => 'CommonController@clientRegistrationView']);
    # related remarks
    #action for remarks of clients
    Route::get('/all-remarks/{client_id}/{delete_status}', ['uses' => 'AdminController@getAllRemarks']);
    Route::get('/add-remarks/{client_id}', ['uses' => 'AdminController@clientRemarkView']);
    Route::post('/remark-submition', ['as'=>'remark-submition','uses' => 'AdminController@submitRemark']); 
    Route::get('/download-file',['as'=>'download-file', 'uses'=>'AdminController@export']);
    Route::post('/import-file',['as'=>'import-file', 'uses'=>'AdminController@import']);
    Route::post('/asign-bdm',['as'=>'asign-bdm', 'uses'=>'AdminController@asignBdm']);
  
    // Route::get('admin_area', ['middleware' => 'admin', function () {
    #global middleware
    // }]);

#------------------------------------- FOR BDM ROUTES --------------------------------------#

    //register BDM 
    Route::get('/register/bdm', 'Auth\RegisterController@showBdmRegisterForm');
    Route::post('/register/bdm', 'Auth\RegisterController@createBdm');
    #clients registration 
    Route::get('/clients-registraion-bdm', ['as'=>'clients-registraion-bdm','uses' => 'BdmController@clientRegistrationView']);
    Route::post('/data-submition-bdm', ['as'=>'data-submition-bdm','uses' => 'BdmController@clientRegistered']);
    //login BDM
    Route::get('/login/bdm', 'Auth\LoginController@showBdmLoginForm');
    Route::post('/login/bdm', 'Auth\LoginController@bdmLogin')->name('login/bdm');
    Route::get('/dashboard/bdm','CommonController@index')->name('bdm_dashboard');
    Route::get('/assigned-leads','BdmController@assignedLeads')->name('assigned-leads');
    Route::post('/change-status','BdmController@changeStatus')->name('change-status');
    Route::get('/show-leads-bdm/{id}/{user_type}','BdmController@ShowAllLeads')->name('show-leads');
   
   
    
    // Route::get('bdm_area', ['middleware' => 'bdm', function () {
        #global middleware
    // }]);

 

#------------------------------------- FOR LG ROUTES -------------------------------------#
    //register LG 
    Route::get('/register/lg', 'Auth\RegisterController@showLgRegisterForm');
    Route::post('/register/lg', 'Auth\RegisterController@createLg');
    #clients registration 
    Route::get('/clients-registraion-lg', ['as'=>'clients-registraion-lg','uses' => 'LgController@clientRegistrationView']);
    Route::post('/data-submition-lg', ['as'=>'data-submition-lg','uses' => 'LgController@clientRegistered']);
    //login LG
    Route::get('/login/lg', 'Auth\LoginController@showLgLoginForm');
    Route::post('/login/lg', 'Auth\LoginController@LgLogin');
    Route::get('/dashboard/lg','CommonController@index')->name('lg_dashboard');
    Route::get('/show-leads-lg/{id}/{user_type}','LgController@ShowAllLeads')->name('show-leads');
   
    
    //Route::get('/dashboard/lg','CommonController@index')->name('lg_dashboard');
     
    // Route::get('lg_area', ['middleware' => 'lg', function () {
    #global middleware
    // }]);

 

