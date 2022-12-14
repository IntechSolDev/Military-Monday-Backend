<!-- Sidebar -->
@php
use App\Models\Product;
$unactive = Product::where('product_status','pending')->get()->count();
@endphp

<ul class="sidebar navbar-nav">
    <li class="nav-item {{ (request()->is('admin')) ? 'active' : '' }}">
        <a class="nav-link" href="{{url('/admin/')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item  {{ (request()->routeIs('user.index')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('user.index')}}">
            <i class="fas fa-fw fa-users"></i>
            <span> Users</span></a>
    </li>
    <li class="nav-item {{ (request()->routeIs('product.index')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('product.index')}}">
            <i class="fas fa-fw fa-tag"></i>
            <span> Product @if($unactive)({{$unactive}})@endif</span></a>
    </li>
       <li class="nav-item {{ (request()->routeIs('push-notification.index')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('push-notification.index')}}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Push Notification</span></a>
    </li>

    <li class="nav-item {{ (request()->routeIs('contact.index')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('contact.index')}}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Send Email</span></a>
    </li>
    <li class="d-none nav-item {{ (request()->routeIs('order.index')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('order.index')}}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span> Order </span></a>
    </li>

</ul>
