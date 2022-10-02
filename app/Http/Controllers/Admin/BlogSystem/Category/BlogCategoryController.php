<?php

namespace App\Http\Controllers\Admin\BlogSystem\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogCategoryTranslations;
use Illuminate\Validation\Rule;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $categories = BlogCategory::orderBy('category_name', 'asc');

        if ($request->has('search')){
            $sort_search = $request->search;
            $categories = $categories->where('category_name', 'like', '%'.$sort_search.'%');
        }

        $lang = $request->lang;
        $categories = $categories->paginate(15);
        return view('admin.blog_system.category.index', compact('categories', 'sort_search' , 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $all_categories = BlogCategory::all();
        $lang = $request->lang;
        return view('admin.blog_system.category.create', compact('all_categories' , 'lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:255',
            'lang' => Rule::in(['sa' , 'en']),
        ]);

        $category = new BlogCategory;

        $category->category_name = $request->category_name;
        $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->category_name));
        $category->save();

        BlogCategoryTranslations::create(array_merge($request->only(['category_name' , 'lang']) ,['blog_category_id' => $category->id]));


        flash(translate('Blog category has been created successfully'))->success();
        return redirect()->route('blog-category.index' , ['lang' => $request->lang]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,  $id)
    {
        $cateogry = BlogCategory::find($id);
        $all_categories = BlogCategory::all();
        $lang = $request->lang;
        return view('admin.blog_system.category.edit',  compact('cateogry','all_categories' , 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|max:255',
            'lang' => Rule::in(['sa' , 'en']),
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->category_name));
        $category->save();

        BlogCategoryTranslations::whereBlogCategoryId($category->id)->updateOrCreate(
            [
                'blog_category_id' => $category->id,
                'lang' => $request->lang,
            ],
            array_merge($request->only(['category_name' , 'lang']) , ['blog_category_id' => $category->id]),
        );

        flash(translate('Blog category has been updated successfully'))->success();
        return redirect()->route('blog-category.index' ,  ['lang' => $request->lang]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,  $id)
    {
        BlogCategory::find($id)->delete();
        return redirect(route('blog-category.index' , ['lang' => $request->lang]));
    }
}
