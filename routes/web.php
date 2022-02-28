<?php
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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {return view('student.create');
});
Route::resource('ajaxproducts','ProductAjaxController');
Route::post('Dashboard','studentController@authenticate')->name('authenticate');
//***************************************** Students Routes ***************************************//
Route::get('Student/List','studentController@index')->middleware('auth')->name('studentsList');
Route::get('Student/Show/{id}','studentController@show')->middleware('auth')->name('showStudent');
Route::post('Student/Add','studentController@store')->middleware('auth')->name('storeStudent');
Route::post('Student/Edit/{id}','studentController@edit')->middleware('auth')->name('editStudent');
Route::post('Student/Delete/{id}','studentController@destroy')->middleware('auth')->name('deleteStudent');
Auth::routes();
Route::get('home','HomeController@index')->middleware('auth')->name('dashboard');
Route::get('Create/Add','ProductController@create1')->middleware('auth')->name('AddStudent');
Route::post('Create','ProductController@handleAddProduct')->middleware('auth')->name('storeProduct');
//***************************************** update Students Routes ***************************************//

/*Route::get('Update/{id}','StudentController@Inp1')->middleware('auth')->name('InpStudent1');*/    
Route::post('Image/{id}','ProductController@InputStudent')->middleware('auth')->name('InputStudent');
Route::post('Create/{id}','ProductController@InputStudent1')->middleware('auth')->name('UpdateStudent');
Route::post('Delete/{id}','studentController@archive')->middleware('auth')->name('archive');
Route::get('Update/Name/{id}','StudentController@UpdateName')->middleware('auth')->name('UpdateStudentName');
//***************************************** Image Routes ***************************************//
/*Route::get('store_image', 'StoreImageController@index');
Route::post('store_image/insert_image', 'StoreImageController@insert_image')->name('insert');
Route::get('store_image/fetch_image/{id}', 'StoreImageController@fetch_image');*/
//***********************************************Ideas de sorties***************************************//
Route::get('Show/Map','IdeasController@index')->middleware('auth')->name('ShowMap');
Route::post('Liste/Add','IdeasController@addIdea')->middleware('auth')->name('addIdea');
Route::get('Liste/Show','IdeasController@getIdeasList')->middleware('auth')->name('getIdeasList');
Route::get('Show/{id}','IdeasController@showIdeas')->middleware('auth')->name('showIdeas');
Route::post('Delete/Ideas/{id}','IdeasController@deleteIdea')->middleware('auth')->name('deleteIdea');
Route::get('Update/{id}','IdeasController@UpIdeas')->middleware('auth')->name('UpIdeas');
Route::post('Delete/Logo/{id}','IdeasController@Archives')->middleware('auth')->name('Archives');
Route::Post('Ideas/Update/{id}','IdeasController@UpdateIdeas')->middleware('auth')->name('UpdateIdeasText');
//****************************************Acces*********************************************************//
Route::get('user/Liste','UserAccesController@index')->middleware('Admin')->name('ShowUser');
Route::get('user/Role/Update/{id}','UserAccesController@update')->middleware('Admin')->name('updateRole');
Route::get('user/Delete/User/{id}','UserAccesController@destroy')->middleware('Admin')->name('DelRole');
Route::post('user/Update/{id}','UserAccesController@edit')->middleware('Admin')->name('Edit');
Route::get('user/Add/user','UserAccesController@create')->middleware('Admin')->name('AddUser');
Route::Post('user/Save','UserAccesController@SaveUser')->middleware('Admin')->name('SaveUser');
//****************************************Invitation*********************************************************//
Route::get('user/Role/Admin/{id}','UserAccesController@AdminRole')->middleware('Admin')->name('AdminRole');
Route::get('user/Role/user/{id}','UserAccesController@UserRole')->middleware('Admin')->name('UserRole');
Route::get('user/Refuser/{id}','UserAccesController@RefuserUser')->middleware('Admin')->name('RefuserUser');
//****************************************Games*********************************************************//
Route::get('Home/game','HomeController@Games')->middleware('auth')->name('Games');
//****************************************quiz test*********************************************************//
Route::get('Home/Quiz','HomeController@Quiz')->middleware('auth')->name('quizTable');
Route::get('Home/ts','HomeController@testQuizAppel')->middleware('auth')->name('testQuizAppel');
Route::get('Home/Quiz/1','HomeController@NextQuiz2')->middleware('auth')->name('NextQuiz2');
Route::get('Home/Quiz/2','HomeController@ColerQuiz')->middleware('auth')->name('ColerQuiz');
Route::get('Home/Quiz/3','HomeController@QuizSyllabe')->middleware('auth')->name('QuizSyllabe');
//****************************************quiz in test*********************************************************//
Route::get('Home/Quiz','HomeController@QuizTable')->middleware('auth')->name('QuizTable');
Route::get('Home/Quiz/animal','HomeController@QuizAnimal')->middleware('auth')->name('QuizAnimal');
Route::get('Home/Quiz/Historique','HomeController@QuizHistorique')->middleware('auth')->name('QuizHistorique');
Route::get('Home/Quiz/Science','HomeController@QuizScience')->middleware('auth')->name('QuizScience');
Route::get('Home/Quiz/All','HomeController@QuizAll')->middleware('auth')->name('QuizAll');
Route::get('Home/Quiz/Rep','HomeController@QuizRep')->middleware('auth')->name('QuizRep');
Route::Post('Home/Formulaire','HomeController@QuizFormulaire')->middleware('auth')->name('QuizFormulaire');



