<?php

namespace Ojlinks\Http\Controllers;
use Ojlinks\Book;
use Illuminate\Http\Request;
use Ojlinks\Http\Requests\AdminRequest;

class AdminController extends Controller{
   public function __construct(){
        if(auth()->guest()){
            return redirect('/');
        }
   }
   public function category($category){
        $books = Book::where('category', $category)->paginate(5);
        return view('admin.category')->with('books', $books);

   }
   public function login(){
        return view('admin.login');
   }
   public function index(){
        return view('admin.index');
   }
   public function managebook($action){
        if(strtolower($action)=='add'){
            return view('admin.addbook');
        }
   }
   public function storebook(AdminRequest $request){       
        \DB::Transaction(function() use($request){
            $inputArray = $request->except(['_token', 'cover_photo']);
            $inputs = [];
            foreach($inputArray as $key=>$value){
                if($value!=''){
                    $inputs[$key]=$value;
                }
            }
            $inputs['date_added'] = time();
            $inputs['added_by'] = 'Tochukwu';
            $id = \DB::table('books')->insertGetId($inputs);

            //  [
            //     'title'=>$request->input('title'),
            //     'author'=>$request->input('author'),
            //     'edition'=>$request->input('edition'),
            //     'price'=>$request->input('price'),
            //     'category'=>$request->input('category'),
            //     'subcategory'=>$request->input('subcategory'),
            //     'details'=>$request->input('details'),
            //     'date_added'=>time(),
            //     'pages'=>$request->input('pages'),
            //     'language'=>$request->input('language'),
            //     'added_by'=>'Tochukwu'
            // ]
             if($request->hasFile('cover_photo') && $request->file('cover_photo')->isValid()){
                $fileObj = $request->file('cover_photo'); 
                $ext  = $fileObj->guessExtension();
                $imgExt = ($ext=='jpeg')? ".jpg" : ".$ext";
                $filename = $id.$imgExt;
                $fileObj->storeAs('book_img', $filename, 'public');
             }
            
             \DB::table('books')->where('id', $id)->update(['img'=>$filename]);
        });

        return redirect('admin/managebook/add');
      
   }
}

