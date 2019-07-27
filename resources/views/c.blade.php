@extends('layouts.app')

<?php
  //setup nice looking date string

  $tags = [];
  $tagStr = '';
  foreach ($c->tags as $t){
    array_push($tags, $t->label);
    $tagStr .= $t->label . ', ';
  }
?>

<html>
  <div id = "container">
    <h3>{!! $c->created_at !!}</h3>
    <p>{!! $c->content !!}</p>
    <small><i>Tags</i>: {!! $tagStr !!}</small>
  </div>
</html>
