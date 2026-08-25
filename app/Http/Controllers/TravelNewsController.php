<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TravelNews;
use App\Airlines;
use Validator;
use Session;
use Hash;
use Auth;
use Image;
use Input;
class TravelNewsController extends Controller
{
    public function TravelNews(Request $r)
    {
        $blog = TravelNews::whereNotNull('id');
        if (!empty($r->q)) {
            $blog = $blog->where('title','LIKE','%'.$r->q.'%');
        }
        if (!empty($r->airline)) {
            $blog = $blog->where('airlines_id',$r->airline);
        }
        $data['news'] = $blog->paginate(10);
        $data['airlines'] = Airlines::orderBy('name','ASC')->get();
        return view('travelNews.travel-news',$data);

    }
    public function TravelNewsDetail($slug)
    {
        $data['detail'] = TravelNews::where('slug',$slug)->first();
        $data['meta_title'] = $data['detail']->meta_title;
        $data['meta_description'] = $data['detail']->meta_description;
        return view('travelNews.travel-news-detail',$data);

    }
    
}
