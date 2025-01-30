<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css'])
    <title>{{ $product->name }}</title>
</head>
@include('layouts.nav')
<body>
<div class="container">
    <div class="detail">
        <div class="image">
            <img src="{{ asset('storage/products/' . $product->thumbnail) }}" alt="{{ $product->name }}"/>
        </div>
        <div class="productInfo">
            <h1 class="name">{{ $product->name }}</h1>
            <p class="price">Price: £{{ $product->price }}</p>
            <p class="description">{{ $product->description }}</p>
        </div>
    </div>
</div>

</body>
</html>
