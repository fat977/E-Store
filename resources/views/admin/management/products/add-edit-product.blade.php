@extends('admin.layout.layout')
@section('body')
<div class="main-pane">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Catalogue Management</h3>
                  <h6 class="font-weight-normal">Products</h6>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$title}}</h4>

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
                          @if (empty($product['id']))
                            action="{{url('admin/product/add-edit-product')}}" 
                          @else
                            action="{{url('admin/product/add-edit-product/'.$product['id'])}}" 
                          @endif
                          enctype="multipart/form-data"> 
                          @csrf
                      
                          <div class="form-group">
                              <label for="category_id">Select Category</label>
                              <select name="category_id" id="category_id" class="form-control getBrands" onclick="console.log($(this).val())"
                                  onchange="console.log('change is firing')">
                                  <option value="">Select</option>
                                  @foreach ($categories as $section)
                                      <optgroup label="{{ $section['name'] }}"></optgroup>
                                      @foreach ($section['categories'] as $category)
                                          <option @if (!empty($product['category_id']==$category['id']))
                                              selected
                                          @endif
                                          value="{{ $category['id'] }}">&nbsp;&raquo;{{ $category['category_name'] }}</option>
                                          @foreach ($category['sub_categories'] as $sub_category)
                                          <option @if (!empty($product['category_id']==$sub_category['id']))
                                              selected
                                          @endif
                                          value="{{ $sub_category['id'] }}">&nbsp;&nbsp;--&nbsp;{{ $sub_category['category_name'] }}</option>
                                          @endforeach
                                      @endforeach    
                                  @endforeach
                              </select>
                          </div>

                          <div class="LoadFilters">
                              @include('admin.management.filters.category_filters')
                          </div>

                          <div class="form-group">
                              <label for="brand_id">Select Brand</label>
                              <select name="brand_id" id="brand_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach ($brands as $brand)
                                      <option @if (!empty($product['brand_id']==$brand['id']))
                                          selected
                                      @endif
                                      value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                  @endforeach
                              </select>
                          </div>

                        <div class="form-group">
                            <label for="product_name">product Name</label>
                            <input type="text" class="form-control" id="product_name" 
                              placeholder="Enter product Name" name="product_name"
                              @if (!empty($product['product_name']))
                                  value="{{ $product['product_name'] }}" 
                              @else
                                  value="{{ old('product_name') }}" 
                              @endif>

                            @error('product_name')
                            <small class="form-text text-danger">{{$message}} </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="product_code">product Code</label>
                            <input type="text" class="form-control" id="product_code" 
                              placeholder="Enter product Code" name="product_code"
                            @if (!empty($product['product_code']))
                                value="{{ $product['product_code'] }}" 
                            @else
                                value="{{ old('product_code') }}" 
                            @endif>
          
                            @error('product_code')
                            <small class="form-text text-danger">{{$message}} </small>
                            @enderror
                          </div>

                          <div class="form-group">
                              <label for="product_color">product Color</label>
                              <input type="text" class="form-control" id="product_color" 
                                placeholder="Enter product Color" name="product_color"
                              @if (!empty($product['product_color']))
                                  value="{{ $product['product_color'] }}" 
                              @else
                                  value="{{ old('product_color') }}" 
                              @endif>
            
                              @error('product_color')
                              <small class="form-text text-danger">{{$message}} </small>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label for="product_price">product Price</label>
                              <input type="text" class="form-control" id="product_price" 
                              placeholder="Enter product Price" name="product_price"
                              @if (!empty($product['product_price']))
                                  value="{{ $product['product_price'] }}" 
                              @else
                                  value="{{ old('product_price') }}" 
                              @endif>
              
                              @error('product_price')
                              <small class="form-text text-danger">{{$message}} </small>
                              @enderror
                          </div>
                          
                          <div class="form-group">
                              <label for="product_discount">product Discount</label>
                              <input type="text" class="form-control" id="product_discount" 
                              placeholder="Enter product Discount" name="product_discount"
                              @if (!empty($product['product_discount']))
                                  value="{{ $product['product_discount'] }}" 
                              @else
                                  value="{{ old('product_discount') }}" 
                              @endif>
              
                              @error('product_discount')
                              <small class="form-text text-danger">{{$message}} </small>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label for="product_weight">product Weight</label>
                              <input type="text" class="form-control" id="product_weight" 
                                placeholder="Enter product Weight" name="product_weight"
                              @if (!empty($product['product_weight']))
                                  value="{{ $product['product_weight'] }}" 
                              @else
                                  value="{{ old('product_weight') }}" 
                              @endif>
              
                              @error('product_weight')
                              <small class="form-text text-danger">{{$message}} </small>
                              @enderror
                          </div>
              
                          <div class="form-group">
                              <label for="product_image">product Image (Recommended size : 1000x1000)</label>
                              <input type="file" class="form-control" id="product_image" name="product_image">
                              @if (!empty($product['product_image']))
                                  <a target="_blank" href="{{ url('assets/admin/images/'.$product['product_image']) }}">View Image </a> &nbsp;| &nbsp;
                                  <a href="javascript:void(0)" class="confirmDelete" module="product-image" moduleid="{{$product['id']}}">Delete Image</a>
                              @endif
                              @error('product_image')
                              <small class="form-text text-danger">{{$message}} </small>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label for="description ">product Discription</label>
                              <textarea type="text" class="form-control" id="description" 
                              placeholder="Enter product description" name="description" rows="3">{{ $product['description'] }}</textarea>

                              @error('description')
                              <small class="form-text text-danger">{{$message}} </small>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label for="meta_title ">Meta Title</label>
                              <input type="text" class="form-control" id="meta_title" 
                              placeholder="Enter Meta Title" name="meta_title"
                              @if (!empty($product['meta_title']))
                                  value="{{ $product['meta_title'] }}" 
                              @else
                                  value="{{ old('meta_title') }}" 
                              @endif>
            
                              @error('meta_title')
                              <small class="form-text text-danger">{{$message}} </small>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label for="meta_description ">Meta Description</label>
                              <input type="text" class="form-control" id="meta_description" 
                              placeholder="Enter Meta Description" name="meta_description"
                              @if (!empty($product['meta_description']))
                                  value="{{ $product['meta_description'] }}" 
                              @else
                                  value="{{ old('meta_description') }}" 
                              @endif>
            
                              @error('meta_description')
                              <small class="form-text text-danger">{{$message}} </small>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label for="meta_keywords">Meta Keywords</label>
                              <input type="text" class="form-control" id="meta_keywords" 
                              placeholder="Enter Meta Keywords" name="meta_keywords"
                              @if (!empty($product['meta_keywords']))
                                  value="{{ $product['meta_keywords'] }}" 
                              @else
                                  value="{{ old('meta_keywords') }}" 
                              @endif>
            
                              @error('meta_keywords')
                              <small class="form-text text-danger">{{$message}} </small>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label for="is_featured ">Feature Items</label>
                              <input type="checkbox" id="is_featured" 
                              name="is_featured" value="Yes"
                              @if (!empty($product['is_featured'])&& $product['is_featured']=='Yes') 
                              checked
                              @endif>
            
                          </div>

                          <div class="form-group">
                            <label for="is_featured ">Best Seller Items</label>
                            <input type="checkbox" id="bestseller" 
                            name="bestseller" value="Yes"
                            @if (!empty($product['bestseller'])&& $product['bestseller']=='Yes') 
                            checked
                            @endif>

                          </div>
                      
                          <button type="submit" class="btn btn-primary mr-2">Submit</button>
                          <button type="reset" class="btn btn-light">Cancel</button>
                      </form>
                  </div>
              </div>
          </div>
        </div>
    </div>
</div>
@endsection