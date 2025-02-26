<ul class="account-nav">
    <li><a href="{{ route('user.index') }}" class="menu-link menu-link-us">Dashboard</a></li>
    <li><a href="account-orders.html" class="menu-link menu-link-us">Orders</a></li>
    <li><a href="account-address.html" class="menu-link menu-link-us">Addresses</a></li>
    <li><a href="account-details.html" class="menu-link menu-link-us">Account Details</a></li>
    <li><a href="account-wishlist.html" class="menu-link menu-link-us">Wishlist</a></li>

    <li>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <a href="{{ route('logout') }}" class="menu-link menu-link-us"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Logout</a>
        </form>
    </li>
</ul>
