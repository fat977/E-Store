@extends('admin.layout.layout') 
@section('body')
<div class="main-pane">
    <div class="content-wrapper">
        <div class="row">
        
            <div class="col-lg-12 grid-margin stretch-card">
            <div class="card p-5">
                <div class="card-body">
                <h4 class="font-weight-bold">Orders History</h4>
                <a href="{{url('admin/orders')}}" class="btn btn-block btn-warning">New Orders</a>
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success :</strong> {{Session::get('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif
                <div class="table-responsive pt-3">
                    <table class="table table-bordered" id="orders">
                    <thead>
                        <th class="image">Order Data</th>
                        <th class="image">Tracking No</th>
                        <th class="price">Total Price</th>
                        <th class="price">Status</th>
                        <th class="total">Action</th>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ date('d-m-Y',strtotime($item->created_at)) }}</td>
                                <td>{{ $item['tracking_no'] }}</td>
                                <td>{{ $item['total_price'] }}</td>
                                <td>{{ $item['status']=='0' ? 'pending' : 'completed' }}</td>
                                <td><a href="{{ url('admin/order/view-orders/'.$item['id']) }}" class="btn btn-primary">View</a></td>
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