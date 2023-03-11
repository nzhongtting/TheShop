@extends('wh.adm.admForm') 

@section('content')
<div class="pagetitle">
  <h1>List Product</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/AdminPage">Home</a></li>
	  <li class="breadcrumb-item">Product</li>
	  <li class="breadcrumb-item active">list</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

          <div class="card">
            <div class="card-body">
              <h5 class="card-title" style="float:right">
				<a href="/CreateProducts" class="right-box btn btn-secondary">CREATE</a>
			  </h5>

              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">update</th>
                    <th scope="col">Category</th>
					<th scope="col">sku</th>
                    <th scope="col">name</th>
                    <th scope="col">price</th>
                  </tr>
                </thead>
                <tbody>
@if(!empty($test) && $test->count())

    @foreach($test as $column)
                  <tr>
                    <th scope="row" align=center>{{$column->updated_at}}</th>
                    <td>{{$column->category_name}} {{$column->upper}}</td>
                    <td>{{$column->sku}}</td>
                    <td><a href="{{ route('Product.Edit', $column->sku)}}">{{$column->name}}</a></td>
                    <td>{{$column->amount}}</td>
                  </tr>
	@endforeach
@else
                  <tr>
                    <th scope="row" colspan=5>No Data!</th>
                  </tr>
@endif
                </tbody>
              </table>
  {!! $test->links() !!}
              <!-- End Default Table Example -->
            </div>
          </div>

@endsection