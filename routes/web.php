<?php
use App\Http\Controllers\AuthController;
use App\Models\Fichero;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/trash', [HomeController::class, 'trash']);
Route::get('/storage', [HomeController::class, 'storage']);

Route::post('/upload', [FileController::class, 'upload'])
    ->can('upload', Fichero::class);
Route::get('/download/{fichero}', [FileController::class, 'downloadFile'])
    ->can('download', 'fichero')->name('ficheros.download');
Route::get('/delete_or_share', [FileController::class, 'delete_or_share']);
Route::get('/delete', [FileController::class, 'delete']);
Route::get('/share', [FileController::class, 'share']);
Route::post('/share/process', [FileController::class, 'processShare']);
Route::get('/shared', [FileController::class, 'sharedWithMe']);
Route::get('/unshare/{fichero}', [FileController::class, 'unshare']);
Route::get('/deletetrash/{file}', [FileController::class, 'deleteFromTrash'])
    ->can('seeFile', 'file');
Route::get('/restore/{file}', [FileController::class, 'restore']);


Route::get('/search', [SearchController::class, 'search']);

Route::post('/tags/add', [TagController::class, 'addTag']);
Route::post('/tags/add-to-file/{file}', [TagController::class, 'addTagToFile']);
Route::get('/tags/{tag_name}', [TagController::class, 'showFilesByTagName'])->name('tags.files');

Route::get('/preview/{fichero}', [FileController::class, 'preview'])->name('ficheros.preview');
Route::get('/edit/{fichero}', [FileController::class, 'edit'])->name('ficheros.edit');
Route::put('/edit/{fichero}', [FileController::class, 'update'])->name('ficheros.update');
Route::get('/preview/{fichero}', [FileController::class, 'preview'])->name('ficheros.preview');
Route::post('/preview/{fichero}', [FileController::class, 'updateTextFile'])->name('ficheros.updateTextFile');

Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

