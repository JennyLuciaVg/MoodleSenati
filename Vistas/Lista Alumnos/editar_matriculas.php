<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="iE=edge">   
    <meta name="keywords" content="moodle, SV : Reporte de Evidencias Completas " />
    <title>SV : Editar Matriculas</title>
	
    <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../css/theme.css" />

    <script src="../../js/jquery/jquery-1.8.3.js"></script>
    <script src="../../data/db.js"></script>
	<link rel="stylesheet" href="../../css/font-awesome.css">
    <script src="../../js/jsgrid/jsgrid.core.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.field.js"></script>
	<script src="../../js/jsgrid/fields/jsgrid.field.text.js"></script>
    <script src="../../js/jsgrid/fields/jsgrid.field.number.js"></script>
    <script src="../../js/jsgrid/fields/jsgrid.field.select.js"></script>
    <script src="../../js/jsgrid/fields/jsgrid.field.checkbox.js"></script>
    <script src="../../js/jsgrid/fields/jsgrid.field.control.js"></script>
</head>
<body>	       <img src="../../img/image001.png" />   
   <div id="notas">
		<p class="blue">Edici&oacute;n de Matrículas</p>
		<table>
			<thead></thead>
			<tbody>
				<tr>
					<th> iD Curso Moodle</th>
					<td>7213</td>
				<tr>
				<tr>
					<th>Nombre Curso Moodle</th>
					<td>ATCL 201620 - Grupo B - Zonal Lambayeque Cajamarca Norte</td>
				<tr>
				<tr>
					<th> MATERiA-CURSO SiNFO</th>
					<td>CGEU-165 </td>
				<tr>
				<tr>
					<th>PERiODO SiNFO</th>
					<td>201620</td>
				<tr>
				<tr>
					<th> Fecha de inicio</th>
					<td>26-09-2016</td>
				<tr>
				<tr>
					<th> Tutor(es)</th>
					<td>MiLUSKA, HEREDiA DEZA</td>
				<tr>
			</tbody>
		</table>
		<p><a href="#">ir a la Página de Grupos</a></p>
   </div>
   
   <div >
		<button type="button" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
		<button type="button" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</button>
		<button type="button" class="btn btn-primary"><i class="fa fa-list-alt" aria-hidden="true"></i> Leer Datos de SiNFO(todos)</button>
		<button type="button" class="btn btn-primary"><i class="fa fa-list-alt" aria-hidden="true"></i> Leer Datos de SiNFO(Sin Campus, Bloque o Nrc)</button>
		<button type="button" class="btn btn-primary"><i class="fa fa-list-alt" aria-hidden="true"></i> Leer Datos de SiNFO(inducci&oacute;n, Sin Camp o Bloque)</button>
   </div>
	
	<div id="notas">
		
		<table>
			<thead class="lightblue">
				<tr>
					<th>N°</th>
					<th>id Moodle</th>
					<th>id Sinfo</th>
					<th>Apellidos, Nombres</th>
					<th>Camp</th>
					<th>Campus</th>
					<th>Carr</th>
					<th>NRC</th>
					<th>Periodo</th>
					<th>Bloque</th>
					<th>Ciudad</th>
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<td>1</td>
					<td>187224</td>
					<td>902583</td>
					<td>DELGADO DE LA CRUZ, HENRY MARCELiNO </td>
					<td ><input type="text"  class="form-control" size="3"/></td>
					<td>UCP CHiCLAYO CENTRO PNi-iDiOMA </td>
					<td><input type="text" class="form-control" size="3"/></td>
					<td><input type="text" class="form-control" size="3"/></td>
					<td><input type="text" class="form-control" size="6"/></td>
					<td><input type="text" class="form-control" size="6"</td>
					<td><input type="text" class="form-control" size="6"/></td>
				</tr>
			
			</tbody>
		
		</table>
		
	</div>
	
	<div>
		<button type="button" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Salvar</button>
		<button type="button" class="btn btn-default"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
	</div>
	
	<div id="botones_matricula">
		<button type="button" class="btn btn-primary"><i class="fa fa-eraser" aria-hidden="true"></i> Limpiar Nrcs (inducci&oacute;n)</button>
		<button type="button" class="btn btn-primary"> <i class="fa fa-clipboard" aria-hidden="true"></i> Copiar Bloque a Nrc(solo inducci&oacute;n)</button>
		<button type="button" class="btn btn-primary"><i class="fa fa-arrow-up" aria-hidden="true"></i> Llenar Periodos</button>
	</div>
	
		
   <script>		
		
		
   </script>
       <img src="../../img/image002.png" />     </body>	
</html>

