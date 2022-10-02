<?php

namespace App\Http\Controllers\Customer;

use App\Models\AppTranslation;
use Illuminate\Http\Request;
use Session;
use App\Models\Language;
use App\Models\Translation;
use Cache;
use Storage;
use App\Http\Controllers\Controller;
class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $request->session()->put('locale', $request->locale);
        $language = Language::where('code', $request->locale)->first();
    	flash(translate('Language changed to ').$language->name)->success();
    }
}
