<!-- copied this template over from ESW site -->
<!DOCTYPE html>
<html lang="en">

	<title>The Pond</title>

	<head>
		<link href = "{{{ asset('css/skeleton.css') }}}" rel = "stylesheet" />
    <link href = "{{{ asset('css/style.css') }}}" rel = "stylesheet" />
    <meta name = "keywords" content = "todo"/>
	</head>

	<div class = "banner">
		<div class = "banner-title">
			<h1>Frog Pond</h1>
		</div>
	</div>

  <!-- sidebar obsolete
	<div class = "sidebar">
		<div class = "nav-link">
			<ul>
				<li><a href = "/">About</a></li>
				<li><a href = "/projects">Projects</a></li>
			</ul>
			<br>

		</div>
	</div>
  -->

  @yield('content')

	<div class = "footer">
		<a href = "/about">About FrogPond</a>
		<div style = "float:right;">
			<a href = "https://github.com/grothedev/frogpond">Source Code</a>
		</div>
	</div>

</html>
