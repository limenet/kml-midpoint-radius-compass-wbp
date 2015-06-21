<!DOCTYPE html>
<html>
<head>
	<title>WBP KML Line Generator</title>
	<style>
	* {
		margin: 0;
		padding: 0;
	}
	form {
		margin: 150px auto 0 auto;
		width: 600px;
	}
	input {
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
	}
	input[type=text] {
		width: 580px;
		padding: 10px;
		font-size: 15px;
		border: 2px #f1c40f solid;
	}
	input[type=submit]{
		width: 604px;
		padding: 10px;
		font-size: 25px;
		color: #fff;
		background: #3498db;
		margin: 20px 0 0 0;
		border: 2px #3498db solid;
		
	}
	</style>
</head>
<body>
	<form action="kml.php" method="post">
		<input name=origin required type=text placeholder="Origin, WGS84 decimal, comma separated">
		<br>
		<input type=submit value="KML!">
	</form>
</body>
</html>
