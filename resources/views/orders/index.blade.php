@php($helper = new \App\Helpers\Helper())
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row" id="basic-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ordenes del Cliente</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Cantidad de Articulos</th>
                                <th>Total a pagar</th>
                                <th>Estado de Orden</th>
                                <th>Fecha de Orden</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $orders as $order )
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td class="">{{ $helper->total_products_in_cart($order->cart_id) }}</td>
                                    <td class="">{{ $helper->total_products_in_cart($order->cart_id) }}</td>
                                    <td class="">
                                        <h4>
                                            <span class="badge rounded-pill {{ $status=$helper->get_status($order->status)->color }} me-1">
                                                {{ $status=$helper->get_status($order->status)->status }}</span>
                                        </h4>
                                    </td>
                                    <td>{{  date_format($order->created_at, 'd/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
