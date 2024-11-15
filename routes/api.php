<?php

use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\aaa;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\ChildController;
use App\Http\Controllers\API\FavoriteeController;
use App\Http\Controllers\API\NowReadungController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ForgetPasswordController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/usernumber',[UserController::class,'User_Number']);
    
    

});

Route::middleware(['auth:api','userrole:child'])->group(function(){
   
    Route::get('/getEducationalSong',[ChildController::class,'getEducationalSong']);
    Route::get('/getEducationalbooks',[ChildController::class,'getEducationalbooks']);
    Route::get('/getEducationalVideos',[ChildController::class,'getEducationalVideos']);
    Route::get('/getentertainingSong',[ChildController::class,'getEntertainingSong']);
    Route::get('/getEntertainingVideos',[ChildController::class,'getEntertainingVideos']);
    Route::get('/getEntertainingbooks',[ChildController::class,'getEntertainingbooks']);
    Route::post('/favorite',[FavoriteController::class,'store_and_deletFavorite']);
    Route::get('/getbookfavorite',[FavoriteController::class,'getUserFavorites']);
    Route::post('/add',[NowReadungController::class,'add_now_reading']);
    Route::post('/AddSuggestchild',[UserController::class,'AddSuggest']);
    Route::post('/evaluation_child',[UserController::class,'evaluation']);
    Route::get('/getUserNowReading_child',[NowReadungController::class,'getUserNowReading']);
});//completed_goals_week
Route::middleware(['auth:api', 'userrole:adult'])->group(function () {
   Route::get('/getAllCategory',[BookController::class,'getAllCategory']);
    Route::get('/getallbooks_adult',[BookController::class,'getallbooks']);
    Route::post('/GetBooks',[BookController::class,'getbooks']);//
    Route::post('/GetBooksDetails',[BookController::class,'getbooksdetails']);
    Route::post('/add_now_reading',[NowReadungController::class,'add_now_reading']);
    Route::get('/getUserNowReading',[NowReadungController::class,'getUserNowReading']);
    Route::get('/CompletReading',[NowReadungController::class,'CompletReading']);
    Route::post('/store_and_deletFavorite',[FavoriteController::class,'store_and_deletFavorite']);
    Route::get('/getUserFavorites', [FavoriteController::class, 'getUserFavorites']);
    Route::post('/getAudioBook',[BookController::class,'getAudioBook']);
    Route::post('/getAudioBookData',[BookController::class,'getAudioBookData']);
    Route::post('/evaluation',[UserController::class,'evaluation']);

    Route::post('/storeimage',[UserController::class,'storeimage']);
    Route::post('/AddSuggest',[UserController::class,'AddSuggest']);
  
   // Route::get('/getuser/{id}',[BookController::class,'getuser']);
    Route::post('/storeqoute',[UserController::class,'storeqoute']);
    Route::delete('/deletqoute/{id}',[UserController::class,'deletqoute']);
    Route::get('/getqoute',[UserController::class,'getqoute']);
    Route::post('/addLikeToBook',[UserController::class,'addLikeToBook']);
    Route::post('/getcountlike',[UserController::class,'getcountlike']);
    Route::post('/addComment',[UserController::class,'addComment']);
    Route::post('/getComments',[UserController::class,'getComments']);
    Route::delete('/deletecomment/{id}',[UserController::class,'deletecomment']);
    Route::post('/addReply',[UserController::class,'addReply']);
    Route::post('/getReplay',[UserController::class,'getReplay']);
    Route::get('/getMyQuestions',[UserController::class,'getMyQuestions']);
    Route::get('/checkgoal',[UserController::class,'checkgoal']);
    Route::post('/set_goal',[UserController::class,'set_goal']);
    Route::post('/set_spentime',[UserController::class,'set_spentime']);
    Route::get('/goalprogress',[UserController::class,'goalprogress']);
});
//popularity  completed_goals getcountlike addComment getComments addReply getReplay getMyQuestions storeimage   goalprogress addReply set_goal set_spentime
   
    Route::post('/password/email',[AuthController::class,'userForgatePassword']);
    Route::post('/CodeCheck',[AuthController::class,'userCheckCode']);
    Route::post('/ResetPassword',[AuthController::class,'userResetPassword']);
   
    Route::middleware(['auth:api', 'userrole:admin'])->group(function () {
      Route::post('/StoreBookData',[BookController::class,'storeBookData']);
      Route::get('/Most_Liked_Book',[AdminController::class,'Most_Liked_Book']);
      Route::get('/Most_Reading_Book',[AdminController::class,'Most_Reading_Book']);
      Route::get('/Getsuggestion',[AdminController::class,'Getsuggestion']);
      Route::get('/Getpopularity',[AdminController::class,'popularity']);
      Route::get('/completed_goals_month',[AdminController::class,'completed_goals_month']);
      Route::get('/completed_goals_week',[AdminController::class,'completed_goals_week']);
      Route::get('/Book_Number',[AdminController::class,'Book_Number']);
      Route::get('/getapprate',[AdminController::class,'getapprate']);
      Route::get('/AudioBook_Number',[AdminController::class,'AudioBook_Number']);
      Route::get('/User_Number',[AdminController::class,'User_Number']);
      Route::get('/topuser',[AdminController::class,'topuser']);
      ///
      Route::get('/getalluser',[AdminController::class,'getalluser']);
    Route::post('/adduser',[AdminController::class,'adduser']);
    Route::delete('/deleteuser/{id}',[AdminController::class,'deleteuser']);
    Route::get('/getallbooks',[AdminController::class,'getallbooks']);
    Route::post('/addbook',[AdminController::class,'addbook']);
    Route::delete('/deletebook/{id}',[AdminController::class,'deletebook']);
    Route::post('/updatebook/{id}',[AdminController::class,'updatebook']);
    Route::get('/getallAudiobooks',[AdminController::class,'getallAudiobooks']);
    Route::post('/addAudiobook',[AdminController::class,'addAudiobook']);
    Route::get('/deleteAudiobook/{id}',[AdminController::class,'deleteAudiobook']);
    Route::post('/updateAudiobook/{id}',[AdminController::class,'updateAudiobook']);
    // Route::get('/numbers',[AdminController::class,'numbers']);
    Route::get('/number',[AdminController::class,'numbers']);
    Route::post('/Get_Books_Details',[AdminController::class,'getbooksdetails']);
    Route::post('/get_Audio_BookData',[AdminController::class,'getAudioBookData']);
    });