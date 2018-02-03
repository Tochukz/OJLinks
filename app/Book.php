<?php
namespace Ojlinks;
use Illuminate\Database\Eloquent\Model;

class Book extends Model{
	public $timestamps = false;
    //protected $fillable = ['id', 'title', 'author', 'edition', 'price', 'category', 'subcategory', 'details'];
    protected $guarded = ['date_added', 'added_by', 'image_type', 'availability'];
   
}