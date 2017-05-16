<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="iE=edge">   
    <meta name="keywords" content="moodle, SV : Reporte de Evidencias Completas " />
    <title>SV : MMTR201710A_1_10: Acta de Notas Final</title>
	
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
    
	<div id="">
		<h4>ACTAS DE NOTAS FiNAL</h4>
		<p class="bold">Curso: <span>MMTR 201710 - Grupo A - Zonal San Martin </span></p>
		<p  class="bold">Fecha de inicio (D/M/A): <span>05/03/2017</span></p>
		<p  class="bold">iD del CURSO: <span>7778</span></p>
		<p>
			(Las primeras notas mostradas son el resultado de un proceso de cálculo deben generarse solo al finalizar el curso).
			<br>(Las columnas 8 y 9 muestran las notas en HiSTORiA ACADEMiCA que es la instancia superior del registro de notas).
			<br>(Los checks en amarillo indican que esa nota es candidata para pasar a Historia Academica).
			<br>(Las notas/estados de Historia Academica en gris indican que esa nota fue modificada directamente por un administrador).
			<br>(Los Alumnos que tiene Promedio Final Ponderado igual a cero, no pueden tener nota de Subsanaci&oacute;n (sombreada en celeste), si la tuviesen esta no será tomada en cuenta y se considerará como cero.)</p>
		<p class="nota_importante">NOTA : ESTE PROCESO SOLO LO PUEDE HACER EL ADMiNiSTRADOR DE SENATi ViRTUAL.</p>
	</div>
	
	<div id="jsGrid7"></div>
	
	<div id="notas">
		<button type="button" class="btn btn-primary"><i class="fa fa-files-o" aria-hidden="true"></i> Pasar Notas Seleccionadas a Historia Academica</button>(Solo el administrador de SENATi ViRTUAL puede pasar notas))
	</div>
	
	<div>
		<p class="span_insertar">DEL PROMEDiO FiNAL PONDERADO</p>
		<table >
			<thead class="lightblue">
				<tr>
					<th colspan="3">Detalles</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Aprobados</td>
					<td>0</td>
					<td>0.0 %</td>
				</tr>
				<tr>
					<td>Desaparobados</td>
					<td>100</td>
					<td>96.2 %</td>
				</tr>
				<tr>
					<td>No participaron</td>
					<td>4</td>
					<td>3.8 %</td>
				</tr>
				<tr>
					<td>TOTAL</td>
					<td>104</td>
					<td>100 %</td>
				</tr>
			</tbody>
		</table>
	</div>
    
	<div id="notas">
		<table>
			<thead class="lightblue">
				<tr>
					<th colspan="3">Resumen</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Aprobados</td>
					<td>0</td>
					<td>0.0 %</td>
				</tr>
				<tr>
					<td>El Resto</td>
					<td>100</td>
					<td>96.2 %</td>
				</tr>
				<tr>
					<td>TOTAL</td>
					<td>104</td>
					<td>100 %</td>
				</tr>
			</tbody>
		</table>
		
	</div>
    <a href="#">Regresar a Calificaciones</a>
	
	
	
	<script>		
		
	
	
		$(function() {

            $("#jsGrid7").jsGrid({
                height: "60%",
                width: "90%",
				autoload: true,
				sorting: true,
				paging: true,
				pageSize: 2,
				selecting: true,
                controller: db,
                fields: [
					
                    { name: "id", type: "text", width: 20, title: "id User Moddle" },
                    { name: "Apellidos", type: "text",width: 20, title: "Apellidos, Nombres"},
					{ name: "Promedio_Final", type: "number", width: 20, title: "Promedio Final Ponderado"},
					{ name: "Estado_PFP", type: "text", width: 20, title: "Estado PFP"},
					{ name: "Promedio_Subsanacion", type: "number", width: 20, title: "Promedio en Modo Subsanaci&oacute;n<br>(< 15)"},
					{ 
						headerTemplate: function() {			
						 return $("<p>").text("Pasar a Historia Académica").append('<br>').append('<a href="#" class="btn_todo">Seleccionar Todos</a>');  
						},  
						itemTemplate: function(_, item) {  
						 return $("<input>").attr("type","checkbox");
						 },  
						  align: "center", 
						 width: 30 
					} ,
					{ name: "Nota_Historia_Academica", type: "number", width: 20, title: "Nota en Historia Académica"},
					{ name: "Estado_Historia_Academica", type: "text", width: 20, title: "Estado en Historia Académica"},
					{ name: "Ponderaci&oacute;n_HA", type: "number", width: 20, title: "Ponderaci&oacute;n Utilizada en HA"},
					{ name: "Fecha_Entrega_Certificado", type: "text", width: 20, title: "Fecha de Entrega del Certificado"},
					{ name: "Nota_Certificado", type: "text", width: 20, title: "Nota en Certificado"}
					 <!-- {  -->
						 <!-- headerTemplate: function() { -->
						<!-- return $("<p>").text("elige");  -->
						 <!-- },  -->
						<!-- itemTemplate: function(_, item) {  -->
						 <!-- return $("<a>").attr("href","sss").attr("target", "_blank").text("ver")  -->
									<!-- .on("click", function () {	  -->
										
								 <!-- });  -->
						 <!-- },  -->
						 <!-- align: "center",  -->
						<!-- width: 50  -->
					<!-- }  -->
                ]

            });

		
        });
   </script>
	       <img src="../../img/image002.png" />     </body>		
</html>
