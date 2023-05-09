<?php use App\Models\Category; ?>
@extends('admin.layout.layout')
@section('body')
<div class="main-pane">
    <div class="content-wrapper">
        <div class="row">      
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-weight-bold">Catalogue Management</h3>
                        <h6 class="font-weight-normal">Filters</h6>

                        <a href="{{ url('admin/filter/add-edit-filter') }}" class="btn btn-block btn-primary"
                        style="max-width: 150px; float: right; display:inline-block">Add Filter</a>

                        <a href="{{ route('filter.value.index') }}" class="btn btn-block btn-primary"
                        style="max-width: 150px; float: left; display:inline-block">Filter Values</a>

                        <br><br><br><br>
                        @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success :</strong> {{Session::get('success')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="filters">
                            <thead>
                                <tr>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Filter Name
                                </th>
                                <th>
                                    Filter Column
                                </th>
                                <th>
                                    Categories
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Action
                                </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filters as $filter)
                                <tr>
                                    <td>{{ $filter['id']}} </td>
                                    <td>{{ $filter['filter_name']}} </td>
                                    <td>{{ $filter['filter_column']}} </td>
                                    <td>
                                        <?php
                                            $catIds = explode(",",$filter['cat_ids']);
                                            foreach($catIds as $key => $catId){
                                                $category_name = Category::getCategoryName($catId);
                                                echo $category_name. "-";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        @if ($filter['status']==1)
                                        <a class="updateFilterStatus" 
                                        href="javascript:void(0)"
                                        id="filter-{{$filter['id']}}"
                                        filter_id="{{ $filter['id']}}"
                                        >
                                        <i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>
                                        </a>
                                        @else
                                        <a class="updateFilterStatus" 
                                        href="javascript:void(0)"
                                        id="filter-{{$filter['id']}}"
                                        filter_id="{{ $filter['id']}}"
                                        >
                                        <i style="font-size: 20px"  status="inactive" class="far fa-bookmark"></i> 
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a  href="{{ url('admin/filter/add-edit-filter/'.$filter['id']) }}"><i style="font-size: 20px" class="fas fa-user-edit"></i></a>
                                        <a href="javascript:void(0)" class="confirmDelete" name="filter" module="filter" moduleid="{{ $filter['id']}}"><i style="font-size: 20px; color:red" class="fas fa-trash-alt"></i></a>
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