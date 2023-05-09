@extends('admin.auth.layouts.app')

@section('content')
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                            </a>
                            <h3>Sign In</h3>
                        </div>

                       <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error :</strong><?php echo Session::get('error_message') ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                          </div>
                          <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                          </div>
                          <div class="mt-3">
                            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                        </div>
                          <div class="my-2 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                              <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input">
                                Keep me signed in
                              </label>
                            </div>
                            <a href="{{ url('admin/forgot-password-view') }}" class="auth-link text-black">Forgot password?</a>
                          </div>
                          <div class="mb-2">
                            <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                              <i class="ti-facebook mr-2"></i>Connect using facebook
                            </button>
                          </div>
                          <div class="text-center mt-4 font-weight-light">
                            Don't have an account? <a href="register.html" class="text-primary">Create</a>
                          </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>
@endsection
 