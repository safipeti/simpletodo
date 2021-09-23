@extends('layouts.app')
@section('content')
    <h2>Új TODO hozzáadása</h2>
<form method="POST" action="{{ route('todos.store') }}" enctype='multipart/form-data'>
    {{ csrf_field() }}
    <div class="mb-3">
        <label for="name" class="form-label">TODO neve:</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Enter todo"
        value="{{old('name')}}"
        >
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">TODO leírása:</label>
        <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
    </div>
    <div class="mb-3">
        <label for="due" class="form-label">TODO határideje:</label>
        <input type="date" name="due" class="form-control" id="due" placeholder=""
        value="{{ old('due_date') }}"
        >
    </div>
    <div class="form-group">
        <label for="file">Fájl feltöltése</label>
        <input type="file" class="form-control-file" name="upload_file" id="file">
    </div>

    <button type="submit" class="btn btn-primary">Mentés</button>&nbsp; | &nbsp;
    <a href="{{route('todos.index')}}" class="align-items-end">Főoldalra</a>
</form>

@endsection
