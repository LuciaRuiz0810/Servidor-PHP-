<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return view('home');
});


Route::get('Login', function () {
     return view('auth.login');
});


Route::get('logout', function () {
    return 'User logout';
});


Route::get('catalog', function () {
    return view('catalog.index');
});

Route::get('catalog/show/{id}', function (string $id) {
 return view('catalog.show', array('id'=>$id));
});

Route::get('catalog/create', function () {
    return view('catalog.create');
});

Route::get('catalog/edit/{id} ', function () {
    return view('catalog.edit');
});

