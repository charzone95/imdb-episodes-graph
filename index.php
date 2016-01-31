<html>
	<head>
		<title>IMDB Episodes Graph</title>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		
		<style>
			body {
				font-family: 'Open Sans', sans-serif;
			}
		</style>
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		
	</head>
	<body>
		<h1>IMDB Episodes Graph</h1>
		<p><b>By: Charlie</b> (charzone95@gmail.com) </p> 
		
		<?php 
			if (@$_GET['id']) {
				require_once 'process.php';
			}
		?>
		
		<hr/>
		<form action="" method="GET">
			<p>
				<label for="id">Enter IMDB ID:</label>
				<input type="text" id="id" name="id" placeholder="Example: tt3556944" value="<?php echo @$_GET['id']?>"/>
				<button type=submit">Go</button>
			</p>
		</form>
		
		<p>This tool only works on <b>TV SERIES</b></p>
		<p>Some examples:</p>
		<ul>
			<li><a href="?id=tt3556944">Heroes Reborn</a></li>
			<li><a href="?id=tt0944947">Game of Thrones</a></li>
			<li><a href="?id=tt2364582">Agents of S.H.I.E.L.D. </a></li>
			<li><a href="?id=tt4532368">Legends of Tomorrow</a></li>
			
		</ul>
		
		<hr style="margin-top:20px"/>
		
		<p>Source code available at <a href="https://github.com/charzone95/imdb-episodes-graph" target="_BLANK">github.com/charzone95/imdb-episodes-graph</a></p>
	</body>
</html>