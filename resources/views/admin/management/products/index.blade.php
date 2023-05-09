@extends('admin.layout.layout')
@section('body')
<div class="main-pane">
    <div class="content-wrapper">
        <div class="row">     
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-weight-bold">Catalogue Management</h3>
                        <h6 class="font-weight-normal">Products</h6>
                        <a href="{{ url('admin/product/add-edit-product') }}" class="btn btn-block btn-primary">Add Product</a>
                        @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success :</strong> {{Session::get('success')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="products">
                            <thead>
                                <tr>
                                <th>Product Id</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Product Color</th>
                                <th>Product Image</th>
                                <th>Section</th>
                                <th>Category</th>
                                <th> Status </th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product['id']}} </td>
                                    <td>{{ $product['product_name']}} </td>
                                    <td>{{ $product['product_code']}} </td>
                                    <td>{{ $product['product_color']}} </td>
                                    <td>
                                    @if (!empty($product['product_image']))
                                        <img style="width: 70px; height: 70px;" src="{{ asset('assets/admin/images/'.$product['product_image']) }}">
                                    @else
                                        <img style="width: 70px; height: 70px;" src="{{ asset('admin/images/products/no-image.png') }}">
                                    @endif
                                    </td>
                                    <td>{{ $product['section']['name']}} </td>
                                    <td>
                                    @if (!empty($product['category']['category_name']))
                                        {{ $product['category']['category_name']}}
                                    @endif
                                    </td> 
                                    <td>
                                        @if ($product['status']==1)
                                        <a class="updateProductStatus" 
                                        href="javascript:void(0)"
                                        id="product-{{$product['id']}}"
                                        product_id="{{ $product['id']}}"
                                        >
                                        <i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>
                                        </a>
                                        @else
                                        <a class="updateProductStatus" 
                                        href="javascript:void(0)"
                                        id="product-{{$product['id']}}"
                                        product_id="{{ $product['id']}}"
                                        >
                                        <i style="font-size: 20px"  status="inactive" class="far fa-bookmark"></i> 
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a  href="{{ url('admin/product/add-edit-product/'.$product['id']) }}"><i style="font-size: 20px" class="fas fa-user-edit"></i></a>
                                        <a title="add attributes"  href="{{ route('attribute.create',$product['id']) }}"><i style="font-size: 20px" class="fas fa-plus-square"></i></a>
                                        <a title="add multiple images" href="{{ url('admin/image/add-images/'.$product['id']) }}"><i style="font-size: 20px" class="fas fa-plus-circle"></i></a>
                                        <a href="javascript:void(0)" class="confirmDelete" name="product" module="product" moduleid="{{ $product['id']}}"><i style="font-size: 20px; color:red" class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection