<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Country extends Model
{

    /**
     * Each Countrry Has many Cities through its states
     */
    public function cities()
    {
        return $this->hasManyThrough(City::class , State::class);
    }


    public function country_translations()
    {
        return $this->hasMany(CountryTranslation::class);
    }

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? (App::getLocale() == 'sa' ? 'ar' : App::getLocale()) : ($lang);
        $country_translations = $this->country_translations->where('locale', $lang)->first();
        return $country_translations != null ? $country_translations->$field : $this->$field;
    }
}
