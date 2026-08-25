<?php

namespace App\Http\Controllers\Api\v1;;

use App\Traits\RestApi;
use App\Utilities\ErrorStatusResponse;
use App\Utilities\GroceryValidator;
use App\Utilities\MobiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use Illuminate\Support\Facades\Input;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        if (!empty($r->top)) {
            return new CategoryCollection(Category::with('children')->whereNull('parent_id')->where('inTop',$r->top)->paginate());
        }else{
            return new CategoryCollection(Category::with('children')->whereNull('parent_id')->paginate());
            
        }
    }
    public function categories(Request $r)
    {
        $categories = Category::with('children',function($q){
            $q->with('products');
        })->where('category.id',$r->id)->paginate(10);

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
        ]);

        if ($validator->fails()) { 
            return new CategoryResource([], 404, $validator->errors()->toArray());
        }

        $fileName = "";
        $isUpload = false;
        if($request->has('image')){
            try {
                $file = $request->file('image');

                //Display File Name
                $fileName = $file->getClientOriginalName();
                //Move Uploaded File
                $destinationPath = storage_path('uploads');
                $file->move($destinationPath,$file->getClientOriginalName());
                $isUpload = true;
            } catch (Exception $e) {
                return new CategoryResource([], 400, trans('strings.id_not_found'));
            }         
        }

        // Update category
        $c = new Category;
        $c->name = $request->name;
        $c->inTop = $request->inTop;
        if($isUpload){
            $c->image = $fileName;
        }
        if($request->has("parent_id")){
           $c->parent_id = $request->get("parent_id");
       }
       $isSave = $c->save();
       if($isSave){
        return new CategoryResource($c);   
    }else{
        return new CategoryResource([], 400, trans('strings.default_error'));        
    }
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
        if(!is_numeric($id)){
            return new CategoryResource(Category::find($id), 404, trans('validation.is_numeric'));
        }

        return new CategoryResource(Category::find($id));
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
        //
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
        ]);

        if ($validator->fails()) { 
            return new CategoryResource([], 404, $validator->errors()->toArray());
        }

        $c = Category::where("id", $id)->first();
        if(is_null($c)){
            return new CategoryResource([], 404, trans('strings.id_not_found'));
        }else{
            $fileName = "";
            $isUpload = false;
            if($request->has('image')){
                try {
                    $file = $request->file('image');

                    //Display File Name
                    $fileName = $file->getClientOriginalName();
                    //Move Uploaded File
                    $destinationPath = storage_path('uploads');
                    if(file_exists($destinationPath."/".$c->image)){
                        unlink($destinationPath."/".$c->image);
                    }
                    $file->move($destinationPath,$file->getClientOriginalName());
                    $isUpload = true;
                } catch (Exception $e) {
                    return new CategoryResource([], 400, trans('strings.id_not_found'));
                }         
            }

            // Update category
            $c->name = $request->name;
            if($isUpload){
                $c->image = $fileName;
            }
            if($request->has("parent_id")){
                $c->parent_id = $request->get("parent_id");
            }
            $isSave = $c->save();
            if($isSave){
                return new CategoryResource($c);   
            }else{
                return new CategoryResource([], 400, trans('strings.default_error'));        
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!is_numeric($id)){
            return new CategoryResource(Category::find($id), 404, trans('validation.is_numeric'));
        }
        $c = Category::where("id", $id)->first();
        if(is_null($c)){
            return new CategoryResource([], 404, trans('strings.id_not_found'));
        }else{
            try {
                $destinationPath = storage_path('uploads');
                if(file_exists($destinationPath."/".$c->image)){
                    unlink($destinationPath."/".$c->image);
                }
                $c->delete();
                return new CategoryResource($c, 201, 'Data deleted successfully');
            } catch (Exception $e) {
                return new CategoryResource([], 400, 'Can not delete category with products');
            }
        }
    }

    public function getCategoriesWithSubCategories(Request $request){
        $mobiResponse = new MobiResponse();
        $validator = Validator::make(Input::all(),[
            'categoryId' => 'required',
        ]);
        if ($validator->fails()){
            return $mobiResponse->setMobiResponse($mobiResponse->getAllErrors($validator->errors(), ['categoryId']),ErrorStatusResponse::ERROR_RESPONSE);
        }
        $response = null;
        
        //if only one product
        if($request->get("categoryId") != -1 && $request->get("categoryId") != "-1"){
         $obj   =  Category::where("id","=",$request->get("categoryId"))->select("id","name")->first();
         $obj->products  = $obj->products()->paginate(env("PAGINATION_ITEMS_PER_PAGE",10));

         if($obj->children()->count() != 0){
            $obj->subCategory  = $obj->children()->select("id","name")->get();
            foreach ($obj->subCategory  as $subCategory){
                $subCategory->products =  $subCategory->products()->paginate(env("PAGINATION_ITEMS_PER_PAGE",10));
            }
        }else{
            $obj->subCategory = [];
        }
        $response =$obj;
    }
        //end of only one product    


        //for many products
    else{
     $objs   =  Category::select("id","name")->get();  
     if(!is_null($objs) && $objs->count()>0){
        foreach($objs as $obj){
            $obj->products  = $obj->products()->paginate(env("PAGINATION_ITEMS_PER_PAGE",10));

            if($obj->children()->count() != 0){
                $obj->subCategory  = $obj->children()->select("id","name")->get();
                foreach ($obj->subCategory  as $subCategory){
                    $subCategory->products =  $subCategory->products()->paginate(env("PAGINATION_ITEMS_PER_PAGE",10));
                }
            }else{
                $obj->subCategory = [];
            }    
                            }//end of loop
                        }
                        $response =$objs;       
                    }
        //end    



                    return $mobiResponse->setMobiResponse($response,ErrorStatusResponse::SUCCESS_RESPONSE);

                }
            }
