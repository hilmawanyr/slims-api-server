<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiblioAuthor extends Model
{
	protected $table = 'biblio_author';

	public function biblio()
	{
		return $this->belongsTo('App\Models\Article','biblio_id');
	}
}
