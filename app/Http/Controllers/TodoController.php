<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class TodoController extends Controller
{

    /**
     * @var TodoService
     */
    private $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->middleware('auth');
        $this->todoService = $todoService;
    }


    public function index()
    {
        $active_only = isset($_COOKIE['active_only']) ? $_COOKIE['active_only'] : false;

        $filters = isset($_GET['search']) ? $_GET['search'] : null;

        $todos = $this->todoService->loadTodos($active_only, $filters);
        return view('todos.index', ['todos' => $todos]);
    }


    public function create()
    {
        return view('todos.create');
    }


    public function store(StoreTodoRequest $request)
    {

        $todo = $this->todoService->addTodo(array_merge(['user_id' => Auth::id()], $request->all()));


        return redirect(route('todos.index'));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
      $todo = $this->todoService->loadTodo($id);


      if(!$todo)
          return redirect(route('todos.index'))->with('error', 'Ilyen feladat nincs');

      return  view('todos.edit', ['todo' => $todo]);

    }


    public function update(StoreTodoRequest $request, $id)
    {
        $todo = $this->todoService->updateTodo(Auth::user(), array_merge(['id' => $id], $request->all()));

        return redirect(route('todos.edit', $todo->id))->with('success', 'Sikeres módosítás.');
    }


    public function destroy($id)
    {
        if($this->todoService->delete(Auth::user(), $id))
        {
            return redirect()->route('todos.index')->with('success', 'Sikeres törlés');
        }
        else
        {
            return redirect()->route('todos.index')->with('error', 'Sikertelen törlés');
        }
    }
}
