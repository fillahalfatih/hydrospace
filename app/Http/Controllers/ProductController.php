<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProductRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Auth::user()->role);
        return view('dashboard.products.index', [
            "title" => "HydroSpace | Daftar Produk",
            "active" => "Produk",
            "products" => Product::with('category')->latest()->filter(request(['search', 'category']))->paginate(20)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create', [
            "title" => "HydroSpace | Tambah Produk",
            "active" => "Produk",
            'product' => new Product(),
            "categories" => ProductCategory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric|max:1000000',
            'description' => 'required',
            'stock' => 'required|numeric|min:1',
            'category_id' => 'required|exists:product_categories,id'
        ]);

        if ($request->file('picture1')) {
            $validatedData['picture1'] = $request->file('picture1')->store('product_images', 'public');
        } else {
            throw new \Exception('The picture1 field is required.');
        }

        foreach (['picture2', 'picture3', 'picture4', 'picture5'] as $optionalPicture) {
            if ($request->file($optionalPicture)) {
                $validatedData[$optionalPicture] = $request->file($optionalPicture)->store('product_images', 'public');
            } else {
                unset($validatedData[$optionalPicture]);
            }
        }

        $validatedData['user_id'] = Auth::user()->id;

        // dd($validatedData);

        Product::create($validatedData);

        return redirect('/dashboard/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('dashboard.products.show', [
            "title" => $product->name . " | HydroSpace",
            "active" => "Produk",
            "product" => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('dashboard.products.edit', [
            "title" => "HydroSpace | Update Produk",
            "active" => "Produk",
            "product" => $product,
            "categories" => ProductCategory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'category_id' => 'required|exists:product_categories,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'picture.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];

        if ($request->slug != $product->slug) {
            $rules['slug'] = 'required|string|max:255|unique:products,slug';
        }

        $validatedData = $request->validate($rules);

        $oldImagesFromRequest = $request->input('oldImages', []);

        for ($i = 1; $i <= 5; $i++) {
            $pictureField = 'picture' . $i;
            $currentPicturePath = $product->$pictureField;

            if ($request->hasFile($pictureField)) {
                if ($currentPicturePath) {
                    Storage::disk('public')->delete($currentPicturePath);
                }
                $validatedData[$pictureField] = $request->file($pictureField)->store('product_images', 'public');
            } else {
                if (!isset($oldImagesFromRequest[$i]) && $currentPicturePath) {
                    Storage::disk('public')->delete($currentPicturePath);
                    $validatedData[$pictureField] = null;
                } elseif (isset($oldImagesFromRequest[$i])) {
                    $validatedData[$pictureField] = $oldImagesFromRequest[$i];
                } elseif (!$currentPicturePath) {
                    $validatedData[$pictureField] = null;
                }
            }
        }

        unset($validatedData['picture.*']);
        unset($validatedData['oldImages']);

        $product->update($validatedData);

        return redirect('/dashboard/products')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        OrderItem::where('product_id', $product->id)->delete();

        foreach (['picture1', 'picture2', 'picture3', 'picture4', 'picture5'] as $pictureField) {
            if ($product->$pictureField) {
                Storage::disk('public')->delete($product->$pictureField);
            }
        }

        // Hapus produk dari database
        $product->delete();

        return redirect('/dashboard/products')->with('success', 'Data produk berhasil dihapus!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

    // CUSTOMERS PRODUCTS
    public function customerIndex()
    {
        // Menentukan kategori produk berdasarkan slug yang diterima dari request
        $category = ProductCategory::where('slug', request('category'))->first();

        // Inisialisasi variabel user dan order sebagai null atau nilai default
        $user = Auth::user();
        $orderItems = collect([]); // Inisialisasi sebagai collection kosong
        $totalOrder = 0;
        $totalPrice = 0;
        $totalItem = 0;

        // Hanya jalankan query order jika user sudah login
        if ($user) {
            // Mendapatkan order dengan status 'Keranjang' untuk customer yang sedang login
            $order = Order::where('customer_id', $user->id)
                ->where('status', 'Keranjang')
                ->first();

            // Jika ada order yang ditemukan, ambil item-item keranjang tersebut
            $orderItems = $order ? $order->orderItems()->orderBy('created_at', 'desc')->get() : collect([]);

            $totalOrder = Order::where('customer_id', $user->id)
                ->where('status', '!=', 'keranjang')
                ->count();
            $totalPrice = $orderItems->sum('total_price');
            $totalItem = $orderItems->sum('quantity');
        }

        return view('products', [
            "title" => $category ? $category->name : "Produk", // Jika kategori ditemukan, gunakan namanya, jika tidak "Produk"
            "active" => "Produk", // Mengaktifkan menu Produk
            "products" => Product::with('category') // Mengambil produk dengan kategori
                ->latest()
                ->filter(request(['search', 'category'])) // Filter berdasarkan pencarian atau kategori
                ->paginate(12) // Paginate hasil pencarian produk
                ->withQueryString(),
            "categories" => ProductCategory::all(), // Mengambil semua kategori produk
            "currentCategory" => $category, // Mengirimkan kategori saat ini yang sedang dilihat
            "orderItems" => $orderItems, // Mengirimkan orderItems ke view jika ada
            'totalPrice' => $totalPrice,
            'totalItem' => $totalItem,
            'totalOrder' => $totalOrder,
            "bestSellers" => Product::withCount('orderItems')
                ->withSum('orderItems as quantity', DB::raw('quantity'))
                ->orderBy('quantity', 'desc')
                ->take(4)
                ->get(),
        ]);
    }

    public function customerShow(Product $product)
    {
        $user = Auth::user();

        $orderItems = collect([]);
        $totalOrder = 0;

        if ($user) {
            $order = Order::where('customer_id', $user->id)
                ->where('status', 'Keranjang')
                ->first();

            $orderItems = $order ? $order->orderItems()->orderBy('created_at', 'desc')->get() : collect([]);
            $totalOrder = Order::where('customer_id', $user->id)
                ->where('status', '!=', 'keranjang')
                ->count();
        }

        // Ambil count tertinggi
        $maxCount = DB::table('frequently_bought_togethers')
            ->where('product_id', $product->id)
            ->orWhere('related_product_id', $product->id)
            ->max('count');

        $recommendedProducts = collect();

        if ($maxCount > 0) {
            // Ambil semua record dengan count tertinggi
            $topRelated = DB::table('frequently_bought_togethers')
                ->where(function ($query) use ($product) {
                    $query->where('product_id', $product->id)
                        ->orWhere('related_product_id', $product->id);
                })
                ->where('count', $maxCount)
                ->get();

            // Ambil ID produk terkait
            $relatedIds = $topRelated->map(function ($item) use ($product) {
                return $item->product_id == $product->id
                    ? $item->related_product_id
                    : $item->product_id;
            })->unique();

            // Ambil produk terkait dari database
            $recommendedProducts = Product::whereIn('id', $relatedIds)->get();
        }

        return view('viewProduct', [
            "title" => $product->name . " | HydroSpace",
            "active" => "Produk",
            "product" => $product,
            "categories" => ProductCategory::all(),
            "orderItems" => $orderItems,
            'totalPrice' => $orderItems->sum('total_price'),
            'totalItem' => $orderItems->sum('quantity'),
            'totalOrder' => $totalOrder,
            'recommendedProducts' => $recommendedProducts,
        ]);
    }

    public function getProducts()
    {
        $products = Product::select('name', 'id')->get();
        return response()->json($products);
    }
}
