<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('welcome');
});

/**
 * @return Token
 * Retorna um token valido para que o usuario
 * possa se autenticar no sistema.
 */
Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function() {

    /**
     * -------------------------------------------------------------------------
     * @Route::resource Client
     * Responsavel por pegar todas os metodos que possui 
     * no Controller 'ClienteController', exeto os metodos citados
     * abaixo (create, edit).
     * -------------------------------------------------------------------------
     */
    Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);
    
    /*
      Route::get('client', 'ClientController@index');
      Route::post('client', 'ClientController@store');
      Route::get('client/{id}', 'ClientController@show');
      Route::put('client/{id}', 'ClientController@update');
      Route::delete('client/{id}', 'ClientController@destroy');
     * 
     */
   
    /**
     * ------------------------------------------------------------------------
     * @Route::group CheckProjectOwner
     * Grupo de rotas responsavel por verificar se o
     * usuario é dono de um determinado projeto. 
     * (Regra definida no Middleware 'CheckProjectOwner' 
     * e no Repository 'ProjectRepositoryEloquent').
     * ------------------------------------------------------------------------
     */
    
    //Route::group(['middleware' => 'CheckProjectOwner'], function(){
        Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
    //});

    Route::group(['prefix' => 'project'], function() {
        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::post('{id}/note', 'ProjectNoteController@store');
        Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
        Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
        Route::delete('note/{noteId}', 'ProjectController@destroy');
    });

    /*
    Route::get('{id}/note', 'ProjectNoteController@index');
    Route::post('{id}/note', 'ProjectNoteController@store');
    Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
    Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
    Route::delete('note/{noteId}', 'ProjectController@destroy');
     */
    
    /*
      Route::get('project', 'ProjectController@index');
      Route::post('project', 'ProjectController@store');
      Route::get('project/{id}', 'ProjectController@show');
      Route::put('project/{id}', 'ProjectController@update');
      Route::delete('project/{id}', 'ProjectController@destroy');
     * 
     */
});
