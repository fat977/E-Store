@extends('admin.layout.layout')
@section('body')
<div class="main-pane">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Catalogue Management</h3>
                    <h6 class="font-weight-normal">Attributes</h6>
                </div>         
            </div>
        </div>
      </div>
      <div class="row col-12">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Attributes</h4>

                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error :</strong> {{Session::get('error')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif

                    @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success :</strong> {{Session::get('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form class="forms-sample"  method="POST" 
                        action="{{ route('attribute.store',$product['id'])}}" >
                        @csrf
                
                        <div class="form-group">
                            <label for="product_name">product Name</label>
                            &nbsp; {{ $product['product_name'] }}
                        </div>
                    
                        <div class="form-group">
                            <label for="product_code">product Code</label>
                            &nbsp; {{ $product['product_code'] }}
                        </div>
        
                    
                        <div class="form-group">
                            <label for="product_color">product Color</label>
                            &nbsp; {{ $product['product_color'] }}
                        </div>

                        <div class="form-group">
                            <label for="product_price">product Price</label>
                            &nbsp; {{ $product['product_price'] }}
                        </div>
                        
                        <div class="form-group">
                            @if (!empty($product['product_image']))
                            <img style="width: 70px; height: 70px;" src="{{ asset('assets/admin/images/'.$product['product_image']) }}">
                            @else
                            <img style="width: 70px; height: 70px;" src="{{ asset('assets/admin/images/products/no-image.png') }}">
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="field_wrapper">
                                <div>
                                    <input type="text" name="size[]" placeholder="size" required/>
                                    <input type="text" name="stock[]" placeholder="stock" required/>
                                    <input type="text" name="price[]" placeholder="price" required/>
                                    <input type="text" name="sku[]" placeholder="sku" required/>
                                    <a href="javascript:void(0);" class="add_button" title="Add Attribute">Add</a>
                                </div>
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive p-3">
          <h4>Product Attributes</h4>
          <form action="{{ route('attribute.update',$product['id']) }}" method="POST">
            @csrf
            <table class="table table-bordered" id="products">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Size</th>
                  <th>SKU</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($product['attributes'] as $attribute)
                <input style="display: none" type="text" name="attributeId[]" value="{{ $attribute['id'] }}" style="width: 70px" required>

                <tr>
                    <td>{{ $attribute['id']}} </td>
                    <td>{{ $attribute['size']}} </td>
                    <td>{{ $attribute['sku']}} </td>
                    <td>
                      <input type="number" name="price[]" value="{{ $attribute['price'] }}" style="width: 70px" required>
                    </td>
                    <td>
                      <input type="number" name="stock[]" value="{{ $attribute['stock'] }}" style="width: 70px" required>
                    </td>
                    <td>
                        @if ($attribute['status']==1)
                          <a class="updateAttributeStatus" 
                          href="javascript:void(0)"
                          id="attribute-{{$attribute['id']}}"
                          attribute_id="{{ $attribute['id']}}"
                          >
                          <i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>
                          </a>
                        @else
                          <a class="updateAttributeStatus" 
                          href="javascript:void(0)"
                          id="attribute-{{$attribute['id']}}"
                          attribute_id="{{ $attribute['id']}}"
                          >
                          <i style="font-size: 20px"  status="inactive" class="far fa-bookmark"></i>
                          </a>
                        @endif
                    </td>
                    <td>
                        <a  href="{{ url('admin/product/add-edit-product/'.$product['id']) }}"><i style="font-size: 20px" class="fas fa-plus-square"></i></a>
                        <a  href="{{ route('attribute.edit',$product['id']) }}"><i style="font-size: 20px" class="fas fa-plus-circle"></i></a>
                        <a href="javascript:void(0)" class="confirmDelete" name="attribute" module="attribute" moduleid="{{ $product['id']}}"><i style="font-size: 20px; color:red" class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach
              
              </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Update Attributes</button>
          </form>
        </div>
    </div>
</div>
@endsection