<?php

namespace App\Services;


use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TodoService
{
    private $uploadService;

    public function __construct()
    {
        $this->uploadService = new UploadService();
    }

    public function addTodo($data)
    {
        extract($data);

        $todo = new Todo();
        $todo->name = $name;
        $todo->description = $description;
        $todo->due = $due;


        $user = User::find($user_id);

        $todo = $user->todos()->save($todo);
        if(!empty($data['upload_file']))
        {
            $file = $this->uploadService->upload($data['upload_file']);

            $this->uploadService->addUpload($todo, $file);
        }



        return $todo;

    }

    public function loadTodos($active_nly, $filters = null)
    {
        $user = Auth::user();
        $q = 'select * from todos WHERE user_id = ' . Auth::id() ;
        if($active_nly)
        {
            $q .= ' AND done = 0 ';
        }
        if($filters)
        {
            $i = 0;
            $texts = explode(' ', $filters);
            $textsCount = count($texts);


            $search = '';

            foreach ($texts as $text)
            {

                if($textsCount -1 > $i)
                {
                    if(!$active_nly)
                    {
                        $search .= " AND (name like '%" . $text . "%' OR description like '%" . $text . "%') AND ";
                    }
                    else
                    {
                        $search .= " (name like '%" . $text . "%' OR description like '%" . $text . "%') AND ";
                    }


                }
                else
                {
                    if(!$active_nly)
                    {
                        $search .= " AND (name like '%" . $text . "%' OR description like '%" . $text . "%')  ";
                    }
                    else
                    {
                        $search .= " AND (name like '%" . $text . "%' OR description like '%" . $text . "%')  ";
                    }
                }

                $i++;
            }

            $q .= $search;

//            if($search != '')
//            {
//                $q .= $active_nly ? ' AND ' . $search :  " where " . $search;
//
//            }

            $q .= ' ORDER BY done DESC, due DESC';







        }
//dd($q);
        $todos = DB::select($q);

        return $todos;

        if($active_nly)
        {
            $todos = $user->todos()->where(['done'=> 0]);
        }

        return $todos->orderBy('done')->orderBy('due', 'DESC')->get();

    }

    public function loadTodo($id)
    {
        return Todo::where(['id' => $id, 'user_id' => Auth::id()])->first();
    }

    public function updateTodo(User $user, $data)
    {
        extract($data);

        $todo = $user->todos()->where('id', $id)->first();
        if(!$todo)
            return false;

        $todo->update([
           'name' => $name,
            'description' => $description,
            'due' => $due,
            'done' => !empty($done) ? 1 : 0
        ]);

        if(!empty($data['upload_file']))
        {
            $file = $this->uploadService->upload($data['upload_file']);

            $this->uploadService->addUpload($todo, $file);
        }

        return $todo;

    }

    public function delete(User $user, $id)
    {
        $todo = $user->todos()->where('id', $id)->first();

        if ($todo)
        {
            $todo->forceDelete();
            return true;
        }
        else
        {
            return false;
        }
    }

}
