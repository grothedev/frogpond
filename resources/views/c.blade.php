@extends('layouts.app')

<?php
  //setup nice looking date string
  include('functions.php');


  $tagStr = getTagsAsStr($c);
  $file = getFile($c);
  $fileHTML = 'No file attachments';

  if (!is_null($file)){

    if ( fileIsType($file['filename'], '.jpg') || fileIsType($file['filename'], '.jpeg') || fileIsType($file['filename'], '.gif') || fileIsType($file['filename'], '.png') ){
      $fileHTML = '<img width="1rem" height="auto" src = "../f/' . $file['filename'] . '"><a href = "../f/' . $file['filename'] . '"><br>' . $file['filename'] . '</a></img>';
    } else if (fileIsType($file['filename'], '.mp4') || fileIsType($file['filename'], '.mov') || fileIsType($file['filename'], '.mpeg') || fileIsType($file['filename'], '.avi')){
      $fileHTML = '<video controls src = "../f/' . $file['filename'] . '">Your browser does not support video player</video><a href = "../f/' . $file['filename'] . '"><br>' . $file['filename'] . '</a>';
    } else if (fileIsType($file['filename'], '.mp3') || fileIsType($file['filename'], '.flac') || fileIsType($file['filename'], '.ogg') || fileIsType($file['filename'], '.wav')){
      $fileHTML = '<audio controls> <source src = "../f/' . $file['filename'] . '">Your browser does not support audio player</audio><a href = "../f/' . $file['filename'] . '"><br>' . $file['filename'] . '</a>';
    } else $fileHTML = '<a href = "../f/' . $file['filename'] . '">' . $file['filename'] . '</a>';
  }
?>

@section('content')
  <div class = "container">
    <div class = "croak-box">
      <h4>{!! $c->created_at !!}</h4>
      <p>{!! $c->content !!}</p>
      <div style = "margin: 1rem">
        <small><i>Tags</i>: {!! $tagStr !!}</small>
      </div>
      <div style = "margin: 1.2rem">
        {!! $fileHTML !!}
      </div>
      <br>
      {!! Form::open(['url' => 'api/croaks', 'files' => true]) !!}
        Croak back: {!! Form::text('content') !!}
        <br>
        Attach file: {!! Form::file('f[]', ['multiple' => 'multiple']) !!}
        <input type = "hidden" value = "{{ $c->id }}" name = "p_id" />
        <input type = "hidden" value = "1" name = "redirect" />
        <button type = "submit">Submit</button>
      {!! Form::close() !!}
      <br>
    </div>
    @foreach ( $c->comments() as $comment )
      <a href = "/c/{{ $comment->id }}">
      <div class = "comment-box">
        <small><b>{{ $comment->created_at }}</b></small><br>
        {{ $comment->content }}
      </div>
      </a>
    @endforeach
</div>
@endsection
