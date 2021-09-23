@extends('layouts.app')
@section('content')
    <h2>TODO szerkesztése</h2>
<form method="POST" action="{{ route('todos.update', $todo->id) }}" enctype='multipart/form-data'>
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mb-3">
        <label for="name" class="form-label">TODO neve:</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Enter todo"
        value="{{!empty(old('name')) ? old('name') : $todo->name}}"
        >
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">TODO leírása:</label>
        <textarea class="form-control" name="description" id="description" rows="3">{{ !empty(old('description')) ? old('description') : $todo->description }}</textarea>
    </div>
    <div class="mb-3">
        <label for="due" class="form-label">TODO határideje:</label>
        <input type="date" name="due" class="form-control" id="due" placeholder=""
        value="{{ !empty(old('due')) ? old('due') : $todo->due }}"
        >
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox"  id="done" value="1" name="done" {{ ( !empty(old('done')) OR $todo->done == 1 ) ? 'checked' : '' }} >
        <label class="form-check-label" for="done">
            Elkészült
        </label>
    </div>
    <div class="form-group">
        <label for="file">Example file input</label>
        <input type="file" class="form-control-file" name="upload_file" id="file">
    </div>
    @if($todo->uploadedFiles->count() > 0)
        <h2>Feltöltött fájlok:</h2>
        <ul class="list-group">
            @foreach($todo->uploadedFiles as $file)
                <li class="list-group-item"><a href="{{ route('fileHandler.download', ['file_name' => $file->filename]) }}">{{ $file->orig_filename }}</a></li>
            @endforeach

        </ul>
    @endif


    <button type="submit" class="btn btn-primary">Mentés</button>
    <a href="{{ route('todos.destroy', $todo->id) }}">Törlés</a>&nbsp; | &nbsp;
    <a href="{{route('todos.index')}}" class="align-items-end">Főoldalra</a>
</form>

@endsection
