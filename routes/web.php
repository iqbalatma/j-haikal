<?php

use App\Enums\Role;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForecastingController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RestockController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function () {
    Route::controller(\App\Http\Controllers\Auth\AuthenticateController::class)->group(function () {
        Route::get("login", "login")->name("login");
        Route::post("authenticate", "authenticate")->name("authenticate");
    });

    Route::prefix("forgot-password")->name("forgot.password.")->controller(\App\Http\Controllers\Auth\ForgotPasswordController::class)->group(function () {
        Route::get("", "showForgotPassword")->name("show.forgot.password");
        Route::post("", "requestForgotPassword")->name("request.forgot.password");
        Route::get("/reset/{email}/{token}", "showResetPassword")->name("request.reset.password");
        Route::post("/reset", "resetPassword")->name("reset.password");
    });
});


Route::middleware("auth:web")->group(function () {
    Route::post("logout", [\App\Http\Controllers\Auth\AuthenticateController::class, "logout"])->name("logout");

    Route::get('/', function () {
        return redirect()->route("dashboard");
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix("users")->name("users.")->controller(UserController::class)->middleware("permission:" . Role::ADMINISTRATOR->name)->group(function () {
        Route::get("", "index")->name("index");
        Route::get("create", "create")->name("create");
        Route::post("", "store")->name("store");
        Route::get("{id}/edit", "edit")->name("edit");
        Route::patch("{id}", "update")->name("update");
        Route::delete("{id}", "destroy")->name("destroy");
    });
    Route::middleware("permission:" . Role::KEPALA_GUDANG->name)->group(function () {
        Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/edit/{produk}', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::post('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        Route::prefix("sales")->name("sales.")->controller(SaleController::class)->group(function () {
            Route::get("", "index")->name("index");
            Route::get("create", "create")->name("create");
            Route::post("", "store")->name("store");
        });
    });
    Route::middleware("permission:" . Role::KEPALA_TOKO->name)->group(function () {
        Route::get('/suplier', [SuplierController::class, 'index'])->name('suplier.index');
        Route::get('/suplier/create', [SuplierController::class, 'create'])->name('suplier.create');
        Route::post('/suplier', [SuplierController::class, 'store'])->name('suplier.store');
        Route::get('/suplier/edit/{suplier}', [SuplierController::class, 'edit'])->name('suplier.edit');
        Route::post('/suplier/{suplier}', [SuplierController::class, 'update'])->name('suplier.update');
        Route::delete('/suplier/{suplier}', [SuplierController::class, 'destroy'])->name('suplier.destroy');

        Route::prefix("forecasting")->name("forecasting.")->controller(ForecastingController::class)->group(function () {
            Route::get("", "index")->name("index");
            Route::post("", "store")->name("store");
        });

        Route::prefix("transactions")->name("transactions.")->controller(TransactionController::class)->group(function () {
            Route::get("", "index")->name("index");
            Route::get("create", "create")->name("create");
            Route::post("", "store")->name("store");
        });
    });

    Route::prefix("restocks")->name("restocks.")->controller(RestockController::class)->group(function () {
        Route::get("", "index")->name("index")->middleware("permission:".Role::KEPALA_GUDANG->name);
        Route::get("create", "create")->name("create");
        Route::post("", "store")->name("store");

        Route::get("restock-by-forecasting", "restockForecasting")->name("restock.by.forecasting")->middleware("permission:".Role::KEPALA_GUDANG->name);
        Route::post("restock-forecasting", "storeByForecasting")->name("store.by.forecasting")->middleware("permission:".Role::KEPALA_GUDANG->name);


        Route::get("restock-add-supplier", "restockAddSupplier")->name("restock.add.supplier")->middleware("permission:".Role::KEPALA_TOKO->name);
        Route::post("restock-add-supplier", "storeByForecastingSupplier")->name("store.by.forecasting.supplier")->middleware("permission:".Role::KEPALA_TOKO->name);
    });
});
