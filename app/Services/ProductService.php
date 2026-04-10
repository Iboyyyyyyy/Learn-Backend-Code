<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function createProduct($request)
    {
        DB::beginTransaction();

        try {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric',
            'images' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);


        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);

            $images = 'images/' . $fileName;
        }

        $validatedData['images'] = $images;

        // Product::create($validatedData);
        $this->productRepo->createProduct($validatedData);


        DB::commit();

        return response()->json([
            'success' => true,
            'message' => "Product created successfully!"
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to create product: ' . $e->getMessage()
        ]);
    }
    }
}
