<?php use App\Models\Book ; ?>
@extends('front.layout.layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <ul class="bread-crumb mt-5">
            <li class="has-separator">
                <i class="ion ion-md-home"></i>
                <a href="index.html">Home</a>
            </li>
            <li class="is-marked">
                <a href="wishlist.html">Show Orders</a>
            </li>
        </ul>
        <div class="table-responsive cart_info mt-5">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Name</td>
                        <td class="price">Quantity</td>
                        <td class="price">Price</td>
                        <td class="total">image</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                   @foreach ($orders['order_item'] as $item)
                       <tr>
                            <td>{{ $item['product']['product_name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>
                                {{ $item['price'] }}
                            </td>
                            <td><a href=""><img style="width: 60px; height:70px;" src="{{ asset('assets/admin/images/'.$item['product']['product_image']) }}" alt="" /></a></td>

                       </tr>   
                   @endforeach
                  

                </tbody>
               
            </table>
        </div>
        <h4>Total : {{ $orders->total_price }} </h4>

        <table class="table table-borderless">
           <div class="row">
                <div class="col-sm-6">
                    <tr>
                        <td>Name</td>
                        <td>{{ $orders->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $orders['email'] }}</td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>{{ $orders['mobile'] }}</td>
                    </tr>
                    <tr>
                        <td>Shipping Address</td>
                        <td>{{ $orders['address'] }} / {{ $orders['city'] }} / {{ $orders['state'] }} / {{ $orders['country'] }}</td>
                    </tr>
                    <tr>
                        <td>Zip Code</td>
                        <td>{{ $orders['pincode'] }}</td>
                    </tr>
                </div>
           </div>
        </table>
    </div>
</section> <!--/#cart_items-->

@endsection