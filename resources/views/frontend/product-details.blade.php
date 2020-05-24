@extends('frontend.layouts.master')
@section('content')
<div class="container">
    <div class="row">
        
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="col-sm-4">
            <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%"
                    alt="Image"></div>
            <h2>{{ $product->product_name }}</h2>
            <p>{{ $product->description }}</p>
            <p><b>Kshs {{ number_format($product->price,2) }}</b></p>
        </div>
        <div class="col-sm-8">
            <form method="post" action="/add-to-cart">
                @csrf
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity',1) }}">

                    @if ($errors->has('quantity'))
                    <span style="color:red">
                        <strong>{{ $errors->first('quantity') }}</strong></span>
                    @endif
                </div>
                <!--Product ID-->
                <input type="hidden" class="form-control" id="product_id" name="product_id" value="{{ $product->id }}">
                <!--Price-->
                <input type="hidden" class="form-control" id="price" name="price" value="{{ $product->price }}">
                <button type="submit" class="btn btn-success">Add to cart</button>
            </form>
        </div>    
    </div>
</div>            
@endsection