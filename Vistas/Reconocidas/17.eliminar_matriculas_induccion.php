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

   </div>
   <div id="jsGrid7"></div>

   <div id="botones">
		<a type="button" class="btn btn-primary"><i class="fa fa-book" aria-hidden="true"></i> Leer Datos de inducci&oacute;n</a><br><br>
		<a type="button" class="btn btn-primary"><i class="fa fa-file-text-o" aria-hidden="true"></i> Desmatricular Seleccionados</a>
		
   </div>
	       <img src="../../img/image002.png" />     
	<script src="../../js/filter/filter.js"></script>
	<script src="../../js/filter/thead.js"></script>
	<script>		
		$(function() {

            $("#jsGrid7").jsGrid({
                height: "60%",
                width: "50%",
				autoload: true,
				sorting: true,
				paging: true,
				pageSize: 2,
				selecting: true,
                controller: db,
                fields: [
					
                    { name: "nro", type: "text", width: 4, title: "N°" },
                    { name: "id", type: "text",width: 40, title: "iD Matricula"},
                     {
						headerTemplate: function() {
						return $("<p>").text("Alumno"); 
						}, 
						itemTemplate: function(_, item) { 
						return $("<a>").attr("href","course/view.php?id=" + item.id).attr("target", "_blank").text(item.fullname) 
						.on("click", function () { 
	 					});
						},
	 					align: "start", 
	 					width: 50 
					},
					{ name: "alumno", type: "number", width: 20, title: "Alumno"},	
					{ name: "pdidm", type: "number", width: 20, title: "PDiDM"},
					{ name: "bloque", type: "text", width: 20, title: "Bloque"},
					{ 
						headerTemplate: function() {			
						 return $("<p>").text("Acción");  
						},  
						itemTemplate: function(_, item) {  
						 return $("<input>").attr("type","checkbox");
						 },  
						 align: "center", 
						 width: 30 
					} ,

                ]

            });

		
        });
   </script>
</body>		
</html>


