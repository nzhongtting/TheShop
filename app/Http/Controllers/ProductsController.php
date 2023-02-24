<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProductsCRUD;
use App\CartCRUD;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Auth;

class ProductsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if (Auth::check())
		{  

        $test = ProductsCRUD::orderBy('sku','desc')->paginate(6);

        $totalCnt = DB::table('cart_tab')
        ->select('sku')
        ->where('username', '=', Auth::user()->email )
        ->whereNull('checkoutNo')
        ->count();        

        return view('wh.products',compact('test','totalCnt'));

        }
        else
        {
        return redirect('/login');
        }        

    }

    public function cartCnt(Request $request)
    {

		if (Auth::check())
		{         

        $totalCnt = DB::table('cart_tab')
        ->select('sku')
        ->where('username', '=', Auth::user()->email )
        ->whereNull('checkoutNo')
        ->count();

        return response()->json(array('result_cnt'=>$totalCnt ), 200);   
        
        }
        else
        {
        return redirect('/login');
        }          
        
    }

    public function addCart(Request $request)
	{

		if (Auth::check())
		{         
                // dd('test'.$request['sku']);

                $msg = "" ;
                $result = DB::table('products_tab')
                ->select('name','sku','amount')
                ->where('sku', $request['sku'])
                ->first();
            
                $chkTabcnt = DB::table('cart_tab')
                ->select('sku')
                ->where('sku', '=', $request['sku'] )
                ->where('username', '=', Auth::user()->email )
                ->whereNull('checkoutNo')
                ->count();

                if( $chkTabcnt == 0 )    // create new one
                {
                    $save_table = new CartCRUD ;
                    $save_table->sku = $result->sku;
                    $save_table->username = Auth::user()->email;
                    $save_table->name = $result->name;
                    $save_table->amount = $result->amount;
                    $save_table->quantity = 1 ;
                    $save_table->save();
                    $msg = "Added new items to cart" ;
                }
                else if( $chkTabcnt == 1 )   // increment quantity
                {
                    $updateTable = DB::table('cart_tab')
                    ->where('sku', '=', $request['sku'] )
                    ->where('username', '=', Auth::user()->email )
                    ->whereNull('checkoutNo')
                    ->update([ 'quantity' => DB::raw('quantity+1') , 'updated_at' => now() ]);
                    $msg = "Item quantity added" ;
                }

                $totalCnt = DB::table('cart_tab')
                ->select('sku')
                ->where('username', '=', Auth::user()->email )
                ->whereNull('checkoutNo')
                ->count();


                return response()->json(array('msg'=> $msg , 'result_cnt'=>$totalCnt ), 200);
        }
        else
        {
        return redirect('/login');
        }             
    }
}
