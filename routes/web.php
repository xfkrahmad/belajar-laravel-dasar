<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pzn', function () {
    return "Hello Fikri Ahmad Fauzi";
});

Route::fallback(function () {
    return "404 Not Found";
});

Route::redirect('/youtube', '/pzn');

Route::view('/hello', 'hello', ['name' => 'Fikri']);

Route::get('/hello-again', function () {
    return view('hello', ['name' => 'Fikri']);
});

Route::get('/hello-world', function () {
    return view('hello.world', ['name' => 'Fikri']);
});

Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
})->name('product.detail');

Route::get('/products/{productid}/items/{itemid}', function ($productId, $itemId) {
    return "Product $productId dan Item $itemId";
})->name('product.item.detail');

Route::get('/categories/{id}', function ($categoryId) {
    return "Category : " . $categoryId;
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id?}', function ($userId = 404) {
    return "Users $userId";
})->name('user.detail');

Route::get('/conflict/fikri', function () {
    return "Conflict kedua";
});

Route::get('/conflict/{name}', function ($name) {
    return "Conflict $name";
});

Route::get('/produk/{id}', function ($id) {
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get('produk-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', ['id' => $id]);
});
//Testing
Route::get('/controller/test', [TestController::class, 'index']);

Route::get('/controller/hello/request', [HelloController::class, 'request']);
Route::get('/controller/hello/{name}', [HelloController::class, 'hello']);

Route::prefix('/input')->controller(InputController::class)->group(function () {
    Route::get('/hello', 'hello');
    Route::post('/hello', 'hello');
    Route::post('/hello/first', 'helloFirstName');
    Route::post('/hello/input', 'helloInput');
    Route::post('/hello/array', 'helloArray');
    Route::post('/hello/array/paramsquery', 'helloInputQuery');
    Route::post('/type', 'inputType');
    Route::post('/filter/only', 'filterOnly');
    Route::post('/filter/except', 'filterExcept');
    Route::post('/filter/merge', 'filterMerge');
});

Route::post('/file/upload', [FileController::class, 'upload'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/response/hello', [ResponseController::class, 'response']);
Route::get('/response/header', [ResponseController::class, 'header']);

Route::prefix('/response/type')->controller(ResponseController::class)->group(function () {
    Route::get('/view', 'responseView');
    Route::get('/json', 'responseJson');
    Route::get('/file', 'responseFile');
    Route::get('/download', 'responseDownload');
});

Route::controller(CookieController::class)->group(function () {
    Route::get('/cookie/set', 'createCookie');
    Route::get('/cookie/get', 'getCookie');
    Route::get('/cookie/clear', 'clearCookie');
});

Route::prefix('/redirect')->controller(RedirectController::class)->group(function () {
    Route::get('/from',  'redirectFrom');
    Route::get('/to',  'redirectTo');
    Route::get('/name',  'redirectName');
    Route::get('/name/{name}',  'redirectHello')
        ->name('redirect-hello');
    Route::get('/named', function () {
        return route('redirect-hello', [
            'name' => 'Fikri'
        ]);
        // return url()->route('redirect-hello', [
        //     'name' => 'Fikri'
        // ]);
        // URL::route('redirect-hello', [
        //     'name' => 'Fikri'
        // ]);
    });
    Route::get('/action',  'redirectAction');
    Route::get('/away',  'redirectAway');
});
Route::middleware(['contoh:PZN,401'])->prefix('/middleware')->group(function () {
    Route::get('/api', function () {
        return "OK";
    });
    Route::get('/group', function () {
        return "group";
    });
});

Route::get('/url/action', function () {
    return action([FormController::class, 'form'], []);
    return url()->action([FormController::class, 'form'], []);
    return URL::action([FormController::class, 'form'], []);
});

Route::get('/form', [FormController::class, 'form']);
Route::post('/form', [FormController::class, 'submitForm']);

Route::get('/url/current', function () {
    return URL::full();
});

Route::get('/session/create', [SessionController::class, 'createSession']);
Route::get('/session/get', [SessionController::class, 'getSession']);

Route::get('/error/sample', function () {
    throw new ErrorException('Sample Error');
});
Route::get('/error/manual', function () {
    report(new Exception('Sample Error'));
    return "OK";
});
Route::get('/error/validation', function () {
    throw new ValidationException('Validation Error');
});

Route::get('abort/400', function () {
    abort(400, 'Ups Validation Error');
});
Route::get('abort/401', function () {
    abort(401);
});
Route::get('abort/500', function () {
    abort(500);
});
