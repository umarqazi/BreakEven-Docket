<?php

namespace App\Repository;
/**
 * Class BaseRepo
 * @package App\Repository
 */
abstract class BaseRepo implements IRepo {

    /**
     * @var object
     */
    protected $model;

    /**
     * BaseRepo constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = new $model;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Count All Records
     *
     * @return mixed
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * @param int $paginate
     *
     * @return mixed
     */
    public function paginate(int $paginate)
    {
        return $this->model->all();//paginate($paginate);
    }

    /**
     * @param array $data
     * @return object
     */
    public function create(array $data): object
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * @param int $id
     * @return object
     */
    public function edit(int $id): object
    {
        return $this->model->where('id', $id);
    }

    /**
     * @param int $id
     * @return object
     */
    public function findById(int $id): object
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $clause
     * @return mixed
     */
    public function findByClause(array $clause)
    {
        return $this->model->where($clause);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    /**
     * @param array $clause
     * @param array $data
     * @return bool
     */
    public function updateByClause(array $clause, array $data): bool
    {
        return $this->model->where($clause)->update($data);
    }

    /**
     * @param array $ids
     * @param array $data
     * @return bool
     */
    public function updateMultipleRows(array $ids, array $data): bool
    {
        return $this->model->whereIn('id', $ids)->update($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * @param array $clause
     * @return bool
     */
    public function deleteByClause(array $clause): bool
    {
        return $this->model->where($clause)->delete();
    }

    /**
     * @return object
     */
    public function model(): object
    {
        return $this->model;
    }

    /**
     * @return object
     */
    public function query(): object
    {
        return $this->model->query();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function editTrashed($id)
    {
        return $this->model->onlyTrashed()->where('id', $id);
    }

    /**
     * WhereIn
     *
     * @param $clause
     * @return mixed
     */
    public function findbyClauseMultiple($clause)
    {
        return $this->model->whereIn($clause);
    }
    
    /**
     * @param int $id
     * @return object
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }
}
