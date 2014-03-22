<?php
session_start();
?>
<html>
	<meta charset="UTF-8">
	<head>
		<title> Paraiškos konferencijoms </title>
	</head>
	<body>
		<table>
			<th>
				<td>Pavadinimas</td>
				<td>Užregistravo</td>
				<td>Patvirtinta</td>
				<td>Nuomojama nuo</td>
				<td>Nuomojama iki</td>
			</th>
			<?php
			include_once "../models/"
			?>
		</table>
	</body>
</html>