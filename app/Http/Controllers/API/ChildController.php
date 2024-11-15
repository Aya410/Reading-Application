<?php

namespace App\Http\Controllers\API;
use App\Helpers\ApiResponse;
use App\Helpers\StatusCodeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ChildController extends Controller
{
    use ApiResponse;
    public function getEducationalSong(){
        $song = DB::table('videos')->select('videos.id','videos.name','videos.image','videos.path','videos.time')
                        ->join('categories','videos.category_id','=','categories.id')
                        ->whereIn('categories.id',[13])->get();
       
        $result = $song->map(function ($songs) {
                        
            $image = url($songs->image);
            return [
                'id' => $songs->id,
                'name' => $songs->name,
                'path' => $songs->path,
                'time' => $songs->time,
                'image'=> $image,
            ];
        });
        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
        }
    
    public function getEducationalVideos(){
        $video = DB::table('videos')->select('videos.id','videos.name','videos.image','videos.path','videos.time')
                        ->join('categories','videos.category_id','=','categories.id')
                        ->whereIn('categories.id',[11])->get();

                        
        $result = $video->map(function ($videos) {
                        
            $image = url($videos->image);
            return [
                'id' => $videos->id,
                'name' => $videos->name,
                'path' => $videos->path,
                'time' => $videos->time,
                'image'=> $image,
            ];
        });
        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
    }
    public function getEducationalbooks(){
        $book = DB::table('books')->select('books.id','books.book_name','books.image','books.rate','books.path','categories.category_name')
            ->join('categories', 'books.category_id', '=', 'categories.id')
                    ->whereIn('categories.id',[11])->get();
                                     
        $result = $book->map(function ($books) {
                        
            $image = url($books->image);
            return [
                'book_id' => $books->id,
                'book_name' => $books->book_name,
                'path' => $books->path,
                'rate'=>$books->rate,
                'category_name'=>$books->category_name,
                'image'=> $image,
            ];
        });
        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
       
    }
    public function getEntertainingSong(){
        $song = DB::table('videos')->select('videos.id','videos.name','videos.image','videos.path','videos.time')
                        ->join('categories','videos.category_id','=','categories.id')
                        ->whereIn('categories.id',[12])->get();
                        
        $result = $song->map(function ($songs) {
                        
            $image = url($songs->image);
            return [
                'id' => $songs->id,
                'name' => $songs->name,
                'path' => $songs->path,
                'time' => $songs->time,
                'image'=> $image,
            ];
        });
        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
        
    }
    public function getEntertainingVideos(){
        $video = DB::table('videos')->select('videos.id','videos.name','videos.image','videos.path','videos.time')
                        ->join('categories','videos.category_id','=','categories.id')
                        ->whereIn('categories.id',[10])->get();
                        $result = $video->map(function ($videos) {
                        
                            $image = url($videos->image);
                            return [
                                'id' => $videos->id,
                                'name' => $videos->name,
                                'path' => $videos->path,
                                'time' => $videos->time,
                                'image'=> $image,
                            ];
                        });
                        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
       
    }
    public function getEntertainingbooks(){
        $book = DB::table('books')->select('books.id','books.book_name','books.image','books.rate','books.path','categories.category_name')
            ->join('categories', 'books.category_id', '=', 'categories.id')
                    ->whereIn('categories.id',[10])->get();
                                                  
        $result = $book->map(function ($books) {
                        
            $image =url($books->image) ;
            return [
                'book_id' => $books->id,
                'book_name' => $books->book_name,
                'path' => $books->path,
                'rate'=>$books->rate,
                'category_name'=>$books->category_name,
                'image'=> $image,
            ];
        });
        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
      
    }

}
