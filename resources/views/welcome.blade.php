<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>Test API</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '#showtomodal', function () {
                var current_row = $(this).closest('tr');
    var id = $(this).data('id');
    var productName = current_row.find('td').eq(1).text();
    var price = current_row.find('td').eq(2).text().replace('$', '').trim();
    var unit = current_row.find('td').eq(3).text();

    // Populate modal fields
    $('#id').val(id);
    $('#modal-product-id').text(id);
    $('#product_name').val(productName);
    $('#price').val(price);
    $('#unit').val(unit);
    $('#category_id').val('');
});

 $(document).on('click', '.btn-delete', function () {
                var current_row = $(this).closest('tr');
    var id = $(this).data('id');

    // Populate modal fields
    $('#delete-id').val(id);
    $('#modal-delete-id').text(id);

    // Set dynamic form action for delete route
    var action = "{{ route('products.destroy', ['id' => ':id']) }}".replace(':id', id);
    $('#delete-form').attr('action', action);
});
    </script>
    <div class="wrapper">

        <div class="main">

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-8 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <form action="{{ route('products.search') }}" method="GET">
                                        <input type="text" name="product_name" placeholder="Search...">
                                        <button type="submit">Search</button>
                                    </form>

                                </div>
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th class="d-none d-xl-table-cell">Product Name</th>
                                            <th class="d-none d-xl-table-cell">Image</th>
                                            <th class="d-none d-xl-table-cell">Customer</th>
                                            <th class="d-none d-xl-table-cell">Quantity</th>
                                            <th class="d-none d-xl-table-cell">Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orderDetails as $detail)
                                        @php
                                        // Since we start from the Detail, we find the parent Order and the Product
                                        $order = $orders->firstWhere('order_id', $detail->order_id);
                                        $product = $product_lists->firstWhere('product_id', $detail->product_id);
                                        $customer = $order ? $customers->firstWhere('customer_id', $order->customer_id)
                                        : null;
                                        $totalPrice = $detail->quantity * $product->price;
                                        @endphp
                                        <tr>
                                            <td class="d-none d-xl-table-cell">#{{ $order->order_id ?? 'N/A' }}</td>

                                            <td class="d-none d-xl-table-cell">{{ $product->product_name ?? 'Unknown
                                                Product' }}</td>
                                            <td class="d-none d-xl-table-cell">
                                                @if($product && $product->images)
                                                <img src="{{ asset('images/' . $product->images) }}" alt="Product Image"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                <span>No Image</span>
                                                @endif
                                            </td>

                                            <td class="d-none d-md-table-cell">{{ $customer->customer_name ?? 'Guest' }}
                                            </td>

                                            <td class="d-none d-xl-table-cell">{{ $detail->quantity }}</td>

                                            <td>
                                                <span class="badge bg-warning">
                                                    {{ number_format($totalPrice, 2) }} $
                                                </span>
                                            </td>

                                            <td>
                                                <button type="button" class="btn-edit" data-toggle="modal"
                                                    data-target="#update" data-id="{{ $detail->id }}"
                                                    style="background: transparent; border: none;">
                                                    <i class="align-middle me-2" data-feather="edit"
                                                        style="color: Green"></i>
                                                </button>
                                                <button type="button" class="btn-delete" data-toggle="modal"
                                                    data-target="#delete" data-id="{{ $detail->id }}"
                                                    style="background: transparent; border: none;">
                                                    <i class="align-middle me-2" data-feather="trash-2"
                                                        style="color: Red"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No orders found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                </br>

                                {{$orderDetails->links('pagination::bootstrap-5')}}



                                <div class="modal fade" id="delete" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form id="delete-form" action="{{ route('products.destroy', ['id' => 0]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Product <span
                                                            id="modal-delete-id"></span></h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this product?
                                                    <input type="hidden" id="delete-id" name="txtdid">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <div class="modal fade" id="update" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('orders.store') }}" method="POST" id="order-form">
                                                @csrf
                                                <div class="card-body">
                                                    <label for="customer_id">Customer:</label>
                                                    <select id="customer_id" name="customer_id" class="form-select mb-3"
                                                        required>
                                                        <option value="">Select Customer</option>
                                                        @foreach ($customers as $customer)
                                                        <option value="{{ $customer->customer_id }}">{{
                                                            $customer->customer_name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <hr>
                                                    <h5>Products</h5>
                                                    <div id="product-container">
                                                        <div class="product-row border p-2 mb-2">
                                                            <label>Product:</label>
                                                            <select name="details[0][product_id]"
                                                                class="form-select mb-2" required>
                                                                <option value="">Select Product</option>
                                                                @foreach ($product_lists as $product)
                                                                <option value="{{ $product->product_id }}">{{
                                                                    $product->product_name }}</option>
                                                                @endforeach
                                                            </select>

                                                            <label>Quantity:</label>
                                                            <input type="number" name="details[0][quantity]"
                                                                class="form-control mb-2" min="1" required>
                                                        </div>
                                                    </div>

                                                    <button type="button" class="btn btn-sm btn-outline-primary mb-3"
                                                        id="add-product">
                                                        + Add Another Product
                                                    </button>

                                                    <div class="d-grid gap-2 mt-3">
                                                        <button type="submit" class="btn btn-lg btn-success">Create
                                                            Order</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-4 d-flex" style="height: 435px">
                            <div class="card flex-fill w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Create Order</h5>
                                </div>
                                {{-- <form action="{{ route('orders.store') }}" method="POST" id="order-form">
                                    csrf
                                    <div class="card-body">
                                        <label for="customer_id">Customer:</label>
                                        <select id="customer_id" name="customer_id" class="form-select mb-3" required>
                                            <option value="">Select Customer</option>
                                            foreach ($customers as $customer)
                                            <option value="{{ $customer->customer_id }}" style="color: black;">{{
                                                $customer->customer_name }}</option>
                                            endforeach
                                        </select>
                                        <label>Product:</label>
                                        <select class="form-select product-select mb-2" required>
                                            <option value="">Select Product</option>
                                            foreach ($product_lists as $product)
                                            <option value="{{ $product->product_id }}"
                                                data-price="{{ $product->price }}">
                                                {{ $product->product_name }} - ${{ number_format($product->price, 2) }}
                                            </option>
                                            endforeach
                                        </select>
                                        <label>Quantity:</label>
                                        <input type="number" name="quantity" class="form-control quantity-input" min="1"
                                            required>


                                        {{-- <button type="button" class="btn btn-sm btn-outline-primary mb-3"
                                            id="add-product">Add Another Product</button>

                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-success">Create Order</button>
                                        </div>
                                    </div>
                                </form> --}}

                                <form action="orders" method="POST">
                                    @csrf
                                    <div class="card-body">

                                        <!-- Customer -->
                                        <label for="customer_id">Customer</label>
                                        <select name="customer_id" id="customer_id" class="form-select mb-3">
                                            <option value="">-- Select Customer --</option>
                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->customer_id }}">
                                                {{ $customer->customer_name }}
                                            </option>
                                            @endforeach
                                        </select>

                                        <!-- Product -->
                                        <label for="product_id">Product</label>
                                        <select name="product_id" id="product_id" class="form-select mb-3">
                                            <option value="">-- Select Product --</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->product_id }}">
                                                {{ $product->product_name }} - ${{ $product->price }}
                                            </option>
                                            @endforeach
                                        </select>

                                        <!-- Quantity -->
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" min="1"
                                            required>

                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-success">Create Order</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-4 d-flex" style="height: 500px">
                            <div class="card flex-fill w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Add Product</h5>
                                </div>
                                <form action="/products" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <input type="text" class="form-control" id="product_name" name="product_name"
                                            placeholder="Product Name"></br>
                                        <select id="category_id" name="category_id" class="form-select mb-3">
                                            <option value="">-- Select Category --</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}">
                                                {{ $category->category_name }}
                                            </option>
                                            @endforeach
                                        </select></br>
                                        <input type="text" class="form-control" id="unit" name="unit"
                                            placeholder="Unit"></br>
                                        <input type="text" class="form-control" id="price" name="price"
                                            placeholder="Price"></br>
                                        <div class="d-grid gap-2 mt-3">
                                            <input type="file" class="form-control" id="images" name="images"
                                                placeholder="Image"></br>
                                            <button type="submit" class="btn btn-lg btn-primary">Insert</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-4 d-flex" style="height: 550px">
                            <div class="card flex-fill w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Update Product</h5>
                                </div>

                                <form action="{{ route('products.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">

                                    <input type="text" class="form-control" name="product_id" value="{{ $product->product_id }}"></br>

                                    <input type="text" class="form-control" name="product_name" value="{{ $product->product_name }}"></br>
                                    <input type="text" class="form-control"

                                    name="unit" value="{{ $product->unit }}"></br>
                                    <input type="text" class="form-control" name="price" value="{{ $product->price }}"></br>
<div class="d-grid gap-2 mt-3">
                                    <input type="file" name="images" class="form-control"></br>

                                    <button type="submit"  class="btn btn-lg btn-primary">Update</button>
</div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script src="js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>


    {{-- <script>
        let productIndex = 1;

    document.getElementById('add-product').addEventListener('click', function() {
        const container = document.getElementById('product-container');
        const newRow = document.createElement('div');
        newRow.className = 'product-row border p-2 mb-2';

        newRow.innerHTML = `
            <label>Product:</label>
            <select name="details[${productIndex}][product_id]" class="form-select mb-2" required>
                <option value="">Select Product</option>
                foreach ($product_lists as $product)
                    <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                endforeach
            </select>

            <label>Quantity:</label>
            <input type="number" name="details[${productIndex}][quantity]" class="form-control mb-2" min="1" required>
            <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
        `;

        container.appendChild(newRow);
        productIndex++;
    });

    // Delegate remove button click
    document.getElementById('product-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.product-row').remove();
        }
    });
    </script> --}}


    {{-- <script>
        // Order form JavaScript
        $(document).ready(function() {
            let productIndex = 1;

            $('#add-product').click(function() {
                const productHtml = `
                    <div class="product-item mb-3">
                        <label>Product:</label>
                        <select name="products[${productIndex}][product_id]" class="form-select product-select mb-2" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->product_id }}" data-price="{{ $product->price }}">
                                {{ $product->product_name }} - ${{ number_format($product->price, 2) }}
                            </option>
                            @endforeach
                        </select>
                        <label>Quantity:</label>
                        <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" min="1" required>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2 remove-product">Remove</button>
                    </div>
                `;
                $('#product-list').append(productHtml);
                productIndex++;
            });

            $(document).on('click', '.remove-product', function() {
                $(this).closest('.product-item').remove();
            });
        });
    </script> --}}
</body>

</html>
