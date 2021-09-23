@extends('layouts.app')

@section('content')
    @if(count($todos) > 0 OR (count($todos) == 0 AND isset($_GET['search'])) )
        @include('inc.search')
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">TODO neve</th>
            <th scope="col">Lejárat</th>
            <th scope="col">Elvégezve</th>
            <th scope="col">Szerkesztés</th>
        </tr>
        </thead>
        <tbody>
        @foreach($todos as $todo)
        <tr class="{{ $todo->done == 1 ? 'done-todo' : 'active-todo' }}">
            <td>{{ $todo->name }}</td>
            <td>{{ $todo->due }}</td>
            <td>{{ $todo->done == 1 ? 'Elvégezve' : 'Aktív' }}</td>
            <td><a href="{{ route('todos.edit', $todo->id)}}">Szerkesztés</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else

        <div>
            <p>No todos to show</p>

        </div>

    @endif
    <div>
        <a href="{{route('todos.create')}}">Új todo</a>
    </div>
@endsection
