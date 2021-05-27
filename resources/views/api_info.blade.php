@extends('layouts.app')

@section('content')
<div class="container">
    <h4>REST API</h4>
    <h6><a href = "https://github.com/grothedev/frogpond">Source on GitHub</a></h6>
    <p>
        Welcome to the frogpond API. Feel free to use this for your own frogpond client application, or spin up your own server. 
    </p>

    <h5>Endpoints:</h5> <small>Instructions on GitHub</small>
    <ul>
        <li><a href = "/api/croaks">/api/croaks</a></li>
        <li><a href = "/api/tags">/api/tags</a></li>
        <li><a href = "/api/files">/api/files</a></li>
        <li><a href = "/api/votes">/api/votes</a></li>
        <li><a href = "/api/reports">/api/reports</a></li>
    </ul>
</div>
@endsection