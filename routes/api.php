    <?php

    use App\Http\Controllers\Auth\AuthController;
    use App\Http\Controllers\Car\CarController;
    use App\Http\Controllers\Order\OrderController;
    use Illuminate\Support\Facades\Route;


    // Authentication Routes
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:api');
    });

    // Public Routes
    Route::get('/cars', [CarController::class, 'index']);

    // Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::controller(CarController::class)->group(function () {
            Route::post('/cars', 'store');
            Route::patch('/cars/{car}/maintenance', 'markAsUnavailable');
        });
    });

    // Order Routes
    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index');
        Route::post('/orders', 'store');
        Route::patch('/orders/{order}/pay', 'pay');
    });

