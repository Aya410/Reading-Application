<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Helpers\StatusCodeRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    public function getCategoryId(Request $request){
    $validator=Validator::make($request->all(), [
        'category_name'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ]);
        }
        $cate=Category::where('category_name',$request->category_name)->first();
        
           
        
        return $cate;
    }
}
