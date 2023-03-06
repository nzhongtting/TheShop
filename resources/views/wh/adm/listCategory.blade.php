@extends('wh.adm.admForm') 
<style>
    .th_align
    {
        text-align:center;
	}

</style>
@section('content')
<div class="pagetitle">
  <h1>List Category</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/AdminPage">Home</a></li>
	  <li class="breadcrumb-item">Category</li>
	  <li class="breadcrumb-item active">list</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<div class="card">
    <div class="card-body">
        <h5 class="card-title" style="float:right">
        <a href="/createCategory" class="right-box btn btn-secondary">CREATE</a>
        </h5>


        <table class="table table-bordered">
	<colgroup>
	<col width="5" title="No">    
	<col width="*" title="Category name">
	<col width="10%" title="exposed">
	<col width="10%" title="*">
	<col width="20%" title="Category Create">
	</colgroup>
	<thead>
	<tr> 
        <th class="th_align">No.</th>        
		<th>Category name</th>
		<th class="th_align">exposed</th>
		<th class="th_align">*</th>
		<th class="th_align">Create Category</th>
	</tr>
	</thead>
	<tbody>
@if(!empty($test) && $test->count())
    @foreach($test as $column)
	<tr> <!-- danger --><!-- primary --><!-- warning -->
        <td>{{$column->number}}</td>
		<td><span class="btn btn-light btn-xs btn-grad btn-rect">&nbsp;&nbsp;{{$column->level}} Level&nbsp;&nbsp;</span>&nbsp;&nbsp;<b>{{$column->name}}</b>{{$column->upper}}</td>
		<td class="text-center"><span class="btn btn-default btn-sm">{{$column->exposed}}</span></td>
		<td class="text-center">
			<a href="{{ route('Category.Edit', $column->code)}}" class="btn btn-primary btn-sm">Modify</a>
			<!-- <a href="#" class="btn btn-danger btn-sm">Delete</a> //-->
		</td>
		<td class="text-center">
        @php
            $amount = 0 ;
            if($column->level < 3) 
            {
                $levelNo = $column->level + 1 ;
        @endphp
                <a href="{{ route('Category.EachCreate', $column->code)}}" class='btn btn-dark btn-sm'>Create {{$levelNo}} level</a>
        @php
            }
            else { }
        @endphp

		</td>
	</tr>
	@endforeach
@else
    <tr><td colspan=4></td></tr>
@endif

		</tbody>
	</table>
{!! $test->links() !!}



    </div>
</div>    

@endsection