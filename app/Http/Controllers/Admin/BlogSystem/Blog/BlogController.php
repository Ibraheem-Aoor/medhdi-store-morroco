<?php

namespace App\Http\Controllers\Admin\BlogSystem\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\BlogTranslations;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $blogs = Blog::orderBy('created_at', 'desc');

        if ($request->search != null){
            $blogs = $blogs->where('title', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $blogs = $blogs->paginate(15);
        $lang = $request->lang;
        return view('admin.blog_system.blog.index', compact('blogs','sort_search' , 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $blog_categories = BlogCategory::all();
        $lang = $request->lang;
        return view('admin.blog_system.blog.create', compact('blog_categories' , 'lang'));
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
            'category_id' => 'required',
            'title' => 'required|max:255',
        ]);

        $blog = new Blog;

        $blog->category_id = $request->category_id;
        $blog->title = $request->title;
        $blog->banner = $request->banner;
        $blog->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        $blog->author = $request->author;

        $blog->meta_title = $request->meta_title;
        $blog->meta_img = $request->meta_img;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;

        $blog->save();
        BlogTranslations::create(
            [
                'title' => $blog->title,
                'short_description' => $blog->short_description,
                'description' => $blog->description,
                'blog_id' =>   $blog->id,
                'lang' => $request->lang,
                'author' => $request->author,
            ]
        );

        flash(translate('Blog post has been created successfully'))->success();
        return redirect()->route('blog.index' , ['lang' => $request->lang]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,  $id)
    {
        $blog = Blog::find($id);
        $blog_categories = BlogCategory::all();
        $lang = $request->lang;
        return view('admin.blog_system.blog.edit', compact('blog','blog_categories' , 'lang'));
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
            'category_id' => 'required',
            'title' => 'required|max:255',
        ]);

        $blog = Blog::find($id);

        $blog->category_id = $request->category_id;
        $blog->title = $request->title;
        $blog->banner = $request->banner;
        $blog->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        $blog->author = $request->author;

        $blog->meta_title = $request->meta_title;
        $blog->meta_img = $request->meta_img;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;

        $blog->save();

        BlogTranslations::updateOrCreate(
                [
                    'blog_id' => $blog->id,
                    'lang' => $request->lang,
                ] ,
                $request->only(
                    ['title' , 'short_description' , 'description' , 'author' ,'lang']
                )
            );

        flash(translate('Blog post has been updated successfully'))->success();
        return redirect()->route('blog.index' , ['lang' => $request->lang]);
    }

    public function change_status(Request $request) {
        $blog = Blog::find($request->id);
        $blog->status = $request->status;

        $blog->save();
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,  $id)
    {
        Blog::find($id)->delete();

        return redirect(route('blog.index' , ['lang' => $request->lang]));
    }


    public function all_blog() {
        $blogs = Blog::where('status', 1)->orderBy('created_at', 'desc')->paginate(12);
        return view("frontend.blog.listing", compact('blogs'));
    }

    public function blog_details($slug) {
        $blog = Blog::where('slug', $slug)->first();
        return view("frontend.blog.details", compact('blog'));
    }
}
