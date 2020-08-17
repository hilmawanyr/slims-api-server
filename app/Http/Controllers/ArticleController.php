<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article as Biblio;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function index(Request $request) : array
    {
        $limit  = $request->query('rows') ? $request->query('rows') : 25;
        $page   = $request->query('page') 
                    ? ($request->query('page') == 1 ? 0 : ($request->query('page')*10)) 
                    : 0;
        $biblio = Biblio::getArticles($limit, $page);


        $response['code']       = '1';
        $response['status']     = 'request success';
        $response['message']    = 'successfully return random article';
        $response['total_rows'] = $biblio->count();
        
        foreach ($biblio as $value) {
            $response['items'][] = [
                'title'          => $value->title,
                'publish_year'   => $value->publish_year,
                'image'          => $value->image,
                'author_name'    => $value->author_name,
                'publisher_name' => $value->publisher_name,
                'place_name'     => $value->place_name,
                'items'          => Biblio::getExemplar($value->biblio_id)
            ];
        }

        return $response;
    }
}
