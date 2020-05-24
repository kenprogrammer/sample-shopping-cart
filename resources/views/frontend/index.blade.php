@extends('frontend.layouts.master')
@section('content')

@php
    $counter = 0;
@endphp
@foreach($products as $product)
@if($counter % 3 == 0)
<div class="container">
    <div class="row"> 
@endif           
        <div class="col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading">{{ $product->product_name }}</div>
                <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive"
                        style="width:100%" alt="Image"></div>
                <div class="panel-footer"><a href="/add-to-cart/{{ $product->id }}" class="btn btn-success" role="button"><i class="fa fa-shopping-cart" aria-hidden="true">&nbsp;</i>Add to cart</a></div>
            </div>
        </div>
@if($counter % 3 == 2)             
    </div>
</div><br>
@endif
@php
    $counter += 1;
@endphp
@endforeach
</div><br><br>
@endsection