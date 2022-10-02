<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    public function category() {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    protected $with = ['blog_translations'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $blog_translations = $this->blog_translations->where('lang', $lang)->first();
        return $blog_translations != null ? $blog_translations->$field : $this->$field;
    }

    public function blog_translations()
    {
        return $this->hasMany(BlogTranslations::class);
    }

}
