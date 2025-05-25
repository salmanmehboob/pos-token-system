@extends('layouts.pos')
@section('title', $title)

@section('content')

    <!-- BEGIN pos-menu -->
    <div class="pos-menu bg-light border-end" style="width: 220px; min-height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto;">
        <div class="logo p-3 border-bottom">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                <div class="logo-img me-2"><i class="fa fa-arrow-left fa-lg"></i></div>
                <div class="logo-text fw-bold fs-5">Dashboard</div>
            </a>
        </div>
        <div class="nav-container p-2">
            <ul class="nav nav-tabs flex-column" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-filter="all">
                        <i class="fa fa-fw fa-utensils"></i> All
                    </a>
                </li>
                @foreach ($productCategories as $category)
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-filter="cat-{{ $category->id }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- END pos-menu -->


    <!-- BEGIN pos-content -->
    <div class="pos-content" style="margin-left: 10%; min-height: 100vh; display: flex; flex-direction: column;">
        <!-- Products grid -->
        <div class="pos-content-container flex-grow-1 overflow-auto p-3"
             style="max-height: calc(100vh - 200px); overflow-y: auto;">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                @foreach($products as $product)
                    @php $imagePath = asset($product->image); @endphp
                    <div class="col product-item"
                         data-type="cat-{{ $product->product_category_id }}"
                         data-category-id="{{ $product->product_category_id }}">
                        <a href="javascript:;" class="pos-product d-block card h-100" data-id="{{ $product->id }}" style="cursor: pointer;">
                            <div class="card-img-top" style="background-image: url('{{ $imagePath }}'); background-size: cover; background-position: center; height: 150px;"></div>
                            <div class="card-body p-2">
                                <div class="title fw-semibold text-truncate">{{ $product->name }}</div>
                                <div class="retail_price text-end text-success">Rs {{ number_format($product->retail_price, 2) }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Cart and order section -->
        <div class="pos-sidebar bg-white border-top p-3"
             style="max-height: calc(100vh - 160px); overflow-y: auto; display: flex; flex-direction: column;">

            <h5 class="mb-3">Your Cart</h5>
            <div class="pos-sidebar-body flex-grow-1 mb-3" id="pos-sidebar"
                 data-scrollbar="true"
                 style="max-height: calc(100vh - 300px); overflow-y: auto;">
                <div class="tab-pane fade h-100 show active" id="newOrderTab"></div>
            </div>

            <!-- Calculation Section -->
            <div class="calculation-section">
                <div class="d-flex flex-column flex-md-row justify-content-between text-center text-md-start mb-3">
                    <div class="mb-2 mb-md-0">
                        <strong>Subtotal:</strong> <br> <span class="subtotal">Rs. 0.00</span>
                    </div>
                    <div class="mb-2 mb-md-0">
                        <strong>Discount:</strong> <br><span class="discount">Rs. 0.00</span>
                    </div>
                    <div class="mb-2 mb-md-0">
                        <strong>Total:</strong> <br><span class="total">Rs. 0.00</span>
                    </div>
                </div>

                <div class="input-group">
                    <input type="number" id="discount-input" class="form-control" placeholder="Discount Amount" min="0" step="0.01">
                    <button class="btn btn-success apply-discount" type="button">Apply</button>
                </div>
            </div>
        </div>

        <!-- Fixed footer -->
        <div class="pos-sidebar-footer bg-white border-top p-3 d-flex justify-content-end align-items-center gap-3"
             style="position: fixed; bottom: 0; left: 220px; right: 0; z-index: 1050; box-shadow: 0 -2px 6px rgba(0,0,0,0.1);">

            <form id="orderForm" action="{{ route('order.place') }}" method="POST" class="d-flex gap-3 align-items-center">
                @csrf
                <ul class="nav employee-nav flex-row gap-3">
                    @foreach ($employees as $employee)
                        <li class="nav-item">
                            <a href="#"
                               class="nav-link employee-box"
                               data-employee-id="{{ $employee->id }}">
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <input type="hidden" name="employee_id" id="employee_id" required>

                <button type="submit" class="btn order-now-btn d-flex align-items-center gap-4" style="min-width: 180px;">
                     Order Now
                </button>

            </form>


        </div>
    </div>

@endsection
@push('js')
    <script !src="">
        document.querySelectorAll('.employee-box').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active from all
                document.querySelectorAll('.employee-box').forEach(el => el.classList.remove('active'));

                // Add active to clicked
                this.classList.add('active');

                // Set hidden input value
                document.getElementById('employee_id').value = this.getAttribute('data-employee-id');
            });
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Try to enter fullscreen immediately if browser allows
            const elem = document.documentElement;

            if (elem.requestFullscreen) {
                elem.requestFullscreen().catch(err => {
                    // fallback: wait for user interaction
                    document.addEventListener("click", triggerFullScreenOnce);
                });
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }

            function triggerFullScreenOnce() {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }

                // Remove listener after first trigger
                document.removeEventListener("click", triggerFullScreenOnce);
            }
        });
    </script>

@endpush
