<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV: Historia Academica - Acta de Notas SiNFO por NRC-PERiODO</title>
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
		<p class="blue"><a href="#"> Historia Academica </a> - Actas de Notas SiNFO por NRC</p>
	</div>
	<div>
		 <table >
		   <tbody>
				<tr>
					<th>Nombre Curso SiNFO</th>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO</td>
				</tr>
				<tr>
					<th>Materia-Curso</th>
					<td>BRHV-101</td>
				</tr>                 
		   </tbody>
		</table>
	</div>
    <div>
		<br><span class="red">Si el alumno desaprob&oacute; el primer curso y lo volvi&oacute; a dar este reporte solo toma en cuenta la nota más alta, de los dos cursos.</span>
		 <table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">N°</th>
					<th onclick="sortTable(1)">Curso</th>
					<th onclick="sortTable(2)">Nrc</th>
					<th onclick="sortTable(3)">Período</th>
					<th onclick="sortTable(4)">Camp</th>
					<th onclick="sortTable(5)">id Sinfo</th>
					<th onclick="sortTable(6)">PiDM</th>
					<th onclick="sortTable(7)">Apellidos, Nombres</th>
					<th onclick="sortTable(8)">Nota</th>
				</tr>
			</thead>    
		   <tbody id="myTable">
				<tr>
					<td>1</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL  </td>
					<td>323232</td>
					<td>432423</td>
					<td>65</td>
					<td>432432</td>
					<td>16</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
				<tr>
					<td>2</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO </td>
					<td>4234324</td>
					<td>200943243200</td>
					<td>43</td>
					<td>43243243</td>
					<td>16</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
				<tr>
					<td>3</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA  </td>
					<td>423432</td>
					<td>42343243</td>
					<td>32</td>
					<td>42343243</td>
					<td>16</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
				<tr>
					<td>4</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO </td>
					<td>323232</td>
					<td>32323</td>
					<td>98</td>
					<td>323232</td>
					<td>16</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
				<tr>
					<td>5</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO </td>
					<td>887303</td>
					<td>200900</td>
					<td>22</td>
					<td>000000106</td>
					<td>16</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
				<tr>
					<td>6</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO </td>
					<td>3232</td>
					<td>20094300</td>
					<td>65</td>
					<td>432432432</td>
					<td>16</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
				<tr>
					<td>7</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO </td>
					<td>887432432303</td>
					<td>432432</td>
					<td>19</td>
					<td>32432432</td>
					<td>32</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
				<tr>
					<td>8</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO </td>
					<td>654645654</td>
					<td>53454</td>
					<td>19</td>
					<td>432423432</td>
					<td>43</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
				<tr>
					<td>9</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO </td>
					<td>65765765</td>
					<td>5645645</td>
					<td>19</td>
					<td>00000540106</td>
					<td>44</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
				<tr>
					<td>10</td>
					<td>ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO </td>
					<td>3243243</td>
					<td>423423</td>
					<td>55</td>
					<td>65756765</td>
					<td>16</td>
					<td>ACCiLiO CRUZ, WALTER GUSTAVO </td>
					<td>0</td>
				</tr>
		   </tbody>
		</table>
    </div>
	<div class="text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
	</div>
	
	<!-- <div id="notas"> -->
		 <!-- <table> -->
			<!-- <tbody> -->
				<!-- <tr> -->
					<!-- <td>Aprobados</td> -->
					<!-- <td>0</td> -->
				<!-- </tr> -->
				 <!-- <tr> -->
					<!-- <td>Desaprobados</td> -->
					<!-- <td>0</td> -->
				<!-- </tr> -->
				 <!-- <tr> -->
					<!-- <td>Retirados</td> -->
					<!-- <td>0</td> -->
				<!-- </tr> -->
				 <!-- <tr> -->
					<!-- <td>No participaron</td> -->
					<!-- <td>0</td> -->
				<!-- </tr>             -->
				 <!-- <tr> -->
					<!-- <th>iNSCRiTOS</th> -->
					<!-- <td>489</td> -->
				<!-- </tr> -->
			<!-- </tbody> -->
		<!-- </table> -->
    
	<!-- </div> -->
		
	<!-- <div> -->
		<!-- <caption>Estadísticas por Campus - Carrera</caption> -->
		<!-- <table> -->
			<!-- <thead class="lightblue"> -->
				<!-- <tr> -->
					<!-- <th>Camp</th> -->
					<!-- <th>Campus</th> -->
					<!-- <th>Carr</th> -->
					<!-- <th>Carrera</th> -->
					<!-- <th>Estado</th> -->
					<!-- <th>Alumnos</th> -->
				<!-- </tr> -->
			<!-- </thead>     -->
		   <!-- <tbody > -->
				<!-- <tr> -->
					<!-- <td>63</td> -->
					<!-- <td>CFP Callao - Ventanilla<td> -->
					<!-- <td>&nbsp</td> -->
					<!-- <td>&nbsp</td> -->
					<!-- <td>38</td> -->
				<!-- </tr> -->
				<!-- <tr> -->
					<!-- <th colspan="5">TOTAL</th> -->
					<!-- <th>489</th> -->
				<!-- </tr> -->
		   <!-- </tbody> -->
		<!-- </table> -->
	<!-- </div> -->
    
	<!-- <div id="notas"> -->
		 <!-- <caption>Estadísticas por CAMPUS</caption> -->
		<!-- <table> -->
			<!-- <thead class="lightblue"> -->
				<!-- <tr> -->
					<!-- <th>Camp</th> -->
					<!-- <th>Campus</th> -->
					<!-- <th>Estado</th> -->
					<!-- <th>Alumnos</th>     -->
				<!-- </tr> -->
			<!-- </thead>     -->
		   <!-- <tbody> -->
				<!-- <tr> -->
					<!-- <td>63</td> -->
					<!-- <td>CFP Callao - Ventanilla<td> -->
					<!-- <td>38</td>            -->
				<!-- </tr> -->
				<!-- <tr> -->
					<!-- <th colspan="3">TOTAL</th> -->
					<!-- <th>489</th> -->
				<!-- </tr> -->
		   <!-- </tbody> -->
		<!-- </table> -->
	<!-- </div> -->
	
   


       <img src="../../img/image002.png" />     
<script src="../../js/filter/filter.js"></script>
<script src="../../js/filter/thead.js"></script>
</body>	
</html>