@extends('admin.layout.layout')
@section('body')
<div class="container-xxl">
      <div class="main-panel p-5">
          <div class="content-wrapper">
              <div class="row">
                  <div class="col-md-12 grid-margin">
                      <div class="row">
                          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                              <h3 class="font-weight-bold">Settings</h3>
                          </div>            
                      </div>
                  </div>
              </div>
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Update Admin Details </h4>
          
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

                            <form  action="javascript:;" method="POST" id="forgotForm">
                                @csrf 
                                <h4 class="account-h2 ">Forgot Password</h4>
                                <h4 class="account-h6 ">Welcome back! Sign in to your account.</h4>
                                <p id="forgot-error"></p>
                                <p id="forgot-success"></p>
                                <div class="u-s-m-b-30">
                                    <label for="user-email">Email
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="email" name="email" id="users-email" class="text-field" placeholder="Email">
                                    <p id="forgot-email"></p>
                                </div>
                                <div class="group-inline u-s-m-b-30">
                                    <div class="group-2 text-right">
                                        <div class="page-anchor">
                                            <a href="{{ url('admin/index') }}">
                                                <i class="fas fa-circle-o-notch u-s-m-r-9"></i>Back to Login</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-b-45">
                                    <button type="submit" class="button button-outline-secondary w-100">Submit</button>
                                </div>
                            </form>                     
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
</div>
@endsection
