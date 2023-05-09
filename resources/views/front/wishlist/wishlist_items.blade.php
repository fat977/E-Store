<?php use App\Models\Product ; 
use App\Models\ProductAttribute ;
?>
<!-- Products-List-Wrapper -->
<div class="table-wrapper u-s-m-b-60 WishlistItems">
    @if (Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success :</strong><?php echo Session::get('success_message') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif
    <table>
        @if (count($getWishlistItem) > 0)
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Stock Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getWishlistItem as $item)
                    <tr class="product_data">
                        <td>
                            <div class="cart-anchor-image">
                                <a href="{{ url('product/'.$item['product_id']) }}">
                                    <img src="{{ asset('assets/admin/images/'.$item['product']['product_image']) }}" alt="Product">
                                    <h6>{{ $item['product']['product_name'] }} 
                                       
                                    </h6> 
                                </a>
                            </div>
                        </td>
                        <td>
                            <?php $getDiscountPrice = Product::getDiscountPrice($item['product_id']);?>
                            <div class="cart-price">
                                RS.{{ $getDiscountPrice }}
                                
                            </div>
                        </td>
                        <td>
                            <?php $totalStock = ProductAttribute::totalStock($item['product_id']);?>
                            <div class="cart-stock">
                                @if ($totalStock>0)
                                    <span>In Stock</span>
                                @else
                                    <span style="color: red">Out of Stock</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <input type="hidden" value="{{ $item['product']['id'] }}" class="product_id">
                            <div class="action-wrapper">
                                <button class="button button-outline-secondary">Add to Cart</button>
                                <button type="submit" class="button button-outline-secondary fas fa-trash remove_item"
                                    data-wishlistid="{{ $item['id'] }}"></button>
                                
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @else
            <h4 class="text-center">There is no items to show in your wishlist</h4>
            <a href="{{ url('/') }}" style="margin-left: 500px" class="btn btn-primary">Browse Products</a>
        @endif   
    </table>
</div>
<!-- Products-List-Wrapper /- -->