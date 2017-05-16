<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV:  Historia Academica - Acta de Aprobados</title>
    <link rel="stylesheet" type="text/css" href="../../css/demos.css"/>
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

</head>
<body>	       <img src="../../img/image001.png" />   

	<div>
		<p class="blue"><a href="#"> Historia Academica </a> - Actas de Aprobados TOTAL</p>
	</div>
	<div id="notas">
		 <table >
		   <tbody>
				<tr>
					<th>iD Curso SENATi</th>
					<td>9</td>
				</tr>
				<tr>
					<th>Nombre Curso SENATi</th>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO</td>
				</tr> 
				<tr>
					<th>Curso Moodle Seleccionados</th>
					<td>23</td>
				</tr>			
		   </tbody>
		</table>
	</div>
	<hr>
	<div>
		 <table>
		   <tbody>
				<tr>
					<th>iD Curso Moodle</th>
					<td>9</td>
				</tr>
				<tr>
					<th>Nombre Curso Moodle</th>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO</td>
				</tr> 
				<tr>
					<th>Fecha de inicio</th>
					<td>29-07-2007</td>
				</tr>
				<tr>
					<th>Tutor(es)</th>
					<td>Luis, Landero Alvarez</td>
				</tr>
		   </tbody>
		</table>
	</div>
	
	<p class="blue">APROBADOS</p>
    <div>
		 <table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">N°</th>
					<th onclick="sortTable(1)">id Moodle</th>
					<th onclick="sortTable(2)">id SiNFO</th>
					<th onclick="sortTable(3)">Apellidos, Nombres</th>
					<th onclick="sortTable(4)">Camp</th>
					<th onclick="sortTable(5)">NRC</th>
					<th onclick="sortTable(6)">Período</th>
					<th onclick="sortTable(7)">Bloque</th>
					<th onclick="sortTable(8)">Nota</th>
					<th onclick="sortTable(9)">Estado</th>
				</tr>
			</thead>    
		   <tbody id="myTable">
				<tr>
					<td>1</td>
					<td>455</td>
					<td>116175</td>
					<td>CARRASCO MU&ntilde;OZ, CLAUDiA </td>
					<td>10</td>
					<td></td>
					<td></td>
					<td></td>
					<td>18.2</td>
					<td>Aprobado</td>
				</tr>
				<tr>
					<td>2</td>
					<td>290</td>
					<td>12121</td>
					<td>CARRASCO MU&ntilde;OZ, CLAUDiA </td>
					<td>12</td>
					<td></td>
					<td></td>
					<td></td>
					<td>18.2</td>
					<td>Aprobado</td>
				</tr>
				<tr>
					<td>3</td>
					<td>5454</td>
					<td>65645654</td>
					<td>CARRASCO MU&ntilde;OZ, CLAUDiA </td>
					<td>67</td>
					<td></td>
					<td></td>
					<td></td>
					<td>18.2</td>
					<td>Aprobado</td>
				</tr>
				<tr>
					<td>4</td>
					<td>43345</td>
					<td>4324324</td>
					<td>CARRASCO MU&ntilde;OZ, CLAUDiA </td>
					<td>43</td>
					<td></td>
					<td></td>
					<td></td>
					<td>18.2</td>
					<td>Aprobado</td>
				</tr>
				<tr>
					<td>5</td>
					<td>23423</td>
					<td>1161435475</td>
					<td>CARRASCO MU&ntilde;OZ, CLAUDiA </td>
					<td>10</td>
					<td></td>
					<td></td>
					<td></td>
					<td>18.2</td>
					<td>Aprobado</td>
				</tr>
				<tr>
					<td>6</td>
					<td>1212</td>
					<td>1163243135</td>
					<td>CARRASCO MU&ntilde;OZ, CLAUDiA </td>
					<td>10</td>
					<td></td>
					<td></td>
					<td></td>
					<td>18.2</td>
					<td>Aprobado</td>
				</tr>
		   </tbody>
		</table>
    </div>
	<div class="text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
	</div>
	<div>
		<hr>
		<p><strong>TOTAL APROBADOS: 3</strong></p>
	</div>
	       <img src="../../img/image002.png" />     
	<script src="../../js/filter/filter.js"></script>
	<script src="../../js/filter/thead.js"></script>
</body>	
</html>