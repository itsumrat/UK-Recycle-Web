<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="#" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('assets/img/logo-square.png') }}">
            </div>
            <!-- <p>CT</p> -->
        </a>
        <a href="#" class="simple-text logo-normal">
            UK Textiles
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ request()->is('dashboard') ? 'active' : ''}}">
                <a href="{{route('dashboard.index')}}">
                    <i class="nc-icon nc-shop"></i>
                    <p>Home</p>
                </a>
            </li>
            <li class="{{ request()->is('delivery-in') ? 'active' : ''}}">
                <a href="{{route('delivery-in.index')}}">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>Delivery In</p>
                </a>
            </li>
            <li class="{{ request()->is('delivery-out') ? 'active' : ''}}">
                <a href="{{route('delivery-out.index')}}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>Delivery Out</p>
                </a>
            </li>
            <li class="{{ request()->is('production-setup') ? 'active' : ''}}">
                <a href="{{route('production-setup.index')}}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>Production Setup</p>
                </a>
            </li>
            <li>
            </li>
            <li class="{{ request()->is('productions') ? 'active' : ''}}">
                <a href="{{route('productions.index')}}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>Production</p>
                </a>
            </li>
            <li class="{{ request()->is('customers') ? 'active' : ''}}">
                <a href="{{route('customers.index')}}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>Customer</p>
                </a>
            </li>
            <li class="{{ request()->is('suppliers') ? 'active' : ''}}">
                <a href="{{route('suppliers.index')}}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>Supplier</p>
                </a>
            </li>
            <li class="{{ request()->is('attendances') ? 'active' : ''}}">
                <a href="{{route('attendances.index')}}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>Attendance</p>
                </a>
            </li>
            <li class="{{ request()->is('users') ? 'active' : ''}}">
                <a href="{{route('users.index')}}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>Users</p>
                </a>
            </li>

            <li class="">
                <a href="#">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>Reports</p>
                </a>
                <ul>
                    {{-- <li class="{{ request()->is('report/delivery_in') ? 'active' : ''}}">
                        <a href="{{ url('/report/delivery_in') }}">
                            <i class="nc-icon nc-delivery-fast"></i>
                            <p>Delivery In</p>
                        </a>
                    </li>
                    <li class="{{ request()->is('report/delivery_out') ? 'active' : ''}}">
                        <a href="{{ url('/report/delivery_out') }}">
                            <i class="nc-icon nc-ambulance"></i>
                            <p>Delivery Out</p>
                        </a>
                    </li>
                    <li class="{{ request()->is('report/production') ? 'active' : ''}}">
                        <a href="{{ url('/report/production')}}">
                            <i class="nc-icon nc-cart-simple"></i>
                            <p>Production</p>
                        </a>
                    </li> --}}
                    <li class="{{ request()->is('report/customer') ? 'active' : ''}}">
                        <a href="{{ url('/report/customer')}}">
                            <i class="nc-icon nc-cart-simple"></i>
                            <p>Customer</p>
                        </a>
                    </li>
                    <li class="{{ request()->is('report/supplier') ? 'active' : ''}}">
                        <a href="{{ url('/report/supplier')}}">
                            <i class="nc-icon nc-cart-simple"></i>
                            <p>Supplier</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="#">
                    <i class="nc-icon nc-app"></i>
                    <p>Stock</p>
                </a>
                <ul>
                    <li class="{{ request()->is('stock/delivery_in') ? 'active' : ''}}">
                        <a href="{{ url('/stock/delivery_in') }}">
                            <i class="nc-icon nc-cloud-download-93"></i>
                            <p>Delivery In</p>
                        </a>
                    </li>
                    <li class="{{ request()->is('stock/delivery_out') ? 'active' : ''}}">
                        <a href="{{ url('/stock/delivery_out') }}">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            <p>Delivery Out</p>
                        </a>
                    </li>
                    <li class="{{ request()->is('stock') ? 'active' : ''}}">
                        <a href="{{ url('/stock')}}">
                            <i class="nc-icon nc-chart-pie-36"></i>
                            <p>Stock</p>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>