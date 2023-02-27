<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductsCRUD;
use App\CartCRUD;
use App\OrderCRUD;
use Illuminate\Support\Facades\DB;

use Auth;

class AdmPageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
		if (Auth::check())
		{        
		$uri = $request->path();
        return view('wh.adm.firstPage',compact('uri'));
        }
        else
        {
        return redirect('/login');
        }        
    }
    
    public function listProducts(Request $request)
    {
		if (Auth::check())
		{
            $test = ProductsCRUD::orderBy('sku','desc')->paginate(10);
            $uri = $request->path();
            return view('wh.adm.listProducts',compact('test','uri'));
		}
		else
		{
		return redirect('/login');
		}
    }

    public function createProducts(Request $request)
    {
		if (Auth::check())
		{
            $uri = $request->path();
            return view('wh.adm.createProducts',compact('test','uri'));
		}
		else
		{
		return redirect('/login');
		}
    }

    public function insertProducts(Request $request)
    {
      if (Auth::check())
      {

        $urlpath    = "";
        $imageName  = "";

        if(isset($_FILES['image']) && $_FILES['image']['name'] != "")
        {
          $urlpath = "wh/assets/img/product/";
          $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          ]);
          $imageName = time().'.'.$request->image->extension();
          $request->image->move(public_path($urlpath), $imageName); 
        }
        else {}
                               

          $save_table = new ProductsCRUD ;
          $save_table->name = $request-> input('pro_name');
          $save_table->amount = $request-> input('pro_price');
          $save_table->image_url = $urlpath.$imageName ;
          $save_table->description = $request-> input('pro_description');
          $save_table->save(); 

          return redirect('/ListProducts');
      }
      else
      {
      return redirect('/login');
      }        
    }

    public function productAdmEdit($Id)
	{

		if (Auth::check())
		{

			$test = ProductsCRUD::where('sku', $Id)->firstOrFail();
			$uri = 'ListProducts';

			return view('wh.adm.productAdmEdit', compact('test','uri'));
		}
		else
		{
		return redirect('/login');
		}
	}    

	public function productUpdate(Request $request)
	{
		if (Auth::check())
		{
            $id		= $request-> input('pro_sku');

            $urlpath    = "";
            $imageName  = "";
            $sumimgUrl = $request-> input('old_img_url') ;

            if(isset($_FILES['image']) && $_FILES['image']['name'] != "")
            {
              $urlpath = "wh/assets/img/product/";
              $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
              $imageName = time().'.'.$request->image->extension();
              $request->image->move(public_path($urlpath), $imageName); 
              $sumimgUrl = $urlpath.$imageName ;              
            }
            else {}

            $affected = DB::table('products_tab')
            ->where('sku', $id)
            ->update(['name' => $request-> input('pro_name') , 'amount' => $request-> input('pro_price') , 'image_url' => $sumimgUrl  , 'description' => $request-> input('pro_description')  , 'updated_at' => now() ]);            
            return redirect('/ListProducts');
        }
        else
        {
        return redirect('/login');
        }        
    } 

    public function listDetailCart($Id)
    {
		if (Auth::check())
		{
            $test1 = OrderCRUD::where('order_no', $Id)->firstOrFail();
            $test2 = CartCRUD::where('checkoutNo', $Id)->orderBy('id','desc')->paginate(1000);
			$uri = 'ListCart';

			return view('wh.adm.listDetailCart', compact('test1','test2','uri'));     

		}
		else
		{
		return redirect('/login');
		}
    }

    public function listCart(Request $request)
    {
		if (Auth::check())
		{
            $test = CartCRUD::orderBy('id','desc')->paginate(10);
            $uri = $request->path();

            return view('wh.adm.listCart',compact('test','uri'));            
		}
		else
		{
		return redirect('/login');
		}
    }

}
