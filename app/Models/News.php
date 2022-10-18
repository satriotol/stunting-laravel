<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','user_id','verified_by','title','date','content','image'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }
    public function user()
    {
        return $this->belongsTo(Administrator::class,'user_id','id');
    }
    public function verified()
    {
        return $this->belongsTo(Administrator::class,'verified_by','id');
    }
}
