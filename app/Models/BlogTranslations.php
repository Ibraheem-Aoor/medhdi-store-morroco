<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTranslations extends Model
{
    use HasFactory;
    protected $fillable = ['short_description' , 'description',  'title' , 'blog_id' , 'lang'  , 'author'];

    public function blog()
    {
        return $this->belongsTo(Blog::class , 'blog_id');
    }



}
