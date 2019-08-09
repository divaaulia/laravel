@extends('adminlte::page')
@section('title', 'Belajar Laravel')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{ url('/home') }}">Dashboard</a></li>
                <li class="active">Produk</li>
            </ul>
            <p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah </a>
                <a class="btn btn-success" href="{{ url('/pdf/products') }}">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print </a>
            </p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Produk</h2>
                </div>
                <div class="panel-body">
                    <table id="datatable" class="display nowrap table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Foto</th>
                                <th>Kategori</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#datatable').DataTable({
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('table.products') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'id'
            },
            {
                data: 'code',
                name: 'code'
            },
            {
                data: 'name',
                name: 'name',
                width: "20%",
            },
            {
                data: 'stock',
                name: 'stock'
            },
            {
                data: 'price',
                name: 'price',
                width: "20%",
                render: $.fn.dataTable.render.number('.', ',', 0, 'Rp. ')
            },
            {
                data: 'photo',
                name: 'photo',
                width: "15%",
                "render": function(data, type, row) {
                    return '<img src="images/' + data + '" style="height:75px;width:100px;" />';
                }
            },
            {
                data: 'categories.name',
                name: 'categories.name',
                width: "10%",
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });
</script>
@endpush