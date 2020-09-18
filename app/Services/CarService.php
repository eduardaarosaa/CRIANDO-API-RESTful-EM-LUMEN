<?php


namespace App\Services;

use App\Models\ValidationCars;
use App\Repositories\CarRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Symfony\Component\HttpFoundation\Response;

class CarService
{
    private $carRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*Usando injeção de dependecias*/
    public function __construct(CarRepositoryInterface $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function getAll()
    {
        $cars = $this->carRepository->getAll();

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
        $car = $this->carRepository->get($id);

        try{

            if(!empty($car)){
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

            //  Usando o validator
            ValidationCars::RULE_CAR

        );

        if($validator->fails()){

            return response()->json($validator->errors(), Response::HTTP_OK);
        }
        $car = $this->carRepository->store($request);

        try{

            return response()->json($car, Response::HTTP_CREATED);

        }catch(QueryException $exception){

            return response()->json(['error'=> 'Erro de conexão com o banco de dados', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }


    }

    public function update($id, Request $request)

    {
        $validator = FacadesValidator::make(
            $request->all(),
            ValidationCars::RULE_CAR
        );

        try{
            //é necessário carregar a linha que vai alterar para depois fazer a alteração
            $car = $this->carRepository->update($id, $request);

            return response()->json($car, Response::HTTP_OK); // retorna true se deu certo

        }catch(QueryException $exception){

            return response()->json(['error'=> 'Erro de conexão com o banco de dados', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

    }

    public function destroy($id)
    {


        try{
            $car = $this->carRepository->destroy($id);
            return response()->json(null, Response::HTTP_OK);

        }catch(QueryException $exception){

            return response()->json(['error'=> 'Erro de conexão com o banco de dados', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

}
