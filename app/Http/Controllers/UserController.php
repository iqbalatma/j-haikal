<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;

class UserController extends Controller
{
    /**
     * @param UserService $service
     * @return Response
     */
    public function index(UserService $service): Response
    {
        $response = $service->getAllData();

        return response()->view("kelola.users.index", $response);
    }

    /**
     * @param UserService $service
     * @return Response
     */
    public function create(UserService $service): Response
    {
        return response()->view("kelola.users.create");
    }

    /**
     * @param UserService $service
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(UserService $service, StoreUserRequest $request): RedirectResponse
    {
        $response = $service->addNewData($request->validated());
        if ($this->isError($response)) return $this->getErrorResponse();

        return redirect()->route('users.index')->with("success", "Berhasil menambahkan data user");
    }


    /**
     * @param UserService $service
     * @param string $id
     * @return Response|RedirectResponse
     */
    public function edit(UserService $service, string $id): Response|RedirectResponse
    {
        $response = $service->getEditDataById($id);
        if ($this->isError($response)) return $this->getErrorResponse();

        return response()->view("kelola.users.edit", $response);
    }

    /**
     * @param UserService $service
     * @param UpdateUserRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UserService $service, UpdateUserRequest $request, string $id): RedirectResponse
    {
        $response = $service->updateDataById($id, $request->validated());
        if ($this->isError($response)) return $this->getErrorResponse();

        return redirect()->route('users.index')->with("success", "Berhasil memperbaharui data user");
    }
}
