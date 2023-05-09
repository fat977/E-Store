<?php use App\Models\ProductFilter; ?>
@extends('admin.layout.layout')
@section('body')
<div class="main-pane">
    <div class="content-wrapper">
        <div class="row"> 
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h3 class="font-weight-bold">Catalogue Management</h3>
                    <h6 class="font-weight-normal">Filters Values</h6>

                    <a href="{{ route('filter.value.create') }}" class="btn btn-block btn-primary"
                    style="max-width: 150px; float: right; display:inline-block">Add Filter Values</a>

                    <a href="{{ route('filter.index') }}" class="btn btn-block btn-primary"
                    style="max-width: 150px; float: left; display:inline-block">Filters</a>

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
                                    Filter Id
                                </th>
                                <th>
                                    Filter Name
                                </th>
                                <th>
                                    Filter Value
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
                            @foreach ($filters_values as $filter)
                            <tr>
                                <td>{{ $filter['id']}} </td>
                                <td>{{ $filter['filter_id']}} </td>
                                <td>
                                <?php
                                    echo $getFilterName =ProductFilter::getFilterName($filter['filter_id']);
                                ?>
                                </td>
                                <td>{{ $filter['filter_value']}} </td>
                                <td>
                                    @if ($filter['status']==1)
                                    <a class="updateFilterValueStatus" 
                                    href="javascript:void(0)"
                                    id="filter-{{$filter['id']}}"
                                    filter_id="{{ $filter['id']}}"
                                    >
                                    <i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>
                                    </a>
                                    @else
                                    <a class="updateFilterValueStatus" 
                                    href="javascript:void(0)"
                                    id="filter-{{$filter['id']}}"
                                    filter_id="{{ $filter['id']}}"
                                    >
                                    <i style="font-size: 20px"  status="inactive" class="far fa-bookmark"></i> 
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    <a  href="{{ route('filter.value.edit',$filter['id']) }}"><i style="font-size: 20px" class="fas fa-user-edit"></i></a>
                                    <a href="javascript:void(0)" class="confirmDelete" name="filter" module="filter-value" moduleid="{{ $filter['id']}}"><i style="font-size: 20px; color:red" class="fas fa-trash-alt"></i></a>

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