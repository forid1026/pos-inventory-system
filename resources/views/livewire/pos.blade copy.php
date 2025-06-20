<div class="container py-4">
    <div class="row">

        {{-- Menus Column --}}
        <div class="col-md-3 mb-3">
            <h5 class="mb-3">Menus</h5>
            @foreach($menus as $menu)
            <button wire:click="addMenu({{ $menu->id }})" class="btn btn-outline-primary w-100 mb-2">
                {{ $menu->name }} - {{ $menu->price }} Tk
            </button>
            @endforeach
        </div>

        {{-- Filter & Items Column --}}
        <div class="col-md-3 mb-3">
            <h5 class="mb-3">Filter by Category</h5>
            <select wire:model="selectedCategory" class="form-select mb-3">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>

            <h5 class="mb-3">Items</h5>
            <div class="d-flex flex-column">
                @foreach($items as $item)
                <button wire:click="addItem({{ $item->id }})" class="btn btn-outline-secondary mb-2 text-start">
                    {{ $item->name }} - {{ $item->price }} Tk
                </button>
                @endforeach
            </div>
        </div>

        {{-- Cart Column --}}
        <div class="col-md-6">
            <h5 class="mb-3">Cart</h5>

            <div class="list-group mb-3">
                @foreach($cart as $index => $item)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $item['name'] }}</strong> x {{ $item['quantity'] }}

                        <button wire:click="increaseQty({{ $index }})" class="btn btn-sm btn-success ms-2">+</button>
                        <button wire:click="decreaseQty({{ $index }})" class="btn btn-sm btn-danger ms-1">-</button>
                    </div>
                    <div>
                        {{ number_format($item['price'] * $item['quantity'], 2) }} Tk
                    </div>
                </div>
                @endforeach
            </div>

            <hr>
            <h4>Total: <span class="text-primary">{{ number_format($this->getTotal(), 2) }} Tk</span></h4>

            <button wire:click="submitOrder" class="btn btn-success mt-3 w-100">Submit Order</button>
        </div>

    </div>


    <div class="page-wrapper pos-pg-wrapper ms-0">
        <div class="content pos-design p-0">

            <div class="row align-items-start pos-wrapper">

                <!-- Products -->
                <div class="col-md-12 col-lg-7 col-xl-8">
                    <div class="pos-categories tabs_wrapper pb-0">
                        <div class="card pos-button">
                            <div class="d-flex align-items-center flex-wrap">
                                <a href="javascript:void(0);" class="btn btn-teal btn-md mb-xs-3" data-bs-toggle="modal"
                                    data-bs-target="#orders"><i class="ti ti-shopping-cart me-1"></i>View Orders</a>
                                <a href="javascript:void(0);" class="btn btn-md btn-indigo" data-bs-toggle="modal"
                                    data-bs-target="#reset"><i class="ti ti-reload me-1"></i>Reset</a>
                                <a href="javascript:void(0);" class="btn btn-md btn-info" data-bs-toggle="modal"
                                    data-bs-target="#recents"><i class="ti ti-refresh-dot me-1"></i>Transaction</a>
                            </div>
                        </div>
                        {{-- <div class="d-flex align-items-center justify-content-between">
                            <h4 class="mb-3">Categories</h4>
                        </div>

                        <ul class="tabs owl-carousel pos-category">
                            <li id="all" class="active">
                                <a href="javascript:void(0);">
                                    <img src="{{  asset('backend/assets/img/products/pos-product-01.png') }}"
                                        alt="Categories">
                                </a>
                                <h6><a href="javascript:void(0);">All Categories</a></h6>
                                <span>80 Items</span>
                            </li>
                            @foreach ($categories as $category)
                            <li id="all" class="active">
                                <a href="javascript:void(0);">
                                    <img src="{{  asset('backend/assets/img/products/pos-product-01.png') }}"
                                        alt="Categories">
                                </a>
                                <h6><a href="javascript:void(0);">{{ $category }}</a></h6>
                                <span>80 Items</span>
                            </li>
                            @endforeach

                        </ul> --}}
                        <div class="pos-products">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-3">Products</h4>
                                <div class="input-icon-start pos-search position-relative mb-3">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-search"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Search Product">
                                </div>
                            </div>
                            <div class="tabs_container">
                                <div class="tab_content active" data-tab="all">
                                    <div class="row">
                                        @foreach($items as $menuItem)
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                            <div class="product-info card">
                                                <button wire:click="addItem({{ $menuItem->id }})"
                                                    class="btn btn-outline-secondary mb-2 text-start">
                                                    {{ $menuItem->name }} - {{ $menuItem->price }} Tk
                                                </button>
                                                <a href="javascript:void(0);" class="pro-img">
                                                    <img src="{{asset('backend/assets/img/products/pos-product-01.png')}}"
                                                        alt="Products">
                                                    <span><i class="ti ti-circle-check-filled"></i></span>
                                                </a>
                                                <h6 class="cat-name"><a href="javascript:void(0);">{{
                                                        $menuItem->category }}</a></h6>
                                                <h6 class="product-name"><a href="javascript:void(0);">{{
                                                        $menuItem->name }}</a></h6>
                                                <div class="d-flex align-items-center justify-content-between price">
                                                    <span>30 Pcs</span>
                                                    <p>${{ $menuItem->price }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Products -->

                <!-- Order Details -->
                <div class="col-md-12 col-lg-5 col-xl-4 ps-0 theiaStickySidebar">
                    <aside class="product-order-list">
                        <div class="order-head bg-light d-flex align-items-center justify-content-between w-100">
                            <div>
                                <h3>Order List</h3>
                                <span>Transaction ID : #65565</span>
                            </div>
                            <div>
                                <a class="link-danger fs-16" href="javascript:void(0);"><i
                                        class="ti ti-trash-x-filled"></i></a>
                            </div>
                        </div>
                        <div class="customer-info block-section">
                            <h4 class="mb-3">Customer Information</h4>
                            <div class="input-block d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <select class="select">
                                        <option>Walk in Customer</option>
                                        <option>John</option>
                                        <option>Smith</option>
                                        <option>Ana</option>
                                        <option>Elza</option>
                                    </select>
                                </div>
                                <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#create"><i data-feather="user-plus" class="feather-16"></i></a>
                            </div>
                            <div class="input-block">
                                <select class="select">
                                    <option>Search Products</option>
                                    <option>IPhone 14 64GB</option>
                                    <option>MacBook Pro</option>
                                    <option>Rolex Tribute V3</option>
                                    <option>Red Nike Angelo</option>
                                    <option>Airpod 2</option>
                                    <option>Oldest</option>
                                </select>
                            </div>
                        </div>
                        <div class="product-added block-section">
                            <div class="head-text d-flex align-items-center justify-content-between">
                                <h5 class="d-flex align-items-center mb-0">Product Added<span class="count">2</span>
                                </h5>
                                <a href="javascript:void(0);" class="d-flex align-items-center link-danger"><span
                                        class="me-2"><i data-feather="x" class="feather-16"></i></span>Clear all</a>
                            </div>
                            <div class="product-wrap">
                                <div class="empty-cart">
                                    <div class="fs-24 mb-1">
                                        <i class="ti ti-shopping-cart"></i>
                                    </div>
                                    <p class="fw-bold">No Products Selected</p>
                                </div>
                                @foreach ($cart as $item)
                                <div class="product-list align-items-center justify-content-between">
                                    <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                                        data-bs-target="#products">
                                        <a href="javascript:void(0);" class="pro-img">
                                            <img src="{{ asset('backend/assets/img/products/pos-product-04.png') }}"
                                                alt="Products">
                                        </a>
                                        <div class="info">
                                            <span>PT0005</span>
                                            <h6><a href="javascript:void(0);">Red Nike Laser</a></h6>
                                            <p class="fw-bold text-teal">$2000</p>
                                        </div>
                                    </div>
                                    <div class="qty-item text-center">
                                        <a href="javascript:void(0);"
                                            class="dec d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i
                                                data-feather="minus-circle" class="feather-14"></i></a>
                                        <input type="text" class="form-control text-center" name="qty" value="4">
                                        <a href="javascript:void(0);"
                                            class="inc d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i
                                                data-feather="plus-circle" class="feather-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center action">
                                        <a class="btn-icon edit-icon me-1" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit-product">
                                            <i data-feather="edit" class="feather-14"></i>
                                        </a>
                                        <a class="btn-icon delete-icon" href="javascript:void(0);"
                                            data-bs-toggle="modal" data-bs-target="#delete">
                                            <i data-feather="trash-2" class="feather-14"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                                <div class="product-list align-items-center justify-content-between">
                                    <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                                        data-bs-target="#products">
                                        <a href="javascript:void(0);" class="pro-img">
                                            <img src="{{ asset('backend/assets/img/products/pos-product-10.png') }}"
                                                alt="Products">
                                        </a>
                                        <div class="info">
                                            <span>PT0235</span>
                                            <h6><a href="javascript:void(0);">Iphone 14</a></h6>
                                            <p class="fw-bold text-teal">$3000</p>
                                        </div>
                                    </div>
                                    <div class="qty-item text-center">
                                        <a href="javascript:void(0);"
                                            class="dec d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i
                                                data-feather="minus-circle" class="feather-14"></i></a>
                                        <input type="text" class="form-control text-center" name="qty" value="3">
                                        <a href="javascript:void(0);"
                                            class="inc d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i
                                                data-feather="plus-circle" class="feather-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center action">
                                        <a class="btn-icon edit-icon me-1" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit-product">
                                            <i data-feather="edit" class="feather-14"></i>
                                        </a>
                                        <a class="btn-icon delete-icon" href="javascript:void(0);"
                                            data-bs-toggle="modal" data-bs-target="#delete">
                                            <i data-feather="trash-2" class="feather-14"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-list align-items-center justify-content-between">
                                    <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                                        data-bs-target="#products">
                                        <a href="javascript:void(0);" class="pro-img">
                                            <img src="{{ asset('backend/assets/img/products/pos-product-09.png') }}"
                                                alt="Products">
                                        </a>
                                        <div class="info">
                                            <span>PT0242</span>
                                            <h6><a href="javascript:void(0);">Timex Black Silver</a></h6>
                                            <p class="fw-bold text-teal">$1457</p>
                                        </div>
                                    </div>
                                    <div class="qty-item text-center">
                                        <a href="javascript:void(0);"
                                            class="dec d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i
                                                data-feather="minus-circle" class="feather-14"></i></a>
                                        <input type="text" class="form-control text-center" name="qty" value="1">
                                        <a href="javascript:void(0);"
                                            class="inc d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i
                                                data-feather="plus-circle" class="feather-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center action">
                                        <a class="btn-icon edit-icon me-1" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit-product">
                                            <i data-feather="edit" class="feather-14"></i>
                                        </a>
                                        <a class="btn-icon delete-icon" href="javascript:void(0);"
                                            data-bs-toggle="modal" data-bs-target="#delete">
                                            <i data-feather="trash-2" class="feather-14"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-list align-items-center justify-content-between">
                                    <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                                        data-bs-target="#products">
                                        <a href="javascript:void(0);" class="pro-img">
                                            <img src="{{ asset('backend/assets/img/products/pos-product-08.png') }}"
                                                alt="Products">
                                        </a>
                                        <div class="info">
                                            <span>PT0005</span>
                                            <h6><a href="javascript:void(0);">SWAGME</a></h6>
                                            <p class="fw-bold text-teal">$6587</p>
                                        </div>
                                    </div>
                                    <div class="qty-item text-center">
                                        <a href="javascript:void(0);"
                                            class="dec d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i
                                                data-feather="minus-circle" class="feather-14"></i></a>
                                        <input type="text" class="form-control text-center" name="qty" value="1">
                                        <a href="javascript:void(0);"
                                            class="inc d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i
                                                data-feather="plus-circle" class="feather-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center action">
                                        <a class="btn-icon edit-icon me-1" href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit-product">
                                            <i data-feather="edit" class="feather-14"></i>
                                        </a>
                                        <a class="btn-icon delete-icon" href="javascript:void(0);"
                                            data-bs-toggle="modal" data-bs-target="#delete">
                                            <i data-feather="trash-2" class="feather-14"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-section">
                            <div class="selling-info">
                                <div class="row g-3">
                                    <div class="col-12 col-sm-4">
                                        <div>
                                            <label class="form-label">Order Tax</label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option>GST 5%</option>
                                                <option>GST 10%</option>
                                                <option>GST 15%</option>
                                                <option>GST 20%</option>
                                                <option>GST 25%</option>
                                                <option>GST 30%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div>
                                            <label class="form-label">Shipping</label>
                                            <select class="select">
                                                <option>0</option>
                                                <option>15</option>
                                                <option>20</option>
                                                <option>25</option>
                                                <option>30</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div>
                                            <label class="form-label">Discount</label>
                                            <select class="select">
                                                <option>0%</option>
                                                <option>10%</option>
                                                <option>10%</option>
                                                <option>15%</option>
                                                <option>20%</option>
                                                <option>25%</option>
                                                <option>30%</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-total">
                                <table class="table table-responsive table-borderless">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-end">$60,454</td>
                                    </tr>
                                    <tr>
                                        <td>Tax (GST 5%)</td>
                                        <td class="text-end">$40.21</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping</td>
                                        <td class="text-end">$40.21</td>
                                    </tr>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-end">$60,454</td>
                                    </tr>
                                    <tr>
                                        <td class="text-danger">Discount (10%)</td>
                                        <td class="text-danger text-end">$15.21</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-end">$64,024.5</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="block-section payment-method">
                            <h4>Payment Method</h4>
                            <div class="row align-items-center justify-content-center methods g-3">
                                <div class="col-sm-6 col-md-4">
                                    <a href="javascript:void(0);" class="payment-item" data-bs-toggle="modal"
                                        data-bs-target="#payment-cash">
                                        <i class="ti ti-cash-banknote fs-18"></i>
                                        <span>Cash</span>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <a href="javascript:void(0);" class="payment-item" data-bs-toggle="modal"
                                        data-bs-target="#payment-card">
                                        <i class="ti ti-credit-card fs-18"></i>
                                        <span>Debit Card</span>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <a href="javascript:void(0);" class="payment-item" data-bs-toggle="modal"
                                        data-bs-target="#scan-payment">
                                        <i class="ti ti-scan fs-18"></i>
                                        <span>Scan</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="btn-block">
                            <a class="btn btn-secondary w-100" href="javascript:void(0);">
                                Grand Total : $64,024.5
                            </a>
                        </div>
                        <div class="btn-row d-sm-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);"
                                class="btn btn-purple d-flex align-items-center justify-content-center flex-fill"
                                data-bs-toggle="modal" data-bs-target="#hold-order"><i
                                    class="ti ti-player-pause me-1"></i>Hold</a>
                            <a href="javascript:void(0);"
                                class="btn btn-danger d-flex align-items-center justify-content-center flex-fill"><i
                                    class="ti ti-trash me-1"></i>Void</a>
                            <a href="javascript:void(0);"
                                class="btn btn-success d-flex align-items-center justify-content-center flex-fill"
                                data-bs-toggle="modal" data-bs-target="#payment-completed"><i
                                    class="ti ti-cash-banknote me-1"></i>Payment</a>
                        </div>
                    </aside>
                </div>
                <!-- /Order Details -->

            </div>
        </div>
    </div>
</div>