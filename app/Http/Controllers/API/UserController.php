<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Helpers\StatusCodeRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Goal;
use App\Models\Like;
use App\Models\Quote;
use App\Models\Replay;
use App\Models\Suggestions;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use ApiResponse;





public function AddSuggest(Request $request){
            $validator = Validator::make($request->all(), [
                'book_name' => 'required',
                'auther' => 'required',
                'typecategory' => 'required',
                
            ]);
            if($validator->fails()){
                return $validator->errors();
            }
            $suggest = Suggestions::create([
                'book_name' => $request->book_name,
                'auther' => $request->auther,
                'typecategory' => $request->typecategory,
                'user_id' =>  Auth::id(),
            ]);
            if($suggest){
                return $this->apiResponse($suggest,'Success',StatusCodeRequest::OK);
            }
           
       
              else
             {
               return $this->apiResponse(null,'suggestion not  true',StatusCodeRequest::BAD_REQUEST);
             }
            }
        

public function storeqoute(Request $request){
                $validator = Validator::make($request->all(), [
                    'book_id' => 'required',
                     'quote'=>'required'
                ]);
                if ($validator->fails()) {
                    return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
                }
                $quote = Quote::create([
                    'user_id'=> Auth::id(),
                    'book_id'=> $request->book_id,
                    'quote'=>$request->quote,
                ]);
                if($quote)
                return $this->apiResponse($quote,'quote add success',StatusCodeRequest::OK);
                else
                {
                        return $this->apiResponse(null,'quote not found',StatusCodeRequest::BAD_REQUEST);
                }
            }
public function deletqoute($id){

                $quote=Quote::find($id);
                 $quote->delete();
                if($quote){
                 return $this->apiResponse($quote,' Quote deleted Success',StatusCodeRequest::OK);
             }
            }

public function getqoute(){
    $quote = DB::table('quotes')
    ->join('books', 'quotes.book_id', '=', 'books.id')
    ->select('quotes.book_id','books.book_name', 'books.author','quotes.quote')
    ->where('quotes.user_id', '=',Auth::id())
    ->get();
    return $this->apiResponse($quote,'Success',StatusCodeRequest::OK);
} 
 public function addLikeToBook(Request $request){
        $validator = Validator::make($request->all(), [
            'book_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
        }
        $likebook = Like::where('user_id',Auth::id())
                    ->where('book_id',$request->book_id)->first();
        if(!$likebook){
            $likebook = Like::create([
                'user_id' => Auth::id(),
                'book_id' => $request->book_id
            ]);
            return $this->apiResponse($likebook,'Book add to Likes',StatusCodeRequest::OK);
        }
        else {
            $likebook->delete();
            return $this->apiResponse(null,'Book removed from Likes',StatusCodeRequest::OK);
        }
        
    }
 // get count like to a book
 public function getcountlike(Request $request){
    $validator = Validator::make($request->all(), [
        'book_id' => 'required',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
    $count = DB::table('likes')->where('book_id',$request->book_id)->count();
    return $this->apiResponse($count,'Success',StatusCodeRequest::OK);
}
 // add comment to a book
 public function addComment(Request $request){
    $validator = Validator::make($request->all(), [
        'comment' => 'required|string|max:256',
        'book_id' => 'required',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
    $user = Auth::user();
    $comment = new Comment();
    $comment->comment = $request->comment;
    $comment->date = now();
    $comment->user_id = $user->id;
    $comment->book_id = $request->book_id;
    $comment->save();
    $data = [
        'id'=> $comment->id,
        'comment' => $comment->comment,
        'username' => $user->username,
        'date' => Carbon::parse($comment->date)->format('Y-m-d H:i:s'),
        'image' => $user->image ? url($user->image) : 'Image not found',
    ];
    return $this->apiResponse($data,'Success',StatusCodeRequest::OK);
}
// get all comment to a book
public function getComments(Request $request){
    $validator = Validator::make($request->all(), [
        'book_id' => 'required',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
    $comments = Comment::with('user')->where('book_id', $request->book_id)->get();
    $result = $comments->map(function ($comment) {
        $user = $comment->user;
        $image = $user->image ? url($user->image) : 'Image not found';
        return [
            'id'=> $comment->id,
            'comment' => $comment->comment,
            'username' => $user->username,
            'date' => Carbon::parse($comment->date)->format('Y-m-d H:i:s'),
            'image' => $image,
        ];
    });
    if($result->isEmpty()){
        return $this->apiResponse(null,'Comments not found',StatusCodeRequest::NOTFOUND);
    }
    else{
        return $this->apiResponse($result,'Success',StatusCodeRequest::OK);
    }
}
// add replay to a comment
public function addReply(Request $request){
    $validator = Validator::make($request->all(), [
        'replay' => 'required',
        'comment_id' => 'required',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
    $user = Auth::user();
    $reply = new Replay();
    $reply->replay = $request->replay;
    $reply->date = now();
    $reply->user_id = $user->id;
    $reply->comment_id = $request->comment_id;
    $reply->save();
    $data = [
        'replay_id' => $reply->id,
        'replay' => $reply->replay,
        'username' => $user->username,
        'date' => Carbon::parse($reply->date)->format('Y-m-d H:i:s'),
        'image' => $user->image ? url($user->image) : 'Image not found',
    ];
    return $this->apiResponse($data,'Success',StatusCodeRequest::OK);

}
// get all replay to a comment
public function getReplay(Request $request){
    $validator = Validator::make($request->all(), [
        'comment_id' => 'required',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
    $replays = Replay::with('user')->where('comment_id', $request->comment_id)->get();
    $result = $replays->map(function ($reply) {
        $user = $reply->user;
    
        $image = $user ? ($user->image ? url($user->image) : 'Image not found') : 'User not found';
        return [
            'replay_id' => $reply->id,
            'replay' => $reply->replay,
            'username' => $user->username,
            'date' => Carbon::parse($reply->date)->format('Y-m-d H:i:s'),
            'image' => $image,
        ];
    });
    $count = DB::table('replays')->where('comment_id', $request->comment_id)->count();
    if($result->isEmpty()){
        return $this->apiResponse(null,'Replays not found',StatusCodeRequest::NOTFOUND);
    }
    else{
        return $this->apiResponse([$result,'replay count' => $count],'Success',StatusCodeRequest::OK);
    }
}
// get all Questions to a user
public function getMyQuestions(){
    $myQuestions = DB::table('comments')
    ->join('books', 'comments.book_id', '=', 'books.id')
    ->select('books.book_name','comments.comment','comments.id')
    ->where('user_id',Auth::id())->get();
    if($myQuestions->isEmpty()){
        return $this->apiResponse(null,'Comments not found',StatusCodeRequest::NOTFOUND);
    }
    else{
        return $this->apiResponse($myQuestions,'Success',StatusCodeRequest::OK);
    }
}
// store user image
public function storeimage(Request $request){
    $validator = Validator::make($request->all(), [
        'image' => ['image','mimes:jpeg,png,bmp,jpg,gif,svg'],
    ]);
    if($validator->fails()){
        return $validator->errors();
    }
    $image = $request->file('image');
    $user_image = time().'.'.$image->getClientOriginalExtension();
    $image->move(public_path('image'),$user_image);
    $user_image = 'image/'.$user_image;
    $user = User::find(Auth::id());
    if ($user) {
    $user->image = $user_image;
    $user->save();
    $image=url($user->image);
    return $this->apiResponse($image,'Success',StatusCodeRequest::OK);
    }
}
// delete comment
public function deletecomment($id){
    $msg1 = '';
    $msg2 = '';
    $reply = DB::table('replays')->where('comment_id',$id);
    if($reply->count() > 0){
        $reply->delete();
        $msg2 = 'Replay delete';
    }
    $comment = DB::table('comments')->where('id',$id)->where('user_id',Auth::id());
    if($comment->count() > 0){
        $comment->delete();
        $msg1 = 'Comment delete';
    }
    return $this->apiResponse(null,[$msg1,$msg2],StatusCodeRequest::OK);
}
// delete replay
public function deletereplay($id){
    $reply = DB::table('replays')->where('id',$id)->where('user_id',Auth::id());
    if($reply){
        $reply->delete();
        return $this->apiResponse(null,'replay delete',StatusCodeRequest::OK);
    }
}
// store or update evaluation
public function evaluation(Request $request){
    $validator = Validator::make($request->all(), [
        'evaluation' => 'required',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
    $user = User::find(Auth::id());
    if ($user) {
    $user->evaluation = $request->evaluation;
    $user->save();
    return $this->apiResponse(null,'Success',StatusCodeRequest::OK);
    }
}/////
    public function checkgoal(){
        $id = Auth::id();
        $goal = Goal::where('user_id', $id)->where('date', now()->format('Y-m-d'))->first(); // retrieve the goal for the user on the current date
        if (!$goal) {
        // if the user doesn't have a goal for today, return null for both fields
        $data = [
            'spend_time' => null,
            'goal' => null,
        ];
        return $this->apiResponse($data, 'do not have goal', StatusCodeRequest::OK);
        }
        else {
            
        $data = [
            'spend_time' => $goal->spend_time,
            'date' => Carbon::parse($goal->date)->format('Y-m-d'),
            'goal' => $goal->goal,
        ];
        return $this->apiResponse($data, 'this user has a goal', StatusCodeRequest::OK);
        }
    }

public function set_goal(Request $request){
    $validator = Validator::make($request->all(), [
        'goal' => 'required',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
    $id=Auth::id();
    $goal1 = Goal::where('user_id', $id)->where('date', now()->format('Y-m-d'))->first();
    if($goal1){
            return $this->apiResponse($goal1,'this user have goal today  ',StatusCodeRequest::OK);
        }      
   else{
    $goal = Goal::create([
        'user_id'=> Auth::id(),
        'date'=> Carbon::now(),
        'spend_time'=> 0,
        'goal'=>$request->goal,
    ]);
    $data = [
        'date' => Carbon::parse($goal->date)->format('Y-m-d '),
        'goal' => $goal->goal,
    ];
    return $this->apiResponse($data,'add goal succesesfully ',StatusCodeRequest::OK);
    }
   }
   
public function set_spentime(Request $request){
    $validator = Validator::make($request->all(), [
        'spend_time' => 'required',
    ]);
    if ($validator->fails()) {
        return $this->apiResponse(null,$validator->errors(),StatusCodeRequest::BAD_REQUEST);
    }
$id=Auth::id();
$goal = Goal::where('user_id', $id)->where('date', now()->format('Y-m-d'))->first();; 

  if($goal) {

    if((($goal->spend_time)==($goal->goal))||($goal->spend_time>$goal->goal)){
        $goal->status='ok';
        
        $goal->save();
      
        return $this->apiResponse($goal,'you gone goal ',StatusCodeRequest::OK);  
         }   
  else{
    $goal->spend_time=($request->spend_time)+( $goal->spend_time);
    $goal->save();
    return $this->apiResponse($goal,'you gone goal ',StatusCodeRequest::OK); 
  }

    
    
    }
    
}


public function goalprogress(){
    $week_ago = now()->subDays(7); // Calculate the date 7 days ago.
    $user_id=Auth::id();


    $goals = DB::table('goals')
    ->select('date', DB::raw('SUM(goal) as goal'), DB::raw('SUM(spend_time) as spend_time'))
    ->where('user_id', $user_id)
    ->where('date', '>=', $week_ago)
    ->groupBy('date')
    ->get();
  
foreach ($goals as $goal) {
    $dataDate = \Carbon\Carbon::parse($goal->date);
    $dataDay = $dataDate->dayName;
    $result[] = [
        'date' => $dataDay,
        'spend_time' => $goal->spend_time,
        'goal' => $goal->goal,
    ];
}
if($result){
    return $this->apiResponse($result,'add goal succesesfully ',StatusCodeRequest::OK);
}



}

}