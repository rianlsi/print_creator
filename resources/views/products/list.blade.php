<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css'])
    <title>Product List</title>
</head>
@include('layouts.nav')
<body>

<div class="header">
    <h1>All Products</h1>
</div>
<div class="container">
    <div class="listProduct">
        @foreach($products as $product)

                <a href="{{route('product.detail', ['id' => $product->id])}}" class="item">
                    <img src="{{ asset('storage/products/' . $product->thumbnail) }}" alt="{{ $product->name }}"/>
                    <h2>{{$product->name}}</h2>
                    <p>£{{$product->price}}</p>
                </a>

        @endforeach
    </div>
</div>
</body>
</html>
