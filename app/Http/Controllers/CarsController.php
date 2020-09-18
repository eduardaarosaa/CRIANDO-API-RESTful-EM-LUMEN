<?php

namespace App\Http\Controllers;

use Iluminate\Support\Facades\Validator;
use Illuminate\Http\Request as Request;
use App\Models\Cars;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator as FacadesValidator;
/*Retornar os status code da requisição */
use Symfony\Component\HttpFoundation\Response;


class CarsController extends Controller
{
    private $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*Usando injeção de dependecias*/
    public function __construct(Cars $cars)
    {
        $this->model = $cars;
    }

    public function getAll()
    {
       $cars = $this->model->all();

       try{

        if(count($cars)> 0){
            return response()->json($cars, Response::HTTP_OK);

             }else{

            return response()->json(['Nenhum registro encontrado'], Response::HTTP_OK);
           }
        }catch(QueryException $exception){

            return response()->json(['error'=> 'Erro de conexão com o banco de dados', Response::HTTP_INTERNAL_SERVER_ERROR]);

       }



    }

    public function get($id)
    {
        $car = $this->model->find($id);

        try{

            if(count($car)> 0){
                return response()->json($car, Response::HTTP_OK);

                 }else{

                return response()->json(null, Response::HTTP_OK);
               }

        }catch(QueryException $exception){

            return response()->json(['error'=> 'Erro de conexão com o banco de dados', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }



    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make(
            $request->all(),
            [
                'name' => 'required | max:80',
                'description'=> 'required',
                'model' => 'required | max: 10 | min:2',
                'date' => 'required | date_format: "Y-m-d"'
            ]

        );

        if($validator->fails()){

            return response()->json($validator->errors(), Response::HTTP_OK);
        }
        $car = $this->model->create($request->all());

        try{

            return response()->json($car, Response::HTTP_CREATED);

        }catch(QueryException $exception){

            return response()->json(['error'=> 'Erro de conexão com o banco de dados', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }


    }

    public function update($id, Request $request)
    {
        //é necessário carregar a linha que vai alterar para depois fazer a alteração
        $car = $this->model->find($id)
            ->update($request->all()); //atualiza

            try{

                return response()->json($car, Response::HTTP_OK); // retorna true se deu certo

            }catch(QueryException $exception){

                return response()->json(['error'=> 'Erro de conexão com o banco de dados', Response::HTTP_INTERNAL_SERVER_ERROR]);
            }

    }

    public function destroy($id)
    {
        $car = $this->model->find($id)
            ->delete();
        try{
            return response()->json(null, Response::HTTP_OK);

        }catch(QueryException $exception){

            return response()->json(['error'=> 'Erro de conexão com o banco de dados', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }
}
