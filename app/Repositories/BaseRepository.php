<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    public Model $model;


    /**
     * BaseService constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @param array $attributes
     *
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        return $this->model->query()
            ->where('id', $id)
            ->update($attributes);
    }


    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->query()->create($attributes);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): mixed
    {
        return $this->model->query()->where('id', $id)->delete();
    }

    /**
     * @return array
     */
    protected function getColumnsOfTable(): array
    {
        $table = $this->model->getTable();
        return Schema::getColumnListing($table);
    }

    /**
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function index(Request $request, int $perPage): LengthAwarePaginator
    {
        $columns = $this->getColumnsOfTable();
        return $this->model->query()
            ->paginate($perPage, '*', '', $request->get('page'));
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function show(int $id): ?Model
    {
        return $this->model->query()->where('id', $id)->firstOrFail();
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Model|null
     */
    public function updateAndFetch(int $id, array $attributes): ?Model
    {
        if ($this->update($id, $attributes)) {
            return $this->find($id);
        }

        return null;
    }

    public function getAll(array $attributes)
    {
        $repository = $this->model->query();
        foreach ($attributes as $key => $attribute) {
            $repository = $repository->where($key, $attribute);
        }
        $repository->get();
    }
}
