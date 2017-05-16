<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="iE=edge">   
    <meta name="keywords" content="moodle, SV : Reporte de Evidencias Completas " />
    <title>SV : Eliminaci&oacute;n de Matriculas de inducci&oacute;n</title>
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
<body>        <img src="../../img/image001.png" />   	   
   <div id="notas">
		<h4 class="blue"><span>iNDUCCiON A CURSOS ViRTUALES 201620</span> - Eliminaci&oacute;n de Matrículas de iNDUCCi&oacute;N</h4>
		<p class="red">Este NO ES UN CURSO DE iNDUCCi&oacute;N. (no podrá realizar ninguna acci&oacute;n)</p>
		<p class="blue">Este m&oacute;dulo verifica si el alumno ha llevado inducci&oacute;n y la ha aprobado de ser así permite desmatricularlo</p>
		
		<span class="span_insertar">LiSTA DE ALUMNOS</span>
		<table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">N°</th>
					<th onclick="sortTable(1)">iD Matricula</th>
					<th onclick="sortTable(2)">Alumno</th>
					<th onclick="sortTable(3)">PDiDM</th>
					<th onclick="sortTable(4)">Bloque</th>
					<th >Acci&oacute;n</th>
				</tr>
			</thead>
			<tbody id="myTable">
				<tr>
					<td>1</th>
					<td>1408123</td>
					<td><a href="#">CONDORi APAZA, DANiEL ROBERT</a></td>
					<td>588805</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
				<tr>
					<td>2</th>
					<td>0787543</td>
					<td><a href="#">CONDORi APAZA, ANDY JAYRO</a></td>
					<td>435887</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
				<tr>
					<td>3</th>
					<td>76232</td>
					<td><a href="#">CONDORi APAZA, MANUEL RAMON</a></td>
					<td>9733232</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
				<tr>
					<td>4</th>
					<td>323232</td>
					<td><a href="#">CONDORi APAZA, CARLOS STEVEN</a></td>
					<td>76877676</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
				<tr>
					<td>5</th>
					<td>987987</td>
					<td><a href="#">CONDORi APAZA, SALVADOR MARCO</a></td>
					<td>87687686</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
				<tr>
					<td>6</th>
					<td>5767657</td>
					<td><a href="#">CONDORi APAZA, CRiSTHiAN ENRiQUE</a></td>
					<td>234243</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
				<tr>
					<td>7</th>
					<td>324324</td>
					<td><a href="#">CONDORi APAZA, FABRiCiO FRANCO</a></td>
					<td>7657657</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
				<tr>
					<td>8</th>
					<td>3452879</td>
					<td><a href="#">CONDORi APAZA, ROBERT CARLOS</a></td>
					<td>076538</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
				<tr>
					<td>9</th>
					<td>9571346</td>
					<td><a href="#">CONDORi APAZA, JUAN BENiTO</a></td>
					<td>367849</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
				<tr>
					<td>10</th>
					<td>1408678</td>
					<td><a href="#">CONDORi APAZA, MARCO ULiSES</a></td>
					<td>3232445</td>
					<td>53AMODFB04</td>
					<td></td>
				</tr>
			</tbody>
		</table>
   </div>
    <div class=" text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
   </div>
   <div id="botones">
		<a type="button" class="btn btn-primary"><i class="fa fa-book" aria-hidden="true"></i> Leer Datos de inducci&oacute;n</a><br><br>
		<a type="button" class="btn btn-primary"><i class="fa fa-file-text-o" aria-hidden="true"></i> Desmatricular Seleccionados</a>
		
   </div>
	       <img src="../../img/image002.png" />     
	<script src="../../js/filter/filter.js"></script>
	<script src="../../js/filter/thead.js"></script>
</body>		
</html>

