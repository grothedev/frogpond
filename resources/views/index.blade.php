@extends('layouts.app')

<?php include('functions.php') ?>

@section('content')
<br>
<div class = "container">
        <!-- TODO: jquery pull out for query settings -->

            <div class = "row">
                <h5>Welcome to the Pond</h5>
            </div>

            @foreach ($croaks as $c)
                <?php $tagsStr = getTagsAsStr($c); ?>

                <a href = "c/{!! $c->id !!}">
                <div class = "box croak-listitem">
                    <h6>{!! $c->created_at !!}</h6>
                   <p>{!! $c->content !!}</p>
                    
                    <small><b>Tags</b>: {!! $tagsStr !!}</small><br>
                    <small>{!! $c->replies !!} Replies</small><br>
                    @if (!is_null($file = getFile($c)))
                        <small>File: <a href = {!! $file->path !!}>{!! $file->filename !!}</a></small>
                    @endif
                </div>
                </a>
            @endforeach
            <center> - -- --- ----- -------- ----- --- -- -</center>
            <br>
    
</div>
@endsection