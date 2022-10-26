## About 

This web service is built with Laravel and includes the necessary controllers and routes to collect and store data. The data is stored in a database deployed by Heroku. The web service stores data under the product name, product description, price, image and quantity. Functionality for showing which items are low in stock and to update the stock is included and easily done. The data is protected and accessible through authentication with registration and login. 


## Routes
The following routes are used to send queries into the database.

// password protected 
Route::resource('plants', PlantController::class)->middleware('auth:sanctum');
Route::resource('categories', CategoryController::class)->middleware('auth:sanctum');
Route::get('plants/search/{searchTerm}', [PlantController::class, 'searchText'])->middleware('auth:sanctum');
Route::get('plants/lowstock/{quantity}', [PlantController::class, 'lowStock'])->middleware('auth:sanctum');
Route::put('plants/addstock/{id}', [PlantController::class, 'update'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::resource('about', AboutController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
