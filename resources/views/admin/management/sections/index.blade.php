@extends('admin.layout.layout')
@section('body')
    <div class="content-wrapper">
        <div class="main-pane">
            <div class="row">    
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bold">Catalogue Management</h3>
                            <h6 class="font-weight-normal">Sections</h6>
                            <a href="{{ route('section.create') }}" class="btn btn-block btn-primary">Add Section</a>
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success :</strong> {{Session::get('success')}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="table-responsive pt-3">
                                <table class="table table-bordered" id="sections">
                                <thead>
                                    <tr>
                                    <th>
                                        Section Id
                                    </th>
                                    <th>
                                        Name
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
                                    @foreach ($sections as $section)
                                    <tr>
                                        <td>{{ $section['id']}} </td>
                                        <td>{{ $section['name']}} </td>
                                        <td>
                                            @if ($section['status']==1)
                                            <a class="updateSectionStatus" 
                                            href="javascript:void(0)"
                                            id="section-{{$section['id']}}"
                                            section_id="{{ $section['id']}}"
                                            >
                                            <i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>
                                            </a>
                                            @else
                                            <a class="updateSectionStatus" 
                                            href="javascript:void(0)"
                                            id="section-{{$section['id']}}"
                                            section_id="{{ $section['id']}}"
                                            >
                                            <i style="font-size: 20px"  status="inactive" class="far fa-bookmark"></i>  
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a  href="{{ route('section.edit',$section['id']) }}"><i style="font-size: 20px" class="fas fa-user-edit"></i></a>
                                            <a href="javascript:void(0)" name="section" class="confirmDelete" module="section" moduleid="{{ $section['id']}}"><i style="font-size: 20px; color:red" class="fas fa-trash-alt"></i></a>
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