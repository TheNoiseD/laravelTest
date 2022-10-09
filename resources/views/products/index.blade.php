@extends('layouts.app',['cart_qty' => $cart_qty])
@section('styles')
    @vite(['resources/css/products.css'])
@endsection
@section('content')
    <div class="app-content content ecommerce-application">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-detached content-right">
                <div class="content-body">
                    <section id="ecommerce-products" class="grid-view">
                        @foreach($products as $product)
                            <div class="card ecommerce-card">
                                <div class="item-img text-center justify-content-around">
                                        <img
                                            class="img-fluid card-img-top"
                                            src="{{ $product->image }}"
                                            alt="img-placeholder"
                                        />
                                </div>
                                <div class="card-body">
                                    <div class="item-wrapper justify-content-md-end">
                                        <div class="">
                                            <h6 class="item-price">${{ $product->price }}</h6>
                                        </div>
                                    </div>
                                    <h6 class="item-name">
                                        <a class="text-body" href="#">
                                            {{ $product->name }}
                                        </a>
                                        <span class="card-text item-company">
                                            By <a href="#" class="company-name">{{ $product->brand }}</a>
                                        </span>
                                    </h6>
                                    <p class="card-text item-description">
                                        <span>{{ $product->description }}</span>
                                    </p>
                                </div>
                                <div class="item-options text-center">
                                    <a href="#" class="btn btn-light btn-wishlist">
                                        <span>Lista de Deseos</span>
                                    </a>
                                    <a
                                        href="javascript:void(0)"
                                        data-product-id="{{ $product->id }}"
                                        class="btn btn-primary btn-cart add-to-cart"
                                    >
                                        <i data-feather="shopping-cart"></i>
                                        <span class="">Añadir al carrito</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/products.js'])
@endsection
