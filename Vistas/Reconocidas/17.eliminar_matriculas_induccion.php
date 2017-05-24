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
<!--    <div id="notas">
		<h4 class="blue"><span>iNDUCCiON A CURSOS ViRTUALES 201620</span> - Eliminaci&oacute;n de Matrículas de iNDUCCi&oacute;N</h4>
		<p class="red">Este NO ES UN CURSO DE iNDUCCi&oacute;N. (no podrá realizar ninguna acci&oacute;n)</p>
		<p class="blue">Este m&oacute;dulo verifica si el alumno ha llevado inducci&oacute;n y la ha aprobado de ser así permite desmatricularlo</p>
		
		<span class="span_insertar">LiSTA DE ALUMNOS</span>

   </div> -->
   <div id="mensaje"></div>
   <div id="jsGridEliMat"></div>

   <div id="botones">
		<a type="button" class="btn btn-primary"><i class="fa fa-book" aria-hidden="true"></i> Leer Datos de inducci&oacute;n</a><br><br>
		<a type="button" class="btn btn-primary"><i class="fa fa-file-text-o" aria-hidden="true"></i> Desmatricular Seleccionados</a>
		
   </div>
	       <img src="../../img/image002.png" />     
	<script src="../../js/filter/filter.js"></script>
	<script src="../../js/filter/thead.js"></script>
	<script>
	var id_curso = 7745;
	var disabled = true;

	if (isAdmin()) { //Metodo indeterminado, Xtian debe determinar la forma de acceder a esta info
		//mensaje previo a la tabla
		var nombre_curso;
		var induccionx;
		var presencial_de;
		var subsanacion_de;

		var mensaje1 = "";

		$.ajax({
			url: "http://localhost/Api/Api/DAO/ELIMINACION_MATRICULAS_CURSO_INDUCCION?action=Lista_Curso&id_cursox="+ id_curso,
			type: "GET",
		    async: false,
			contentType: "application/json;charset=utf-8",
			dataType: "json",
			success: function(result){
				nombre_curso=result.fullname;
				induccionx=result.induccion;
				presencial_de=result.presencial_de;
				subsanacion_de=result.subsanacion_de;
			},
			error : function(xhr,errmsg,err) {
				 console.log(xhr.status + ": " + xhr.responseText);
			}
		});
		if (induccionx=="s" || induccionx=="S") {
			$.ajax({
				url: "http://localhost/Api/Api/DAO/ELIMINACION_MATRICULAS_CURSO_INDUCCION?action=Existes&id_curso_moodle="+ id_curso,
				type: "GET",
			    async: false,
				contentType: "application/json;charset=utf-8",
				dataType: "json",
				success: function(result){
					if (result.existe_acta == '1'|| result.existe_acta == 1) {
						mensaje1 = "Este CURSO YA TIENE ACTAS DE NOTAS NO SE PUEDE DESMATRICULAR.";
						disabled = true;
					} else {
						mensaje = "Este NO ES UN CURSO DE INDUCCION. (no podrá realizar ninguna acción)";
						disabled = true;
					}
				},
				error : function(xhr,errmsg,err) {
					 console.log(xhr.status + ": " + xhr.responseText);
				}
			});
		}
		var html_mensaje = "<strong style='color:blue'><a href='view.php?id="+id_curso_moodle+"'><u>"+nombre_curso+"</u></a> - Eliminación de Matriculas de INDUCCION</strong><BR><BR>";
		html_mensaje += "<p><font style='font-size:14px' color=red>"+mensaje1+"</font></p>";
		$("#mensaje").html(html_mensaje);

		$(function() {
	        $("#jsGridEliMat").jsGrid({
	            height: "60%",
	            width: "50%",
				autoload: true,
				sorting: true,
				paging: true,
				pageSize: 2,
				selecting: true,
	            controller: listarAlumnosCurso,
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
							if (disabled) {
								return $("<p>").text("");
							} else {
								return $("<input>").attr("type","checkbox");
							}
						},  
						align: "center", 
						width: 30 
					} ,
	            ]
	        });	
	    });
	} else {
		$("#jsGridEliMat").html("<h1>Debe ser administrador para entrar a esta pagina</h1>");
	}

	var listarAlumnosCurso =  function () {
	    var data = $.Deferred();
	    $.ajax({
	    type: "GET",
	    contentType: "application/json; charset=utf-8",
	    url: "http://localhost/Api/Api/DAO/ELIMINACION_MATRICULAS_CURSO_INDUCCION?action=Lista_Alumnos_Curso&id_curso_moodle="+ id_curso,
	    dataType: "json"
	    }).done(function(response){
	        data.resolve(response);
	    });
	    return data.promise();
	};

	function EliminarMatriculados() {
        var table = $("#jsGridEliMat .jsgrid-grid-body");
		
        table.find('tr').each(function (i) {
            var $tds = $(this).find('td'),
                id_matricula = $tds.eq(1).text(),// N°
            	chk = $tds.eq(5).find('input').is(":checked");// accion
            if (chk) {
				$.ajax({
					url: "http://localhost/Api/Api/DAO/ELIMINACION_MATRICULAS_CURSO_INDUCCION?action=EliminarME&id_matrix="+ id_matricula,
					type: "GET",
				    async: false,
					contentType: "application/json;charset=utf-8",
					dataType: "json",
					success: function(result){
						console.log("matricula eliminada: " + id_matricula);
					},
					error : function(xhr,errmsg,err) {
						console.log(xhr.status + ": " + xhr.responseText);
					}
				});
            }
        });
	}

	</script>
</body>		
</html>


