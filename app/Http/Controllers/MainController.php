<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Customers;
use App\Models\OrderDetails;
// use App\Models\User;
// use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


class MainController extends Controller
{
    public function dashboardView(){
        return view('dashboard');
    }
    public function login(){
        // $tasks = Task::all();
        // return view('index', compact('tasks'));
        return view('login');
    }



    public function logininput(Request $request)
{
    $username = $request->input('customer_name');
    $email = $request->input('email');
    $password = $request->input('password');

    // find user first (without password)
    $user = Customers::where('customer_name', $username)
                ->where('email', $email)
                ->first();

    // check password correctly
    if ($user && $password === $user->password) {
        $cusid = $user->customer_id;
        $cusname = $user->customer_name;
        session(['name' => $cusname, 'id' => $cusid]);
        return Redirect::to('welcome');
    } else {
        return back()->with('error', 'Invalid credentials');
    }

}


    public function indexView()
    {
        $orders = Order::all();
        $customers = Customers::all();
        $orderDetails = OrderDetails::paginate(9);
        $categories = Categories::all();
        $product_lists = Product::all();
        $products = Product::all();
        return view('welcome', compact('products', 'categories', 'orders', 'customers', 'orderDetails', 'product_lists'));
    }


    // public function indexView()
    // public function store(Request $request)
    // {
    //     try{
    //         $validatedData = $request->validate([
    //         'product_name' => 'required|string|max:255',
    //         'category_id' => 'required|integer',
    //         'unit' => 'required|string|max:50',
    //         'price' => 'required|numeric',
    //     ]);

    //     Product::create($validatedData);

    //     return redirect()->back()->with('success', 'Product created successfully!');
    //     }
    //     catch(\Exception $e){
    //         return response()->json(['error' => 'Failed to create product: ' . $e->getMessage()]);
    //     }

    // }

    public function search(Request $request)
    {
        $searchTerm = $request->input('product_name');
        $products = Product::where('product_name', 'like', '%' . $searchTerm . '%')->paginate(9);
        $orders = Order::all();
        $customers = Customers::all();
        $orderDetails = OrderDetails::all();
        $categories = Categories::all();
        return view('welcome', compact('products', 'categories', 'orders', 'customers', 'orderDetails'));
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->txtEid);
        $product->update($validatedData);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with(Log::alert('success', 'Product deleted successfully!'));
    }


// public function storeOrder(Request $request)
// {
//     // 1. Validate the structure
//     $request->validate([
//         'order_items' => 'required|array',
//         'order_items.*.product_id' => 'required|exists:products,product_id',
//         'order_items.*.quantity' => 'required|integer|min:1',
//     ]);


//     DB::beginTransaction();

//     try {
//         // STEP 1: Create the Order
//         $order = Order::create([
//             'customer_id' => session('id'),
//             'order_date'  => now(),
//         ]);

//         // STEP 2: Loop through the items sent from the cart
//         foreach ($request->order_items as $item) {
//             OrderDetails::create([
//                 'order_id'   => $order->order_id,
//                 'product_id' => $item['product_id'],
//                 'quantity'   => $item['quantity'],
//             ]);
//         }

//         DB::commit();

//         // RETURN JSON instead of back()
//         return response()->json([
//             'success' => true,
//             'message' => "Order #{$order->order_id} created successfully!"
//         ], 201);

//     } catch (\Exception $e) {

//         DB::rollBack();

//         Log::error('Order Process Failed: ' . $e->getMessage());

//         // RETURN JSON ERROR
//         return response()->json([
//             'success' => false,
//             'message' => "Transaction Failed: " . $e->getMessage()
//         ], 500);
//     }
// }

}
