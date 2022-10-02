<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityTranslation extends Model
{
    use SoftDeletes;

    public $timestamps = true;
  protected $fillable = ['name', 'locale', 'city_id'];

  public function city(){
    return $this->belongsTo(City::class);
  }
}
