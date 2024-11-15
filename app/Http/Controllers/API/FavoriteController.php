<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Helpers\StatusCodeRequest;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
   use ApiResponse;
public function store_and_deletFavorite(Request $request)
{  $validator = Validator::make($request->all(), [
    'book_id' => 'required'
]);
if ($validator->fails()) {
    return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
}
$favorite = Favorite::where('user_id',Auth::id())
                    ->where('book_id', $request->book_id)
                    ->first();
if (!$favorite) {
    $favorite = Favorite::create([
        'user_id'=> Auth::id(),
        'book_id'=> $request->book_id
    ]);
    return $this->apiResponse($favorite,'Book add to favorites',StatusCodeRequest::OK);
}
else {
    $favorite->delete();
    return $this->apiResponse(null,'Book removed from favorites',StatusCodeRequest::OK);
}
}


public function getUserFavorites( )
{
  $favorites = DB::table('favorites')
  ->join('books', 'favorites.book_id', '=', 'books.id')
  ->join('categories', 'books.category_id', '=', 'categories.id')
  ->select('books.book_name', 'books.author', 'books.image', 'categories.category_name', 'favorites.book_id','books.path')
  ->where('favorites.user_id', '=', Auth::id())
  ->get();
  $result = $favorites->map(function($users){
    $image = $users->image ? url($users->image) : null;
    $path=url($users->path);
    return [
        'book_id' => $users->book_id,
        'book_name' => $users->book_name,
        'image' => $image,
        'author' => $users->author,
        'category_name'=>$users->category_name,
        'path'=>$path,
    ];
});
return $this->apiResponse($result,'Success',StatusCodeRequest::OK);


}
   





}


