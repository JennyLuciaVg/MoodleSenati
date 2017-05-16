<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="UTF-8">	
    <title>SV:  Reporte de Alumnos Desaprobados</title>
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
<body> 
	       <img src="../../img/image001.png" />   	
   
    
    <div> 
		<h3 class="blue">REPORTE DE ALUMNOS DESAPROBADOS(id curso=7778)</h3>
		<p class="nota_importante">(No se toman en cuenta a los retirados de SiNFO)</p>
		<p>Los criterios para pasar a SUBSANACiON son : el % de evidencias entregadas debe ser mayor a 40% y la nota obtenida MAYOR a 4.
		<br>Los Cursos de iNDUCCiON NO TiENEN SUBSANACiON al igual que los mismos cursos de SUBSANACiON.
		</p>
    </div>

	<div>
		<table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">id Sinfo</th>
					<th onclick="sortTable(1)">id SV</th>
					<th>Apellidos, Nombres</th>
					<th onclick="sortTable(1)">Camp</th>
					<th onclick="sortTable(1)">Campus</th>
					<th onclick="sortTable(1)">NRC</th>
					<th onclick="sortTable(1)">Bloque</th>
					<th onclick="sortTable(1)">Evid. Entregadas</th>
					<th onclick="sortTable(1)">% Evid. Entregadas</th>
					<th onclick="sortTable(1)">Promedio</th>
					<th onclick="sortTable(1)">Estado</th>
				</tr>
			</thead>
			<tbody id="myTable">
				<tr>
					<td class="yellow" colspan="7">TOTAL EViDENCiAS CALiFiCABLES : 6</td>					
					<td colspan="4"></td>
				</tr>
				<tr>
					<td>874393</td>
					<td>6564565</td>
					<td>SANCHEZ SANCHEZ, ELViS ABEL</td>
					<td>32</td>
					<td>CFP Moyobamba</td>
					<td>312321</td>
					<td>25AMODE501</td>
					<td>4</td>
					<td>66.7 %</td>
					<td>1.6</td>
					<td><span class="red">DESAPROBADO</span></td>				
				</tr>	
				<tr>
					<td>846454</td>
					<td>34343</td>
					<td>SANCHEZ SANCHEZ, Ramon ABEL</td>
					<td>323</td>
					<td>CFP Moyobamba</td>
					<td>312312</td>
					<td>25AMODE501</td>
					<td>4</td>
					<td>66.7 %</td>
					<td>1.6</td>
					<td><span class="red">DESAPROBADO</span></td>				
				</tr>	
				<tr>
					<td>232145</td>
					<td>432432</td>
					<td>SANCHEZ SANCHEZ,  ABEL</td>
					<td>321</td>
					<td>CFP Moyobamba</td>
					<td>432432</td>
					<td>25AMODE501</td>
					<td>4</td>
					<td>66.7 %</td>
					<td>1.6</td>
					<td><span class="red">DESAPROBADO</span></td>				
				</tr>		
			</tbody>
		</table>
	</div>
	<div class="col-md-12 text-center">
    	<ul class="pagination pagination-lg pager" id="myPager"></ul>
	</div>

	       <img src="../../img/image002.png" />     
	<script src="../../js/filter/filter.js"></script>	
	<script src="../../js/filter/thead.js"></script>	
	</body>	
</html>