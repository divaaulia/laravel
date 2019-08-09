@extends('adminlte::page')
@section('title', 'Belajar Laravel')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{ url('/home') }}">Dashboard</a></li>
                <li><a href="{{ url('/products') }}">Produk</a></li>
                <li class="active">Ubah Produk</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Ubah Produk</h2>
                </div>

                <div class="panel-body">
                    {!! Form::model($products,['url' => route('products.update', $products->id),
                    'method' => 'put', 'files'=>'true', 'class'=>'form-horizontal')] !!}
                    @include('products._formedit')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection