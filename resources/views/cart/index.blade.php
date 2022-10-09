@extends('layouts.app',['cart_qty' => $cart_qty])
@section('styles')
    @vite(['resources/css/products.css'])
@endsection
@section('content')
    <div class="app-content content container ecommerce-application">
        <div id="place-order" class="list-view product-checkout">
            <div class="checkout-items">
                @foreach($products_info as $product)
                <div class="card ecommerce-card">
                    <div class="item-img">
                        <img src="{{ $product->image }}" alt="img-placeholder">
                    </div>
                    <div class="card-body">
                        <div class="item-name">
                            <h6 class="mb-0">
                                <a href="#">
                                    {{ $product->name }}
                                </a>
                            </h6>
                        </div>
                        @if( $product->stock > 0)
                            <span class="text-success mb-1">
                                Disponible
                            </span>
                        @else
                            <span class="text-danger mb-1">
                                No disponible
                            </span>
                        @endif
                        <div class="item-quantity">
                            <span class="quantity-title">Qty: &nbsp;</span>
                            <div class='form-group'>
                                    <input
                                        type="number"
                                        min="0"
                                        name="qty"
                                        data-product-id="{{ $product->id }}"
                                        class="quantity-counter form-control"
                                        onchange="updateCartQty(this, {{ $product->cart_product_id }})"
                                        value="{{ $product->quantity }}"
                                    />
                            </div>
                        </div>
                    </div>
                    <div class="item-options text-center">
                        <div class="item-wrapper">
                            <div class="item-cost">
                                <h4 class="item-price price">
                                    ${{ number_format($product->total,'2','.','') }}
                                </h4>
                            </div>
                        </div>
                        <button type="button"
                                onclick="deleteProductFromCart({{ $product->cart_product_id }})"
                                class="btn btn-danger mt-1 remove-wishlist waves-effect waves-float waves-light">
                            <span>Eliminar</span>
                        </button>
                        <button type="button"
                                class="btn btn-success btn-cart move-cart waves-effect waves-float waves-light">
                            <span class="text-truncate">Lista de deseos</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="checkout-options">
                <div class="card">
                    <div class="card-body">
                        <div class="price-details">
                            <h6 class="price-title">Detalle de compra</h6>
                            <ul class="list-unstyled">
                                <li class="price-detail">
                                    <div class="detail-title">Sub-Total</div>
                                    <div class="detail-amt price">
                                        ${{ number_format($total,'2','.','') }}
                                    </div>
                                </li>
                            </ul>
                            <hr>
                            <ul class="list-unstyled">
                                <li class="price-detail">
                                    <div class="detail-title detail-total">Total</div>
                                    <div class="detail-amt fw-bolder price">
                                        ${{ number_format($total,'2','.','') }}
                                    </div>
                                </li>
                            </ul>
                            <button type="button" {{$products_info ? '' : 'disabled'}}
                                    onclick="placeOrder({{ $cart->id }})"
                                    class="btn btn-primary w-100 btn-next place-order waves-effect waves-float waves-light">
                                Crear Orden
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function updateCartQty(input, id) {
            let product_id = $(input).data('product-id');
            axios.put('/cart/' + id, {
                qty: input.value,
                product_id: product_id
            })
                .then(function (response) {
                    // handle success
                    console.log(response);
                    window.location.href = '/cart';
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        }
        function deleteProductFromCart(id) {
            axios.delete('/cart/' + id,)
                .then(function (response) {
                    // handle success
                    console.log(response);
                    window.location.href = '/cart';
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        }
        function placeOrder(id) {
            axios.post('/orders',{
                cart_id: id
            })
                .then(function (response) {
                    let url = response.data.processUrl;
                    console.log(response);
                    window.location.href = url;
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    </script>
@endsection
