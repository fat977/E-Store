@extends('admin.layout.layout')
@section('body')
<div class="main-pane">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Catalogue Management</h3>
                        <h6 class="font-weight-normal">filters</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Filter</h4>

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

                        <form class="forms-sample"  method="POST" action="{{ route('filter.update',$filter['id']) }}" 
                            enctype="multipart/form-data"> 
                            @csrf
                            <div class="form-group">
                                <label for="cat_ids">Select Category</label>
                                <select name="cat_ids[]" id="cat_ids" class="form-control" multiple>
                                    <option value="">Select</option>
                                    @foreach ($categories as $section)
                                        <optgroup label="{{ $section['name'] }}"></optgroup>
                                        @foreach ($section['categories'] as $category)
                                            <option 
                                            value="{{ $category['id'] }}">&nbsp;&raquo;{{ $category['category_name'] }}</option>
                                            @foreach ($category['sub_categories'] as $sub_category)
                                            <option 
                                            value="{{ $sub_category['id'] }}">&nbsp;&nbsp;--&nbsp;{{ $sub_category['category_name'] }}</option>
                                            @endforeach
                                        @endforeach    
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="filter_name">Filter Name</label>
                                <input type="text" class="form-control" id="filter_name" 
                                placeholder="Enter filter Name" name="filter_name"
                                @if (!empty($filter['filter_name']))
                                    value="{{ $filter['filter_name'] }}" 
                                @else
                                    value="{{ old('filter_name') }}" 
                                @endif>

                                @error('filter_name')
                                <small class="form-text text-danger">{{$message}} </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="filter_column">Filter Column</label>
                                <input type="text" class="form-control" id="filter_column" 
                                placeholder="Enter filter Column" name="filter_column"
                                @if (!empty($filter['filter_column']))
                                    value="{{ $filter['filter_column'] }}" 
                                @else
                                    value="{{ old('filter_column') }}" 
                                @endif>

                                @error('filter_column')
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