@extends('admin.layout.layout')
@section('body')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Catalogue Management</h3>
              <h6 class="font-weight-normal">Categories</h6>
            </div>
       
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Edit Category</h4>

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

              <form class="forms-sample"  method="POST" action="{{ route('category.update',$category->id) }}" 
              enctype="multipart/form-data"> 
              @csrf
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" id="category_name" 
                    placeholder="Enter category Name" name="category_name"
                    @if (!empty($category['category_name']))
                        value="{{ $category['category_name'] }}" 
                    @else
                        value="{{ old('category_name') }}" 
                    @endif>

                    @error('category_name')
                    <small class="form-text text-danger">{{$message}} </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="section_id">Select Section</label>
                    <select name="section_id" id="section_id" class="form-control">
                        <option value="">Select</option>
                        @foreach ($getSections as $section)
                          <option value="{{ $section['id'] }}"
                          @if (!empty($category['section_id'])&& $category['section_id'] == $section['id'])
                        selected @endif>
                     {{ $section['name'] }}</option>
                        @endforeach
                    </select>

                    @error('section_id')
                      <small class="form-text text-danger">{{$message}} </small>
                    @enderror
                </div>

                <div id="appendCategories">
                  @include('admin.management.categories.append-categories')
                </div>

                <div class="form-group">
                    <label for="category_discount ">Category Discount</label>
                    <input type="text" class="form-control" id="category_discount" 
                    placeholder="Enter category discount" name="category_discount"
                    @if (!empty($category['category_discount']))
                        value="{{ $category['category_discount'] }}" 
                    @else
                        value="{{ old('category_discount') }}" 
                    @endif>
  
                    @error('category_discount')
                    <small class="form-text text-danger">{{$message}} </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description ">Category Discription</label>
                    <textarea type="text" class="form-control" id="description" 
                    placeholder="Enter category description" name="description" rows="3"

                    @if (!empty($category['description']))
                        value="{{ $category['description'] }}" 
                    @else
                        value="{{ old('description') }}" 
                    @endif></textarea>

                    @error('description')
                    <small class="form-text text-danger">{{$message}} </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="url ">Category URL</label>
                    <input type="text" class="form-control" id="url" 
                    placeholder="Enter category URL" name="url"
                    @if (!empty($category['url']))
                        value="{{ $category['url'] }}" 
                    @else
                        value="{{ old('url') }}" 
                    @endif>
  
                    @error('url')
                    <small class="form-text text-danger">{{$message}} </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_title ">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" 
                    placeholder="Enter Meta Title" name="meta_title"
                    @if (!empty($category['meta_title']))
                        value="{{ $category['meta_title'] }}" 
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
                    @if (!empty($category['meta_description']))
                        value="{{ $category['meta_description'] }}" 
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
                    @if (!empty($category['meta_keywords']))
                        value="{{ $category['meta_keywords'] }}" 
                    @else
                        value="{{ old('meta_keywords') }}" 
                    @endif>
  
                    @error('meta_keywords')
                    <small class="form-text text-danger">{{$message}} </small>
                    @enderror
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