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
    <form action="{{ route('Product.Insert') }}" id="TableForm" name="TableForm" method="POST">
    @csrf
    @method('PATCH')
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
            <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
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

        if( F.pro_name.value == '' )
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
</script>
@endsection