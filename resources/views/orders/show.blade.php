@extends('layouts.app',['cart_qty' => $cart_qty])
@section('styles')
@endsection
@section('content')
    <div class="container">
        <div class="row" id="basic-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Resumen de Orden No. {{ $order->id }}
                            <span class="badge rounded-pill {{ $status->color }} me-1">{{ $status->status }}</span></h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{ debug($products_info) }}
                            @foreach( $products_info  as $product )
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $product->name }}</span>
                                    </td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        {{ $product->quantity }}
                                    </td>
                                    <td>
                                        ${{ number_format($product->price,'2','.','') }}
                                    </td>
                                    <td>
                                        ${{ number_format($product->total,'2','.','') }}
                                    </td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td colspan="4" class="text-end">
                                        <span class="fw-bold">
                                            Subtotal
                                        </span>
                                    </td>
                                    <td>
                                        ${{ number_format($order->total,'2','.','') }}
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">
                                        <span class="fw-bold">
                                            Total
                                        </span>
                                    </td>
                                    <td>
                                        ${{ number_format($order->total,'2','.','') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if( $status->status == 'Pendiente' )
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ $order->url_process }}" class="btn btn-primary me-1 mb-1">Continuar Pago</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
