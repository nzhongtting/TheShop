<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CartCRUD;
use App\OrderCRUD;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Auth;

class CartController extends Controller
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

    public $orderNo ;   // order Number

    public function index()
    {

		if (Auth::check() && Auth::user()->id == '1' )
		{          
            $test = CartCRUD::orderBy('id','desc')->where('username', '=', Auth::user()->email )->whereNull('checkoutNo')->paginate(1000);

            $totalCnt = DB::table('cart_tab')
            ->select('sku')
            ->where('username', '=', Auth::user()->email )
            ->whereNull('checkoutNo')
            ->count();
                    
            return view('wh.cart',compact('test','totalCnt'));
        }
        else
        {
        return redirect('/login');
        }            
    }

    public function removeCart(Request $request)
    {
		if (Auth::check() && Auth::user()->id == '1' )
		{        
            //dd('test'.$request['id']);
            CartCRUD::where('id', $request['id'])->delete();
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

    public function cartCheckOut(Request $request)
    {

		if (Auth::check() && Auth::user()->id == '1' )
		{ 

                $cart_T_list    = explode(',', $request-> input('finalyCartlist'));
                $collection1 = collect($cart_T_list);
                $multiplied = $collection1->map(function ($item, $key) {
                
                    $cutCart        = explode('/', $item);

                    $chkoutNo = Carbon::now()->timestamp; 
                    $this->orderNo = $chkoutNo;
                    $updateCart = DB::table('cart_tab')
                    ->where('id', '=', $cutCart[0] )
                    ->where('username', '=', Auth::user()->email )
                    ->update(['quantity' => $cutCart[1] , 'checkoutNo' => $chkoutNo  ,  'updated_at' => now() ]); 

                });

                $save_table = new OrderCRUD ;
                $save_table->order_no = $this->orderNo;
                $save_table->order_state ='Order completed';
                $save_table->username = Auth::user()->email ;
                $save_table->user_firstname = $request-> input('firstname');
                $save_table->user_lastname = $request-> input('lastname');
                $save_table->user_email = $request-> input('inputemail');
                $save_table->shippingprice = $request-> input('shippingPrice');
                $save_table->subtotal = $request-> input('subTotal');
                $save_table->tax = $request-> input('tAx');
                $save_table->grandtotal = $request-> input('grandTotal');
                $save_table->save();        

                return "<script> alert('Check-Out complete'); window.parent.location.href = '/products';</script>";

        }
        else
        {
        return redirect('/login');
        }  
    }
}
