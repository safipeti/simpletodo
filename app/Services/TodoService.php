<?php

namespace App\Services;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TodoService
{
    private UploadService $uploadService;

    public function __construct()
    {
        $this->uploadService = new UploadService();
    }

    public function create(array $data): Model
    {
        /** @var Todo $todo */
        $todo = Todo::query()->make($data);

        User::query()->find($data['user_id'])->todos()->save($todo);

        $this->save($todo, $data);

        return $todo;
    }

    public function get(bool $isActive, string $search): Collection
    {
        $todoQuery = Todo::query()
            ->where('user_id', '=', Auth::id())
            ->orderBy('done')
            ->orderBy('due', 'desc')
            ;

        if($isActive) {
            $todoQuery->where('done', '=', 0);
        }

        if ($search) {
            $texts = explode(' ', $search);

            $todoQuery->where(function (Builder $where) use ($texts) {
                foreach ($texts as $text) {
                    $where->orWhereRaw(sprintf("name LIKE '%%%s%%' OR description LIKE '%%%s%%'", $text, $text));
                }
            });
        }

        return $todoQuery->get();
    }

    public function find(int $id): Model
    {
        return Todo::query()->with('uploadedFiles')->findOrFail($id);
    }

    public function update(Todo $todo, array $data): Model
    {
        $data['done'] = empty($data['done']) ? 0 : 1;
        $todo->update($data);

        $this->save($todo, $data);

        return $todo;
    }

    private function save(Todo $todo, array $data): void
    {
        if(!empty($data['upload_file']))
        {
            $file = $this->uploadService->upload($data['upload_file']);

            $this->uploadService->addUpload($todo, $file);
        }
    }

    public function delete(int $id): void
    {
        $todo = Todo::query()->find($id);

        if ($todo) {
            $todo->forceDelete();
        }
    }
}
