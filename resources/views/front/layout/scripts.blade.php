<?php use App\Models\ProductFilter ; 
 $productFilter = ProductFilter::product_filters();
 //dd($productFilter)
?>
<script>
    $(document).ready(function(){
        //sort for filter
        $("#sort").on("change",function(){
        // this.form.submit();
        var sort = $("#sort").val();
        var url = $("#url").val();
        var color = get_filters('color');
        var size = get_filters('size');
        var price = get_filters('price');
        var brand = get_filters('brand');
        @foreach($productFilter as $filters)
                var {{ $filters['filter_column'] }} = get_filters('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:'post',
                url:url,
                data:{
                    @foreach($productFilter as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    sort:sort,url:url,color:color,size:size,price:price,brand:brand},
                success : function(data){
                $('.filter_products').html(data);
                },
                error : function(){
                    alert("error");
                }

            });
        });

        //brand filter
           $(".brand").on("change",function(){
        // this.form.submit();
        var sort = $("#sort").val();
        var url = $("#url").val();
        var color = get_filters('color');
        var size = get_filters('size');
        var price = get_filters('price');
        var brand = get_filters('brand');
        @foreach($productFilter as $filters)
                var {{ $filters['filter_column'] }} = get_filters('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:'post',
                url:url,
                data:{
                    @foreach($productFilter as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    sort:sort,url:url,color:color,size:size,price:price,brand:brand},
                success : function(data){
                $('.filter_products').html(data);
                },
                error : function(){
                    alert("error");
                }

            });
        });

        // price filter
        $(".price").on("change",function(){
        // this.form.submit();
        var sort = $("#sort").val();
        var url = $("#url").val();
        var color = get_filters('color');
        var size = get_filters('size');
        var price = get_filters('price');
        var brand = get_filters('brand');
        @foreach($productFilter as $filters)
                var {{ $filters['filter_column'] }} = get_filters('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:'post',
                url:url,
                data:{
                    @foreach($productFilter as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    sort:sort,url:url,color:color,size:size,price:price,brand:brand},
                success : function(data){
                $('.filter_products').html(data);
                },
                error : function(){
                    alert("error");
                }

            });
        });
        // sort for size
        $(".size").on("change",function(){
        // this.form.submit();
        var sort = $("#sort").val();
        var url = $("#url").val();
        var color = get_filters('color');
        var size = get_filters('size');
        var price = get_filters('price');
        var brand = get_filters('brand');
        @foreach($productFilter as $filters)
                var {{ $filters['filter_column'] }} = get_filters('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:'post',
                url:url,
                data:{
                    @foreach($productFilter as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    sort:sort,url:url,color:color,size:size,price:price,brand:brand},
                success : function(data){
                $('.filter_products').html(data);
                },
                error : function(){
                    alert("error");
                }

            });
        });

         //color filter
         $(".color").on("change",function(){
        // this.form.submit();
        var sort = $("#sort").val();
        var url = $("#url").val();
        var size = get_filters('size');
        var color = get_filters('color');
        var price = get_filters('price');
        var brand = get_filters('brand');
        @foreach($productFilter as $filters)
                var {{ $filters['filter_column'] }} = get_filters('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:'post',
                url:url,
                data:{
                    @foreach($productFilter as $filters)
                    {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                    @endforeach
                    sort:sort,url:url,color:color,size:size,price:price,brand:brand},
                success : function(data){
                $('.filter_products').html(data);
                },
                error : function(){
                    alert("error");
                }

            });
        });

    // dunamic filter
   @foreach($productFilter as $filter)
    $('.{{ $filter['filter_column'] }}').on("click",function(){
        var url = $("#url").val();
        var sort = $("#sort option:selected").val();
        var size = get_filters('size');
        var color = get_filters('color');
        var price = get_filters('price');
        var brand = get_filters('brand');
        @foreach($productFilter as $filters)
             var {{ $filters['filter_column'] }} = get_filters('{{ $filters['filter_column'] }}');
        @endforeach
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:'post',
            url:url,
            data:{
                @foreach($productFilter as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                @endforeach
                sort:sort,url:url,color:color,size:size,price:price,brand:brand},
            success : function(data){
            $('.filter_products').html(data);
            },
            error : function(){
                alert("error");
            }

        });
    });
    @endforeach
});
</script>