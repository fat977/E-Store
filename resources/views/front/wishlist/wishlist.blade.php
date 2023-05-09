@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Wishlist</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="index.html">Home</a>
                </li>
                <li class="is-marked">
                    <a href="wishlist.html">Wishlist</a>
                </li>
            </ul>
           
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Wishlist-Page -->
<div class="page-wishlist u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="appendWishlistItems">
                    @include('front.wishlist.wishlist_items')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wishlist-Page /- -->
@endsection