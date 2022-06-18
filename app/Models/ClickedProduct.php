<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClickedProduct extends Model
{
	protected $guarded = [
		'id',    
		'created_at',
		'updated_at',
	];

	/**
	 * Define relationship with the Category
	 *
	 * @return void
	 */
	public function categories()
	{
		return $this->belongsToMany('App\Models\Category', 'product_categories');
	}

  /**
	 * Define relationship with the user
	 *
	 * @return void
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}
