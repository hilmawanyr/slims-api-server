<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
	protected $table = 'biblio';
    protected $primaryKey = 'biblio_id';

    /**
     * Return random articles
     * 
     * @param 	{int}	$limit
     * @param 	{int}	$page
     * @return 	{obj}
     */    
    public static function getArticles(int $limit, int $page) : object
    {
    	$articles = DB::table('biblio as bbl')
    					->selectRaw('
    						bbl.biblio_id,
    						bbl.title,
    						bbl.publish_year,
    						bbl.image,
    						aut.author_name,
    						pub.publisher_name,
    						pla.place_name')
    					->join('biblio_author as bba', 'bbl.biblio_id', '=', 'bba.biblio_id')
    					->join('mst_author as aut', 'bba.author_id', '=', 'aut.author_id')
    					->join('mst_publisher as pub', 'bbl.publisher_id', '=', 'pub.publisher_id')
    					->join('mst_place as pla', 'bbl.publish_place_id', '=', 'pla.place_id')
    					->offset($page)
    					->limit($limit)
    					->get();
    	return $articles;
    }

    /**
     * Get book exemplar by its biblio ID
     * 
     * @param 	{int}	$biblioID
     * @return 	{obj}
     */
    public static function getExemplar(int $biblioID) : object
    {
    	$exemplar = DB::table('item as itm')
    					->selectRaw('
    						itm.item_code as code, 
    						loa.is_return as available_flag, 
    						IF(loa.is_return = 1, "available", "not available") as available_desc')
    					->join('loan as loa', 'itm.item_code', '=', 'loa.item_code')
    					->where('itm.biblio_id', $biblioID)
    					->groupBy('itm.item_code','loa.is_return')
    					->orderByDesc('loa.loan_id')
    					->get();
    	return $exemplar;
    }
}