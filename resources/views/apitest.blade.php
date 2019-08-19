@extends('layouts.app')

@section('content')
<div class="container">

  <h3>File upload</h3>
  {!! Form::open(['url' => 'api/files', 'files' => true]) !!}
    {!! Form::file('f[]', ['multiple' => 'multiple']) !!}
    <button type = "submit">Submit</button>
  {!! Form::close() !!}

  <br>

  <h3>Croak post</h3>
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

  <br>

  <h3>Vote cast</h3>
  {!! Form::open(['url' => 'api/votes']) !!}
    croak id {!! Form::text('croak id') !!}
    up/down {!! Form::checkbox('checked=up; unchecked=down', 'v') !!}
    <button type = "submit">Submit</button>
  {!! Form::close() !!}

</div>
@endsection
