@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Account</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="index.html">Home</a>
                </li>
                <li class="is-marked">
                    <a href="account.html">Account</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Account-Page -->
<div class="page-account u-s-p-t-80">
    <div class="container">
        @if (Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success :</strong> {{Session::get('success_message')}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        @if (Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error :</strong> {{Session::get('error_message')}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error :</strong> <?php echo implode('',$errors->all('<div>:message</div>')); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        <div class="row">
            <!-- Password -->
            <div class="col-lg-6">
                <div class="reg-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">Create New Password</h2>
                    
                    <form id="passwordForm" method="POST" action="{{ url('user/create-new-password') }}">
                        @csrf

                        <div class="u-s-m-b-30">
                            <label for="new-password">New Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="new-password" name="new_password" class="text-field">
                            
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="confirm-password">Confirm Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="confirm-password" name="confirm_password" class="text-field">

                        </div>
                        <div class="u-s-m-b-45">
                            <button class="button button-primary w-100">Create</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Password /- -->
        </div>
    </div>
</div>
<!-- Account-Page /- -->
@endsection