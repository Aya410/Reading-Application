<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Helpers\StatusCodeRequest;
use App\Http\Controllers\Controller;
use App\Models\Audio_Book;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use ApiResponse;
    public function numbers(){
        $app_rate=$this->getapprate();

        $num_user = User::whereIn('role',['adult','child'])->count();
        $num_book = Book::count();
        $num_Audio = Audio_Book::count();
        $data=[
           'User_Number' => $num_user,
           'Book_Number'=>$num_book,
           'AudioBook_Number'=>$num_Audio,
             'app_rate'=>$app_rate,

        ];
        return $this->apiResponse($data,'Success',StatusCodeRequest::OK);

    }
    public function User_Number(){
        $num = User::whereIn('role',['adult','child'])->count();
        if($num){
            return $this->apiResponse($num,'Success',StatusCodeRequest::OK);
         }
         else{
            return $this->apiResponse(null,'users not found   ',StatusCodeRequest::BAD_REQUEST);
         }
        }
    public function Book_Number(){
            $num = Book::count();

            if($num){
                return $this->apiResponse($num,'Success',StatusCodeRequest::OK);
             }
             else{
                return $this->apiResponse(null,'books not found   ',StatusCodeRequest::BAD_REQUEST);
             }}
    public function AudioBook_Number(){
                $num = Audio_Book::count();
                if($num){
                    return $this->apiResponse($num,'Success',StatusCodeRequest::OK);

                 }
                 else{
                    return $this->apiResponse(null,'audio_books not found   ',StatusCodeRequest::BAD_REQUEST);
                 }}
    
    public function Most_Liked_Book(){

        $mostLikedBooks = DB::table('likes')
        ->join('books', 'likes.book_id', '=', 'books.id')
        ->select('books.book_name', DB::raw('count(*) as total_likes'))
        ->groupBy('likes.book_id', 'books.book_name')
        ->orderByDesc('total_likes')
        ->take(7)
        ->get();
        if($mostLikedBooks){
            return $this->apiResponse($mostLikedBooks,'Success',StatusCodeRequest::OK);
         }
         
         else
         {
           return $this->apiResponse(null,'there  is not book liked ',StatusCodeRequest::BAD_REQUEST);
         }    
    }
    public function Most_Reading_Book(){
        $mostReadBooks = DB::table('now__readings')
                    ->join('books', 'now__readings.book_id', '=', 'books.id')
                    ->select('books.book_name', DB::raw('count(*) as total_readings'))
                    ->where('now__readings.ratio', '=', 100)
                    ->groupBy('now__readings.book_id','books.book_name')
                    ->orderByDesc('total_readings')
                    ->take(7)
                    ->get();


                    if($mostReadBooks){
                        return $this->apiResponse($mostReadBooks,'Success',StatusCodeRequest::OK);
                     }
                     
                     else
                     {
                       return $this->apiResponse(null,'there  is not book reading ',StatusCodeRequest::BAD_REQUEST);
                     }   
                    
    }
 
    public function popularity(){
        $usersByMonth = DB::table('users')
        ->select(DB::raw('MONTHNAME(date) as month'), DB::raw('COUNT(*) as count'))
        ->groupBy('month')
        ->orderBy(DB::raw('MONTH(date)'))
        ->get();
                return $this->apiResponse($usersByMonth,'Success',StatusCodeRequest::OK);
                

    }
  

    public function completed_goals_month(){
        $lastMonthStart = Carbon::now()->subDays(29)->format('Y-m-d');
        $lastMonthEnd = Carbon::now()->format('Y-m-d');
    
        $goalsByMonth = DB::table('goals')
            ->select(DB::raw('DAY(date) as date'), DB::raw('COUNT(*) as count'))
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->where('status', '=', 'ok')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            $month = Carbon::now()->format('m');
          
            $data=[
            'monthName' => Carbon::createFromFormat('m', $month)->format('F'),
            'day'=>$goalsByMonth
            ];
        return $this->apiResponse($data, 'Success', StatusCodeRequest::OK);
    }
    public function completed_goals_week(){
        $lastWeekStart = Carbon::now()->subDays(6)->format('Y-m-d');
        $lastWeekEnd = Carbon::now()->format('Y-m-d');
    
        $goalsByWeek = DB::table('goals')
            ->select(DB::raw('DAYNAME(date) as date'), DB::raw('COUNT(*) as count'))
            ->whereBetween('date', [$lastWeekStart, $lastWeekEnd])
            ->where('status', '=', 'ok')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        return $this->apiResponse($goalsByWeek, 'Success', StatusCodeRequest::OK);
    }

   
    public function topuser(){
        $topUsers = DB::table('users')
        ->select('users.id', 'users.username', 'users.image', DB::raw('SUM(goals.spend_time) as total_spend_time'), DB::raw('RANK() OVER (ORDER BY SUM(spend_time) DESC) as rank'))
        ->join('goals', 'users.id', '=', 'goals.user_id')
        ->groupBy('users.id', 'users.username', 'users.image')
        ->having('total_spend_time', '>', 0)
        ->orderByDesc('total_spend_time')
        ->limit(10)
        ->get();
     
        $result = $topUsers->map(function ($topUser) {
               
            $image = ($topUser->image ? url($topUser->image) : null)  ;
            return [
                
                'username' => $topUser->username,
                'rank' => $topUser->rank,
                'total_spend_time' => $topUser->total_spend_time,
                'image'=> $image,
            ];
        });
   
        return $this->apiResponse($result, 'Success', StatusCodeRequest::OK);
        }

        public function getallbooks(){
            $book = DB::table('books')->select('books.id','books.book_name','books.author','books.image','books.rate')
                
                        ->whereIn('category_id', [1, 2 , 3, 4, 5, 6, 7, 8,10,11])->get();
                        $result = $book->map(function ($books) {
                           $image=null; 
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




        public function getapprate(){
            $ratings = User::whereNotNull('evaluation')->get();
            $count = User::whereNotNull('evaluation')->count();
            $sum=0;
            foreach ($ratings as $rating){
                $sum = $sum + $rating->evaluation;
            }
            if($count==0){
                return 0;
            }
            else{
                $avg = round($sum/$count);

                return $avg;
            }
           
    
        }
        public function Getsuggestion(){
        
            $suggestions = DB::table('suggestions')
            ->join('users', 'suggestions.user_id', '=', 'users.id')
            ->select('users.username', 'suggestions.id', 'suggestions.book_name', 'suggestions.auther', 'users.role', 'suggestions.typecategory')
            ->get();
                 if($suggestions)
                 {
                        return $this->apiResponse($suggestions,'Success',StatusCodeRequest::OK);
                 }
                  else
                 {
                         return $this->apiResponse(null,'suggestions not found',StatusCodeRequest::BAD_REQUEST);
                 }
            
        
                }

        public function getalluser(){
            $user = Db::table('users')->select('id','image','username','email','role')->get();
            $result = $user->map(function($users){
                $image = $users->image ? url($users->image) : null;
                return [
                    'id' => $users->id,
                    'username' => $users->username,
                    'image' => $image,
                    'email' => $users->email,
                    'role' => $users->role
                ];
            });
            return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
        }
        public function adduser(Request $request){
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'email'=>'required',
                'password' => 'required',
                'role' => 'required',
                'image' => ['image','mimes:jpeg,png,bmp,jpg,gif,svg'],
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
            }
            $image = $request->file('image');
            $expert_image = null;
            if($request->hasFile('image')){
              $expert_image = time().'.'.$image->getClientOriginalExtension();
              $image->move(public_path('image'),$expert_image);
               $expert_image = 'image/'.$expert_image;
           }$date = Carbon::now()->format('Y-m-d');
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->pasword),
                'role' => $request->role,
                'image'=>$expert_image,
                'date' => $date
            ]);
            if($user){
                return $this->apiResponse($user,'User Add Successfully',StatusCodeRequest::OK);
            }
        }
       
        public function addbook(Request $request){
            $validator = Validator::make($request->all(), [
                'book_name' => 'required',
                'author' => 'required',
                'rate' => 'required',
                'image'=>['required','image','mimes:png,jpg'],
                'path' => ['required','mimes:pdf'],
                'book_details' => 'required',
            ]);
            if($validator->fails()){
                return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
            }
            $image = $request->file('image');
            if($request->hasFile('image')){
                $book_image = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('image'),$book_image);
                $book_image = 'image/'.$book_image;
            }
            $pdffile = $request->file('path');
            $pdf = time() . '.' . $pdffile->getClientOriginalExtension();
            $pdffile->move(public_path('books'),$pdf);
            $pdf = 'books/'.$pdf;
            $cat = new CategoryController();
            $cate_id = $cat->getCategoryId($request);
            $book = Book::create([
                'book_name' => $request->book_name,
                'author' => $request->author,
                'rate' => $request->rate,
                'image' =>$book_image,
                'book_details' => $request->book_details,
                'path' => $pdf,
                'category_id' =>$cate_id->id,
            ]);
            if($book){
                return $this->apiResponse(null,'Book Add Successfully',StatusCodeRequest::OK);
            }
        }
        public function deletebook($id){
            $book = Book::find($id);
            if (!$book) {
                return $this->apiResponse(null, 'Book not found', StatusCodeRequest::NOTFOUND);
            }
            else{
            $now_reading=DB::table('now__readings')->where('book_id',$id);
            if($now_reading){
             $now_reading->delete();
     
            }
             
            $favorites=DB::table('favorites')->where('book_id',$id);
            if($favorites){
             $favorites->delete();
     
            }
            $likes=DB::table('likes')->where('book_id',$id);
            if($likes){
             $likes->delete();
     
            }
            $quotes=DB::table('quotes')->where('book_id',$id);
            if($quotes){
             $quotes->delete();
     
            }
            $book->comments()->delete();

        $book->delete();
                return $this->apiResponse(null, 'Book deleted successfully', StatusCodeRequest::OK);
    } 
    }


        public function updatebook(Request $request, $id){
            $validator = Validator::make($request->all(), [
                'book_name' => 'required',
                'author' => 'required',
                'rate' => 'required',
                'image'=>['image','mimes:png,jpg'],
                'path' => ['mimes:pdf'],
                'book_details' => 'required',
                'category_name' => 'required'
            ]);
            if($validator->fails()){
                return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
            }
            $book = Book::find($id);
            if($book){
                $image = $request->file('image');
                if($request->hasFile('image')){
                    $book_image = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('image'),$book_image);
                    $book_image = 'image/'.$book_image;
                    $book->image = $book_image;

                }
                if($request->hasFile('path')){

                $pdffile = $request->file('path');
                $pdf = time() . '.' . $pdffile->getClientOriginalExtension();
                $pdffile->move(public_path('books'),$pdf);
                $pdf = 'books/'.$pdf;
                $book->path = $pdf;

            }
                $book->book_name = $request->book_name;
                $book->author = $request->author;
                $book->rate = $request->rate;
                $book->book_details = $request->book_details;
                $category = Category::where('category_name',$request->category_name)->first();
                $book->category()->associate($category);
                $book->save();
                return $this->apiResponse(null,'Book Update Successfully',StatusCodeRequest::OK);
            }
        }
        public function getallAudiobooks(){
            $Audiobook = DB::table('audio__books')->select('audio__books.id','audio__books.name','audio__books.author','categories.category_name')
            ->join('categories', 'audio__books.category_id', '=', 'categories.id')->get();
            return $this->apiResponse($Audiobook,'Success',StatusCodeRequest::OK);
        }
        public function addAudiobook(Request $request){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'author'=>'required',
                'rate' => 'required',
                'image'=>['required','image','mimes:png,jpg'],
                'path' => ['required','mimes:mp3'],
                'book_details' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
            }
            $image = $request->file('image');
            if($request->hasFile('image')){
                $book_image = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('image'),$book_image);
                $book_image = 'image/'.$book_image;
            }
            $audiofile = $request->file('path');
            $audio = time() . '.' . $audiofile->getClientOriginalExtension();
            $audiofile->move(public_path('Audiobooks'),$audio);
            $audio = 'Audiobooks/'.$audio;
            $book = Audio_Book::create([
                'name' => $request->name,
                'author' => $request->author,
                'rate' => $request->rate,
                'image' =>$book_image,
                'book_details' => $request->book_details,
                'path' => $audio,
                'category_id' =>9,
            ]);
            if($book){
                return $this->apiResponse(null,'Book Add Successfully',StatusCodeRequest::OK);
            }
        }
        public function deleteAudiobook($id){
            $Audiobook = Audio_Book::find($id);
            if (!$Audiobook) {
                return $this->apiResponse(null, 'Book not found', StatusCodeRequest::NOTFOUND);
            }
            $Audiobook->delete();
            return $this->apiResponse(null, 'Book deleted successfully', StatusCodeRequest::OK);
        }
        public function updateAudiobook(Request $request, $id){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'author'=>'required',
                'rate' => 'required',
                'image'=>['image','mimes:png,jpg'],
                'path' => ['mimes:mp3'],
                'book_details' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
            }
            $Audiobook = Audio_Book::find($id);
            if($Audiobook){
                $image = $request->file('image');
                if($request->hasFile('image')){
                    $book_image = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('image'),$book_image);
                    $book_image = 'image/'.$book_image;
                    $Audiobook->image = $book_image;

                }
                if($request->hasFile('path')){
                $audiofile = $request->file('path');
                $audio = time() . '.' . $audiofile->getClientOriginalExtension();
                $audiofile->move(public_path('Audiobooks'),$audio);
                $audio = 'Audiobooks/'.$audio;
                $Audiobook->path = $audio;

            }
                $Audiobook->name = $request->name;
                $Audiobook->author = $request->author;
                $Audiobook->rate = $request->rate;
                $Audiobook->book_details = $request->book_details;
                $Audiobook->save();
                return $this->apiResponse(null,'Book Update Successfully',StatusCodeRequest::OK);
            }
        }
        public function getAudioBookData(Request $request){
    
            $validator = Validator::make($request->all(), [
                'book_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $bookdata = DB::table('audio__books')->select('id','path','image','book_details','name','author','rate')
            ->where('id',$request->book_id)->get();
            $result = $bookdata->map(function ($bookdatas) {
                            
                $image = url($bookdatas->image);
                $path=url($bookdatas->path);
                return [
    
                    'id' => $bookdatas->id,
                    'name'=> $bookdatas->name,
                    'author'=> $bookdatas->author,
                    'rate'=> $bookdatas->rate,
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
    public function deleteuser($id){
        $user = User::find($id);
        if (!$user) {
            return $this->apiResponse(null, 'User not found', StatusCodeRequest::NOTFOUND);
        }
   else{
   $now_reading=DB::table('now__readings')->where('user_id',$id);
   if($now_reading){
    $now_reading->delete();

   }
    
   $favorites=DB::table('favorites')->where('user_id',$id);
   if($favorites){
    $favorites->delete();

   }
   $likes=DB::table('likes')->where('user_id',$id);
   if($likes){
    $likes->delete();

   }
   $quotes=DB::table('quotes')->where('user_id',$id);
   if($quotes){
    $quotes->delete();

   }

   $goals=DB::table('goals')->where('user_id',$id);
   if($goals){
    $goals->delete();
   }
   
   $suggestions=DB::table('suggestions')->where('user_id',$id);
   if($suggestions){
    $suggestions->delete();
   }

// حذف جميع الردود المرتبطة بالمستخدم
$user->replays()->delete();
// حذف جميع التعليقات المرتبطة بالمستخدم
$user->comments()->delete();

    $user->delete();
    return $this->apiResponse(null, 'User deleted successfully', StatusCodeRequest::OK);
   }

    }
    public function getbooksdetails(Request $request){
    
        $validator = Validator::make($request->all(), [
            'book_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
        }
        $book = DB::table('books')
        ->join('categories', 'books.category_id', '=', 'categories.id')
        ->where('books.id', $request->book_id)
        ->first();
        if ($book) {
            $image = url($book->image);
    
            $result = [
                'id' => $book->id,
                'book_name' => $book->book_name,
                'author' => $book->author,
                'rate' => $book->rate,
                'path' => $book->path,
                'book_details' => $book->book_details,
                'image' => $image,
                'category_name' => $book->category_name
            ];
    
            return $this->apiResponse($result, 'Success', StatusCodeRequest::OK);
        } else {
            return $this->apiResponse(null, 'book_id is false', StatusCodeRequest::BAD_REQUEST);
        }

}
    
}

