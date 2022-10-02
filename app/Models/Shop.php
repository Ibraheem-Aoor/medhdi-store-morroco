<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public $timestamps = false;
  protected $with = ['user'];

  public function shop_translations()
  {
      return $this->hasMany(ShopTranslation::class , 'shop_id');
  }


  public function getTranslation($field = '', $lang = false)
  {
      $lang = $lang == false ? (App::getLocale() == 'sa' ? 'ar' : App::getLocale()) : ($lang);
      $shop_translations = $this->shop_translations->where('lang', $lang)->first();
      return $shop_translations != null ? $shop_translations->$field : $this->$field;
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function seller_package(){
      return $this->belongsTo(SellerPackage::class);
  }
}
