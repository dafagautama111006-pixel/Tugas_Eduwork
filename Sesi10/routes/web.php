use App\Http\Controllers\ShopController;

Route::get('/', [ShopController::class, 'home']);
Route::get('/product', [ShopController::class, 'product']);
Route::post('/cart/add/{id}', [ShopController::class, 'addToCart']);
Route::get('/cart', [ShopController::class, 'cart']);
Route::post('/checkout', [ShopController::class, 'checkout']);
