<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blogs;
use App\BlogsCategory;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
use Input;

class BlogsController extends Controller
{
      public $filePath = 'storage/uploads/blogs';
      public function index(Request $r)
      {
      	$data['blogs'] = Blogs::all();
      	return view('admin.blogs.manage-blogs',$data);
      
      }
       public function saveBlog(Request $req){

        $validator = Validator::make(Input::all(), [
            'title'   => 'required',
            'category'   => 'required',
            'content'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $blog     = new Blogs;
        }else{
            $blog     = Blogs::where('id',$req->id)->first();
        }

        if (!empty($req->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid()."-".preg_replace('/\s/', '-',$filename);
            Input::file('image')->move($this->filePath, $fileNewName);

            $blog->image          = $fileNewName;
        }

        $blog->title           = $req->title;
        if (!empty($req->slug)) {
            $url = url('/');
            $slug = str_replace($url.'/blog/','', $req->slug);
            $blog->slug               = $slug;
        }else{
            $blog->slug               = str_slug($req->name);
        }
        if (!empty($req->meta_title)) {
            $blog->meta_title         = ucfirst($req->meta_title);
        }
        if (!empty($req->meta_desc)) {
            $blog->meta_desc       = $req->meta_desc;
        }
        $blog->content           = $req->content;
        $blog->image_alt           = $req->image_alt;
        $blog->blog_category_id           = $req->category;
        $isSave                     = $blog->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.blogs');
    }
      public function editBlog($id){
      	$data['categories'] = BlogsCategory::all();
        $data['detail'] = Blogs::where('id',$id)->first();
        return view("admin.blogs.add-blog", $data);
    }
    public function addBlog($value='')
    {
    	$data['categories'] = BlogsCategory::all();
    	return view("admin.blogs.add-blog",$data);
    }
     public function indexCategories(Request $r)
      {
      	$data['categories'] = BlogsCategory::all();
      	return view('admin.blogs.manage-blog-category',$data);
      
      }
       public function saveBlogCategory(Request $req){

        $validator = Validator::make(Input::all(), [
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", $validator->messages()->first());
            return redirect()->back()->withInput(Input::all());
        }

        if (is_null($req->id)) {
            $blog     = new BlogsCategory;
        }else{
            $blog     = BlogsCategory::where('id',$req->id)->first();
        }


        $blog->name           = $req->name;
        $isSave                     = $blog->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        }else{
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.blogs-categories');
    }
      public function editBlogCategory($id){

        $data['detail'] = BlogsCategory::where('id',$id)->first();
        return view("admin.blogs.add-blog-category", $data);
    }
    public function addBlogCategory($value='')
    {
    	$data['categories'] = BlogsCategory::all();
    	return view("admin.blogs.add-blog-category");
    }
    public function SaveFeatured(Request $req)
    {
    	   $visa 			= Blogs::where('id', $req->id)->first();
        $visa->is_featured 	= $req->is_featured;
        $isSave 		= $visa->save();
        if ($isSave) {
            return response()->json(["notify"=>true, "msg"=>"Success"]);
        }else{
            return response()->json(["notify"=>false, "msg"=>"Fail"]);
        }
    }

}
