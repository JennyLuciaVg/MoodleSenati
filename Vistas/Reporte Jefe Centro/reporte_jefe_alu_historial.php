<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV:  Reporte para Jefes de Centro - Historial de un Alumno</title>
     <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../css/theme.css" />

    <script src="../../js/jquery/jquery-1.8.3.js"></script>
    <script src="../../data/db.js"></script>

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
        <table class="table_reporte_alu_histo">
			<thead class="lightblue">
				<tr>
					<th colspan="2">Datos Generales</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>PiDM SiNFO</th>
					<td>964615 </td>
				</tr>
				<tr>
					<th>Apellidos, Nombres	</th>
					<td >ORiHUELA FLORiAN, JAiME ALEJANDRO</td>
				</tr>
				<tr>
					<th>iD de SENATi ViRTUAL</th>
					<td>203007</td>
				</tr>
				<tr>
					<th>Email</th>
					<td>964615@senati.pe</td>
				</tr>
				<tr>
					<th>Campus</th>
					<td >CFP Ca&ntilde;ete (70)</td>
				</tr>

			</tbody>
          
        </table>
    </div>

   
    <!-- <div id=""> -->
       <!-- <a href="#">Ver solo Desaprobados</a> -->
	   <!-- <a href="#">Ver Todos</a> -->
    <!-- </div> -->

    <div id="notas">
		<table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">iD Curso</th>
					<th onclick="sortTable(1)">Curso</th>
					<th onclick="sortTable(2)">Camp</th>
					<th onclick="sortTable(3)">NRC</th>
					<th onclick="sortTable(4)">Periodo</th>
					<th onclick="sortTable(5)">Bloque</th>
					<th onclick="sortTable(6)">Semestre</th>
					<th onclick="sortTable(7)">Carrera</th>
					<th onclick="sortTable(8)">Status SiNFO</th>
					<th onclick="sortTable(9)">Nota</th>
					<th onclick="sortTable(10)">Estado</th>
				</tr>
			</thead>
			<tbody id="myTable">
				<tr>
					<td>1</td>
					<td>inducci&oacute;n 201620 - Grupo A - Zonal Lima Callao</td>
					<td>56</td>
					<td>7786</td>
					<td>201620</td>
					<td>70AMODFB01</td>
					<td></td>
					<td>AMOD</td>
					<td></td>
					<td>12.9</td>
					<td>AP</td>
				</tr>
				<tr>
					<td>2</td>
					<td>inducci&oacute;n 201620 - Grupo A - Zonal Loreto iquitos</td>
					<td>21</td>
					<td>7786</td>
					<td>201620</td>
					<td>70AMODFB01</td>
					<td></td>
					<td>AMOD</td>
					<td></td>
					<td>12.9</td>
					<td>AP</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Tarea 201620 - Grupo A - Zonal Lima Callao</td>
					<td>32</td>
					<td>7786</td>
					<td>201620</td>
					<td>70AMODFB01</td>
					<td></td>
					<td>AMOD</td>
					<td></td>
					<td>12.9</td>
					<td>AP</td>
				</tr>
				<tr>
					<td>4</td>
					<td>Examen 201620 - Grupo A - Zonal Lima Callao</td>
					<td>70</td>
					<td>7786</td>
					<td>201620</td>
					<td>70AMODFB01</td>
					<td></td>
					<td>AMOD</td>
					<td></td>
					<td>12.9</td>
					<td>AP</td>
				</tr>

			</tbody>
			
		</table>
		<div class="col-md-12 text-center">
      		<ul class="pagination pagination-lg pager" id="myPager"></ul>
   		</div>
	</div>

   
	       <img src="../../img/image002.png" />     

	<script src="../../js/filter/filter.js"></script>
	<script src="../../js/filter/thead.js"></script>
</body>	

</html>
