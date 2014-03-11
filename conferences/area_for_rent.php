<?php ?>
<html>
	<meta charset="UTF-8">
	<head>
		<title> Pridėti naują konferenciją </title>
	</head>
	<body>
		<form method="POST" action="./area_for_rent.php">
			<div>
				<label> Pavadinimas </label>
				<input type="text" name="title"/>
			</div>
			<div>
				<label> Ilgis, m </label>
				<input type="number" name="length" step="0.01"/>
			</div>
			<div>
				<label> Plotis, m </label>
				<input type="text" name="width" step="0.01"/>
			</div>
			<div>
				<label> Kaina, Lt/m² </label>
				<input type="text" name="price" step="0.01"/>
			</div>
			<div>
				<label> Galima nuomoti nuo </label>
				<input type="datetime-local" name="available_from"/>
			</div>
			<div>
				<label> Galima nuomoti iki </label>
				<input type="datetime-local" name="available_to"/>
			</div>
			<div>
				<label> Telpa žmonių </label>
				<input type="number" name="available_from" step="1"/>
			</div>
			<input type="submit" />
		</form>
	</body>
</html>