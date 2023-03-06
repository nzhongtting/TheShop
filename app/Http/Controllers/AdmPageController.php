<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductsCRUD;
use App\CartCRUD;
use App\OrderCRUD;
use App\TheshopCategoryCRUD;
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
              $uri = 'ListProducts';
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

    // Category 
    public function insertCategory(Request $request)
    {

      if (Auth::check())
      {

        if($request-> input('pro_name'))
        {
          if( $request-> input('level1') =='' && $request-> input('level2') =='')
          {

            // make code of level 1
            $new_lvl1 = DB::table('theshopcategory_tab')
            ->select('code','level')
            ->selectRaw('(SUBSTR(code,1,2)*1)+1 AS next_code1')
            ->selectRaw('SUBSTR(code,1,2) AS substrTxt')
            ->where('level', '1')
            ->orderBy('substrTxt', 'DESC')
            ->first();

            if( is_null($new_lvl1) )
            {
              $nextCode = sprintf('%02d',1);
            }
            else
            {
              $nextCode = sprintf('%02d',$new_lvl1->next_code1);
            }

            $lastcode = $nextCode."000000";
            $level    = "1";
          }
          else if( $request-> input('level1') && $request-> input('level2') =='' )
          {
            // DB::enableQueryLog();
            $cut = substr($request-> input('level1'), 0, 2);

            // make code of level 2
            $new_lvl2 = DB::table('theshopcategory_tab')
            ->select('code','level')
            ->selectRaw('(SUBSTR(code, 3, 3)*1+1) AS next_code2')
            ->selectRaw('SUBSTR(code, 3, 3) AS substrTxt')
            ->where('level', '2')
            ->whereRaw('SUBSTR(code,1,2) ='.$cut)
            ->orderBy('substrTxt', 'DESC')
            ->first();

            // print_r(DB::getQueryLog());
            
            if( is_null($new_lvl2) )
            {
              $nextCode = sprintf('%03d',1);
            }
            else
            {
              $nextCode = sprintf('%03d',$new_lvl2->next_code2);
            }
            $lastcode = $cut.$nextCode."000";
            $level    = "2";

          }
          else if( $request-> input('level1') && $request-> input('level2') )
          {
            $cut = substr($request-> input('level2'), 0, 5);

            // make code of level 3
            $new_lvl3 = DB::table('theshopcategory_tab')
            ->select('code','level')
            ->selectRaw('((SUBSTR(code, 6, 3)*1)+1) AS next_code3')
            ->selectRaw('SUBSTR(code, 6, 3) AS substrTxt')
            ->where('level', '3')
            ->whereRaw('SUBSTR(code,1,5) = '.$cut)   
            ->orderBy('substrTxt', 'DESC')
            ->first();

            if( is_null($new_lvl3) )
            {
              $nextCode = sprintf('%03d',1);
            }
            else
            {
              $nextCode = sprintf('%03d',$new_lvl3->next_code3);
            }          

            $lastcode = $cut.$nextCode;
            $level    = "3"; 
          }

          if($request-> input('exposed') =='on')
          {
            $exposed = "Y";
          }
          else
          {
            $exposed = "N";
          }


          $save_table             = new TheshopCategoryCRUD ;
          $save_table->code       = $lastcode ;
          $save_table->level      = $level;
          $save_table->name       = $request-> input('pro_name');
          $save_table->exposed    = $exposed;        
          $save_table->save();
        }

        return redirect('/createCategory');

    }
    else
    {
    return redirect('/login');
    }      
      
    }

    public function createCategory(Request $request)
    {
      if (Auth::check())
      {

              $uri = 'ListCategory';

              $test = TheshopCategoryCRUD::where('level', '1')->orderBy('id','desc')->get();
              return view('wh.adm.createCategory',compact('test','uri'));
      }
      else
      {
      return redirect('/login');
      }
    }

  public function viewCategorylist(Request $request)
	{
    // dd($request['level']."  ".$request['code']);
    if (Auth::check())
    {
        if( $request['level'] == '2')
        {
          $viewTxt1    = TheshopCategoryCRUD::where('level', $request['level'])->whereRaw('SUBSTR(code,1,2) ='.$request['code'])->orderBy('id','desc')->get();
          $viewTxt1Cnt = TheshopCategoryCRUD::where('level', $request['level'])->whereRaw('SUBSTR(code,1,2) ='.$request['code'])->count();
        
          $collection1 = collect([]);
          foreach ($viewTxt1 as $p) {
            $collection1->push(['code' =>  $p->code, 'name' => $p->name]);
          }  


          $viewTxt2    = TheshopCategoryCRUD::where('level', 3)->whereRaw('SUBSTR(code,1,2) ='.$request['code'])->orderBy('id','desc')->get();
          $viewTxt2Cnt = TheshopCategoryCRUD::where('level', 3)->whereRaw('SUBSTR(code,1,2) ='.$request['code'])->count();

          $collection2 = collect([]);
          foreach ($viewTxt2 as $p) {
            $collection2->push(['code' =>  $p->code, 'name' => $p->name]);
          }

          return response()->json(array('msg1'=> $collection1, 'result_cnt1'=>$viewTxt1Cnt , 'msg2'=> $collection2, 'result_cnt2'=>$viewTxt2Cnt ), 200);        

        }
        else
        {
    
          $viewTxt    = TheshopCategoryCRUD::where('level', 3)->whereRaw('SUBSTR(code,1,5) ='.$request['code'])->orderBy('id','desc')->get();
          $viewTxtCnt = TheshopCategoryCRUD::where('level', 3)->whereRaw('SUBSTR(code,1,5) ='.$request['code'])->count();      

          $collection2 = collect([]);

          foreach ($viewTxt as $p) {
            $collection2->push(['code' =>  $p->code, 'name' => $p->name]);
          }

          return response()->json(array('msg'=> $collection2, 'result_cnt'=>$viewTxtCnt ), 200);  
        }
    }
  }
  
  public function listCategory(Request $request)
  {
    if (Auth::check())
    {
            $test = TheshopCategoryCRUD::orderBy('id','desc')->paginate(10);
            $categoryname = "";

            foreach($test as $column)
            {
                if($column->level == 3)
                {
                  $cut1 = substr($column->code,0,2)."000000";
                  $cut2 = substr($column->code,0,5)."000";
                  $cut1name = DB::table('theshopcategory_tab')->where('code', $cut1)->pluck('name');
                  $cut2name = DB::table('theshopcategory_tab')->where('code', $cut2)->pluck('name');
                  
                  $categoryname = " < ".$cut2name[0]." < ".$cut1name[0] ;
                }
                else if($column->level == 2)
                {
                  $cut1 = substr($column->code,0,2)."000000";
                  $cut1name = DB::table('theshopcategory_tab')->where('code', $cut1)->pluck('name');

                  $categoryname = " < ".$cut1name[0] ;
                }
                else
                {
                  $categoryname ="";
                }
                $column->upper = $categoryname ;
            }

            // No. ---- Start
            $total = $test->total();
            $perpage = $test->perPage();
            $currentpage = $test->currentPage();
            $count = 0;

            $test->getCollection()->transform(function ($test) use ($total, $perpage, $currentpage, &$count) {
            $test->number = ($total - ($perpage * ($currentpage - 1))) - $count;
            $count++;
            return $test;
          });
            // No. ---- End          

            $uri = $request->path();
            return view('wh.adm.listCategory',compact('test','uri'));
    }
    else
    {
    return redirect('/login');
    }
  }

  public function categoryAdmEdit($Id)
	{

		if (Auth::check())
		{

			$uri = 'ListCategory';
      $result = TheshopCategoryCRUD::where('code', $Id)->firstOrFail();

      $categoryname = "";

      if($result->level == 3)
      {
        $cut1 = substr($result->code,0,2)."000000";
        $cut2 = substr($result->code,0,5)."000";
        $cut1name = DB::table('theshopcategory_tab')->where('code', $cut1)->pluck('name');
        $cut2name = DB::table('theshopcategory_tab')->where('code', $cut2)->pluck('name');

        $categoryname = $cut1name[0] ." > ". $cut2name[0] ." > 3 Level " ;
      }
      else if($result->level == 2)
      {
        $cut1 = substr($result->code,0,2)."000000";
        $cut1name = DB::table('theshopcategory_tab')->where('code', $cut1)->pluck('name');

        $categoryname = $cut1name[0] ." > 2 Level " ;
      }
      else
      {
        $categoryname = "1 Level";
      }

      $result->upper = $categoryname ; 
      
      
      return view('wh.adm.categoryAdmEdit', compact('result','uri'));
		}
		else
		{
		return redirect('/login');
		}
	}

	public function categoryUpdate(Request $request)
	{
		if (Auth::check())
		{
      $id		= $request-> input('resultId');

      if($request-> input('exposed') =='on')
      {
        $exposed = "Y";
      }
      else
      {
        $exposed = "N";
      }

      $affected = DB::table('theshopcategory_tab')
      ->where('id', $id)
      ->update(['name' => $request-> input('pro_name') , 'exposed' => $exposed , 'updated_at' => now() ]);
      return redirect('/ListCategory');
    }
    else
    {
      return redirect('/login');
    }
  }


  public function categoryEachCreate($Id)
	{

		if (Auth::check())
		{

			$uri = 'ListCategory';
      $result = TheshopCategoryCRUD::where('code', $Id)->firstOrFail();

      $categoryname = "";
      $placeholder  = "";

      if($result->level == 1)
      {
        $cut1name = DB::table('theshopcategory_tab')->where('code', $result->code)->pluck('name');
        $categoryname = $cut1name[0] ." > 2 Level " ;
        $placeholder  = "Level2";
      }
      else if($result->level == 2)
      {
        $cut1 = substr($result->code,0,2)."000000";
        $cut2 = substr($result->code,0,5)."000";
        $cut1name = DB::table('theshopcategory_tab')->where('code', $cut1)->pluck('name');
        $cut2name = DB::table('theshopcategory_tab')->where('code', $cut2)->pluck('name'); 
        $categoryname = $cut1name[0] ." > ". $cut2name[0] ." > 3 Level " ;
        $placeholder  = "Level3";   
      }

      $result->upper = $categoryname ;
      $result->placeholder = $placeholder ; 
      
      return view('wh.adm.createEachCategory', compact('result','uri'));
		}
		else
		{
		return redirect('/login');
		}
	}  
  
  public function eachInsertCategory(Request $request)
  {
		if (Auth::check())
		{    
          if( $request-> input('eachCreateLvl') == "Level2" )
          {
              $cut = substr($request-> input('uppercode'), 0, 2);

                // make code of level 2
                $new_lvl2 = DB::table('theshopcategory_tab')
                ->select('code','level')
                ->selectRaw('(SUBSTR(code, 3, 3)*1+1) AS next_code2')
                ->selectRaw('SUBSTR(code, 3, 3) AS substrTxt')
                ->where('level', '2')
                ->whereRaw('SUBSTR(code,1,2) ='.$cut)
                ->orderBy('substrTxt', 'DESC')
                ->first();

                if( is_null($new_lvl2) )
                {
                  $nextCode = sprintf('%03d',1);
                }
                else
                {
                  $nextCode = sprintf('%03d',$new_lvl2->next_code2);
                }
                $lastcode = $cut.$nextCode."000";
                $level    = "2";            

          }
          else if( $request-> input('eachCreateLvl') == "Level3" )
          {
                $cut = substr($request-> input('uppercode'), 0, 5);

                // make code of level 3
                $new_lvl3 = DB::table('theshopcategory_tab')
                ->select('code','level')
                ->selectRaw('((SUBSTR(code, 6, 3)*1)+1) AS next_code3')
                ->selectRaw('SUBSTR(code, 6, 3) AS substrTxt')
                ->where('level', '3')
                ->whereRaw('SUBSTR(code,1,5) = '.$cut)   
                ->orderBy('substrTxt', 'DESC')
                ->first();

                if( is_null($new_lvl3) )
                {
                  $nextCode = sprintf('%03d',1);
                }
                else
                {
                  $nextCode = sprintf('%03d',$new_lvl3->next_code3);
                }          

                $lastcode = $cut.$nextCode;
                $level    = "3";         
          }

          if($request-> input('exposed') =='on')
          {
            $exposed = "Y";
          }
          else
          {
            $exposed = "N";
          }      

          $save_table             = new TheshopCategoryCRUD ;
          $save_table->code       = $lastcode ;
          $save_table->level      = $level;
          $save_table->name       = $request-> input('pro_name');
          $save_table->exposed    = $exposed;        
          $save_table->save();      

          return redirect('/ListCategory');
    }
    else
    {
    return redirect('/login');
    }          
  }

}
