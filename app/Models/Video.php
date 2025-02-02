<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    public $fillable = ['name','image',
    'path','time','category_id'];
    public $timestamps = false;
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
