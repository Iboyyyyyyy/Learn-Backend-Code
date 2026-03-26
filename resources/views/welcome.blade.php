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
                            < class="card flex-fill">
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
                                            <th class="d-none d-xl-table-cell">Customer</th>
                                            <th class="d-none d-xl-table-cell">Quantity</th>
                                            <th class="d-none d-xl-table-cell">Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                        @php
                                        $category = $categories->firstWhere('category_id', $product->category_id);
                                        $orderDetail = $orderDetails->firstWhere('product_id', $product->product_id);
                                        $order = $orderDetail ? $orders->firstWhere('order_id', $orderDetail->order_id)
                                        : null;
                                        $customer = $order ? $customers->firstWhere('customer_id', $order->customer_id)
                                        : null;
                                        @endphp
                                        <tr>
                                            <td class="d-none d-xl-table-cell">{{ $order->order_id ?? 'N/A' }}</td>
                                            <td class="d-none d-xl-table-cell">{{ $product->product_name }}</td>
                                            <td class="d-none d-md-table-cell">{{ $customer->customer_name ?? 'N/A' }}
                                            </td>
                                            <td class="d-none d-xl-table-cell">{{ $orderDetail->quantity ?? 'N/A' }}
                                            </td>
                                            <td><span class="badge bg-warning">{{ number_format($product->price, 2) }}
                                                    $</span></td>
                                            <td>
                                                <button type="button" class="btn-edit"
                                                    style="background: transparent; border: none;" data-toggle="modal"
                                                    data-target="#update" data-id="{{ $product->product_id }}">
                                                    <i class="align-middle me-2" data-feather="edit"
                                                        style="color: Green"></i>
                                                </button>
                                                <button type="button" class="btn-delete"
                                                    style="background: transparent; border: none;" data-toggle="modal"
                                                    data-target="#delete" data-id="{{ $product->product_id }}">
                                                    <i class="align-middle me-2" data-feather="trash-2"
                                                        style="color: Red"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">No products found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                </br>

                                {{$products->links('pagination::bootstrap-5')}}



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
                                            <form action="{{ route('products.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Product ID:
                                                        <span id="modal-product-id"></span>
                                                    </h5>
                                                    <input type="hidden" id="id" name="txtEid">
                                                    <button type=" button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <input type="text" class="form-control" id="product_name"
                                                        name="product_name" placeholder="Product Name"></br>
                                                    <input type="text" class="form-control" id="category_id"
                                                        name="category_id" placeholder="Category ID"></br>
                                                    <input type="text" class="form-control" id="unit" name="unit"
                                                        placeholder="Unit"></br>
                                                    <input type="text" class="form-control" id="price" name="price"
                                                        placeholder="Price">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
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
                                <form action="{{ route('orders.store') }}" method="POST" id="order-form">
                                    @csrf
                                    <div class="card-body">
                                        <label for="customer_id">Customer:</label>
                                        <select id="customer_id" name="customer_id" class="form-select mb-3" required>
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->customer_id }}" style="color: black;">{{ $customer->customer_name }}</option>
                                            @endforeach
                                        </select>
                                        <div id="product-list">
                                            <div class="product-item mb-3">
                                                <label>Product:</label>
                                                <select name="products[0][product_id]" class="form-select product-select mb-2" required>
                                                    <option value="">Select Product</option>
                                                    @foreach ($product_lists as $product)
                                                    <option value="{{ $product->product_id }}" data-price="{{ $product->price }}">
                                                        {{ $product->product_name }} - ${{ number_format($product->price, 2) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <label>Quantity:</label>
                                                <input type="number" name="products[0][quantity]" class="form-control quantity-input" min="1" required>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-outline-primary mb-3" id="add-product">Add Another Product</button>

                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-success">Create Order</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>




                        {{-- <div class="col-4 d-flex" style="height: 400px">
                            <div class="card flex-fill w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Product</h5>
                                </div>
                                <form action="{{ route('products.store') }}" method="POST">
                                    csrf
                                    <div class="card-body">
                                        <input type="text" class="form-control" id="product_name" name="product_name"
                                            placeholder="Product Name"></br>
                                        <input type="text" class="form-control" id="category_id" name="category_id"
                                            placeholder="Category ID"></br>
                                        <input type="text" class="form-control" id="unit" name="unit"
                                            placeholder="Unit"></br>
                                        <input type="text" class="form-control" id="price" name="price"
                                            placeholder="Price"></br>
                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Insert</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> --}}
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script src="js/app.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
			var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
			var gradient = ctx.createLinearGradient(0, 0, 0, 225);
			gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
			gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
			// Line chart
			new Chart(document.getElementById("chartjs-dashboard-line"), {
				type: "line",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "Sales ($)",
						fill: true,
						backgroundColor: gradient,
						borderColor: window.theme.primary,
						data: [
							2115,
							1562,
							1584,
							1892,
							1587,
							1923,
							2566,
							2448,
							2805,
							3438,
							2917,
							3327
						]
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}],
						yAxes: [{
							ticks: {
								stepSize: 1000
							},
							display: true,
							borderDash: [3, 3],
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}]
					}
				}
			});
		});
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
			// Pie chart
			new Chart(document.getElementById("chartjs-dashboard-pie"), {
				type: "pie",
				data: {
					labels: ["Chrome", "Firefox", "IE"],
					datasets: [{
						data: [4306, 3801, 1689],
						backgroundColor: [
							window.theme.primary,
							window.theme.warning,
							window.theme.danger
						],
						borderWidth: 5
					}]
				},
				options: {
					responsive: !window.MSInputMethodContext,
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					cutoutPercentage: 75
				}
			});
		});
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			new Chart(document.getElementById("chartjs-dashboard-bar"), {
				type: "bar",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "This year",
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 20
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
					}
				}
			});
		});
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
			var markers = [{
					coords: [31.230391, 121.473701],
					name: "Shanghai"
				},
				{
					coords: [28.704060, 77.102493],
					name: "Delhi"
				},
				{
					coords: [6.524379, 3.379206],
					name: "Lagos"
				},
				{
					coords: [35.689487, 139.691711],
					name: "Tokyo"
				},
				{
					coords: [23.129110, 113.264381],
					name: "Guangzhou"
				},
				{
					coords: [40.7127837, -74.0059413],
					name: "New York"
				},
				{
					coords: [34.052235, -118.243683],
					name: "Los Angeles"
				},
				{
					coords: [41.878113, -87.629799],
					name: "Chicago"
				},
				{
					coords: [51.507351, -0.127758],
					name: "London"
				},
				{
					coords: [40.416775, -3.703790],
					name: "Madrid "
				}
			];
			var map = new jsVectorMap({
				map: "world",
				selector: "#world_map",
				zoomButtons: true,
				markers: markers,
				markerStyle: {
					initial: {
						r: 9,
						strokeWidth: 7,
						stokeOpacity: .4,
						fill: window.theme.primary
					},
					hover: {
						fill: window.theme.primary,
						stroke: window.theme.primary
					}
				},
				zoomOnScroll: false
			});
			window.addEventListener("resize", () => {
				map.updateSize();
			});
		});
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
			var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
			var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
			document.getElementById("datetimepicker-dashboard").flatpickr({
				inline: true,
				prevArrow: "<span title=\"Previous month\">&laquo;</span>",
				nextArrow: "<span title=\"Next month\">&raquo;</span>",
				defaultDate: defaultDate
			});
		});
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script>
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
    </script>
</body>

</html>
