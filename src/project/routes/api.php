<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/users', \App\Http\Controllers\Users\StoreUserController::class)
     ->name('register_user');

Route::post('/login', \App\Http\Controllers\Users\LoginUserController::class)
     ->name('user_login');

Route::post('/tools/flush-tokens', [\App\Http\Controllers\GenericController::class, 'flushActiveTokens'])
     ->name('flush_tokens');


Route::prefix('admin')
     ->middleware(['admin.auth'])
     ->name('admin.')
     ->group(function ()
     {
         Route::prefix('/users')
              ->group(function ()
              {

                  //VIEW USER PROFILE
                  Route::get('/{id}', \App\Http\Controllers\Users\ViewUserProfileController::class)
                       ->name('view_user_details');

                  //TODO  TIP ; IN crude we can do Route::resource() => will point to show, index, store, update, delete...
                  //FOR DEMO Purpose want to show the HTTP requests...post, put , delete ..patch if needed...etc..


                  //TASKS MANAGEMENT
                  Route::get('/{userId}/tasks', [\App\Http\Controllers\Users\UserTasksController::class, 'index'])
                       ->name('get_user_tasks');

                  Route::post('/{userId}/tasks', [\App\Http\Controllers\Users\UserTasksController::class, 'store'])
                       ->name('store_user_task');

                  Route::put('/{userId}/tasks/{id}', [\App\Http\Controllers\Users\UserTasksController::class, 'update'])
                       ->name('update_user_task');

                  Route::delete('/{userId}/tasks/{id}', [\App\Http\Controllers\Users\UserTasksController::class, 'delete'])
                       ->name('delete_user_task');



                  //TICKETS
                  Route::post('/{userId}/tickets', [\App\Http\Controllers\Tickets\UserTicketsController::class, 'store'])
                       ->name('assign_task_to_user');
              });
     });
