@extends('backend.layouts.app')

@section('content')
<div class="container">
<div class="box box-primary">
    <a href="/home">Go Home</a>
    <div class="box-header with-border">
        <h3 class="box-title">Add Product</h3
    </div><!-- /.box-header -->
    <form role="form" method="post" id="form" name="form" action="/products">
        @csrf
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td>
                        <div class="form-group">
                            <label>Product Name:</label>
                            <input type="text" id="product_name" name="product_name" class="form-control" value="{{ old('product_name') }}">

                            @if ($errors->has('product_name'))
                            <span style="color:red">
                                <strong>{{ $errors->first('product_name') }}</strong></span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label>Description:</label>
                            <input type="text" id="description" name="description" class="form-control" value="{{ old('description') }}">

                            @if ($errors->has('description'))
                            <span style="color:red">
                                <strong>{{ $errors->first('description') }}</strong></span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label>Price:</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}">

                            @if ($errors->has('price'))
                            <span style="color:red">
                                <strong>{{ $errors->first('price') }}</strong></span>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box-footer">
            <button type="submit" id="submit" name="submit" class="btn btn-success">Save</button>
        </div>
    </form>
</div>
</div>
@endsection