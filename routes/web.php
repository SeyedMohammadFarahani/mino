<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/forbidden', function () {
    return view('forbidden');
})->name('forbidden');

//show dashboard
/*Route::get('/products/index', function () {
    $id = auth()->user()->id;
    $products = DB::table('products')->where('user_id', '=', $id)->get();
    return view('products/index', compact('products'));
})->name('user.home');*/


Route::get('/products/create-step-zero', 'ProductController@createStepZero')->name('products.create.step.zero');
Route::post('/products/create-step-zero', 'ProductController@postCreateStepZero')->name('products.create.step.zero.post');

Route::get('/products/create-step-one', 'ProductController@createStepOne')->name('products.create.step.one');
Route::post('/products/create-step-one', 'ProductController@postCreateStepOne')->name('products.create.step.one.post');

Route::get('/products/create-step-two', 'ProductController@createStepTwo')->name('products.create.step.two');
Route::post('/products/create-step-two', 'ProductController@postCreateStepTwo')->name('products.create.step.two.post');

Route::get('/products/create-step-three', 'ProductController@createStepThree')->name('products.create.step.three');
Route::post('/products/create-step-three', 'ProductController@postCreateStepThree')->name('products.create.step.three.post');

Route::get('/products/create-step-four', 'ProductController@createStepFour')->name('products.create.step.four');
Route::post('/products/create-step-four', 'ProductController@postCreateStepFour')->name('products.create.step.four.post');

Route::get('/products/create-step-five', 'ProductController@createStepFive')->name('products.create.step.five');
Route::post('/products/create-step-five', 'ProductController@postCreateStepFive')->name('products.create.step.five.post');

Route::get('/products/create-step-six', 'ProductController@createStepSix')->name('products.create.step.six');
Route::post('/products/create-step-six', 'ProductController@postCreateStepSix')->name('products.create.step.six.post');

Route::get('/products/create-step-seven', 'ProductController@createStepSeven')->name('products.create.step.seven');
Route::post('/products/create-step-seven', 'ProductController@postCreateStepSeven')->name('products.create.step.seven.post');

Route::get('/products/report', 'ProductController@generateDocx')->name('products.get.report');
Route::get('/products/bom', 'ProductController@generateBom')->name('products.get.bom');
Route::get('/products/download/{fileName}', 'ProductController@downloadReport')->name('products.download');

Route::group(['middleware' => ['auth', 'role'], 'prefix' => 'manager'], function () {

    //show dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return view('manager/dashboard', compact('user'));
    })->name('manager.dashboard');

    //Todo transactions
    //show transactions table
    Route::get('/transactions/show', ['uses' => 'ManagerController@showTransactions'])->name('transactions.show');

    //show create transactions page
    Route::get('/transactions/create', function () {
        $products = \App\Product::all();
        return view('transaction/create_transaction', compact('products'));
    })->name('transactions.create');

    //insert new transaction
    Route::post('/transactions/save', ['uses' => 'TransactionController@save'])->name('transactions.save');

    //show edit transactions page
    Route::get('/transactions/edit/{id}', ['uses' => 'ManagerController@showEditTransaction'])->name('transactions.edit');

    //edit transaction
    Route::patch('/transactions/update/{id}', ['uses' => 'TransactionController@update'])->name('transactions.update');

    //delete material
    Route::get('/transactions/delete/{id}', ['uses' => 'TransactionController@deleteTransaction'])->name('transactions.destroy');

    //find product
    Route::get('/transactions/find_product/{code}', ['uses' => 'TransactionController@findProduct'])->name('product.find');

    //show edit transactions page
    Route::get('/transactions/search', ['uses' => 'TransactionController@showSearchTransaction'])->name('transactions.search');

    //show edit transactions page
    Route::get('/transactions/search_result', ['uses' => 'TransactionController@showSearchResult'])->name('transactions.search.result');

    //download bom report
    Route::get('/transactions/download_bom/{bom}', 'TransactionController@downloadBom')->name('transactions.download.bom');

    //delete multiple materials
    Route::post('/transactions_delete_all', ['uses' => 'TransactionController@deleteAll'])->name('transactions.destroyAll');

    //todo Users Routes
    //show users table
    Route::get('/users/show', ['uses' => 'ManagerController@showUsers'])->name('users.show');

    //show create users page
    Route::get('/users/create', function () {
        return view('user/create_user');
    })->name('users.create');

    //show edit users page
    Route::get('/users/edit/{id}', ['uses' => 'ManagerController@showEditUser'])->name('users.edit');

    //edit user
    Route::patch('/users/update/{id}', ['uses' => 'UserController@update'])->name('users.update');

    //insert new user
    Route::post('/users/save', ['uses' => 'UserController@save'])->name('users.save');

    //delete user
    Route::get('/users/delete/{id}', ['uses' => 'UserController@deleteUser'])->name('users.destroy');

    //delete multiple users
    Route::post('/users_delete_all', ['uses' => 'UserController@deleteAll'])->name('users.destroyAll');


    //todo Material Routes
    //show materials table
    Route::get('/materials/show', ['uses' => 'ManagerController@showMaterials'])->name('materials.show');

    //show create materials page
    Route::get('/materials/create', function () {
        return view('material/create_material');
    })->name('materials.create');

    //show edit materials page
    Route::get('/materials/edit/{id}', ['uses' => 'ManagerController@showEditMaterial'])->name('materials.edit');

    //edit material
    Route::patch('/materials/update/{id}', ['uses' => 'MaterialController@update'])->name('materials.update');

    //insert new material
    Route::post('/materials/save', ['uses' => 'MaterialController@save'])->name('materials.save');

    //delete material
    Route::get('/materials/delete/{id}', ['uses' => 'MaterialController@deleteMaterial'])->name('materials.destroy');

    //delete multiple materials
    Route::post('/materials_delete_all', ['uses' => 'MaterialController@deleteAll'])->name('materials.destroyAll');

    //todo Packs Routes
    //show packs table
    Route::get('/packs/show', ['uses' => 'ManagerController@showPacks'])->name('packs.show');

    //show create packs page
    Route::get('/packs/create', function () {
        return view('pack/create_pack');
    })->name('packs.create');

    //show edit packs page
    Route::get('/packs/edit/{id}', ['uses' => 'ManagerController@showEditPack'])->name('packs.edit');

    //edit pack
    Route::patch('/packs/update/{id}', ['uses' => 'PackController@update'])->name('packs.update');

    //insert new pack
    Route::post('/packs/save', ['uses' => 'PackController@save'])->name('packs.save');

    //delete pack
    Route::get('/packs/delete/{id}', ['uses' => 'PackController@deletePack'])->name('packs.destroy');

    //delete multiple packs
    Route::post('/packs_delete_all', ['uses' => 'PackController@deleteAll'])->name('packs.destroyAll');

    //todo Processes Routes
    //show processes table
    Route::get('/processes/show', ['uses' => 'ManagerController@showProcesses'])->name('processes.show');

    //show create processes page
    Route::get('/processes/create', function () {
        $materials = \App\Material::all();
        return view('process/create_process', compact('materials'));
    })->name('processes.create');

    //show edit processes page
    Route::get('/processes/edit/{id}', ['uses' => 'ManagerController@showEditProcess'])->name('processes.edit');

    //edit process
    Route::patch('/processes/update/{id}', ['uses' => 'ProcessController@update'])->name('processes.update');


    //insert new process
    Route::post('/processes/save', ['uses' => 'ProcessController@save'])->name('processes.save');

    //delete process
    Route::get('/processes/delete/{id}', ['uses' => 'ProcessController@deleteProcess'])->name('processes.destroy');
    //delete multiple process
    Route::post('/processes', ['uses' => 'ProcessController@deleteAll'])->name('processes.destroyAll');

    //todo Actions Routes
    //show actions table
    Route::get('/actions/show', ['uses' => 'ManagerController@showActions'])->name('actions.show');

    //show create actions page
    Route::get('/actions/create', function () {
        return view('action/create_action');
    })->name('actions.create');

    //show edit actions page
    Route::get('/actions/edit/{id}', ['uses' => 'ManagerController@showEditAction'])->name('actions.edit');

    //edit actions
    Route::patch('/actions/update/{id}', ['uses' => 'ActionController@update'])->name('actions.update');

    //insert new action
    Route::post('/actions/save', ['uses' => 'ActionController@save'])->name('actions.save');

    //delete action
    Route::get('/actions/delete/{id}', ['uses' => 'ActionController@deleteAction'])->name('actions.destroy');
    //delete multiple actions
    Route::post('/actions', ['uses' => 'ActionController@deleteAll'])->name('actions.destroyAll');

    //todo Acids Routes
    //show processes table
    Route::get('/acids/show', ['uses' => 'ManagerController@showAcids'])->name('acids.show');

    //show create processes page
    Route::get('/acids/create', function () {
        return view('acid/create_acid');
    })->name('acids.create');

    //show edit processes page
    Route::get('/acids/edit/{id}', ['uses' => 'ManagerController@showEditAcid'])->name('acids.edit');

    //edit process
    Route::patch('/acids/update/{id}', ['uses' => 'AcidController@update'])->name('acids.update');

    //insert new process
    Route::post('/acids/save', ['uses' => 'AcidController@save'])->name('acids.save');

    //delete process
    Route::get('/acids/delete/{id}', ['uses' => 'AcidController@deleteAcid'])->name('acids.destroy');
    //delete multiple process
    Route::post('/acids', ['uses' => 'AcidController@deleteAll'])->name('acids.destroyAll');

    //todo Products Routes

    //show non confirmed products table
    Route::get('/products/show', ['uses' => 'ManagerController@showProducts'])->name('products.show');

    //show confirmed products table
    Route::get('/confirmed_products/show', ['uses' => 'ManagerController@showConfirmedProducts'])->name('products.confirmed.show');

    //delete product
    Route::get('/products/delete/{id}', ['uses' => 'ProductController@deleteProduct'])->name('products.destroy');
    //delete confirmed product
    Route::get('/confirmed_products/delete/{id}', ['uses' => 'ProductController@deleteConfirmedProduct'])->name('confirmed.products.destroy');
    //delete multiple products
    Route::post('/products_delete_all', ['uses' => 'ProductController@deleteAll'])->name('products.destroyAll');
    //delete multiple confirmed products
    Route::post('/confirmed_products_delete_all', ['uses' => 'ProductController@deleteAllConfirmed'])->name('confirmed.products.destroyAll');

    // download management report
    Route::get('/products/download/{fileName}', 'ProductController@downloadReport')->name('products.download.report');

    // download bom report
    Route::get('/products/download/{bom}', 'ProductController@downloadBom')->name('products.download.bom');

    //confirm product
    Route::get('/products/confirm/{id}', 'ProductController@confirmProduct')->name('products.confirm');

});
