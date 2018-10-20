@extends('layouts.app')

@section('content')
<div class="container">

  {!! Form::open(['url' => 'api/files', 'files' => true]) !!}
    {!! Form::file('f[]', ['multiple' => 'multiple']) !!}
    <button type = "submit">Submit</button>
  {!! Form::close() !!}

  <br>

  {!! Form::open(['url' => 'api/croaks', 'files' => true]) !!}
    content {!! Form::text('content') !!}
    type {!! Form::text('type') !!}
    x {!! Form::text('x') !!}
    y {!! Form::text('y') !!}
    <br>
    tags {!! Form::text('tags') !!}
    <br>
    file/s {!! Form::file('f[]', ['multiple' => 'multiple']) !!}
    <button type = "submit">Submit</button>
  {!! Form::close() !!}

</div>
@endsection
