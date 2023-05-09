@extends('admin.layout.layout')
@section('body')
<div class="main-pane">
    <div class="content-wrapper">
      <div class="row">     
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
                <h3 class="font-weight-bold">Catalogue Management</h3>
                <h6 class="font-weight-normal">Categories</h6>
                <a href="{{ route('category.create') }}" class="btn btn-block btn-primary">Add Category</a>
                
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success :</strong> {{Session::get('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
              <div class="table-responsive pt-3">
                <table class="table table-bordered" id="categories">
                  <thead>
                    <tr>
                      <th>Category Id</th>
                      <th>Category Name</th>
                      <th>Parent Category</th>
                      <th>Section Nmae</th>
                      <th> URL </th>
                      <th> Status </th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($categories as $category)
                    @if (isset($category['parent_category']['category_name'])&&!empty($category['parent_category']['category_name']))
                       @php
                           $parent_category = $category['parent_category']['category_name'];
                       @endphp  
                    @else
                       @php
                            $parent_category = "root";
                       @endphp
                    @endif
                    <tr>
                        <td>{{ $category['id']}} </td>
                        <td>{{ $category['category_name']}} </td>
                        <td> {{ $parent_category }} </td>
                        <td>{{ $category['sections']['name']}} </td>
                        <td>{{ $category['url']}} </td>
                        <td>
                            @if ($category['status']==1)
                               <a class="updateCategoryStatus" 
                               href="javascript:void(0)"
                               id="category-{{$category['id']}}"
                               category_id="{{ $category['id']}}"
                               >
                               <i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>
                              </a>
                            @else
                              <a class="updateCategoryStatus" 
                               href="javascript:void(0)"
                               id="category-{{$category['id']}}"
                               category_id="{{ $category['id']}}"
                              >
                              <i style="font-size: 20px"  status="inactive" class="far fa-bookmark"></i> 
                              </a>
                            @endif
                         </td>
                        <td>
                            <a  href="{{ route('category.edit',$category['id']) }}"><i style="font-size: 20px" class="fas fa-user-edit"></i></a>
                            <a href="javascript:void(0)" class="confirmDelete" name="category" module="category" moduleid="{{ $category['id']}}"><i style="font-size: 20px; color:red" class="fas fa-trash-alt"></i></a>

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