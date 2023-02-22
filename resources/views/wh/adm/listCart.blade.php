@extends('wh.adm.admForm') 

@section('content')
<div class="pagetitle">
  <h1>List Cart</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/AdminPage">Home</a></li>
	  <li class="breadcrumb-item">Cart</li>
	  <li class="breadcrumb-item active">list</li>
	</ol>
  </nav>
</div><!-- End Page Title -->


          <div class="card">
            <div class="card-body">

              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">updated</th>
					<th scope="col">sku</th>
                    <th scope="col">Auth I.D</th>
                    <th scope="col">product name</th>
                    <th scope="col">price</th>
                    <th scope="col">quantity</th>
                    <th scope="col">checkout No.</th>                    
                  </tr>
                </thead>
                <tbody>
@if(!empty($test) && $test->count())

    @foreach($test as $column)
                  <tr>
                    <th scope="row" align=center></th>
                    <td>{{$column->updated_at}}</td>
                    <td>{{$column->sku}}</td>
                    <td>{{$column->username}}</td>
                    <td>{{$column->name}}</td>
                    <td>{{$column->amount}}</td>
                    <td>{{$column->quantity}}</td>
                    <td>
                        @if( !empty( $column->checkoutNo ) )                        
                        <a href="{{ route('Cart.ListDetail', $column->checkoutNo)}}">{{$column->checkoutNo}}</a>
                        @else
                        {{$column->checkoutNo}}
                        @endif
                    </td>
                  </tr>
	@endforeach
@else
                  <tr>
                    <th scope="row" colspan=8>No Data!</th>
                  </tr>
@endif
                </tbody>
              </table>
  {!! $test->links() !!}
              <!-- End Default Table Example -->
            </div>
          </div>

@endsection