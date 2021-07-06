@extends('layouts.app')

@section('content')
<div class="container">

  <h3>File upload</h3>
  {!! Form::open(['url' => 'api/files', 'files' => true]) !!}
    {!! Form::file('f[]', ['multiple' => 'multiple']) !!}
    Tag (optional): <input type = "text" name = "tag" />
    <button type = "submit">Submit</button>
  {!! Form::close() !!}

  <br>

  <h3>Croak post</h3>
  {!! Form::open(['url' => 'api/croaks', 'files' => true]) !!}
    content {!! Form::text('content') !!}
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
    croak id {!! Form::text('croak_id') !!}
    up/down {!! Form::text('v') !!}
    <button type = "submit">Submit</button>
  {!! Form::close() !!}

  <br>

  <h3>Report croak</h3>
  {!! Form::open(['url' => 'api/croaks/report']) !!}
    croak id {!! Form::text('croak_id') !!}
    reason {!! Form::text('reason') !!}
    <button type = "submit">Submit</button>
  {!! Form::close() !!}

  <br>

  <h3>Croak Comment post</h3>
  {!! Form::open(['url' => 'api/croaks', 'files' => true]) !!}
    content {!! Form::text('content') !!}
    parent id {!! Form::text('p_id') !!}
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
