<?php

namespace App\Contracts\Abstracts;

use App\Exceptions\EntityStillInUseException;
use Exception;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\DeletableRelationCheck;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;

abstract class BaseService extends \Iqbalatma\LaravelServiceRepo\BaseService
{
    /**
     * @param string|int $id
     * @param array $requestedData
     * @return true[]
     */
    public function updateDataById(string|int $id, array $requestedData):array
    {
        try{
            $this->checkData($id);

            $this->getServiceEntity()
                ->fill($requestedData)
                ->save();
            $response = [
                "success" => true
            ];
        }catch(EmptyDataException $e){
            $response = $e->getMessage();
        }catch(Exception $e){
            $response = getDefaultErrorResponse($e);
        }

        return $response;
    }


    /**
     * @param array $requestedData
     * @return true[]
     */
    public function addNewData(array $requestedData): array
    {
        try {
            $this->repository->addNewData($requestedData);
            $response = [
                "success" => true
            ];
        } catch (Exception $e) {
            $response = getDefaultErrorResponse($e);
        }

        return $response;
    }


    /**
     * @param string|int $id
     * @return true[]
     */
    public function deleteDataById(string|int $id): array
    {
        try {
            $response = [
                "success" => true
            ];
            $this->checkData($id);

            /** @var DeletableRelationCheck $entity */
            $entity = $this->getServiceEntity();

            $this->checkIsEligibleToDelete($entity);

            $entity->delete();
        } catch (EntityStillInUseException|EmptyDataException $e) {
            $response = [
                "success" => false,
                "message" => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $response = getDefaultErrorResponse($e);
        }

        return $response;
    }
}
