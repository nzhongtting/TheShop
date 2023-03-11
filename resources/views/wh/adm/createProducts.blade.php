@extends('wh.adm.admForm') 

@section('content')
<div class="pagetitle">
  <h1>Create Product</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/AdminPage">Home</a></li>
	  <li class="breadcrumb-item">Product</li>
	  <li class="breadcrumb-item active">Input-Form</li>
	</ol>
  </nav> 
</div><!-- End Page Title -->

<div class="card-body">
    <form action="{{ route('Product.Insert') }}" id="TableForm" name="TableForm" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    @if(!empty($test) && $test->count() )
        <div class="row mb-3"> 
            <label for="inputText" class="col-sm-2 col-form-label">Category select</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" id="level1" name="level1" onchange="viewCategory(this,2)">
                <option value=''>Open this select level1</option>
                @foreach($test as $column)
                <option value='{{$column->code}}'>{{$column->name}} {{$column->IR}}</option>
                @endforeach
                </select>
                <div id="box_level2" name="box_level2"></div>
                <div id="box_level3" name="box_level3"></div>
            </div>
        </div>
    @else
    @endif    

        <div class="row mb-3"> 
            <label for="inputText" class="col-sm-2 col-form-label">Product Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="pro_name" name="pro_name" >
            </div>
        </div>

        <div class="row mb-3"> 
            <label for="inputText" class="col-sm-2 col-form-label">Product Price</label>
            <div class="col-sm-10"> 
                <input type="number" min="1" step="any" class="form-control" id="pro_price" name="pro_price" >
            </div>
        </div>        

        <div class="row mb-3"> 
            <label for="inputText" class="col-sm-2 col-form-label">Product Image</label>
            <div class="col-sm-10"> 
            <input type="file" name="image" id="image" class="form-control">
            </div>
        </div>                
            
        <div class="row mb-3"> 
            <label for="inputText" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" style="height: 100px" id="pro_description" name="pro_description" ></textarea>
            </div>
        </div>
        
        
        <div class="row mb-3"> <label class="col-sm-2 col-form-label"></label><div class="col-sm-10"> <button type="button" onclick="runInsert()" class="btn btn-primary">Submit Form</button></div></div>
    </form>
</div>
<script>
    function runInsert()
    {
        F	= document.TableForm ;

        if( F.level1.value == '' )
        {
            alert('make a choice "Category" ');
        }
        else if( F.pro_name.value == '' )
        {
            alert('Input the Product Name');
            F.pro_name.focus();
        }
        else if( F.pro_price.value == '' )
        {
            alert('Input the Product Price');
            F.pro_price.focus();
        }
        else if( F.pro_description.value == '' )
        {
            alert('Input the Description');
            F.pro_description.focus();
        }        
        else
        {

            F.submit();
        }

    }


    function viewCategory(select,lvl)
    {

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        if( select.value !='' )
        {

                if(lvl==2)
                {
                    var Str = select.value ;
                    var cutStr = Str.substr(0, 2);
                }
                else if(lvl==3)
                {
                    var Str = select.value ;
                    var cutStr = Str.substr(0, 5);
                }

                var categoryobj = {};
                categoryobj.level   = lvl ;
                categoryobj.code    = cutStr ;

                $.ajax({
                        type:'POST',
                        dataType:"json",
                        url:'/viewCategoryList',
                        data:categoryobj,
                            success:function(data)
                            {

                                if(lvl==2)
                                {

                                    if( data.result_cnt1 > 0 )
                                    {
                                        var json1 = data.msg1
                                        $("#box_level2").html("<select class='form-select' aria-label='Default select example' id='level2' name='level2' onchange='viewCategory(this,3)' ><option value=''>Open this select level2</option></select>");

                                        for(var i = 0; i < json1.length; i++) 
                                        {
                                        var obj = json1[i];
                                        $("#level2").append('<option value="'+obj.code+'">'+obj.name+'</option>');
                                        console.log(obj.code, obj.name);
                                        }
                                    }
                                    else
                                    {
                                        $("#box_level2").html("");
                                    }

                                    if( data.result_cnt2 > 0 )
                                    {
                                        var json2 = data.msg2
                                        $("#box_level3").html("<select class='form-select' aria-label='Default select example' id='level3' name='level3'><option value=''>Open this select level3</option></select>");

                                        for(var i = 0; i < json2.length; i++) 
                                        {
                                        var obj = json2[i];
                                        $("#level3").append('<option value="'+obj.code+'">'+obj.name+'</option>');
                                        console.log(obj.code, obj.name);
                                        }
                                    }
                                    else
                                    {
                                        $("#box_level3").html("");
                                    }

                                }
                                else if(lvl==3)
                                {
                                    if( data.result_cnt > 0 )
                                    {
                                        var json = data.msg;
                                        $("#box_level3").html("<select class='form-select' aria-label='Default select example' id='level3' name='level3'><option value=''>Open this select level3</option></select>");                                    
                                    
                                        for(var i = 0; i < json.length; i++) 
                                        {
                                        var obj = json[i];
                                        $("#level3").append('<option value="'+obj.code+'">'+obj.name+'</option>');
                                        console.log(obj.code, obj.name);
                                        }                                    
                                    
                                    }
                                    else
                                    {
                                        $("#box_level3").html("");
                                    }                                                             
                                }

                            }
                        });

        }
        else
        {
            if(lvl==2)
            {
                $("#box_level2").html("");
                $("#box_level3").html("");
            }
            else if(lvl==3)
            {
                $("#box_level3").html("");
            }
        }


    }    

</script>
@endsection