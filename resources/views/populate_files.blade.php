@extends('layouts.app')

@section('content')
<div class="container">
	<h4>this is a script which will go through all files in the upload dir ('f') and add them to the database as a file object if they are not already added</h4>

	{!! Form::open(['url' => 'pfdb', 'method' => 'post']) !!}
		pass {!! Form::password('pass') !!}
		<br>
		<button type = "submit">Submit</button>
  {!! Form::close() !!}

</div>

@endsection
