<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="iE=edge">
		<meta charset="UTF-8">
        <title>SV: Mis Notas - TUTOR</title>
         <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
		<link rel="stylesheet" type="text/css" href="../../css/theme.css" />
		<link rel="stylesheet" type="text/css" href="../../css/font-awesome.css">

		<script src="../../js/jquery/jquery-1.8.3.js"></script>
		<script src="../../js/jquery/jquery-1.8.3.js"></script>
		<script src="../../js/jsgrid/jsgrid.core.js"></script>
		<script src="../../js/jsgrid/jsgrid.load-indicator.js"></script>
		<script src="../../js/jsgrid/jsgrid.load-strategies.js"></script>
		<script src="../../js/jsgrid/jsgrid.sort-strategies.js"></script>
		<script src="../../js/jsgrid/jsgrid.field.js"></script>
    </head>
    <body>        <img src="../../img/image001.png" />   
		
		<div>
			<p><a href="#">iCAT 201620 - Grupo A-Zonal ica Ayacucho -> Registro de incidencias -> Nueva </a></p>
		</div>
		
		<div>
			<table >
				<thead></thead>
				
				<tbody>
					<tr>
						<th>iD iNCiDENCiA</th>
						<td>NUEVA</td>
					</tr>
					<tr>
						<th>iD CURSO</th>
						<td>6891</td>
					</tr>
					<tr>
						<th>CURSO</th>
						<td>iCAT 201620 - Grupo A - Zonal ica Ayacucho</td>
					</tr>
					<tr>
						<th>TUTOR / USUARiO</th>
						<td>SENATi ViRTUAL, ADMiNiSTRADOR DE</td>
					</tr>
					<tr>
						<th>ALUMNO</th>
						<td><select class="form-control">
							<option>ABARCA PEVE, JAiRO -970344@senati.pe</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>iNCiDENCiA</th>
						<td><textarea cols="40" rows="10"></textarea></td>
					</tr>
					<tr>
						<th>FECHA ACTUAL</th>
						<td>27-03-2017</td>
					</tr>
					<tr>
						<th></th>
						<td><button type="button" class="btn btn-primary"> <i class="fa fa-envelope-o" aria-hidden="true"></i> Enviar</button></td>
					</tr>
				</tbody>
			</table>
		</div>
		
        <div>
			<p class="bold">incidencias de este Curso</p>
			<table id="tables">
				<thead class="lightblue">
					<tr>
						<th onclick="sortTable(0)">Alumno</th>
						<th onclick="sortTable(1)">Tutor</th>
						<th onclick="sortTable(2)">incidencia</th>
						<th onclick="sortTable(3)">Fecha / Hora</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="#">LiZARME BAUTiSTA, ALEX ALFREDO</a></td>
						<td>SOTO GOMEZ, ROSA MARiA</td>
						<td>COPiA DE LA FORO 02 DE OTRO ALUMNO POR LO TANTO NOTA DESAPROBATORiA DE 01.</td>
						<td>28 Sep 2016 09:52:26</td>
					</tr>
					<tr>
						<td><a href="#">LiZARME BAUTiSTA, ALEX SAAVEDRA</a></td>
						<td>SOTO GOMEZ, ROSA MARCELA</td>
						<td>COPiA DE LA FORO 04 DE OTRO ALUMNO POR LO TANTO NOTA DESAPROBATORiA DE 05.</td>
						<td>29 Dec 2017 09:52:26</td>
					</tr>
				</tbody>
			</table>
		</div>
		       <img src="../../img/image002.png" />     
		<script src="../../js/filter/thead.js"></script>
		</body>		
</html>
</html>