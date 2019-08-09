@extends('adminlte::page')
@section('title', "ChocoBun's")

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12">
			<ul class="breadcrumb">
				<li><a href="{{ url('/home') }}">Dashboard</a></li>
				<li class="active">Kategori</li>
			</ul>
			<!-- {{ route('categories.create') }}{{ url('/pdf/categories') }} -->
			<p>
				<a href="" class="btn btn-primary modal-show">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah </a>
				<a class="btn btn-success" href="">
					<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print </a>
			</p>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Kategori</h2>
				</div>
				<div class="panel-body">
					<table id="datatable" class="table table-hover" style="width:100%">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Deskripsi</th>
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
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: "{{ route('table.categories') }}",
		columns: [{
				data: 'DT_RowIndex',
				name: 'id'
			},
			{
				data: 'name',
				name: 'name'
			},
			{
				data: 'description',
				name: 'description'
			},
			{
				data: 'action',
				name: 'action'
			}
		]
	});
</script>
@endpush