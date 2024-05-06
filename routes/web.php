<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConsumerController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PhotoTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RetailersController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\TehsilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/clear-cache', function () {
    return  Artisan::call('cache:clear');
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('dashboard');
Route::get('/getUsers/{project_id}', [App\Http\Controllers\HomeController::class, 'getUsers']);
Route::get('/getState/{project_id}', [App\Http\Controllers\HomeController::class, 'getState']);
Route::get('/getDistrict/{state_id}', [App\Http\Controllers\HomeController::class, 'getDistrict'])->name('get_district');
Route::get('/geVillages/{district_id}', [App\Http\Controllers\HomeController::class, 'getVillage']);
Route::get('/getTehsil/{district_id}', [App\Http\Controllers\HomeController::class, 'getTehsil']);





//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

Route::get('/attendance/get-project-wise-states/{project_id}', [AttendanceController::class, 'getStateByProjectID'])->name('attendance.get_states_by_proejct');
Route::get('/attendance/get-project-wise-users/{project_id}', [AttendanceController::class, 'getUsersProjectID'])->name('attendance.get_districts_by_state');
Route::get('/attendance/get-state-wise-users/{state_id}', [AttendanceController::class, 'getUsersStatusID'])->name('attendance.get_users_by_state');
Route::delete('/attendance/delete/{id}', [AttendanceController::class, 'destroy'])->name('attendance.delete');

Route::get('/branding/images', [App\Http\Controllers\Branding\BrandingController::class, 'brandingImages'])->name('branding.images');
Route::get('/branding/recce-pending', [App\Http\Controllers\Branding\BrandingController::class, 'index'])->name('branding.reccepending');
Route::get('/branding/recce-approved', [App\Http\Controllers\Branding\BrandingController::class, 'approvedRecce'])->name('branding.recceapproved');
Route::get('/branding/recce-rejected', [App\Http\Controllers\Branding\BrandingController::class, 'rejectedRecce'])->name('branding.reccerejected');
Route::get('/branding/recce/approve/{fld_raid}', [App\Http\Controllers\Branding\BrandingController::class, 'approveRecce'])->name('branding.recce.approve');
Route::get('/branding/recce/reject/{fld_raid}', [App\Http\Controllers\Branding\BrandingController::class, 'rejectRecce'])->name('branding.recce.reject');
Route::get('/branding/installation/approve/{fld_oid}', [App\Http\Controllers\Branding\BrandingController::class, 'approveInstallation'])->name('branding.installation.approve');
Route::get('/branding/installation/reject/{fld_oid}', [App\Http\Controllers\Branding\BrandingController::class, 'rejectInstallation'])->name('branding.installation.reject');
Route::get('/branding/installation-completed', [App\Http\Controllers\Branding\BrandingController::class, 'installationComplete'])->name('branding.installationcompleted');
Route::get('/branding/installation-approved', [App\Http\Controllers\Branding\BrandingController::class, 'installationApproved'])->name('branding.installationapproved');
Route::get('/branding/installation-rejected', [App\Http\Controllers\Branding\BrandingController::class, 'installationRejected'])->name('branding.installationrejected');
Route::get('/branding/outlets', [App\Http\Controllers\Branding\BrandingController::class, 'outlets'])->name('branding.outlets');


Route::post('/branding/routePlan/upload', [App\Http\Controllers\Branding\RoutePlanController::class,'uploadRoutePlan'])->name('branding.routePlan.upload');
Route::delete('/branding/delete/route-plan/{id}', [App\Http\Controllers\Branding\RoutePlanController::class, 'deleteRoutePlan'])->name('branding.delete.routePlans');
Route::get('/branding/route-plan', [App\Http\Controllers\Branding\RoutePlanController::class, 'brandingRoutePlan'])->name('branding.routePlan');
Route::get('/branding/upload/route-plans', [App\Http\Controllers\Branding\RoutePlanController::class,'getRoutePlan'])->name('branding.upload.routePlans');
Route::get('/branding/create/route-plan', [App\Http\Controllers\Branding\RoutePlanController::class, 'createRoutePlan'])->name('branding.create.routePlans');
Route::post('/branding/store/route-plan', [App\Http\Controllers\Branding\RoutePlanController::class, 'storeRoutePlan'])->name('branding.store.routePlans');
Route::get('/branding/edit/route-plan/{id}', [App\Http\Controllers\Branding\RoutePlanController::class,'editRoutePlan'])->name('branding.edit.routePlans');
Route::put('/branding/update/route-plan/{id}', [App\Http\Controllers\Branding\RoutePlanController::class,'updateRoutePlan'])->name('branding.update.routePlans');


// Route::get('/mandi/retail-sales', [App\Http\Controllers\Mandi\SalesReportController::class, 'retailSales'])->name('mandi.retailsales');
Route::get('/mandi/retail-sale/details/{id}', [App\Http\Controllers\Mandi\SalesReportController::class, 'retailSaleDetails'])->name('mandi.retailsales.details');
Route::post('/mandi/retail-sale/details-update', [App\Http\Controllers\Mandi\SalesReportController::class, 'retailSaleDetailsUpdate'])->name('mandi.retailsales.details.update');
Route::delete('/mandi/retail-sale/delete/{id}', [App\Http\Controllers\Mandi\SalesReportController::class, 'retailSaleDetailsDelete'])->name('mandi.retailsales.delete');
Route::get('/mandi/route-plan', [App\Http\Controllers\Mandi\SalesReportController::class, 'mandiRoutePlan'])->name('mandi.routePlan');
Route::post('/mandi/store/route-plan', [App\Http\Controllers\Mandi\SalesReportController::class, 'storeRoutePlan'])->name('mandi.store.routePlans');
Route::get('/mandi/upload/route-plans', [App\Http\Controllers\Mandi\SalesReportController::class,'getRoutePlan'])->name('mandi.upload.routePlans');
Route::post('/mandi/routePlan/upload', [App\Http\Controllers\Mandi\SalesReportController::class,'uploadRoutePlan'])->name('mandi.routePlan.upload');
Route::get('/mandi/create/route-plan', [App\Http\Controllers\Mandi\SalesReportController::class, 'createRoutePlan'])->name('mandi.create.routePlans');
Route::delete('/mandi/delete/route-plan/{id}', [App\Http\Controllers\Mandi\SalesReportController::class, 'deleteRoutePlan'])->name('mandi.delete.routePlans');
Route::get('/mandi/edit/route-plan/{id}', [App\Http\Controllers\Mandi\SalesReportController::class,'editRoutePlan'])->name('mandi.edit.routePlans');
Route::put('/mandi/update/route-plan/{id}', [App\Http\Controllers\Mandi\SalesReportController::class, 'updateRoutePlan'])->name('mandi.update.routePlans');

Route::get('/mandi/consumer-sales', [App\Http\Controllers\Mandi\SalesReportController::class, 'consumerSales'])->name('mandi.consumersales');
Route::get('/mandi/consumersales/details/{id}', [App\Http\Controllers\Mandi\SalesReportController::class, 'consumerSaleDetails'])->name('mandi.consumersales.details');
Route::post('/mandi/consumersales/details/update', [App\Http\Controllers\Mandi\SalesReportController::class, 'consumerSaleDetailsUpdate'])->name('mandi.consumerSales.details.update');
Route::delete('/mandi/consumersales/delete/{id}', [App\Http\Controllers\Mandi\SalesReportController::class, 'consumerSaleDetailsDelete'])->name('mandi.consumerSales.delete');

Route::get('/mandi/purchase', [App\Http\Controllers\Mandi\PurchaseDetailController::class, 'index'])->name('mandi.purchase');
Route::get('/mandi/purchase-details/{id}', [App\Http\Controllers\Mandi\PurchaseDetailController::class, 'getPurchaseDetails'])->name('mandi.purchasedetails.items');
Route::post('/mandi//purchase-details-update', [App\Http\Controllers\Mandi\PurchaseDetailController::class, 'updatePurchaseDetails'])->name('mandi.purchasedetails.item.udate');
Route::delete('/mandi/purchase-details/{id}', [App\Http\Controllers\Mandi\PurchaseDetailController::class, 'deletePurchaseDetails'])->name('mandi.purchasedetails.delete');

Route::get('/mandi/activity-photos', [App\Http\Controllers\Mandi\PurchaseDetailController::class, 'activityPhoto'])->name('mandi.activityphotos');

Route::get('/mandi/retailers', [App\Http\Controllers\Mandi\RetailersController::class, 'index'])->name('mandi.retailers');
Route::get('/mandi/retail-sales', [App\Http\Controllers\Mandi\SalesReportController::class, 'retailSales'])->name('mandi.retailsales');
Route::get('/mandi/retail-sale/add-new', [App\Http\Controllers\Mandi\SalesReportController::class, 'addNewOrder'])->name('mandi.retailsales.addnew');
Route::post('/mandi/retail-sale/store', [App\Http\Controllers\Mandi\SalesReportController::class, 'storeNewOrder'])->name('mandi.retailsales.createNewOrder');
Route::get('/mandi/retailer/delete/{rid}', [App\Http\Controllers\Mandi\RetailersController::class, 'destroy'])->name('mandi.retailer.delete');

Route::get('/mandi/consumer', [App\Http\Controllers\Mandi\ConsumerController::class, 'index'])->name('mandi.consumer');
Route::get('/mandi/consumer-sales', [App\Http\Controllers\Mandi\SalesReportController::class, 'consumerSales'])->name('mandi.consumersales');
Route::get('/mandi/consumer/sale/add-new', [App\Http\Controllers\Mandi\ConsumerController::class, 'addNewOrder'])->name('mandi.consumersales.addnew');
Route::post('/mandi/consumer/store/new', [App\Http\Controllers\Mandi\ConsumerController::class, 'storeNewOrder'])->name('mandi.consumer.createNewOrder');
Route::get('/mandi/consumer/delete/{id}', [App\Http\Controllers\Mandi\ConsumerController::class, 'destroy'])->name('mandi.consumer.destroy');
Route::get('mandi/stockists', [App\Http\Controllers\Mandi\PurchaseDetailController::class, 'getStockists'])->name('mandi.stockists');
Route::get('/mandi/stockist/order/add-new', [App\Http\Controllers\Mandi\PurchaseDetailController::class, 'addNewStockistOrder'])->name('mandi.stockists.addneworder');
Route::post('/mandi/stockist/order/save', [App\Http\Controllers\Mandi\PurchaseDetailController::class, 'saveStockistOrder'])->name('mandi.stockists.save.addneworder');
Route::get('/mandi/stockist/delete/{sid}', [App\Http\Controllers\Mandi\PurchaseDetailController::class, 'deleteStockists'])->name('mandi.stockists.delete');


Route::get('/mela/attendees', [App\Http\Controllers\Mela\SalesReportController::class, 'consumer'])->name('mela.attendees');
Route::get('/mela/consumer-sales', [App\Http\Controllers\Mela\SalesReportController::class, 'consumerSales'])->name('mela.consumersales');
Route::get('/mela/consumersales/details/{id}', [App\Http\Controllers\Mela\SalesReportController::class, 'consumerSaleDetails'])->name('mela.consumersales.details');
Route::post('/mela/consumersales/details/update', [App\Http\Controllers\Mela\SalesReportController::class, 'consumerSaleDetailsUpdate'])->name('mela.consumerSales.details.update');
Route::delete('/mela/consumersales/delete/{id}', [App\Http\Controllers\Mela\SalesReportController::class, 'consumerSaleDetailsDelete'])->name('mela.consumerSales.delete');

Route::get('/mela/purchase', [App\Http\Controllers\Mela\PurchaseDetailController::class, 'index'])->name('mela.purchase');
Route::get('/mela/purchase-details/{id}', [App\Http\Controllers\Mela\PurchaseDetailController::class, 'getPurchaseDetails'])->name('mela.purchasedetails.items');
Route::post('/mela/purchase-details-update', [App\Http\Controllers\Mela\PurchaseDetailController::class, 'updatePurchaseDetails'])->name('mela.purchasedetails.item.udate');
Route::delete('/mela/purchase-details/{id}', [App\Http\Controllers\Mela\PurchaseDetailController::class, 'deletePurchaseDetails'])->name('mela.purchasedetails.delete');
Route::get('/mela/activity-photos', [App\Http\Controllers\Mela\PurchaseDetailController::class, 'activityPhoto'])->name('mela.activityphotos');
Route::get('mela/stockists', [App\Http\Controllers\Mela\PurchaseDetailController::class, 'getStockists'])->name('mela.stockists');
Route::get('/mela/stockist/order/add-new', [App\Http\Controllers\Mela\PurchaseDetailController::class, 'addNewStockistOrder'])->name('mela.stockists.addneworder');
Route::post('/mela/stockist/order/save', [App\Http\Controllers\Mela\PurchaseDetailController::class, 'saveStockistOrder'])->name('mela.stockists.save.addneworder');
Route::get('/mela/stockist/delete/{sid}', [App\Http\Controllers\Mela\PurchaseDetailController::class, 'deleteStockists'])->name('mela.stockists.delete');

Route::get('/mela/consumer', [App\Http\Controllers\Mela\ConsumerController::class, 'index'])->name('mela.consumer');
Route::get('/mela/consumer-sales', [App\Http\Controllers\Mela\SalesReportController::class, 'consumerSales'])->name('mela.consumersales');
Route::get('/mela/consumer/sale/add-new', [App\Http\Controllers\Mela\ConsumerController::class, 'addNewOrder'])->name('mela.consumersales.addnew');
Route::post('/mela/consumer/store/new', [App\Http\Controllers\Mela\ConsumerController::class, 'storeNewOrder'])->name('mela.consumer.createNewOrder');
Route::get('/mela/consumer/delete/{id}', [App\Http\Controllers\Mela\ConsumerController::class, 'destroy'])->name('mela.consumer.destroy');

Route::post('/mela/routePlan/upload', [App\Http\Controllers\Mela\MelaRoutePlanController::class,'uploadRoutePlan'])->name('mela.routePlan.upload');
Route::delete('/mela/delete/route-plan/{id}', [App\Http\Controllers\Mela\MelaRoutePlanController::class, 'deleteRoutePlan'])->name('mela.delete.routePlans');
Route::get('/mela/route-plan', [App\Http\Controllers\Mela\MelaRoutePlanController::class, 'melaRoutePlan'])->name('mela.routePlan');
Route::get('/mela/upload/route-plans', [App\Http\Controllers\Mela\MelaRoutePlanController::class,'getRoutePlan'])->name('mela.upload.routePlans');
Route::get('/mela/create/route-plan', [App\Http\Controllers\Mela\MelaRoutePlanController::class, 'createRoutePlan'])->name('mela.create.routePlans');
Route::post('/mela/store/route-plan', [App\Http\Controllers\Mela\MelaRoutePlanController::class, 'storeRoutePlan'])->name('mela.store.routePlans');
Route::get('/mela/edit/route-plan/{id}', [App\Http\Controllers\Mela\MelaRoutePlanController::class,'editRoutePlan'])->name('mela.edit.routePlans');
Route::put('/mela/update/route-plan/{id}', [App\Http\Controllers\Mela\MelaRoutePlanController::class,'updateRoutePlan'])->name('mela.update.routePlans');

Route::get('/van/retail-sales', [App\Http\Controllers\SalesReportController::class, 'retailSales'])->name('van.retailsales');
Route::get('/van/route-plan', [App\Http\Controllers\SalesReportController::class, 'vanRoutePlan'])->name('van.routePlan');

Route::get('/van/upload/route', [App\Http\Controllers\SalesReportController::class,'getRoutePlan'])->name('van.upload.routePlans');
Route::get('/van/retail-sale/details/{id}', [App\Http\Controllers\SalesReportController::class, 'retailSaleDetails'])->name('van.retailsales.details');
Route::delete('/van/retail-sale/delete/{id}', [App\Http\Controllers\SalesReportController::class, 'retailSaleDetailsDelete'])->name('van.retailsales.delete');


Route::get('/sales-report/retail-sale/add-new', [App\Http\Controllers\SalesReportController::class, 'addNewOrder'])->name('salesreport.retailsales.addnew');

Route::post('/sales-report/retail-sale/store', [App\Http\Controllers\SalesReportController::class, 'storeNewOrder'])->name('salesreport.retailsales.createNewOrder');
Route::get('/sales-report/retail-sale/details/{id}', [App\Http\Controllers\SalesReportController::class, 'retailSaleDetails'])->name('salesreport.retailsales.details');
Route::post('/sales-report/retail-sale/details-update', [App\Http\Controllers\SalesReportController::class, 'retailSaleDetailsUpdate'])->name('salesreport.retailsales.details.update');
Route::delete('/sales-report/retail-sale/delete/{id}', [App\Http\Controllers\SalesReportController::class, 'retailSaleDetailsDelete'])->name('salesreport.retailsales.delete');
Route::get('/sales-report/retail-sale/get-state-wise-users/{state_id}', [App\Http\Controllers\SalesReportController::class, 'getUsersStateID'])->name('salesreport.retailsales.get_users_by_state');



Route::get('/van/consumer-sales', [App\Http\Controllers\SalesReportController::class, 'consumerSales'])->name('van.consumersales');
Route::get('/van/consumersales/details/{id}', [App\Http\Controllers\SalesReportController::class, 'consumerSaleDetails'])->name('van.consumersales.details');
Route::post('/van/consumersales/details/update', [App\Http\Controllers\SalesReportController::class, 'consumerSaleDetailsUpdate'])->name('van.consumerSales.details.update');
Route::delete('/van/consumersales/delete/{id}', [App\Http\Controllers\SalesReportController::class, 'consumerSaleDetailsDelete'])->name('van.consumerSales.delete');
Route::get('/sales-report/consumer-sales/get-state-wise-users/{state_id}', [App\Http\Controllers\SalesReportController::class, 'getUsersStateIDForConsumer'])->name('salesreport.consumerSales.getUserByState');


Route::get('/purchase-details/get-state-wise-users/{state_id}/{project_id}', [App\Http\Controllers\PurchaseDetailController::class, 'getUsersStateID'])->name('purchasedetails.getUserByStateId');
Route::get('/van/purchase', [App\Http\Controllers\PurchaseDetailController::class, 'index'])->name('van.purchase');
Route::get('/van/purchase-details/{id}', [App\Http\Controllers\PurchaseDetailController::class, 'getPurchaseDetails'])->name('van.purchasedetails.items');
Route::delete('/van/purchase-details/{id}', [App\Http\Controllers\PurchaseDetailController::class, 'deletePurchaseDetails'])->name('van.purchasedetails.delete');
Route::post('/purchase-details-update', [App\Http\Controllers\PurchaseDetailController::class, 'updatePurchaseDetails'])->name('purchasedetails.item.udate');
Route::get('/van/activity-photos', [App\Http\Controllers\PurchaseDetailController::class, 'activityPhoto'])->name('van.activityphotos');
Route::get('/activity-reports', [App\Http\Controllers\PurchaseDetailController::class, 'activityReports'])->name('activityreports');

Route::get('/stockists', [App\Http\Controllers\PurchaseDetailController::class, 'getStockists'])->name('stockists');
Route::get('van/stockists', [App\Http\Controllers\PurchaseDetailController::class, 'getStockists'])->name('van.stockists');
Route::get('/stockist/order/add-new', [App\Http\Controllers\PurchaseDetailController::class, 'addNewStockistOrder'])->name('stockists.addneworder');
Route::post('/stockist/order/save', [App\Http\Controllers\PurchaseDetailController::class, 'saveStockistOrder'])->name('stockists.save.addneworder');
Route::get('/stockist/delete/{sid}', [App\Http\Controllers\PurchaseDetailController::class, 'deleteStockists'])->name('stockists.delete');
Route::get('/reports', [App\Http\Controllers\ReportsController::class, 'reports'])->name('reports');



Route::get('/get-project-wise-states/{project_id}', [App\Http\Controllers\SalesReportController::class, 'getStateByProjectID'])->name('get_states_by_proejct');
Route::get('/get-state-wise-district/{state_id}', [App\Http\Controllers\SalesReportController::class, 'getDistrictByStateID'])->name('get_districts_by_state');

Route::get('/van/retailers', [RetailersController::class, 'index'])->name('van.retailers');
Route::get('/retailers/orders', [RetailersController::class, 'getRetailerOrders'])->name('retailers.orders');
Route::delete('/retailer/delete/{rid}', [RetailersController::class, 'destroy'])->name('retailer.delete');

Route::get('/retailers/get-project-wise-states/{project_id}', [RetailersController::class, 'getStateByProjectID'])->name('get_states_by_proejct');
Route::get('/retailers/get-state-wise-district/{state_id}', [RetailersController::class, 'getDistrictByStateID'])->name('get_districts_by_state');
Route::get('/retailers/get-project-wise-users/{project_id}', [RetailersController::class, 'getUsersProjectID'])->name('get_districts_by_state');

Route::get('/consumers/get-project-wise-states/{project_id}', [ConsumerController::class, 'getStateByProjectID'])->name('consumer.get_states_by_proejct');
Route::get('/consumers/get-state-wise-district/{state_id}', [ConsumerController::class, 'getDistrictByStateID'])->name('consumer.get_districts_by_state');
Route::get('/consumers/get-project-wise-users/{project_id}', [ConsumerController::class, 'getUsersProjectID'])->name('consumer.get_districts_by_state');


Route::get('/stockist/get-project-wise-states/{project_id}', [App\Http\Controllers\PurchaseDetailController::class, 'getStateByProjectIDForStockist'])->name('stockist.get_states_by_proejct');
Route::get('/stockist/get-state-wise-district/{state_id}', [App\Http\Controllers\PurchaseDetailController::class, 'getDistrictByStateIDForStockist'])->name('stockist.get_districts_by_state');
Route::get('/stockist/get-project-wise-users/{project_id}', [App\Http\Controllers\PurchaseDetailController::class, 'getUsersProjectIDForStockist'])->name('stockist.get_districts_by_state');


Route::get('/report/route-plan', [App\Http\Controllers\ReportsController::class, 'routePlan'])->name('report.routePlan');
Route::get('/report/route-plan/getStates/{project_id}', [App\Http\Controllers\ReportsController::class, 'getStateByProjectID'])->name('report.routePlan.getStates');
Route::get('/report/route-plan/getUsers/{project_id}', [App\Http\Controllers\ReportsController::class, 'getUsersProjectID'])->name('report.routePlan.getUsers');
Route::get('/report/daywise-sales-summary', [App\Http\Controllers\ReportsController::class, 'dayWiseSalesSummary'])->name('report.dayWiseSalesSummary');
Route::get('/report/stock-report', [App\Http\Controllers\ReportsController::class, 'stockReport'])->name('report.stockreport');

Route::get('/van/consumer', [ConsumerController::class, 'index'])->name('van.consumer');
        
Route::group(['prefix' => 'master'], function () {
    Route::controller(App\Http\Controllers\MasterController::class)->group(function () {
        // Route::get('/clients', 'getClients')->name('master.clients');
        // Route::get('/projects', 'getProjects')->name('master.projects');
        Route::get('/route-plans', 'getRoutePlan')->name('master.routePlans');
        Route::get('/create/route-plan', 'createRoutePlan')->name('master.create.routePlans');
        Route::get('/edit/route-plan/{id}', 'editRoutePlan')->name('master.edit.routePlans');
        Route::put('/update/route-plan/{id}', 'updateRoutePlan')->name('master.update.routePlans');
        Route::delete('/delete/route-plan/{id}', 'deleteRoutePlan')->name('master.delete.routePlans');
        Route::post('/store/route-plan', 'storeRoutePlan')->name('master.store.routePlans');
        Route::get('/route-plan-reupload', 'reUploadRoutePlan')->name('master.reuploadroutePlans');
        Route::post('/route-plan/upload-excel', 'uploadRoutePlan')->name('master.routePlan.upload');
        Route::get('/products', 'getProducts')->name('master.products');
        Route::post('/products/uploads', 'uploadProducts')->name('master.products.uploads');
        Route::resource('users', UserController::class);
        Route::resource('clients', ClientController::class);

        Route::resource('projects', ProjectController::class);
        Route::resource('products', ProductController::class);
        Route::post('/product/update-status/', [ProductController::class, 'updateStatus']);

        Route::resource('/phototypes', PhotoTypeController::class);
       Route::resource('/consumer', ConsumerController::class);
        Route::group(['prefix' => 'project'], function () {
            Route::resource('/custom-fields', CustomFieldController::class);
            Route::post('/custom-fields-reorder', [CustomFieldController::class, 'reorder'])->name('custom-fields.reorder');
            Route::post('/custom-fields/update-status', [CustomFieldController::class, 'updateStatus']);
            Route::resource('/summaries', SummaryController::class);
            Route::post('/summaries-reorder', [SummaryController::class, 'reorder'])->name('summaries.reorder');
            Route::post('/summaries/update-status', [SummaryController::class, 'updateStatus']);
        });
        Route::get('/consumer/sale/add-new', [ConsumerController::class, 'addNewOrder'])->name('salesreport.consumersales.addnew');
        Route::post('/consumer/store/new', [ConsumerController::class, 'storeNewOrder'])->name('consumer.createNewOrder');
    });
});

Route::group(['prefix' => 'location'], function () {
    Route::resource('district', DistrictController::class);
    Route::resource('tehsil', TehsilController::class);
    Route::resource('village', VillageController::class);
});
