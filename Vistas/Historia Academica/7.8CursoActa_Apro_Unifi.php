<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV:  SV : Historia Academica - Acta de Aprobados - Lista Unificada</title>
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
		 <table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">N°</th>
					<th onclick="sortTable(1)">Curso</th>
					<th onclick="sortTable(2)">id Curso</th>
					<th onclick="sortTable(3)">Fecha</th>
					<th onclick="sortTable(4)">id Moodle</th>
					<th onclick="sortTable(5)">id SiNFO</th>
					<th onclick="sortTable(6)">Apellidos, Nombres</th>
					<th onclick="sortTable(7)">Camp</th>
					<th onclick="sortTable(8)">NRC</th>
					<th onclick="sortTable(9)">Período</th>
					<th onclick="sortTable(10)">Bloque</th>
					<th onclick="sortTable(11)">Nota</th>
					<th onclick="sortTable(12)">Estado</th>
				</tr>
			</thead>    
		   <tbody id="myTable">
				<tr>
					<td>1</td>
					<td>Administraci&oacute;n Estratégica del Capital Humano</td>
					<td>116175</td>
					<td>29-07-2007</td>
					<td>5454</td>
					<td>453543543</td>
					<td>CARRASCO MU&ntilde;OZ, CLAUDiA</td>
					<td>32</td>
					<td></td>
					<td></td>
					<td></td>
					<td>18.7</td>
					<td>Aprobado</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Administraci&oacute;n Estratégica del Capital Humano</td>
					<td>116175</td>
					<td>29-07-2007</td>
					<td>545645</td>
					<td>32321432</td>
					<td>CARRASCO MU&ntilde;OZ, CLAUDiA</td>
					<td>32</td>
					<td></td>
					<td></td>
					<td></td>
					<td>18.7</td>
					<td>Aprobado</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Administraci&oacute;n Estratégica del Capital Humano</td>
					<td>116175</td>
					<td>29-07-2007</td>
					<td>432</td>
					<td>432432432</td>
					<td>CARRASCO MU&ntilde;OZ, CLAUDiA</td>
					<td>33</td>
					<td></td>
					<td></td>
					<td></td>
					<td>18.7</td>
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