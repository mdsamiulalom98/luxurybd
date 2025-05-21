<div class="customer-auth">
    <div class="customer-img">
        <img src="{{ asset(Auth::guard('customer')->user()->image) }}" alt="">
    </div>
    <div class="customer-name">
        <p><small>Hello</small></p>
        <p>{{ Auth::guard('customer')->user()->name }}</p>
    </div>
</div>
<div class="sidebar-menu">
    <ul>
        <li><a href="{{ route('customer.account') }}" class="{{ request()->is('customer/account') ? 'active' : '' }}"><i
                    data-feather="user"></i> My Account</a></li>
        <li><a href="{{ route('customer.orders') }}" class="{{ request()->is('customer/orders') ? 'active' : '' }}"><i
                    data-feather="database"></i> My Order</a></li>
        @if (Auth::guard('customer')->user()->type == 2)
            <li>
                <a href="{{ route('customer.products') }}"
                    class="{{ request()->is('customer/products') ? 'active' : '' }}">
                    <i data-feather="shopping-cart"></i>
                    My Products
                </a>
            </li>
            <li>
                <a href="{{ route('customer.categories') }}"
                    class="{{ request()->is('customer/categories') ? 'active' : '' }}">
                    <i data-feather="layers"></i>
                    My Category
                </a>
            </li>
        @endif
        <li><a href="{{ route('customer.profile_edit') }}"
                class="{{ request()->is('customer/profile-edit') ? 'active' : '' }}"><i data-feather="edit"></i> Profile
                Edit</a></li>
        <li><a href="{{ route('customer.change_pass') }}"
                class="{{ request()->is('customer/change-password') ? 'active' : '' }}"><i data-feather="lock"></i> Change
                Password</a></li>
        <li>
            <a href="{{ route('customer.deposit_history') }}"
                class="{{ request()->is('customer/deposit-history') ? 'active' : '' }}"><i
                    data-feather="pie-chart"></i>Deposits</a>
        </li>
        <li>
            <a href="{{ route('customer.withdraw_history') }}"
                class="{{ request()->is('customer/withdraw-history') ? 'active' : '' }}"><i
                    data-feather="bar-chart-2"></i>Withdraw</a>
        </li>
        <li>
            <a href="{{ route('customer.members', ['level' => 1]) }}"
                class="{{ request()->is('customer/members') ? 'active' : '' }}"><i
                    data-feather="users"></i>Members</a>
        </li>
        <li><a href="{{ route('customer.logout') }}"
                onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i
                    data-feather="log-out"></i> Logout</a></li>
        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </ul>
</div>
