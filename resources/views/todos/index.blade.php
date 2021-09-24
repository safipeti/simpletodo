@extends('layouts.app')

@section('content')
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
        @forelse($todos as $todo)
            <tr class="{{ $todo->done ? 'done-todo' : 'active-todo' }}">
                <td>{{ $todo->name }}</td>
                <td>{{ $todo->due }}</td>
                <td>{{ $todo->done ? 'Elvégezve' : 'Aktív' }}</td>
                <td><a href="{{ route('todos.edit', $todo->id)}}">Szerkesztés</a></td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No todos to show</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div>
        <a href="{{route('todos.create')}}">Új todo</a>
    </div>
@endsection
