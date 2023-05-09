<?php use App\Models\Book ; ?>
@extends('front.layout.layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="javascript:;">Edit Review</a>
                </li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p><b>Write Your Review for {{ $existing_rating['product']['product_name'] }}</b></p>
                            <form action="{{ url('update-review') }}" method="POST">
                                @csrf
                                <input type="hidden" name="review_id" value="{{ $existing_rating['id'] }}">                               
                                <textarea name="user_review" >{{ $existing_rating->user_review }}</textarea>                             
                                <div class="rating-css">
                                    <div class="star-icon">
                                        @if ($existing_rating)
                                            @for ($i = 1; $i <= $existing_rating->stars_rated; $i++)
                                                <input type="radio" value="{{ $i }}" name="product_rating" checked id="rating{{ $i }}">
                                                <label for="rating{{ $i }}" class="fa fa-star checked"></label>
                                            @endfor
                                            @for ($j = $existing_rating->stars_rated+1 ; $j <= 5; $j++)
                                                <input type="radio" value="{{ $j }}" name="product_rating" id="rating{{ $j }}">
                                                <label for="rating{{ $j }}" class="fa fa-star not-checked"></label>
                                            @endfor
                                        @else
                                            <input type="radio" value="1" name="product_rating" checked id="rating1">
                                            <label for="rating1" class="fa fa-star"></label>
                                            <input type="radio" value="2" name="product_rating" id="rating2">
                                            <label for="rating2" class="fa fa-star"></label>
                                            <input type="radio" value="3" name="product_rating" id="rating3">
                                            <label for="rating3" class="fa fa-star"></label>
                                            <input type="radio" value="4" name="product_rating" id="rating4">
                                            <label for="rating4" class="fa fa-star"></label>
                                            <input type="radio" value="5" name="product_rating" id="rating5">
                                            <label for="rating5" class="fa fa-star"></label>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <button style="margin-top: 1px" type="submit" class="btn btn-default">
                                    Update Review
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--/#cart_items-->


@endsection