@extends('admin.layout.layout')
@section('body')
<div class="main-pane">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Catalogue Management</h3>
              <h6 class="font-weight-normal">Brands</h6>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Brand</h4>

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

                <form class="forms-sample"  method="POST" action="{{ route('brand.update',$brand->id) }}" 
                    enctype="multipart/form-data"> 
                    @csrf
                
                    <div class="form-group">
                        <label for="name">Brand Name</label>
                        <input type="text" class="form-control" id="name" 
                        placeholder="Enter Brand Name" name="name"
                        @if (!empty($brand['name']))
                            value="{{ $brand['name'] }}" 
                        @else
                            value="{{ old('name') }}" 
                        @endif>

                        @error('name')
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