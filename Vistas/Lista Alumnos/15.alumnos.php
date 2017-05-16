<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="iE=edge">   
    <meta name="keywords" content="moodle, SV : Reporte de Evidencias Completas " />
    <title>SV : Reporte de Evidencias Completas</title>
	
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
		<table>
			<thead>
			</thead>
			<tbody>
				<tr>
					<th>Curso</th>
					<td>ATCL 201620 - Grupo B - Zonal Lambayeque Cajamarca Norte</td>
				</tr>
				<tr>
					<th>iD Curso</th>
					<td>7213</td>
				</tr>
				<tr>
					<th>Periodo Sinfo</th>
					<td>201620</td>
				</tr>
				<tr>
					<th>Alumnos</th>
					<td>26</td>
				</tr>
				<tr>
					<th>Grupos</th>
					<td>1  <a href="#">ir a página de Grupos</a> </td>
				</tr>
				<tr>
					<th>Matriculas</th>
					<td><a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Lista%20Alumnos/editar_matriculas.html">Editar Matriculas</a></td>
				</tr>
			</tbody>
		</table>
		<p class="nota_importante">NO SE MUESTRAN LOS RETiRADOS</p>
	</div>
	
	<div>
		<h4>TODOS</h4>
	</div>
	
	<div id="jsGridPeriodo"></div>
	
	<div>
		<p class="blue">*Las Notas y El Estado vienen de Historia Académica</p>
		<table>
			<thead></thead>
			<tbody>
				<tr>
					<th>Nunca accedieron</th>
					<td>9 alumnos</td>
					<td>34.62 %</td>
				</tr>
				<tr>
					<th>Accedieron</th>
					<td>17 alumnos</td>
					<td>34.62 %</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="notas">
		<!-- <p>No tienen Grupo:<span> 0 alumnos</span></p> -->
		
		<!-- <p> -->
			<!-- 1. Haga click en el Nombre del Grupo para ver los emails de los alumnos de ese Grupo.<br> -->
			<!-- 2. Haga click en el Nombre del Tutor para ver los emails de los alumnos de ese Tutor en este Curso. -->
		<!-- </p> -->
		
		<!-- <table class="table_grupo"> -->
			<!-- <thead> -->
				<!-- <tr> -->
					<!-- <th>N°</th> -->
					<!-- <th>id Grupo</th> -->
					<!-- <th>Nombre del Grupo</th> -->
					<!-- <th>Tutor</th> -->
					<!-- <th>Alumnos</th> -->
				<!-- </tr> -->
			<!-- </thead> -->
			<!-- <tbody> -->
				<!-- <tr> -->
					<!-- <td>1</td> -->
					<!-- <td>44148</td> -->
					<!-- <td><a href="#">Heredia Desa</a></td> -->
					<!-- <td><a href="#">Miluska, Heredia Desa(id= 165912)</td> -->
					<!-- <td>26</td> -->
				<!-- </tr> -->
			<!-- </tbody> -->
		<!-- </table> -->
		<p class="span_insertar">Lista de Emails para Outlook o Exchange</p>		
		<textarea resize="vertical" rows="10" cols="50"></textarea>
	</div>
	    
    <div >
        <div class="treeview">
            <ul>
                <li><a href="#">Más opciones</a>
					<ul>
						<li><i class="fa fa-edit"></i> <a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Lista%20Alumnos/listad_EditarCorreos.html">Editar Correos, Ciudad y PiDM</a></li>
						<li><i class="fa fa-edit"></i> <a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Lista%20Alumnos/CursosEdicion_Actas.html">Edici&oacute;n de Acta Oficial</a></li>
						<li><i class="fa fa-trash"></i> <a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reconocidas/17.eliminar_matriculas_induccion.html">Eliminaci&oacute;n de Matriculas de Cursos de inducci&oacute;n </a></li>
						<li><i class="fa fa-trash"></i> <a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reconocidas/18.eliminar_matriculas_bloque.html">Eliminaci&oacute;n de Matriculas según BLOQUE </a></li>
						<li><i class="fa fa-trash"></i> <a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reconocidas/19.eliminacion_matriculas_subsanacion.html">Eliminaci&oacute;n de Matriculas de Cursos de Susbanaci&oacute;n </a></li>
						<li><i class="fa fa-trash"></i> <a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reconocidas/20.eliminar_matriculas_exam_presen.html">Eliminaci&oacute;n de Matriculas de Cursos Presenciales </a></li>
						<li><i class="fa fa-trash"></i> <a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reconocidas/21.borrar_ceros_examen_presencial.html">Borrar Ceros de los Cuestionarios </a></li>
                	</ul>
                </li>
              </ul>
        </div>
    </div>
	
	
	
	
    <script>		
		$(function() {

            $("#jsGridPeriodo").jsGrid({
                height: "40%",
                width: "100%",
				autoload: true,
				sorting: true,
				paging: true,
				pageSize: 2,
                controller: db,
                fields: [
					
                    { name: "id", type: "text", width: 20, title: "id Moddle" },
					{ name: "PiDM_SiNFO", type: "number", width: 20, title: "PiDM SiNFO"},
					{ name: "Username", type: "number", width: 20},
                    { name: "id", type: "text",width: 20, title: "id Grupo"},
					{ name: "Grupo", type: "text", width: 50},
					{ name: "Apellidos", type: "text", width: 40, title: "Apellidos,Nombres"},
					{ name: "Nrc", type: "number", width: 10},
					{ name: "Bloque", type: "number", width: 15},
					{ name: "Camp", type: "number", width:10},
					{ name: "Campus", type: "text",width: 30},
					{ name: "Email", type: "number", width: 30},
					{ name: "Empresa", type: "text", width: 40},
					{ name: "Accesos", type: "number", width: 20},
					{ name: "Nota HA*", type: "number", width: 20},
					{ name: "Estado_Actual", type: "text", width: 20, title: "Estado HA*"}
					
                ]

            });

		
        });
 
		

	
   </script>

	       <img src="../../img/image002.png" />     
	<script src="../../js/filter/list.js"></script>
	

</body>	
</html>
