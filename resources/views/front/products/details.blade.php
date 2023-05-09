<?php 
   use App\Models\Product ;
   use App\Models\ProductFilter ; 
 $productFilter = ProductFilter::product_filters();
 ?>
@extends('front.layout.layout')
@section('content')
 <!-- Page Introduction Wrapper -->
 <div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Detail</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="javascript:;">Detail</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Single-Product-Full-Width-Page -->
<div class="page-detail u-s-p-t-80">
    <div class="container">
        <!-- Product-Detail -->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <!-- Product-zoom-area -->
                <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                    <a href="{{ asset('assets/admin/images/'.$productDetails['product_image']) }}">
                        <img src="{{ asset('assets/admin/images/'.$productDetails['product_image']) }}" alt="" width="100%" height="300" />
                    </a>
                   
                </div>
                <div class="thumbnails">
                    <a href="{{ asset('assets/admin/images/'.$productDetails['product_image']) }}" data-standard="{{ asset('assets/admin/images/'.$productDetails['product_image']) }}">
                        <img width="50" height="50" src="{{ asset('assets/admin/images/'.$productDetails['product_image']) }}" alt="" />
                    </a>
                  
                    @foreach ($productDetails['images'] as $image)
                        <a href="{{ asset('assets/admin/images/products/'.$image['image']) }}" data-standard="{{ asset('assets/admin/images/products/'.$image['image']) }}">
                            <img width="50" height="50" src="{{ asset('assets/admin/images/products/'.$image['image']) }}" alt="" />
                        </a>
                    @endforeach
                   
                </div>
                {{-- <div class="zoom-area">
                    <img id="zoom-pro" class="img-fluid" src="{{ asset('assets/admin/images/'.$productDetails['product_image']) }}" data-zoom-image="{{ asset('assets/admin/images/'.$productDetails['product_image']) }}" alt="Zoom Image">
                    <div id="gallery" class="u-s-m-t-10">
                        <a class="" data-image="{{ asset('assets/admin/images/'.$productDetails['product_image']) }}"
                         data-zoom-image="{{ asset('assets/admin/images/'.$productDetails['product_image']) }}">
                         
                        </a>
                       
                    </div>
                </div> --}}
                <!-- Product-zoom-area /- -->
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <!-- Product-details -->
                <div class="all-information-wrapper product_data">
                    @if (Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success :</strong><?php echo Session::get('success_message') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    @endif
                    @if (Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error :</strong><?php echo Session::get('error_message') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    @endif
                    <p id="wishlist-success"></p>
                    <p id="wishlist-error"></p>
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error :</strong> <?php echo implode('',$errors->all('<div>:message</div>')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    @endif
                    <div class="section-1-title-breadcrumb-rating">
                        <div class="product-title">
                            <h1>
                                <a href="javascript:;">{{ $productDetails['product_name'] }}</a>
                            </h1>
                        </div>
                        <ul class="bread-crumb">
                            <li class="has-separator">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="has-separator">
                                <a href="javascript:;">{{ $productDetails['section']['name'] }}</a>
                            </li>
                            <?php echo $categoryDetails['breadcrumbs'] ; ?>
                        </ul>
                        <div class="product-rating">
                            @php
                                $rate_num = number_format($rating_value)
                            @endphp
                            <td>
                                @for ($i = 1; $i <= $rate_num; $i++)
                                    <i class="fa fa-star checked"></i>
                                @endfor
                                @for ($j = $rate_num; $j < 5; $j++)
                                    <i class="fa fa-star not-checked"></i>
                                @endfor
                                
                            </td>
                            <td>
                                @if ($ratings->count() > 0)
                                    <span>{{ $ratings->count() }} Rating</span>
                                @else
                                    No Rating
                                @endif
                                
                            </td>

                        </div>
                    </div>
                    <div class="section-2-short-description u-s-p-y-14">
                        <h6 class="information-heading u-s-m-b-8">Description:</h6>
                        <p>{{ $productDetails['description'] }}</p>
                    </div>
                     <div class="section-3-price-original-discount u-s-p-y-14">
                        @php
                            $getDiscountPrice = Product::getDiscountPrice($productDetails['id']);
                        @endphp
                        @if ($getDiscountPrice > 0)
                            <div class="price-template">
                                <div class="item-new-price">
                                    RS.{{ $getDiscountPrice }}
                                </div>                                         
                                <div class="item-old-price">
                                    RS.{{ $productDetails['product_price'] }}
                                </div>
                            </div>
                        @else
                            <div class="price-template">
                                <div class="item-new-price">
                                    RS.{{ $productDetails['product_price'] }}
                                </div>                                         
                            </div>
                        @endif
                        </span>
                       
                    </div>
                    <div class="section-4-sku-information u-s-p-y-14">
                        <h6 class="information-heading u-s-m-b-8">Sku Information:</h6>
                        <div class="availability">
                            <span>Product Code:</span>
                            <span>{{ $productDetails['product_code'] }}</span>
                        </div>
                        <div class="availability">
                            <span>Product Color:</span>
                            <span>{{ $productDetails['product_color'] }}</span>
                        </div>
                        <div class="availability">
                            <span>Availability:</span>
                            @if ($totalStock>0)
                                <span>In Stock</span>
                            @else
                                <span style="color: red">Out of Stock</span>
                            @endif
                        </div>
                        <div class="left">
                            <span>Only:</span>
                            <span>{{ $totalStock }} left</span>
                        </div>
                    </div>

                    <!-- vendor name-->
                    {{-- @if (isset($productDetails['vendor']))
                        <div>Sold By : <a href="/products/{{ $productDetails['vendor']['id']}} ">{{ $productDetails['vendor']['vendor_business_details']['shop_name'] }}</a> </div>
                    @endif --}}
                    <form action="{{ url('cart/add') }}" method="POST">
                        @csrf
                        <div class="section-5-product-variants u-s-p-y-14">
                            @if(count($groupProducts)>0)
                            <div>
                                <div><strong>Product Colors :</strong></div>
                                <div>
                                    @foreach ($groupProducts as $product)
                                        <a href="{{ url('product/'.$product['id']) }}">
                                            <img style="width: 80px" src="{{ asset('front/images/products/'.$product['product_image']) }} "></a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                           
                        </div>
                        <div class="section-6-social-media-quantity-actions u-s-p-y-14">
                            
                            @if ($totalStock > 0)
                                <input type="hidden" value="{{ $productDetails['id'] }}" name="product_id" class="product_id">
                                <div class="quantity-wrapper u-s-m-b-22">
                                    <span>Quantity:</span>
                                    <div class="quantity">
                                        <input type="number" class="cart_quantity_input quantity-text-field" name="quantity" min="1" value="1">
                                    </div>
                                </div>
                                <?php
                                    $getProductSizes = productFilter::getSizes($productDetails['category']['url']);
                                ?>
{{--                                 @if ($size)
 --}}                                    <div class="sizes u-s-m-b-11" style="margin-top: 10px" hidden>
                                        <span >Available Size:</span>
                                        <div class="size-variant select-box-wrapper">
                                            <select class="select-box product-size" name="size" id="getPrice" product-id=
                                            {{ $productDetails['id'] }}>
                                                <option value="">Select Size</option>
                                                @foreach ($productDetails['attributes'] as $attribute)
                                                    <option value="{{ $attribute['size'] }} ">{{ $attribute['size'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
{{--                                 @endif
 --}}                               
                                <div>
                                    <button class="button button-outline-secondary addToCart">Add to cart</button>
                                    <button class="button button-outline-secondary far fa-heart u-s-m-l-6 addToWishlist"></button>
                                    <button class="button button-outline-secondary far fa-envelope u-s-m-l-6"></button>
                                </div>
                            @endif
                            
                            <div class="quick-social-media-wrapper u-s-m-b-22 mt-3">
                                <span>Share:</span>
                                <ul class="social-media-list">
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-google-plus-g"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fas fa-rss"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-pinterest"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                    {{-- <form action="{{ url('wishlist/add') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $productDetails['id'] }}" name="product_id">
                        <button class="button button-outline-secondary far fa-heart u-s-m-l-6"></button>
                    </form> --}}
                   
                </div>
                <!-- Product-details /- -->
            </div>
        </div>
        <!-- Product-Detail /- -->
        <!-- Detail-Tabs -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="detail-tabs-wrapper u-s-p-t-80">
                    <div class="detail-nav-wrapper u-s-m-b-30">
                        <ul class="nav single-product-nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#detail">Product Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#review">Reviews ( {{ $ratings->count() }} )</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <!-- Details-Tab -->
                        <div class="tab-pane fade active show" id="detail">
                            <div class="specification-whole-container">
                                
                                <div class="spec-table u-s-m-b-50">
                                    <h4 class="spec-heading">Product Details</h4>
                                    <table>
                                        @foreach ($productFilter as $filter)
                                            @if (isset($productDetails['category_id']))
                                                @php
                                                    $filterAvailable = ProductFilter::filterAvailable($filter['id'],$productDetails['category_id']);
                                                @endphp
                                                 @if ($filterAvailable=="Yes")
                                                    <tr>
                                                        <td>{{ $filter['filter_name'] }}</td>
                                                        <td>
                                                            @foreach ($filter['filter_values'] as $value)
                                                            
                                                            @if (!empty($productDetails[$filter['filter_column']]) && $value['filter_value']==$productDetails[$filter['filter_column']])
                                                               {{ ucwords($value['filter_value']) }}
                                                            @endif
                                                            
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Specifications-Tab /- -->
                        <!-- Reviews-Tab -->
                        <div class="tab-pane fade" id="review">
                            <div class="review-whole-container">
                                <div class="row r-1 u-s-m-b-26 u-s-p-b-22">
                                    @if (count($ratings) > 0)
                                        <div class="col-lg-6 col-md-6">
                                            <div class="total-score-wrapper">
                                                <h6 class="review-h6">Average Rating</h6>
                                                <div class="circle-wrapper">
                                                    <h1>{{ $rating_value }}</h1>
                                                </div>
                                                <h6 class="review-h6">Based on {{ $ratings->count() }}</h6>
                                            </div>
                                        </div>
                                    @else
                                        <h5 class="text-center">There is no ratings yet</h5>
                                    @endif
                                    <div class="col-lg-6 col-md-6">
                                        <div class="total-star-meter">
                                            @foreach ($ratings as $rating)
                                                <div class="star-wrapper">
                                                    <span>{{ $rating->stars_rated }}</span>
                                                    @php
                                                        $user_rated = $rating->stars_rated
                                                    @endphp
                                                    @for ($i = 1; $i <= $user_rated; $i++)
                                                        <i class="fa fa-star checked" style="margin-top:0"></i>
                                                    @endfor
                                                    @for ($j = $user_rated+1; $j <= 5; $j++)
                                                        <i class="fa fa-star not-checked" style="margin-top:0"></i>
                                                    @endfor
                                                    <span>({{ $stars_rated }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @if($verified_purchase->count()>0 && !$user_rating)                    
                                    <div class="row r-2 u-s-m-b-26 u-s-p-b-22">
                                        <div class="col-lg-12">
                                            <div class="your-rating-wrapper">
                                                
                                                <form action="{{ url('/add-rating') }}" method="POST">
                                                    @csrf
                                                    <h6 class="review-h6">Your Review is matter.</h6>
                                                    <h6 class="review-h6">Have you used this product before?</h6>
                                                    <div class="star-wrapper u-s-m-b-8">
                                                        <div class="star">
                                                            <span id="your-stars" style='width:0'></span>
                                                        </div>
                                                        <label for="your-rating-value"></label>
                                                        <input id="your-rating-value" type="text" name="product_rating" class="text-field" placeholder="0.0">
                                                        <span id="star-comment"></span>
                                                    </div>
                                                    <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                                                    <label for="review-text-area">Review
                                                        <span class="astk"> *</span>
                                                    </label>
                                                    <textarea class="text-area u-s-m-b-8" id="review-text-area" name="user_review" placeholder="Review"></textarea>
                                                    <button class="button button-outline-secondary">Submit Review</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @if (!$user_rating)
                                    <div class="alert alert-danger">
                                        <h5>You are not eligible to review this book</h5>
                                        <p>For only Customers</p>
                                        <a href="{{ url('/') }}" class="btn btn-primary"> Go to Home</a>
                                    </div>
                                    @endif
                                @endif

                                <!-- Get-Reviews -->
                                <div class="get-reviews u-s-p-b-22">
                                    <!-- Review-Options -->
                                    <div class="review-options u-s-m-b-16">
                                        <div class="review-option-heading">
                                            <h6>Reviews
                                                <span> ( {{ $ratings->count() }} ) </span>
                                            </h6>
                                        </div>
                                        <div class="review-option-box">
                                            <div class="select-box-wrapper">
                                                <label class="sr-only" for="review-sort">Review Sorter</label>
                                                <select class="select-box" id="review-sort">
                                                    <option value="">Sort by: Best Rating</option>
                                                    <option value="">Sort by: Worst Rating</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Review-Options /- -->
                                    <!-- All-Reviews -->
                                    <div class="reviewers product_data">
                                        @if (count($ratings) > 0)
                                            @foreach ($ratings as $rating)
                                                <div class="review-data">
                                                    <div class="reviewer-name-and-date">
                                                        <h6 class="reviewer-name">{{ $rating->user->name }}</h6>
                                                        @if ($rating->user_id == Auth::id())
                                                        <input type="hidden" name="product_id" class="product_id" value="{{ $productDetails['id'] }}">

                                                            <a class="text-primary" href="{{ url('edit-review/'.$productDetails['id']) }}">Edit</a>
                                                            <a class="delete-review text-danger" href="">Delete</a>
                                                        @endif
                                                        <h6 class="review-posted-date">{{ $rating->created_at->format('d M Y') }}</h6>
                                                    </div>
                                                    <div class="reviewer-stars-title-body">
                                                        <div class="reviewer-stars">
                                                            @php
                                                                $user_rated = $rating->stars_rated
                                                            @endphp
                                                            @for ($i = 1; $i <= $user_rated; $i++)
                                                                <i class="fa fa-star checked" style="margin-top:0"></i>
                                                            @endfor
                                                            @for ($j = $user_rated+1; $j <= 5; $j++)
                                                                <i class="fa fa-star not-checked" style="margin-top:0"></i>
                                                            @endfor
                                                        </div>
                                                        <p class="review-body">
                                                            {{ $rating->user_review }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <h5 class="text-center">There is no reviews to show</h5>
                                        @endif
                                    </div>
                                    <!-- All-Reviews /- -->
                                    <!-- Pagination-Review -->
                                    <div class="pagination-review-area">
                                        <div class="pagination-review-number">
                                            <ul>
                                                <li style="display: none">
                                                    <a href="single-product.html" title="Previous">
                                                        <i class="fas fa-angle-left"></i>
                                                    </a>
                                                </li>
                                                <li class="active">
                                                    <a href="single-product.html">1</a>
                                                </li>
                                                <li>
                                                    <a href="single-product.html">2</a>
                                                </li>
                                                <li>
                                                    <a href="single-product.html">3</a>
                                                </li>
                                                <li>
                                                    <a href="single-product.html">...</a>
                                                </li>
                                                <li>
                                                    <a href="single-product.html">10</a>
                                                </li>
                                                <li>
                                                    <a href="single-product.html" title="Next">
                                                        <i class="fas fa-angle-right"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Pagination-Review /- -->
                                </div>
                                <!-- Get-Reviews /- -->
                            </div>
                        </div>
                        <!-- Reviews-Tab /- -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Detail-Tabs /- -->
        <!-- Different-Product-Section -->
        <div class="detail-different-product-section u-s-p-t-80">
            <!-- Similar-Products -->
            <section class="section-maker">
                <div class="container">
                    <div class="sec-maker-header text-center">
                        <h3 class="sec-maker-h3">Similar Products</h3>
                    </div>
                    <div class="slider-fouc">
                        <div class="products-slider owl-carousel" data-item="4">
                            @foreach ($similarProducts as $product)
                            <div class="item">
                                <div class="image-container">
                                    <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                        <?php $product_image_path = 'assets/admin/images/'.$product['product_image']; ?>
                                        @if (!empty($product['product_image']) && file_exists($product_image_path))
                                           <img class="img-flui" src="{{ asset($product_image_path) }}" height="400px" alt="Product">
                                        @else
                                           <img class="img-fluid" src="{{ asset('front/images/products/no-image.png') }}" alt="Product">
                                        @endif
                                    </a>
                                   {{--  <div class="item-action-behaviors">
                                        <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                        <a class="item-mail" href="javascript:void(0)">Mail</a>
                                        <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                        <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                    </div> --}}
                                </div>
                                <div class="item-content">
                                    <div class="what-product-is">
                                        <ul class="bread-crumb">
                                            <li class="has-separator">
                                                <a href="shop-v1-root-category.html">{{ $product['product_code'] }}</a>
                                            </li>
                                            <li class="has-separator">
                                                <a href="listing.html">{{ $product['product_color'] }}</a>
                                            </li>
                       
                                            <li>
                                                <a href="listing.html">{{ $product['brand']['name'] }}</a>
                                            </li>
                                         
                                        </ul>
                                        <h6 class="item-title">
                                            <a href="{{ url('/product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                        </h6>
                                        {{-- <div class="item-stars">
                                            <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                <span style='width:0'></span>
                                            </div>
                                            <span>(0)</span>
                                        </div> --}}
                                    </div>
                                    @php
                                        $getDiscountPrice = Product::getDiscountPrice($product['id']);
                                    @endphp
                                    @if ($getDiscountPrice > 0)
                                        <div class="price-template">
                                            <div class="item-new-price">
                                                RS.{{ $getDiscountPrice }}
                                            </div>                                         
                                            <div class="item-old-price">
                                                RS.{{ $product['product_price'] }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="price-template">
                                            <div class="item-new-price">
                                                RS.{{ $product['product_price'] }}
                                            </div>                                         
                                        </div>
                                    @endif
                                </div>
                                @php
                                    $isProductNew = Product::isProductNew($product['id']);
                                @endphp
                                @if ($isProductNew=='Yes')
                                    <div class="tag new">
                                        <span>NEW</span>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            <!-- Similar-Products /- -->
            <!-- Recently-View-Products  -->
            <section class="section-maker">
                <div class="container">
                    <div class="sec-maker-header text-center">
                        <h3 class="sec-maker-h3">Recently View</h3>
                    </div>
                    <div class="slider-fouc">
                        <div class="products-slider owl-carousel" data-item="4">
                            @foreach ($recentViewProducts as $product)
                            <div class="item">
                                <div class="image-container">
                                    <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                        <?php $product_image_path = 'assets/admin/images/'.$product['product_image']; ?>
                                        @if (!empty($product['product_image']) && file_exists($product_image_path))
                                           <img class="img-flui" src="{{ asset($product_image_path) }}" height="400px" alt="Product">
                                        @else
                                           <img class="img-fluid" src="{{ asset('front/images/products/no-image.png') }}" alt="Product">
                                        @endif
                                    </a>
                                   {{--  <div class="item-action-behaviors">
                                        <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                        <a class="item-mail" href="javascript:void(0)">Mail</a>
                                        <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                        <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                    </div> --}}
                                </div>
                                <div class="item-content">
                                    <div class="what-product-is">
                                        <ul class="bread-crumb">
                                            <li class="has-separator">
                                                <a href="shop-v1-root-category.html">{{ $product['product_code'] }}</a>
                                            </li>
                                            <li class="has-separator">
                                                <a href="listing.html">{{ $product['product_color'] }}</a>
                                            </li>
                       
                                            <li>
                                                <a href="listing.html">{{ $product['brand']['name'] }}</a>
                                            </li>
                                         
                                        </ul>
                                        <h6 class="item-title">
                                            <a href="{{ url('/product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                        </h6>
                                        {{-- <div class="item-stars">
                                            <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                <span style='width:0'></span>
                                            </div>
                                            <span>(0)</span>
                                        </div> --}}
                                    </div>
                                    @php
                                        $getDiscountPrice = Product::getDiscountPrice($product['id']);
                                    @endphp
                                    @if ($getDiscountPrice > 0)
                                        <div class="price-template">
                                            <div class="item-new-price">
                                                RS.{{ $getDiscountPrice }}
                                            </div>                                         
                                            <div class="item-old-price">
                                                RS.{{ $product['product_price'] }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="price-template">
                                            <div class="item-new-price">
                                                RS.{{ $product['product_price'] }}
                                            </div>                                         
                                        </div>
                                    @endif
                                </div>
                                @php
                                    $isProductNew = Product::isProductNew($product['id']);
                                @endphp
                                @if ($isProductNew=='Yes')
                                    <div class="tag new">
                                        <span>NEW</span>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            <!-- Recently-View-Products /- -->
        </div>
        <!-- Different-Product-Section /- -->
    </div>
</div>
<!-- Single-Product-Full-Width-Page /- -->
@endsection