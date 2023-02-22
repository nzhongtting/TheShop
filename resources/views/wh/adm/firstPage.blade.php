@extends('wh.adm.admForm') 

@section('content')

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="/AdminPage">Home</a></li>
	  <li class="breadcrumb-item active">Dashboard</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
