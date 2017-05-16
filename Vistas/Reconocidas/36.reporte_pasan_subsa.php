<!DOCTYPE html>
<html>
<head>
		<meta http-equiv="X-UA-Compatible" content="iE=edge">
		<meta charset="UTF-8">
		<title>SV: Reporte de Evidencias por Tutor - Grupo</title>
		<link rel="stylesheet" type="text/css" href="../../css/demos.css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
		<link rel="stylesheet" type="text/css" href="../../css/theme.css" />

		<script src="../../js/jquery/jquery-1.8.3.js"></script>
		<script src="../../data/db.js"></script>
		 <link rel="stylesheet" type="text/css" href="../../css/font-awesome.css">

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
	<div>
    	<h4>REPORTE DE ALUMNOS QUE PASAN A SUBSANACiON (<span>id curso=7778</span>)
    	</h4>
    </div>
    <p class="nota_importante">(No se toman en cuenta a los retirados de SiNFO)</p>
	
	<div>
		<label>Los criterios para pasar a SUBSANACiON son : el % de evidencias entregadas debe ser mayor a 40% y la nota obtenida MAYOR a 4.
		</label>
		<br>
		<label>
			Los Cursos de iNDUCCiON NO TiENEN SUBSANACiON al igual que los mismos cursos de SUBSANACiON.
		</label>
		<table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">id Sinfo</th>
					<th onclick="sortTable(1)">id SV</th>
					<th onclick="sortTable(2)">Apellidos, Nombres</th>
					<th onclick="sortTable(3)">Camp</th>
					<th onclick="sortTable(4)">Campus</th>
					<th onclick="sortTable(5)">NRC</th>
					<th onclick="sortTable(6)">Bloque</th>
					<th onclick="sortTable(7)">Evid. Entregadas</th>
					<th onclick="sortTable(8)">% Evid. Entregadas</th>
					<th onclick="sortTable(9)">Promedio</th>
					<th onclick="sortTable(10)">Estado</th>
				</tr>
			</thead>
			<tbody  id="myTable">
				<tr >
					<td  class="yellow" colspan="7">Total Evidencias Calificables : 6</td>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td>874393</td>
					<td>876876</td>
					<td>SANCHEZ SANCHEZ, ELViS ABEL</td>
					<td>67</td>
					<td>CFP Moyobamba</td>
					<td>29087</td>
					<td>25AMODE501</td>
					<td>4</td>
					<td>66.7 %</td>
					<td>1.6</td>
					<td><span class="red">DESAPROBADO</span></td>
				</tr>	
				<tr>
					<td>94843</td>
					<td>12112</td>
					<td>SANCHEZ SANCHEZ, ELViS ABEL</td>
					<td>656</td>
					<td>CFP Moyobamba</td>
					<td>29087</td>
					<td>25AMODE501</td>
					<td>4</td>
					<td>66.7 %</td>
					<td>1.6</td>
					<td><span class="red">DESAPROBADO</span></td>
				</tr>	
				<tr>
					<td>67432</td>
					<td>4324325</td>
					<td>SANCHEZ SANCHEZ, ELViS ABEL</td>
					<td>545</td>
					<td>CFP Moyobamba</td>
					<td>29087</td>
					<td>25AMODE501</td>
					<td>4</td>
					<td>66.7 %</td>
					<td>1.6</td>
					<td><span class="red">DESAPROBADO</span></td>
				</tr>	
				<tr>
					<td>811239</td>
					<td>32432432</td>
					<td>SANCHEZ SANCHEZ, ELViS ABEL</td>
					<td>43</td>
					<td>CFP Moyobamba</td>
					<td>29087</td>
					<td>25AMODE501</td>
					<td>4</td>
					<td>66.7 %</td>
					<td>1.6</td>
					<td><span class="red">DESAPROBADO</span></td>
				</tr>			
			</tbody>
		</table>
		<div class="col-md-12 text-center">
    		<ul class="pagination pagination-lg pager" id="myPager"></ul>
   		</div>
	</div>
	

	<div id="botones_matricula">
		<button type="button" class="btn btn-primary" href="#"><i class="fa fa-eraser" aria-hidden="true"></i> Limpiar Desaprobados</button>
   	</div>

   	<div>	
		<table>
			<thead class="lightblue">
				<tr>
					<th colspan="2">MATRiCULAR EN SUBSANACi&oacute;N</th>
				
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<th>iD CURSO OBJETiVO</th>
					<td><input type="text" size="10" class="form-control"/></td>					
				</tr>				
				<tr>
					<th></th>
					<td><button type="button" class="btn btn-primary" href="#"><i class="fa fa-check" aria-hidden="true"></i> Validar Curso </button></td>
				</tr>
				<tr>
					<th></th>
					<td><button type="button" class="btn btn-primary" href="#"><i class="fa fa-clipboard" aria-hidden="true"></i> Matricular en Subsanaci&oacute;n </button></td>
				</tr>
			</tbody>
		</table>
	<!-- </div> -->
	       <img src="../../img/image002.png" />     
	<script src="../../js/filter/filter.js"></script>	
	<script src="../../js/filter/thead.js"></script>	
	</body>
</html>

