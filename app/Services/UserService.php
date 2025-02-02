<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Iqbalatma\LaravelServiceRepo\BaseService;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;

class UserService extends BaseService
{
    protected $repository;

    public function __construct()
    {
         $this->repository = new UserRepository();
    }

    /**
     * @return array
     */
    public function getAllData(): array
    {
        return [
            "users" => User::query()->get()
        ];
    }


    /**
     * @param array $requestedData
     * @return true[]
     */
    public function addNewData(array $requestedData): array
    {
        try {
            $requestedData["password"] = Hash::make($requestedData["password"]);
            User::query()->create($requestedData);
            $response = [
                "success" => true,
            ];
        } catch (Exception $e) {
            $response = getDefaultErrorResponse($e);
        }

        return $response;
    }


    /**
     * @param string $id
     * @return array|true[]
     */
    public function getEditDataById(string $id): array
    {
        try {
            $this->checkData($id);

            $response = [
                "success" => true,
                "user" => $this->getServiceEntity()
            ];
        } catch (EmptyDataException $e) {
            $response = [
                "success" => false,
                "message" => $e->getMessage()
            ];
        } catch (Exception $e) {
            $response = getDefaultErrorResponse($e);

        }
        return $response;
    }


    /**
     * @param string|int $id
     * @param array $requestedData
     * @return array|true[]
     */
    public function updateDataById(string|int $id, array $requestedData): array
    {
        try {
            $this->checkData($id);
            $this->getServiceEntity()->fill($requestedData)->save();
            $response = [
                "success" => true,
            ];
        } catch (EmptyDataException $e) {
            $response = [
                "success" => false,
                "message" => $e->getMessage()
            ];
        } catch (Exception $e) {
            $response = getDefaultErrorResponse($e);

        }
        return $response;
    }
}
