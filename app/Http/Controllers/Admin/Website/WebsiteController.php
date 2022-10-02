<?php

namespace App\Http\Controllers\Admin\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
	public function header(Request $request)
	{
        $lang = $request->lang;
		return view('admin.website_settings.header' , compact('lang'));
	}
	public function footer(Request $request)
	{
		$lang = $request->lang;
		return view('admin.website_settings.footer', compact('lang'));
	}
	public function pages(Request $request)
	{
		return view('admin.website_settings.pages.index');
	}
	public function appearance(Request $request)
	{
		return view('admin.website_settings.appearance');
	}
}
