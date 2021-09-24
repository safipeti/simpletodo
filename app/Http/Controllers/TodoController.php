<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    private TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index(Request $request): View
    {
        $search = $request->get('search', '');

        return view('todos.index', [
            'todos' => $this->todoService->get($request->cookie('active_only', false), $search),
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('todos.create');
    }

    public function store(StoreTodoRequest $request): RedirectResponse
    {
        $this->todoService->create(['user_id' => Auth::id()] + $request->all());

        return redirect(route('todos.index'));
    }

    public function edit(int $id): View
    {
      return  view('todos.edit', [
          'todo' => $this->todoService->find($id)
      ]);
    }

    public function update(StoreTodoRequest $request, int $id): RedirectResponse
    {
        $todo = Todo::query()->findOrFail($id);
        $todo = $this->todoService->update($todo, $request->except('_token', '_method'));

        return redirect(route('todos.edit', $todo->id))->with('success', 'Sikeres módosítás.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->todoService->delete($id);

        return redirect()->route('todos.index')->with('success', 'Sikeres törlés');
    }

    public function setCookie(Request $request): RedirectResponse
    {
        return redirect()->route('todos.index')
            ->withCookie(cookie('active_only', !$request->cookie('active_only'), 1));
    }
}
