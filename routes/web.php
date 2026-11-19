<?php
use App\Routes\Route;

// ---------- Accueil ----------
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

// ---------- Connexion / déconnexion ----------
Route::get('/login', 'AuthController@create');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');

// ---------- Espace client ----------
Route::get('/mon-espace', 'ClientController@index');

// ---------- Journal de bord (admin) ----------
Route::get('/journal', 'JournalController@index');

// ---------- Utilisateurs (admin) ----------
Route::get('/users', 'UserController@index');
Route::get('/user/create', 'UserController@create');
Route::post('/user/create', 'UserController@store');

// ---------- Cours (CRUD complet, table avec 2 clés étrangères) ----------
Route::get('/cours', 'CoursController@index');
Route::get('/cours/show', 'CoursController@show');
Route::get('/cours/create', 'CoursController@create');
Route::post('/cours/create', 'CoursController@store');
Route::get('/cours/edit', 'CoursController@edit');
Route::post('/cours/edit', 'CoursController@update');
Route::post('/cours/delete', 'CoursController@delete');

// ---------- Catégories ----------
Route::get('/categories', 'CategorieController@index');
Route::get('/categorie/create', 'CategorieController@create');
Route::post('/categorie/create', 'CategorieController@store');
Route::get('/categorie/edit', 'CategorieController@edit');
Route::post('/categorie/edit', 'CategorieController@update');
Route::post('/categorie/delete', 'CategorieController@delete');

// ---------- Formateurs ----------
Route::get('/formateurs', 'FormateurController@index');
Route::get('/formateur/create', 'FormateurController@create');
Route::post('/formateur/create', 'FormateurController@store');
Route::get('/formateur/edit', 'FormateurController@edit');
Route::post('/formateur/edit', 'FormateurController@update');
Route::post('/formateur/delete', 'FormateurController@delete');

// ---------- Étudiants ----------
Route::get('/etudiants', 'EtudiantController@index');
Route::get('/etudiant/show', 'EtudiantController@show');
Route::get('/etudiant/create', 'EtudiantController@create');
Route::post('/etudiant/create', 'EtudiantController@store');
Route::get('/etudiant/edit', 'EtudiantController@edit');
Route::post('/etudiant/edit', 'EtudiantController@update');
Route::post('/etudiant/delete', 'EtudiantController@delete');

// ---------- Inscriptions (relation plusieurs-à-plusieurs) ----------
Route::get('/inscriptions', 'InscriptionController@index');
Route::get('/inscription/create', 'InscriptionController@create');
Route::post('/inscription/create', 'InscriptionController@store');
Route::get('/inscription/edit', 'InscriptionController@edit');
Route::post('/inscription/edit', 'InscriptionController@update');
Route::post('/inscription/delete', 'InscriptionController@delete');

Route::dispatch();