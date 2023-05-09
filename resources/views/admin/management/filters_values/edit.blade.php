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
                        <h4 class="card-title">Edit Filter Value</h4>

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

                        <form class="forms-sample"  method="POST" action="{{ route('filter.value.update',$filter->id) }}" 
                            enctype="multipart/form-data"> 
                            @csrf
                            <div class="form-group">
                                <label for="filter_id">Select Filter</label>
                                <select name="filter_id" id="filter_id" class="form-control">
                                    <option value="">select</option>
                                    @foreach ($product_filters as $product_filter)
                                        <option @if (!empty($product_filter['id']==$filter['filter_id']))
                                                selected
                                            @endif
                                            value="{{ $product_filter['id'] }}">{{ $product_filter['filter_name'] }}
                                        </option>
                                    @endforeach    
                                </select>
                                @error('filter_id')
                                <small class="form-text text-danger">{{$message}} </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="filter_value">Filter Value</label>
                                <input type="text" class="form-control" id="filter_value" 
                                placeholder="Enter filter Value" name="filter_value"
                                @if (!empty($filter['filter_value']))
                                    value="{{ $filter['filter_value'] }}" 
                                @else
                                    value="{{ old('filter_value') }}" 
                                @endif>

                                @error('filter_value')
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