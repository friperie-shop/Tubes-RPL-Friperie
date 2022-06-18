<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClickedProduct;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
    $productss = Product::whereHas(
      'categories',
      function (Builder $query) {
        $clickedProducts = DB::table('clicked_products')
                ->selectRaw('count(category_id) as number_of_category_ids, category_id');
        if (\Auth::user()) {
          $clickedProducts = $clickedProducts->where('user_id', '=', \Auth::user()->id);
        }                
        $clickedProducts = $clickedProducts->groupBy('category_id')              
                ->orderBy('number_of_category_ids', 'desc')
                ->get()
                ->first();
        if($clickedProducts) {
          $query->where('categories.id', '=', $clickedProducts->category_id);
        }
      }
    )->get();
    
		$this->data['products'] = $productss;

		$slides = Slide::active()->orderBy('position', 'ASC')->get();
		$this->data['slides'] = $slides;

		return $this->loadTheme('home', $this->data);
	}
}
