<?php

namespace Ojlinks\Http\Controllers;

//use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Ojlinks\Book;
use Illuminate\Support\Facades\Storage;

/**
 * BookstoreController handles the display of books on the pages.
 */
class BookstoreController extends Controller
{
    /**
     * Holds all the categories and sub categories of books in the database.
     * 
     * @var array
     */
    protected $bookArray;
    
    /**
     * A JSON object that holds all the categories and sub categories of books in the database.
     * 
     * @var string JSON
     */
    protected $JSONfile;

    /**
     * Initializes the class properties with values.
     */
    public function __construct()
    {
        $json = Storage::disk('local')->get('books.json');
        $this->JSONfile = $json;
        $this->bookArray = json_decode($json, true);     
    }
    
   
    public function testing(Request $request)
    {
        $name = $request->input('name');
        $pass = $request->input('pass');
        return "Your name is $name and you pass for $pass";

    }
    
    /**
     * Displays the home page to the user.
     * 
     * @return \Illuminate\View\View;
     */
    public function index()
    {
        return view('index');
    }
    
    /**
     * Checks of a the string passes is a valid category.
     * 
     * @param string $category
     * @return boolean
     */
    public function checkCategory($category)
    {
        return in_array($category, $this->bookArray['catArray']);
    }
    
    /**
     * Checks if the strings passed are valid category and sub category respectively.
     * 
     * 
     * @param string $category
     * @param string $subcategory
     * @return boolean
     */
    public function checkSubcategory($category, $subcategory)
    {
        if ($this->checkCategory($category)) {
            return in_array($subcategory, $this->bookArray['categories'][$category]);
        } else {
            return false;
        }  
    }
    
    /**
     * Returns a JSON string to the client containing book details.
     * This is in response to an AJAX request from the client.
     * 
     * @param string $category
     * @return \Illuminate\Http\Response
     */
    public function getBooks($category)
    {
        $books = Book::where('category', $category)->select('id', 'title', 'author', 'price', 'img')->inRandomOrder()->take(6)->get();
        return response(json_encode($books));
    }
    
    /**
     * Returns a JSON string of book categories and sub category to the client.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getJSONfile()
    {
        return response($this->JSONfile);
    }
    
    /**
     * Display a page with the requested category of books.
     * 
     * @param string $field
     * @return \Illuminate\View\View
     */
    public function field($field)
    {
        if (!$this->checkCategory($field)) {
            return view('errors.404');
        }
        $books = Book::where('category', $field)->select('id', 'title', 'author', 'price', 'img','details')->paginate(10);
        return view('field')->with(['field'=>$field,'books'=>$books]);
    }
    
    /**
     * Displays  a page with the requested sub category of books.
     * 
     * @param string $field
     * @param string  $subject
     * @return \Illuminate\View\View
     */
    public function subject($field, $subject)
    {
        if (!$this->checkSubcategory($field, $subject)) {
            return view('errors.404');
        }
        $books = Book::where(['category'=>$field, 'subcategory'=>$subject])->select('id', 'title', 'author', 'price', 'img','details')->paginate(10);
        return view('subject')->with(['field'=>$field, 'subject'=>$subject,'books'=>$books]);
    }
    
    /**
     * Displays a page with the request book whose id has been supplied.
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function book($id)
    {
        $book = Book::select('id', 'title', 'author', 'edition', 'price', 'category', 'subcategory', 'img','details', 'pages')->find($id);
        $bookArray = [$book];
        return view('book')->with(['book'=>$book, 'bookArray'=>$bookArray]);
    }
    
    /**
     * Provides auto suggest functionality for search form input field.
     * 
     * @param \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function suggest(Request $request)
    {
        $word = $request->input('word');
        $books = \DB::select("select title from books where title like '%$word%'");
        return response()->json($books);
    }
    
    /**
     * Provides search results after querying the database for search input string.
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function search(Request $request)
    {
        if ($request->has('search_phrase')) {
            $search_phrase = $request->input('search_phrase');
            session(['search_phrase'=>$search_phrase]);
        } else {
            $search_phrase =  session('search_phrase');
        }
        $books = Book::where('title','LIKE', "%$search_phrase%")->select('id', 'title', 'author', 'edition', 'price', 'category', 'subcategory', 'img', 'details')->paginate();
        return view('search')->with(['books'=>$books, 'search_phrase'=>$search_phrase]);
    }
}
