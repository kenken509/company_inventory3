<?php

// use <- to load your controllers
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\POS\SupplierController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\POS\CategoriesController;
use App\Http\Controllers\POS\StocksController;
use App\Http\Controllers\POS\UsersController;
use App\Http\Controllers\POS\OrdersController;
use App\Http\Controllers\POS\MerchandiseReturnSlipController;
use App\Http\Controllers\POS\AppliancesDeliveriesController;
use App\Http\Controllers\POS\BrandsController;
use App\Http\Controllers\POS\AppliancesDefectivesController;
use App\Http\Controllers\POS\FurnituresDeliveriesController;  
use App\Http\Controllers\POS\AppliancesSalesController;
use App\Http\Controllers\POS\AppliancesCategoriesController; 
use App\Http\Controllers\POS\AppliancesProductsController;    
use App\Http\Controllers\POS\DefaultController;     
use App\Http\Controllers\POS\FurnitureCategoriesController; 
use App\Http\Controllers\POS\furnitureProductsController;
use App\Http\Controllers\POS\furnitureSupplierController;   
use App\Http\Controllers\POS\FurnitureWorkingStocksController;
use App\Http\Controllers\POS\FurnitureSalesController;
use App\Http\Controllers\POS\FurnitureDefectivesController;

 
use Illuminate\Support\Auth;
use App\Models\AppliancesSales; 
use App\Models\FurnitureSales;


Route::controller(WebsiteController::class)->group(function () {
   Route::get('/', 'home')->name('homepage');
   Route::get('/checkout', 'checkout')->name('checkout'); 
   
});

// handles error 404 incorrect url
// Route::fallback(function (){
//    return view('admin.index');
// });
// end of handles error 404 incorrect url

Route::get('/customer', [CustomerController::class, 'customerData']);	
//Route::middleware('auth')->get('/customer', [CustomerController::class, 'customerData']);	
Route::middleware('auth')->get('/appliances', [AppliancesProductsController::class, 'AppliancesProductsApiAll']);	
Route::middleware('auth')->post('/add-to-cart', [CustomerController::class, 'addToCart']);
Route::middleware('auth')->post('/remove-from-cart', [CustomerController::class, 'deleteFromCart']);
Route::middleware('auth')->post('/submit-cart-items', [CustomerController::class, 'submitCheckout']);
Route::middleware('auth')->get('/payment', [CustomerController::class, 'customerPayment']);



Route::controller(OrdersController::class)->group(function () {
   Route::get('/orders', 'viewAllOrders')->name('orders.all');
   Route::get('/orders/{id}', 'viewOrder')->name('orders.view');
   Route::post('/orders/update_item', 'orderPackItem')->name('order.packItem');   
   Route::post('orders/delivered', 'orderDelivered')->name('order.delivered');
});


 // Admin All Route 
Route::controller(AdminController::class)->group(function () {
   Route::group(['middleware' => ['auth']], function () {
      Route::get('/dashboard', 'dashboard')->name('dashboard'); // middleware is used to authenticate user and redirect to a specific location in app.
      Route::get('/admin/logout', 'destroy')->name('admin.logout');
      Route::get('/admin/profile', 'Profile')->name('admin.profile');
      Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
      Route::post('/store/profile', 'StoreProfile')->name('store.profile');

      Route::get('/change/password', 'ChangePassword')->name('change.password');
      Route::post('/update/password', 'UpdatePassword')->name('update.password');
   });
});

// Users All Route 

Route::controller(UsersController::class)->group(function(){
   Route::get('/users/all', 'UsersAll')->name('users.all');
   Route::get('/user/add','UserAdd')->name('user.add');
   Route::post('/user/store', 'UserStore')->name('user.store');
   Route::get('/user/delete/{id}', 'UserDelete')->name('user.delete');
   Route::get('/user/edit/{id}', 'UserEdit')->name('user.edit');
   Route::post('/user/update', 'UserUpdate')->name('user.update');
});

 
 // appliances suppliers  All Route     ****to edit url***
 Route::controller(SupplierController::class)->group(function () { // must create a controller and model for this route
    Route::get('/supplier/appliances/all', 'SupplierAll')->name('appLiancesSupplier.all'); // name() to use when generating URL  or redirects via laravel's route.  
    Route::get('/supplier/add','SupplierAdd')->name('supplier.add');
    Route::post('/supplier/store', 'SupplierStore')->name('supplier.store');     
    Route::get('/supplier/edit/{id}','SupplierEdit')->name('supplier.edit'); 
    Route::post('/supplier/update','SupplierUpdate')->name('supplier.update');
    Route::get('/supplier/delete/{id}','SupplierDelete')->name('supplier.delete');
}); //get('URL', 'function name') parameters




 

 // Categories All Route 
 Route::controller(CategoriesController::class)->group(function(){
    Route::get('/categories/all', 'CategoriesAll')->name('categories.all');
    Route::get('/categories/add', 'CategoryAdd')->name('category.add');
    Route::post('/categories/store', 'CategoryStore')->name('category.store');
    Route::get('/categories/edit/{id}', 'CategoryEdit')->name('category.edit');
    Route::post('/categories/update', 'CategoryUpdate')->name('category.update');
    Route::get('/categories/delete/{id}', 'CategoryDelete')->name('category.delete');
 });
 
//StocksController
 Route::controller(StocksController::class)->group(function(){   
   Route::get('/stocks/appliances/all', 'AppliancesWorkingStocks')->name('appliancesWorkingStocks.all');
});//end controller

//appliances deliveries controller
 Route::controller(AppliancesDeliveriesController::class)->group(function(){
   Route::get('/appliances/deliveries/all', 'AppliancesDeliveriesAll')->name('appliancesDeliveries.all');
   Route::get('/appliances/deliveries/add', 'AppliancesDeliveriesAdd')->name('appliancesDeliveries.add');
   Route::post('/appliances/deliveries/store', 'AppliancesDeliveriesStore')->name('appliancesDeliveries.store');
   Route::get('/appliances/deliveries/delete/{id}', 'AppliancesDeliveriesDelete')->name('appliancesDeliveries.delete');
 });

 // appliancesProducts controller
 Route::controller(AppliancesProductsController::class)->group(function(){
   Route::get('/appliances/products/all', 'AppliancesProductsAll')->name('appliancesProducts.all');
   Route::get('/appliances/products/add', 'AppliancesProductsAdd')->name('appliancesProducts.add');
   Route::post('/appliances/products/store', 'AppliancesProductStore')->name('appliancesProduct.store');
   Route::get('/appliances/products/delete/{id}', 'AppliancesProductDelete')->name('appliancesProduct.delete');
   Route::get('/appliances/products/edit/{id}', 'AppliancesProductEdit')->name('appliancesProduct.edit');
   Route::post('/appliances/products/update', 'AppliancesProductUpdate')->name('appliancesProduct.update');
 });

 // Brands Controller
 Route::controller(BrandsController::class)->group(function(){
   Route::get('/brands/all', 'BrandsAll')->name('brands.all');
   Route::get('/brands/add', 'BrandAdd')->name('brand.add');
   Route::post('brand/store', 'BrandStore')->name('brand.store');
   Route::get('/brand/edit/{id}', 'BrandEdit')->name('brand.edit');
   Route::post('brand/update', 'BrandUpdate')->name('brand.update');
   Route::get('/brand/delete/{id}', 'BrandDelete')->name('brand.delete');
 });

 Route::controller(AppliancesCategoriesController::class)->group(function(){
   Route::get('/appliances/categories/all', 'AppliancesCategoriesAll')->name('appliancesCategories.all');
   Route::get('/appliances/categories/add', 'AppliancesCategoriesAdd')->name('appliancesCategories.add');
   Route::post('appliances/categories/store', 'AppliancesCategoriesStore')->name('appliancesCategory.store');
   Route::get('/appliances/categories/delete/{id}', 'AppliancesCategoriesDelete')->name('appliancesCategory.delete');
   Route::get('/appliances/categories/edit/{id}', 'AppliancesCategoriesEdit')->name('appliancesCategory.edit');   
   Route::post('appliances/categories/update', 'AppliancesCategoriesUpdate')->name('appliancesCategory.update');
 });



//furniture categories controller
Route::controller(FurnitureCategoriesController::class)->group(function(){
   Route::get('/furniture/categories/all', 'FurnitureCategoriesAll')->name('furnitureCategories.all');
   Route::get('/furniture/categories/edit/{id}', 'FurnitureCategoriesEdit')->name('furnitureCategory.edit');
   Route::get('/furniture/categories/delete/{id}', 'FurnitureCategoriesDelete')->name('furnitureCategory.delete');
   Route::post('/furniture/categories/update', 'FurnitureCategoriesUpdate')->name('furnitureCategory.update');
   Route::get('/furniture/categories/add', 'FurnitureCategoriesAdd')->name('furnitureCategory.add');   
   Route::post('/furniture/categories/store', 'FurnitureCategoriesStore')->name('furnitureCategory.store');
});

// furniture suppliers all route
Route::controller(furnitureSupplierController::class)->group(function(){
   Route::get('/supplier/furniture/all', 'FurnitureSupplierAll')->name('furnitureSuppliers.all');
   Route::get('/supplier/furniture/add', 'FurnitureSupplierAdd')->name('supplierfurniture.add');
   Route::post('/supplier/furniture/store', 'FurnitureSupplierStore')->name('furnitureSupplier.store');
   Route::get('/supplier/furniture/delete/{id}', 'FurnitureSupplierDelete')->name('furnitureSupplier.delete');
   Route::get('/supplier/furniture/edit/{id}', 'FurnitureSupplierEdit')->name('furnitureSupplier.edit');
   Route::post('/supplier/furniture/update', 'FurnitureSupplierUpdate')->name('furnitureSupplier.update');

 });

 //furniture products all route
 Route::controller(furnitureProductsController::class)->group(function(){
   Route::get('furniture/products/all', 'FurnitureProductsAll')->name('furnitureProducts.all');
   Route::get('furniture/products/add', 'FurnitureProductsAdd')->name('furnitureProducts.add');
   Route::post('furniture/products/store', 'FurnitureProductsStore')->name('furnitureProduct.store');
   Route::get('furniture/products/delete/{id}', 'FurnitureProductsDelete')->name('furnitureProduct.delete');
   Route::get('furniture/products/edit/{id}', 'FurnitureProductsEdit')->name('furnitureProduct.edit');
   Route::post('furniture/products/update', 'FurnitureProductsUpdate')->name('furnitureProduct.update');
 });

//****************************************************************************** */
// furniture deliveries controller
Route::controller(FurnituresDeliveriesController::class)->group(function(){
   Route::get('/furnitures/deliveries/all', 'FurnitureDeliveriesAll')->name('furnitureDeliveries.all');
   Route::get('/furnitures/deliveries/add', 'FurnitureDeliveriesAdd')->name('furnitureDeliveries.add');
   Route::post('/furnitures/deliveries/store', 'FurnitureDeliveriesStore')->name('furnitureDeliveries.store'); 
   Route::get('/furnitures/deliveries/delete/{id}', 'FurnitureDeliveriesDelete')->name('furnitureDeliveries.delete');

});
// furniture sales controller
Route::controller(FurnitureDefectivesController::class)->group(function(){
   Route::get('/furniture/defectives/all', 'FurnitureDefectivesAll')->name('furnitureDefectives.all');
   Route::get('/furniture/defectives/return/{id}', 'FurnitureDefectivesReturn')->name('furnitureDefective.return');
});

// furniture sales controller
Route::controller(FurnitureSalesController::class)->group(function(){
   Route::get('/furniture/sales/all', 'FurnitureSalesAll')->name('furnitureSales.all'); 
   Route::get('/furniture/sales/add', 'FurnitureSalesAdd')->name('furnitureSales.add');
   Route::post('/furniture/sales/store', 'FurnitureSalesStore')->name('furnitureSales.store'); 
   Route::get('/furniture/sales/delete/{id}', 'FurnitureSalesDelete')->name('furnitureSales.delete');
});


// furniture working stocks controller
Route::controller(FurnitureWorkingStocksController::class)->group(function(){
   Route::get('/stocks/furnitures/all', 'FurnituresWorkingStocksAll')->name('furnituresWorkingStocks.all');
}); // end FurnitureWorkingStocksController

//appliances sales controller
Route::controller(AppliancesSalesController::class)->group(function(){
   Route::get('/appliances/sales/all', 'AppliancesSalesAll')->name('appliancesSales.all');
   Route::get('/appliances/sales/add', 'AppliancesSalesAdd')->name('appliancesSales.add');
   Route::post('/appliances/sales/store', 'AppliancesSalesStore')->name('appliancesSales.store');
   Route::get('/appliances/sales/delete/{id}', 'AppliancesSalesDelete')->name('appliancesSales.delete');
});//end of function


Route::controller(AppliancesDefectivesController::class)->group(function(){
   Route::get('/appliances/defectives/all', 'AppliancesDefectivesAll')->name('appliancesDefectives.all');
   Route::get('/appliances/return/{id}', 'AppliancesDefectiveReturn')->name('appliancesDefective.return');
});

Route::controller(MerchandiseReturnSlipController::class)->group(function(){
   Route::get('/merchandise-returns/all', 'MerchandiseReturnsAll')->name('merchandiseReturns.all');
});

//default Controller
Route::controller(DefaultController::class)->group(function(){
   //appliances defaults controller
   Route::get('/get-category', 'GetCategory')->name('get-category');
   Route::get('/get-products', 'GetProduct')->name('get-product');
   Route::get('/get-brands', 'GetBrands')->name('get-brands');
   Route::get('/get-serials', 'GetSerials')->name('get-serials');
   Route::get('/get-working-products', 'GetWorkingProducts')->name('get-working-products');

   // furniture defaults controller
   Route::get('/get-furniture-categories', 'GetFurnitureCategories')->name('get-furniture-categories'); 
   Route::get('/get-furniture-products', 'GetFurnitureProducts')->name('get-furniture-products');
   Route::get('/get-working-furnitures', 'GetWorkingFurnitures')->name('get-working-furniture');
   Route::get('/get-furniture-price', 'GetFurniturePrice')->name('get-furniture-price');
});



require __DIR__.'/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });