{!! Form::model($categories, [
'route' => $categories->exists ? ['categories.update', $categories->id] : 'categories.store',
'method' => $categories->exists ? 'PUT' : 'POST'
]) !!}

<div class="form-group">
    <label for="" class="control-label">Nama</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Deskripsi</label>
    {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
</div>

{!! Form::close() !!}