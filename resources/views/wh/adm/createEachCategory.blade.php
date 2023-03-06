@extends('wh.adm.admForm') 

@section('content')

<div class="pagetitle">
  <h1>Each Create Category</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/AdminPage">Home</a></li>
	  <li class="breadcrumb-item">Product</li>
	  <li class="breadcrumb-item active">Category</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<div class="card-body">
    <form action="{{ route('Category.EachInsert') }}" id="TableForm" name="TableForm" method="POST" enctype="multipart/form-data">
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
            <div class="form-check form-switch"> <input class="form-check-input" type="checkbox" id="exposed" name="exposed" > <label class="form-check-label" for="flexSwitchCheckDefault">YES</label></div>
            </div>
        </div>

        <div class="row mb-3"> 
            <label for="inputText" class="col-sm-2 col-form-label">Category Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="pro_name" name="pro_name" value='' placeholder="INPUT Category name of {{$result->placeholder}}" >
            </div>
        </div>

        <div class="row mb-3"> <label class="col-sm-2 col-form-label"></label><div class="col-sm-10"> <button type="button" onclick="runInsert()" class="btn btn-primary">Submit Form</button></div></div>
        <input type=hidden id="eachCreateLvl" name="eachCreateLvl" value="{{$result->placeholder}}">
        <input type=hidden id="uppercode" name="uppercode" value="{{$result->code}}">
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