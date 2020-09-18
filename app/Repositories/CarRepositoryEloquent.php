<?php


namespace App\Repositories;

use Iluminate\Http\Request;
use App\Models\Cars;


class CarRepositoryEloquent implements  CarRepositoryInterface
{
    private  $model;
    public function __construct(Cars $cars)
    {
        $this->model = $cars;
    }
    public function getAll()
    {
        // TODO: Implement getAll() method.
        return $this->model->all();
    }

    public function get($id)
    {
        return $this->model->find($id);
    }
    public function store($request)
    {
        // TODO: Implement store() method.
        return $this->model->create($request->All());
    }
    public function update($id,$request)
    {
        // TODO: Implement update() method.
        return $this->model->find($id)
            ->update($request->all());
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.

        return $this->model->find($id)
            ->delete();

    }
}
