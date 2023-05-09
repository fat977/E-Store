<?php use App\Models\Country ; ?>
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
            <!-- Login -->
            <div class="col-lg-6">
                <div class="login-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">Login</h2>
                    <h6 class="account-h6 u-s-m-b-30">Welcome back! Sign in to your account.</h6>
                    <form  action="javascript:;" method="POST" id="loginForm">
                        @csrf 
                        <p id="login-error"></p>
                        <div class="u-s-m-b-30">
                            <label for="user-email">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" name="email" id="users-email" class="text-field" placeholder="Email">
                            <p id="login-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-password">Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="password" id="users-password" class="text-field" placeholder="Password">
                            
                        </div>
                        <div class="group-inline u-s-m-b-30">
                            <div class="group-1">
                                <input type="checkbox" class="check-box" id="remember-me-token">
                                <label class="label-text" for="remember-me-token">Remember me</label>
                            </div>
                            <div class="group-2 text-right">
                                <div class="page-anchor">
                                    <a href="{{ url('user/forgot-password') }}">
                                        <i class="fas fa-circle-o-notch u-s-m-r-9"></i>Lost your password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-45">
                            <button class="button button-outline-secondary w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Login /- -->
            <!-- Register -->
            <div class="col-lg-6">
                <div class="reg-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">Register</h2>
                    <h6 class="account-h6 u-s-m-b-30">Registering for this site allows you to access your order status and history.</h6>
                    <p id="register-success"></p>
                    <form id="registerForm" method="POST" action="javascript:;">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="user_name">Name
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="user_name" name="name" class="text-field" placeholder="user Name">
                            <p id="register-name"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user_mobile">Mobile
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="user_mobile" name="mobile" class="text-field" placeholder="User Mobile">
                            <p id="register-mobile"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user_email">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" id="user_email" name="email" class="text-field" placeholder="User Email">
                            <p id="register-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user_password">Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="user_password" name="password" class="text-field" placeholder="User Password">
                            <p id="register-password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-address">Address
                                <span class="astk">*</span>
                            </label>
                            <input name="address" class="text-field" id="user-address"
                            name="address">
                            <p id="account-address"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-city">City
                                <span class="astk">*</span>
                            </label>
                            <input name="city" class="text-field" id="user-city"
                            name="city">
                            <p id="account-city"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-state">State
                                <span class="astk">*</span>
                            </label>
                            <input name="state" class="text-field" id="user-state"
                            name="state">
                            <p id="account-state"></p>
                        </div>

                       
                        <?php $countries = Country::countries();
                        ?>
                        <div class="u-s-m-b-30">
                            <label for="user-country">Country
                                <span class="astk">*</span>
                            </label>
                            <select name="country" id="user-country" class="text-field">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country['country_name'] }}" 
                                     @if ($country['country_name'])
                                    selected
                                    @endif>{{ $country['country_name'] }}</option>
                                @endforeach
                            </select>
                            <p id="account-country"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-pincode">Pincode
                                <span class="astk">*</span>
                            </label>
                            <input name="pincode" class="text-field" id="user-pincode"
                            name="pincode">
                            <p id="account-pincode"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <input type="checkbox" class="check-box" id="accept" name="accept">
                            <label class="label-text no-color" for="accept">I’ve read and accept the
                                <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                            </label>
                            <p id="register-accept"></p>
                        </div>
                        <div class="u-s-m-b-45">
                            <button class="button button-primary w-100">Register</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Register /- -->
        </div>
    </div>
</div>

<!-- Account-Page /- -->
@endsection