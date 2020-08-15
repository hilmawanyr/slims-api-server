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

    public function index(int $limit=25, int $page=0) : array
    {
        $_page  = $page === 0 ? 0 : ($page*10);
        $biblio = Biblio::getArticles($limit, $_page);

        foreach ($biblio as $value) {
            $response[] = [
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
