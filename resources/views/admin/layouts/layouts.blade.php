<!DOCTYPE html>
<html lang="en">
@include('admin.includes.head')
<style>
        .ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  z-index: +999999 !important;
  width: 100%;
  height:100%;
}
.ajax-loader img {
  position: relative;
  top:50%;
  left:50%;
}
</style>
 <div class="ajax-loader">
  <img src="{{ url('public/ajax-loader/ajax-loader.gif') }}" class="img-responsive" />
</div>
<body  id="page-top">

@include('admin.includes.header')
<div id="wrapper">
    @include('admin.includes.left-sidebar')
    <div id="content-wrapper">
    @yield('content')
        @include('admin.includes.sticky-footer')
    </div>
</div>

<!-- js -->

@include('admin.includes.footer')
@yield('page-script')
</body>
</html>
