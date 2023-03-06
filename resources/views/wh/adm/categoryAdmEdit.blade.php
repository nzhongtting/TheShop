@extends('wh.adm.admForm') 

    @php
    $viewExposed = ""; 
    if($result->exposed == 'Y') 
    {
        $viewExposed = " checked";
    } 
    else 
    {     $viewExposed = "";  } 
    @endphp

@section('content')

<div class="pagetitle">
  <h1>Edit Category</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/AdminPage">Home</a></li>
	  <li class="breadcrumb-item">Product</li>
	  <li class="breadcrumb-item active">Category</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<div class="card-body">
    <form action="{{ route('Category.Modify') }}" id="TableForm" name="TableForm" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

        <div class="row mb-3"> 
            <label for="inputText" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
            
            {{$result->upper}}

            </div>
        </div>        

        <div class="row mb-3"> 
            <label for="inputText" class="col-sm-2 col-form-label">Exposed</label>
            <div class="col-sm-10">
            <div class="form-check form-switch"> <input class="form-check-input" type="checkbox" id="exposed" name="exposed" {{$viewExposed}} > <label class="form-check-label" for="flexSwitchCheckDefault">YES</label></div>
            </div>
        </div>

        <div class="row mb-3"> 
            <label for="inputText" class="col-sm-2 col-form-label">Category Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="pro_name" name="pro_name" value='{{$result->name}}' placeholder="" >
            </div>
        </div>

        <div class="row mb-3"> <label class="col-sm-2 col-form-label"></label><div class="col-sm-10"> <button type="button" onclick="runInsert()" class="btn btn-primary">Submit Form</button></div></div>
        <input type=hidden name="resultId" id="resultId" value="{{$result->id}}">
    </form>
</div>

<script> 

function runInsert()
{
    F	= document.TableForm ;

    if( F.pro_name.value == '' )
    {
        alert('Input the Category Name');
        F.pro_name.focus();
    }
    else
    {
        F.submit();
    }

}

</script>

@endsection