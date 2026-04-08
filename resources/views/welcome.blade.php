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



// Add an ID to your Buy button: <button id="buy-button">Buy</button>
// document.getElementById('buy-button').addEventListener('click', function() {
//     if (cart.length === 0) {
//         alert("Cart is empty!");
//         return;
//     }
//     fetch('/your-store-route', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': '{{ csrf_token() }}' // Essential for Laravel
//         },
//         body: JSON.stringify({ items: cart })
//     })
//     .then(response => response.json())
//     .then(data => {
//         alert("Order placed successfully!");
//         cart = []; // Clear cart
//         renderTable();
//     });
// });
// function submitOrder() {
//     if (cart.length === 0) return alert("Cart is empty!");
//     fetch('/your-route', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': '{{ csrf_token() }}'
//         },
//         body: JSON.stringify({ order_items: cart })
//     }).then(res => res.json()).then(data => location.reload());
// }
    </script>
    <div class="wrapper">

        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-8 d-flex" style="height: auto">
                            <div class="row">
                                @forelse ($products as $product)
                                <div class="col-2 d-flex" style="height: 310px; text-decoration: none;">
                                    <a href="javascript:void(0)"
                                        onclick="addToCart({{ json_encode($product->product_id) }}, {{ json_encode($product->product_name) }}, {{ $product->price }})">
                                        <div class="card flex-fill">
                                            <div class="card flex-fill w-100">
                                                <div class="card">
                                                    <img class="card-img-top"
                                                        src="{{ asset('images/' . $product->images) }}"
                                                        style="height: 150px; width: 100%;" alt="Card image cap">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $product->product_name }}</h5>
                                                        <p class="card-text" style="color: Red;">{{ $product->price}} $
                                                        </p>
                                                        <center>
                                                            <a href="javascript:void(0)"
                                                                onclick="addToCart({{ json_encode($product->product_id) }}, {{ json_encode($product->product_name) }}, {{ $product->price }})">
                                                                Add to Card
                                                            </a>
                                                            <div style="color: red">{{session()->get('name')}}</div>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @empty
                                <div class="col-12 d-flex">
                                    <center>
                                        <h1 style="color: Red;" class="text-center">No products found.</h1>
                                    </center>
                                </div>
                                @endforelse
                            </div>
                        </div>


                        <div class="col-4 d-flex" style="height: 435px">
                            <div class="card flex-fill w-100">
                                {{-- <div class="card-header">
                                    <h5 class="card-title mb-0">Create Order</h5>
                                </div> --}}
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="d-none d-xl-table-cell">Product Name</th>
                                            <th class="d-none d-xl-table-cell">Quantity</th>
                                            <th class="d-none d-xl-table-cell">Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="order-list-body">
                                        {{-- @forelse ($orderDetails as $detail)
                                        @php
                                        $product = $product_lists->firstWhere('product_id', $detail->product_id);
                                        $totalPrice = $detail->quantity * ($product->price ?? 0);
                                        @endphp
                                        <tr class="existing-row">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="d-none d-xl-table-cell">{{ $product->product_name ?? 'Unknown' }}
                                            </td>
                                            <td class="d-none d-xl-table-cell">
                                                <button class="sub" onclick="subQuantity({{ $detail->id }})">-</button>
                                                {{ $detail->quantity }}
                                                <button class="add"
                                                    onclick="addQuantity({{ $detail->id }})">+++++</button>
                                            </td>
                                            <td class="d-none d-xl-table-cell">{{ number_format($totalPrice, 2) }}</td>
                                            <td>
                                                <button type="button" class="btn-delete"
                                                    style="background: transparent; border: none;">
                                                    <i class="align-middle me-2" data-feather="trash-2"
                                                        style="color: Red"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr id="empty-row">
                                            <td colspan="5" class="text-center">No orders found.</td>
                                        </tr>
                                        @endforelse --}}
                                    </tbody>
                                </table>
                                </br>
                                <button class="btn btn-primary" onclick="buyorder()">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function buyorder() {
    if (cart.length === 0) return alert("Cart is empty!");

    fetch('/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json', // Tell Laravel we want JSON back
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ order_items: cart })
    })
    .then(res => {
        // This parses the JSON response from the controller
        return res.json().then(data => {
            if (!res.ok) throw new Error(data.message || 'Server Error');
            return data;
        });
    })
    .then(data => {
        alert(data.message);
        location.reload(); // Only reloads on success
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Error: " + error.message);
    });
}

        // 1. GLOBAL ARRAY - This stays active as long as the page is open
let cart = [];

function addToCart(id, name, price) {
    // 2. Check if this product is already in our list
    let existingItem = cart.find(item => item.product_id === id);

    if (existingItem) {
        // If it exists, just increase the number
        existingItem.quantity += 1;
    } else {
        // If it's new, add a new object to the array
        cart.push({
            product_id: id,
            name: name,
            price: parseFloat(price),
            quantity: 1
        });
    }

    // 3. Redraw the table with ALL items in the array
    renderOrderTable();
}

function renderOrderTable() {
    const tbody = document.getElementById('order-list-body');

    // Clear only the newly added rows
    document.querySelectorAll('.js-new-row').forEach(row => row.remove());

    const emptyRow = document.getElementById('empty-row');
    if (cart.length > 0 && emptyRow) {
        emptyRow.style.display = 'none';
    }

    cart.forEach((item, index) => {
        let total = (item.price * item.quantity).toFixed(2);

        let html = `
            <tr class="js-new-row">
                <td>${index + 1}</td>
                <td>${item.name}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${index}, -1)">-</button>
                        <span class="mx-2">${item.quantity}</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${index}, 1)">+</button>
                    </div>
                </td>
                <td>$${total}</td>
                <td>
                    <button type="button" onclick="removeFromCart(${index})" style="border:none; background:none;">
                        <i style="color:red; cursor:pointer;">🗑️</i>
                    </button>
                </td>
            </tr>`;
        tbody.insertAdjacentHTML('beforeend', html);
    });
}

// Unified function to handle both + and -
function changeQuantity(index, amount) {
    if (cart[index]) {
        cart[index].quantity += amount;

        // If quantity drops to 0, remove the item entirely
        if (cart[index].quantity <= 0) {
            removeFromCart(index);
        } else {
            renderOrderTable();
        }
    }
}

function removeFromCart(index) {
    cart.splice(index, 1);
    renderOrderTable();

    if (cart.length === 0 && document.getElementById('empty-row')) {
        document.getElementById('empty-row').style.display = 'table-row';
    }
}
    </script>

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


    // {{-- <script>
        //     let productIndex = 1;

    // document.getElementById('add-product').addEventListener('click', function() {
    //     const container = document.getElementById('product-container');
    //     const newRow = document.createElement('div');
    //     newRow.className = 'product-row border p-2 mb-2';

    //     newRow.innerHTML = `
    //         <label>Product:</label>
    //         <select name="details[${productIndex}][product_id]" class="form-select mb-2" required>
    //             <option value="">Select Product</option>
    //             foreach ($product_lists as $product)
    //                 <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
    //             endforeach
    //         </select>

    //         <label>Quantity:</label>
    //         <input type="number" name="details[${productIndex}][quantity]" class="form-control mb-2" min="1" required>
    //         <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
    //     `;

    //     container.appendChild(newRow);
    //     productIndex++;
    // });

    // // Delegate remove button click
    // document.getElementById('product-container').addEventListener('click', function(e) {
    //     if (e.target.classList.contains('remove-row')) {
    //         e.target.closest('.product-row').remove();
    //     }
    // });
    //
    </script> --}}


    // {{-- <script>
        //     // Order form JavaScript
    //     $(document).ready(function() {
    //         let productIndex = 1;

    //         $('#add-product').click(function() {
    //             const productHtml = `
    //                 <div class="product-item mb-3">
    //                     <label>Product:</label>
    //                     <select name="products[${productIndex}][product_id]" class="form-select product-select mb-2" required>
    //                         <option value="">Select Product</option>
    //                         @foreach ($products as $product)
    //                         <option value="{{ $product->product_id }}" data-price="{{ $product->price }}">
    //                             {{ $product->product_name }} - ${{ number_format($product->price, 2) }}
    //                         </option>
    //                         @endforeach
    //                     </select>
    //                     <label>Quantity:</label>
    //                     <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" min="1" required>
    //                     <button type="button" class="btn btn-sm btn-outline-danger mt-2 remove-product">Remove</button>
    //                 </div>
    //             `;
    //             $('#product-list').append(productHtml);
    //             productIndex++;
    //         });

    //         $(document).on('click', '.remove-product', function() {
    //             $(this).closest('.product-item').remove();
    //         });
    //     });
    //
    </script> --}}
</body>

</html>
