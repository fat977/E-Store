<?php use App\Models\ProductFilter ; 
 $productFilter = ProductFilter::product_filters();
 //dd($productFilter)
 if(isset($product['category_id'])){
    $category_id = $product['category_id'];
 }
?>
@foreach ($productFilter as $filter)
@if (isset($category_id))
@php
$filterAvailable = ProductFilter::filterAvailable($filter['id'],$category_id);
@endphp
@if ($filterAvailable=="Yes")
<div class="form-group">
    <label for="{{ $filter['filter_column'] }}">Select {{ $filter['filter_name'] }}</label>
    <select name="{{ $filter['filter_column'] }}" id="{{ $filter['filter_column'] }}" class="form-control">
        <option value="">Select</option>
        @foreach ($filter['filter_values'] as $value)
            <option value="{{$value['filter_value']}}"
            @if (!empty($product[$filter['filter_column']]) && $value['filter_value']==$product[$filter['filter_column']])
                selected
            @endif
            >{{ ucwords($value['filter_value']) }}</option>
        @endforeach
    </select>
</div> 
@endif
@endif
@endforeach
