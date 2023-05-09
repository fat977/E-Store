<?php use App\Models\Product ; ?>
<div class="row product-container grid-style">
    @if(count($categoryProduct) > 0)
    @foreach ($categoryProduct as $product)
        <div class="product-item col-lg-4 col-md-6 col-sm-6">
            <div class="item">
                <div class="image-container">
                    <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                        <?php $product_image_path = 'assets/admin/images/'.$product['product_image']; ?>
                        @if (!empty($product['product_image']) && file_exists($product_image_path))
                        <img class="img-flui" src="{{ asset($product_image_path) }}" height="300px" width="200px" alt="Product">
                        @else
                        <img class="img-fluid" src="{{ asset('front/images/products/no-image.png') }}" alt="Product">
                        @endif
                    </a>
                    {{-- <div class="item-action-behaviors">
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
                        <div class="item-description">
                            <p> {{ $product['description'] }} </p>
                        </div>
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
                    $isProductNew = Product::isProductNew($product['id'])
                @endphp
                @if ($isProductNew=="Yes")
                    <div class="tag new">
                        <span>NEW</span>
                    </div>
                @endif 
            </div>
        </div>
    @endforeach
    @else
    <h3 class="text-danger" style="margin-left: 30%">There is no available item</h3>
    @endif
</div>