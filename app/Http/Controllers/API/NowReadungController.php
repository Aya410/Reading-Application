<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Helpers\StatusCodeRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Now_Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NowReadungController extends Controller
{
    use ApiResponse;
    public function add_now_reading(Request $request)
{
    
    $validator = Validator::make($request->all(), [
        'book_id' => 'required',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
    $now_reading = Now_Reading::where('book_id', $request->book_id)
    ->where('user_id',Auth::id())
    ->first();
    if ($now_reading) {
    $ratio= $this->calculateReadingRatio($request);
    $now_reading->ratio=$ratio;
    $now_reading-> save();
    return $this->apiResponse($now_reading,'Success',StatusCodeRequest::OK);
    }
    else {
        $ratio= $this->calculateReadingRatio($request);
        $now_reading = Now_Reading::create([
            'book_id' => $request->book_id,
            'user_id' => Auth::id(),
            'ratio'=> $ratio,
        ]);
        if ($now_reading) {
            return $this->apiResponse($now_reading,'Success',StatusCodeRequest::OK);
        }
        else {
            return $this->apiResponse(null,'false',StatusCodeRequest::SERVER_ERROR);
        }
    }
   
}

public function calculateReadingRatio(Request $request)
{
    $validator = Validator::make($request->all(), [
        'current_page' => 'required|integer|min:1',
        'total_pages' => 'required|integer|min:1',
    ]);

   
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
     
    $current_page = $request->input('current_page');
    $total_pages = $request->input('total_pages');

    if ($current_page > $total_pages) {
        return $this->apiResponse(null,'Current page number cannot be greater than total number of pages.',StatusCodeRequest::BAD_REQUEST);
    }
    else{
        $ratio=($current_page / $total_pages)*100;
        $ratioroy=round($ratio,2);
        return   $ratio;
       }
    }
    
    public function getUserNowReading( )
    {
     $id=Auth::id();
        $nowreading = DB::table('now__readings')
        ->join('books', 'now__readings.book_id', '=', 'books.id')
        ->select('now__readings.book_id','books.book_name', 'books.author', 'books.image','books.path','now__readings.ratio')
        ->where('now__readings.user_id', '=', $id)->
        where('now__readings.ratio','<',100)
        ->get();
        $result = $nowreading->map(function($users){
            $image = $users->image ? url($users->image) : null;
            $path=url($users->path);
            return [
                'book_id' => $users->book_id,
                'book_name' => $users->book_name,
                'image' => $image,
                'author' => $users->author,
                'path' => $path,
                'ratio'=>$users->ratio
            ];
        });
        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
    }
       // return $this->apiResponse($nowreading,'Success',StatusCodeRequest::OK);
        
    
        public function CompletReading( )
        {
            $id=Auth::id();
            $nowreading = DB::table('now__readings')
            ->join('books', 'now__readings.book_id', '=', 'books.id')
            ->select('now__readings.book_id','books.book_name', 'books.author', 'books.image')
            ->where('now__readings.user_id', '=', $id)
            ->where('now__readings.ratio', '=', 100)
            ->get();
            $result = $nowreading->map(function($users){
                $image = $users->image ? url($users->image) : null;
                
                return [
                    'book_id' => $users->book_id,
                    'book_name' => $users->book_name,
                    'image' => $image,
                    'author' => $users->author,
                    
                    
                ];
            });
            return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
            }
        
    

}
