@extends('adminlte::page')
@section('title', 'Belajar Laravel')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{ url('/home') }}">Dashboard</a></li>
                <li><a href="{{ url('/products') }}">Produk</a></li>
                <li class="active">Tambah Produk</li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Tambah Produk</h2>
                </div>

                <div class="panel-body">
                    {!! Form::open(['url' => route('products.store'),
                    'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal']) !!}
                    @include('products._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection