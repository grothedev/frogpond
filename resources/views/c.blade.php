@extends('layouts.app')

<?php
  //setup nice looking date string

  $tags = [];
  $tagStr = '';
  foreach ($c->tags as $t){
    array_push($tags, $t->label);
    $tagStr .= $t->label . ', ';
  }

  $file = $c->files->first();
  $fHTML = 'No file attachments';
  if (!is_null($file)){
    
    if ( fileIsType($file['filename'], '.jpg') || fileIsType($file['filename'], '.jpeg') || fileIsType($file['filename'], '.gif') || fileIsType($file['filename'], '.png') ){
      $fileHTML = '<img src = "../f/' . $file['filename'] . '"><a href = "../f/' . $file['filename'] . '"><br>' . $file['filename'] . '</a></img>';  
    } else if (fileIsType($file['filename'], '.mp4') || fileIsType($file['filename'], '.mov') || fileIsType($file['filename'], '.mpeg') || fileIsType($file['filename'], '.avi')){
      $fileHTML = '<video controls src = "../f/' . $file['filename'] . '">Your browser does not support video player</video><a href = "../f/' . $file['filename'] . '"><br>' . $file['filename'] . '</a>';  
    } else if (fileIsType($file['filename'], '.mp3') || fileIsType($file['filename'], '.flac') || fileIsType($file['filename'], '.ogg') || fileIsType($file['filename'], '.wav')){
      $fileHTML = '<audio controls> <source src = "../f/' . $file['filename'] . '">Your browser does not support audio player</audio><a href = "../f/' . $file['filename'] . '"><br>' . $file['filename'] . '</a>';  
    } else $fileHTML = '<a href = "../f/' . $file['filename'] . '">' . $file['filename'] . '</a>';
  }

  function fileIsType($fn, $ext){
    $e = strlen($fn) - strlen($ext);
    return ( stripos($fn, $ext) == $e);
  }
?>

@section('content')
<div class = "container">
    <h4>{!! $c->created_at !!}</h4>
    <p>{!! $c->content !!}</p>
    <div style = "margin: 1rem">
      <small><i>Tags</i>: {!! $tagStr !!}</small>
    </div>
    <div style = "margin: 1.2rem">
      {!! $fileHTML !!} 
    </div>
    <br>
</div>
@endsection