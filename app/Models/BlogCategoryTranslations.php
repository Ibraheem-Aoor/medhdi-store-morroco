<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoryTranslations extends Model
{
    use HasFactory;
    protected $fillable = ['category_name' , 'lang' , 'blog_category_id'];

    public function BlogCategory()
    {
        return $this->belongsTo(BlogCategory::class , 'blog_category_id');
    }
}
