<!DOCTYPE html2
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="iE=edge">
		<meta charset="UTF-8">		
        <title>SV: Mis Alumnos</title>
           <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
		<link rel="stylesheet" type="text/css" href="../../css/theme.css" />

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
			<p class="bold">USUARiO ACTUAL: <span class="blue">ADMiNiSTRADOR DE, SENATi ViRTUAL</span></p>
			<label class="bold">Seleccione grupo</label>
			<select class="form-control">
				<option>Grupo1</option>
				<option>Grupo2</option>
				<option>Grupo3</option>
				<option>Grupo4</option>
			</select>
		</div>
        <div id="notas">
			<table id="tables">
				<thead class="lightblue">
					<tr>
						<th onclick="sortTable(0)">N°</th>
						<th onclick="sortTable(1)">iD SiNFO</th>
						<th onclick="sortTable(2)">Status Sinfo</th>
						<th onclick="sortTable(3)">Apellidos</th>
						<th onclick="sortTable(4)">Nombre</th>
						<th onclick="sortTable(5)">Email</th>
						<th onclick="sortTable(6)">Bloque</th>
						<th onclick="sortTable(7)">Grupo</th>
						<th onclick="sortTable(8)">Grupo Númerico</th>
					</tr>
				</thead>
				<tbody id="myTable">
					<tr>
						<td>1</td>
						<td>167784</td>
						<td></td>
						<td>ARiAS CAPCHA</td>
						<td>MiLENKO LEONiDAS</td>
						<td>marias@senati.edu.pe</td>
						<td></td>
						<td></td>
						<td></td>			
					</tr>
					<tr>
						<td>2</td>
						<td>312321</td>
						<td></td>
						<td>ARiAS </td>
						<td>MiLENKO LEONiDAS</td>
						<td>marias@senati.edu.pe</td>
						<td></td>
						<td></td>
						<td></td>			
					</tr>
					<tr>
						<td>3</td>
						<td>5354354</td>
						<td></td>
						<td>CAPCHA</td>
						<td>MiLENKO LEONiDAS</td>
						<td>marias@senati.edu.pe</td>
						<td></td>
						<td></td>
						<td></td>			
					</tr>
					<tr>
						<td>4</td>
						<td>432432432</td>
						<td></td>
						<td>ARiAS</td>
						<td>MiLENKO LEONiDAS</td>
						<td>marias@senati.edu.pe</td>
						<td></td>
						<td></td>
						<td></td>			
					</tr>
					<tr>
						<td>5</td>
						<td>543543543</td>
						<td></td>
						<td> CAPCHA</td>
						<td>MiLENKO LEONiDAS</td>
						<td>marias@senati.edu.pe</td>
						<td></td>
						<td></td>
						<td></td>			
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
</html>