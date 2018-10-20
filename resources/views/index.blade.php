<html>
	<head>
		<script src = "{{ URL::asset('/js/main.js') }}" type = "text/javascript"></script>
		<script src = "{{ URL::asset('/js/processing.js') }}" type = "text/javascript"></script>
		<script src = "https://unpkg.com/axios/dist/axios.min.js"></script>
		<link href = "{{ URL::asset('/css/style.css') }}" rel = "stylesheet" />
	</head>

	<body onload = "init()" onresize = "resize()"></body>

	<div id = "input-zone">
		<h4>Add something to the wall</h4>
		<div id = "input-select">
			<a href = "#" onclick = "updateViewInput(0)">Text</a>
			<a href = "#" onclick = "updateViewInput(1)">Audio</a>
			<a href = "#" onclick = "updateViewInput(2)">Image</a>
			<a href = "#" onclick = "updateViewInput(3)">Video</a>
		</div>
		<div id = "input-edit">
			<label>Write some text</label>
			<!--<button id = "buttonSubmit" onclick = "croak()">Publish</button> -->
			<br>
			<textarea rows = "4" cols = "60" id = "textIn" ></textarea>
		</div>
	</div>
	<div id = "display-zone">
		<canvas id = "canv" width="100%" height = "80%" style = "border:1px solid #030303;">


		</canvas>
	</div>
</html>
