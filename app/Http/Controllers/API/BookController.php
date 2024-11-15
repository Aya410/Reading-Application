<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Helpers\StatusCodeRequest;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\Url;

class BookController extends Controller
{
    use ApiResponse;
    public function getAllCategory(){
        try{
        $category = Category::take(8)->get();
        return $this->apiresponse($category,'Success',StatusCodeRequest::OK);
        }
        catch(\Exception $ex){
            return $this->apiResponse(null,['Server failure : '.$ex],StatusCodeRequest::SERVER_ERROR);
        }
    }
    public function storeBookData(Request $request){
        $validator = Validator::make($request->all(), [
            'book_name' => 'required',
            'author' => 'required',
            'rate' => 'required',
            'image' => ['image','mimes:jpeg,png,bmp,jpg,gif,svg'],
            'path' => 'required',
            'book_details' => 'required',
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
          $image = $request->file('image');
          $expert_image = null;
          if($request->hasFile('image')){
            $expert_image = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('image'),$expert_image);
             $expert_image = 'image/'.$expert_image;
         }
        $cat = new CategoryController();
        $cate_id = $cat->getCategoryId($request);
        $book = Book::create([
            'book_name' => $request->book_name,
            'author' => $request->author,
            'rate' => $request->rate,
            'image' =>$expert_image,
            'book_details' => $request->book_details,
            'path' => $request->path,
            'category_id' =>$cate_id->id,
        ]);
        $url = Url($book->image); 
        if($book)
        return response()->json([
            'book_name' => $book->book_name,
            'author' => $book->author,
            'rate' => $book->rate,
            'image' => $url,
            'book_details' => $book->book_details,
            'path' => $book->path,
            'category_id' =>$book->category_id,

        ]);
        
    }
   
public function getbooks(Request $request){
    
    $validator = Validator::make($request->all(), [
        'category_id' => 'required|min:1|max:8',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
     $id = $request->category_id;
   
    $book = DB::table('books')->select('id','book_name','author','rate','image')
                ->where('category_id',$id)->get();
                $result = $book->map(function ($books) {
                        
                    $image = url($books->image);
                    return [
                        'book_id' => $books->id,
                        'book_name' => $books->book_name,
                        'author' => $books->author,
                        'rate' => $books->rate,
                        
                        'image'=> $image,
                    ];
                }); 
        
    if($book){
        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
    }
  else
    {
        return $this->apiResponse(null,'books not found',StatusCodeRequest::BAD_REQUEST);
    }
    
  
}

public function getbooksdetails(Request $request){
    
        $validator = Validator::make($request->all(), [
            'book_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
        }
        $book = DB::table('books')->
        where('id',$request->book_id)->get();
     
        $result = $book->map(function ($books) {
                        
            $image = url($books->image);
           // $path=url($books->path);

            return [
                'book_id' => $books->id,
                'book_name' => $books->book_name,
                'author' => $books->author,
                'rate' => $books->rate,
                'path'=>$books->path,
                'book_details'=>$books->book_details,
                'image'=> $image,
            ];
        }); 

         if($book){
            return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
         }
        
    
           else
          {
            return $this->apiResponse(null,'book_id is false',StatusCodeRequest::BAD_REQUEST);
          }

}
/////////////////

public function getallbooks(){
    
    $book = DB::table('books')->select('books.id','books.book_name','books.author','books.rate','books.image')
        ->join('categories', 'books.category_id', '=', 'categories.id')
                ->whereIn('categories.id', [1, 2 , 3, 4, 5, 6, 7, 8])->inRandomOrder()
                ->get();

             
        $result = $book->map(function ($books) {
                        
            $image = url($books->image);
            return [
                'book_id' => $books->id,
                'book_name' => $books->book_name,
                'author' => $books->author,
                'rate' => $books->rate,
                'image'=> $image,
            ];
        });   

        if($book){
            return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
        }
        else{
            
        return $this->apiResponse(null,' not found any book ',StatusCodeRequest::BAD_REQUEST);
      
        }
    
    }
    


public function getAudioBook(){
       

        $Audiobook = DB::table('audio__books')->select('id','name','author','rate','image')
        ->get();
      
        $result = $Audiobook->map(function ($Audiobooks) {
                        
            $image = url($Audiobooks->image);
            return [
                'id' => $Audiobooks->id,
                'name' => $Audiobooks->name,
                'author' => $Audiobooks->author,
                'rate' => $Audiobooks->rate,
                'image'=> $image,
            ];
        });
        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
    
        
}


public function getAudioBookData(Request $request){
    
        $validator = Validator::make($request->all(), [
            'book_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $bookdata = DB::table('audio__books')->select('id','path','image','book_details')
        ->where('id',$request->book_id)->get();
        $result = $bookdata->map(function ($bookdatas) {
                        
            $image = url($bookdatas->image);
            $path=url($bookdatas->path);
            return [

                'id' => $bookdatas->id,
                'path' => $path,
                'book_details' => $bookdatas->book_details,
                
                'image'=> $image,
            ];
        });
    
        if($bookdata){
           return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
        }
       else{
        return $this->apiResponse(null,'book_id not found',StatusCodeRequest::BAD_REQUEST);
       }
    

   
}


}