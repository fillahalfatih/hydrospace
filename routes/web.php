<?php

use App\Models\User;
use App\Models\Order;
use App\Livewire\Chat;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Livewire\ChatToAdmin;
use App\Models\VideoCategory;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\VideoCategoryController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\VideoViewController;
use App\Models\Video;
use App\Models\VideoView;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/masuk', [AuthenticationController::class, 'login']);
Route::post('/masuk', [AuthenticationController::class, 'authenticate']);
Route::get('/lupa-password', [AuthenticationController::class, 'showForgotPasswordForm']);
Route::post('/lupa-password', [AuthenticationController::class, 'sendResetLinkEmail']);
Route::get('/reset-password/{token}', [AuthenticationController::class, 'showResetPasswordForm'])
    ->name('password.reset');
Route::put('/reset-password', [AuthenticationController::class, 'resetPassword']);
Route::get('/registrasi', [AuthenticationController::class, 'regist']);
Route::post('/registrasi', [AuthenticationController::class, 'createAccount']);
Route::get('/buat-profil', [AuthenticationController::class, 'showCreateProfile']);
Route::post('/buat-profil', [AuthenticationController::class, 'storeCustomer']);
Route::get('/get-cities/{provinceId}', [LocationController::class, 'getCities']);
Route::get('/get-districts/{cityId}', [LocationController::class, 'getDistricts']);
Route::get('/get-villages/{districtId}', [LocationController::class, 'getVillages']);

Route::middleware(['blockAdmin'])->group(function () {
    Route::get('/', function () {
        $mostViewedVideoViews = VideoView::select('video_id', DB::raw('count(*) as total_views'))
            ->groupBy('video_id')
            ->orderByDesc('total_views')
            ->take(2)
            ->get();

        $mostViewedVideos = collect([]);
        foreach ($mostViewedVideoViews as $view) {
            $video = Video::find($view->video_id);
            if ($video) {
                $mostViewedVideos->push($video);
            }
        }

        return view('index', [
            "title" => "HydroSpace | Beranda",
            "active" => "Beranda",
            "bestSellers" => Product::withCount('orderItems')
                ->withSum('orderItems as quantity', DB::raw('quantity'))
                ->orderBy('quantity', 'desc')
                ->take(4)
                ->get(),
            "mostViewedVideos" => $mostViewedVideos,
        ]);
    });

    Route::post('/question', [GeminiController::class, 'index']);
    Route::post('/hydrobot/clear-history', [GeminiController::class, 'clearHistory']);

    Route::get('/produk', [ProductController::class, 'customerIndex']);

    Route::get('/produk/{product:slug}', [ProductController::class, 'customerShow']);

    Route::get('/edukasi', [VideoController::class, 'indexCustomer']);

    Route::get('/hydrobot', function () {
        return view('index', [
            "title" => "HydroSpace | HydroBot",
            "active" => "HydroBot"
        ]);
    });
    Route::post('/question', [GeminiController::class, 'index']);

    Route::get('/tentang', function () {
        return view('about', [
            "title" => "HydroSpace | Tentang Kami",
            "active" => "Tentang"
        ]);
    });

    Route::resource('/kontak', ContactController::class)->parameters([
        'kontak' => 'contact'
    ]);  
});


Route::middleware(['role:Customer'])->group(function () {
    Route::resource('/profil', UserController::class)->parameters([
        'profil' => 'user'
    ]);

    Route::post('/keluar', [AuthenticationController::class, 'logout']);

    Route::get('/update-password', function () {
        return view('updatePassword', [
            "title" => "HydroSpace | Ubah Password",
            "active" => "Ubah Password"
        ]);
    });

    Route::put('/update-password/{user:username}', [UserController::class, 'updatePassword']);

    Route::get('/keranjang', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/keranjang/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/keranjang/update/{orderItemId}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/keranjang/remove/{orderItemId}', [CartController::class, 'removeItem']);

    Route::get('/edukasi/{video:slug}', [VideoController::class, 'showCustomer']);
    Route::resource('/viewVideo', VideoViewController::class);

    Route::resource('/pesanan', OrderController::class)->parameters([
        'pesanan' => 'order'
    ]);
    Route::get('/get-snap-token/{orderId}', [OrderController::class, 'getSnapToken']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::get('/cancel', [OrderController::class, 'cancelOrder']);

    Route::get('/pesanan/id', function () {
        return view('orderDetail', [
            "title" => "HydroSpace | Pesanan Saya",
            "active" => "Pesanan Saya",
        ]);
    });

    // Route::get('/chat', [Chat::class, 'chatToAdmin'])->name('chatToAdmin');
    Route::get('/chat', ChatToAdmin::class)->name('chatToAdmin');

    Route::post('/place-order', [MidtransController::class, 'placeOrder']);
});

Route::middleware(['role:Admin'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::resource('/admins', AdminController::class)->parameters([
        'admins' => 'user'
    ]);

    Route::resource('/customers', CustomerController::class)->parameters([
        'customers' => 'user'
    ]);

    Route::resource('/profile', AdminProfileController::class)->parameters([
        'profile' => 'user'
    ]);

    Route::post('/keluar', [AdminProfileController::class, 'logout']);

    Route::get('/update-password', function () {
        return view('dashboard.updatePassword', [
            "title" => "HydroSpace | Ubah Password",
            "active" => "Profile"
        ]);
    });

    Route::put('/update-password/{user:username}', [AdminController::class, 'updatePassword']);

    Route::resource('/video-categories', VideoCategoryController::class);
    Route::get('/videoCategories/checkSlug/', [VideoCategoryController::class, 'checkSlug']);

    Route::resource('/videos', VideoController::class);
    Route::get('/video/checkSlug/', [VideoController::class, 'checkSlug']);
    Route::get('/getProducts', [VideoController::class, 'getProducts']);
    Route::get('/getSelectedProducts/{video}', [VideoController::class, 'getSelectedProducts']);

    Route::get('/categories', function (Request $request) {
        // Ambil semua data video categories
        $productCategories = ProductCategory::query();

        // Jika ada pencarian, lakukan filter berdasarkan nama atau slug
        if ($request->has('searchProductCategory')) {
            $search = $request->input('searchProductCategory');
            $productCategories->where('name', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%');
        }

        // Ambil semua data video categories
        $videoCategories = VideoCategory::query();

        // Jika ada pencarian, lakukan filter berdasarkan nama atau slug
        if ($request->has('searchVideoCategory')) {
            $search = $request->input('searchVideoCategory');
            $videoCategories->where('name', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%');
        }

        return view('dashboard.categories.index', [
            "title" => "HydroSpace | Daftar Kategori",
            "active" => "Kategori",
            "videoCategories" => $videoCategories->get(),
            "productCategories" => $productCategories->get()
        ]);
    });

    Route::resource('/product-categories', ProductCategoryController::class);
    Route::get('/productCategories/checkSlug/', [ProductCategoryController::class, 'checkSlug']);

    Route::get('/getProducts', function () {
        return response()->json(Product::select('id', 'name')->get());
    });
    Route::resource('/products', ProductController::class);

    Route::get('/chat', function () {

        $adminIds = User::where('role', 'Admin')->pluck('id');
        $lastMessagesFromUsers = [];

        foreach (User::where('role', 'Customer')->get() as $customer) {
            $lastMessage = \App\Models\Chat::where(function ($query) use ($adminIds, $customer) {
                $query->whereIn('from_user_id', $adminIds)
                    ->where('to_user_id', $customer->id);
            })->orWhere(function ($query) use ($adminIds, $customer) {
                $query->where('from_user_id', $customer->id)
                    ->whereIn('to_user_id', $adminIds);
            })->orderBy('created_at', 'desc')->first();

            $lastMessagesFromUsers[$customer->id] = $lastMessage && $lastMessage->from_user_id === $customer->id;
        }

        // dd($lastMessagesFromUsers);

        return view('dashboard.chat', [
            "title" => "HydroSpace | Chat Customer",
            "active" => "Chat Customer",
            "users" => User::where('role', 'Customer')->get(),
            "lastMessagesFromUsers" => $lastMessagesFromUsers
        ]);
    });

    Route::get('/chat/{user:id}', Chat::class)->name('chat');

    Route::get('/Product/checkSlug', [ProductController::class, 'checkSlug']);

    Route::get('/orders', [OrderController::class, 'indexAdmin']);
    Route::put('/updateStatus', [OrderController::class, 'updateStatus'])->name('dashboard.orders.updateStatus');
    Route::get('/orders/{order:id}', [OrderController::class, 'showAdmin']);
});
