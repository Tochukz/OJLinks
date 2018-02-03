<?php
namespace Ojlinks\Http\ViewComposers;
use Illuminate\Contracts\View\View;
use Storage;
class BookViewComposer{
    protected $categories;
    public function __construct(){
        $json = Storage::disk('local')->get('books.json');
        $bookArray = json_decode($json, true);
        $this->categories = $bookArray['categories'];
    }
    public function compose(View $view){
       $view->with(['categories'=>$this->categories]);
    }
}