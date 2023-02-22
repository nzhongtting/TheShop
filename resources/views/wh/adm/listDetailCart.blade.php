@extends('wh.adm.admForm') 

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<div class="pagetitle">
  <h1>The Details of a cart</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/AdminPage">Home</a></li>
	  <li class="breadcrumb-item"><a href="/ListCart">Cart</a></li>
	  <li class="breadcrumb-item active">detail</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<div class="card">
    <div class="card-body" style="padding-bottom: 0px;">
        <h5 class="card-title">Checkout No : {{ $test1->order_no }}</h5>
        <table class="table table-striped">
        <thead>
        <tr>
        <th scope="col">Input Date</th>
        <th scope="col">Auth I.D</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Email</th>

        </tr></thead>
        
        <tbody>
            <tr>
                <td>{{ $test1->created_at }}</td>
                <th scope="row">{{ $test1->username }}</th>
                <td> {{ $test1->user_firstname }} </td>
                <td> {{ $test1->user_lastname }} </td>
                <td> {{ $test1->user_email }} </td>
                
            </tr>
        </tbody>
        </table>
    </div>

    <div class="card-body">
        <table class="table table-striped">
        <thead>
        <tr>
        <th scope="col">Grand-total</th>   
        <th scope="col">Sub-total</th>                 
        <th scope="col">Shipping Price</th>
        <th scope="col">tax</th>

        <th scope="col">order state</th>

        </tr></thead>
        
        <tbody>
            <tr>
                <th scope="row">{{ $test1->grandtotal }}</th>   
                <td> {{ $test1->subtotal }} </td>             
                <td>{{ $test1->shippingprice }}</td>
                <td> {{ $test1->tax }} </td>
                <td> {{ $test1->order_state }} </td>
                
            </tr>
        </tbody>
        </table>
    </div>    

</div>

<div class="card">
            <div class="card-body">

              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">updated</th>
					<th scope="col">sku</th>
                    <th scope="col">product name</th>
                    <th scope="col">price</th>
                    <th scope="col">quantity</th>                   
                  </tr>
                </thead>
                <tbody>
@if(!empty($test2) && $test2->count())

    @foreach($test2 as $column)
                  <tr>
                    <th scope="row" align=center></th>
                    <td>{{$column->updated_at}}</td>
                    <td>{{$column->sku}}</td>
                    <td>{{$column->name}}</td>
                    <td>{{$column->amount}}</td>
                    <td>{{$column->quantity}}</td>
                  </tr>
	@endforeach
@else
                  <tr>
                    <th scope="row" colspan=8>No Data!</th>
                  </tr>
@endif
                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>

@endsection