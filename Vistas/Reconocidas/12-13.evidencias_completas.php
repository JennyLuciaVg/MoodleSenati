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
<body>
	<img src="../../img/image001.png" />

	<div id="tb_tutores_grupos">
		<table>
			<thead class="lightblue">
				<tr>
					<th>Tutores</th>
					<th>Grupos</th>
					<th>Total Grupos</th>
				</tr>
			</thead>
			<tbody class="tbody_tutores_grupos"></tbody>
		</table>
	</div>

	<div id="">
		<p class="red">NOTA iMPORTANTE : En la Tabla abajo mostrada se puede identificar al Tutor del GRUPO usando la tabla de arriba.</p>
		<a href="./14.notas_historia_academica.html">Pasar a Historia Academica(Regular, Presencial o induccion)</a>
		<br />
		<p>Los criterios para pasar a SUBSANACiON son : el % de evidencias entregadas debe ser mayor a 40% y la nota obtenida MAYOR a 4.
		<br>Los Cursos de iNDUCCiON NO TiENEN SUBSANACiON al igual que los mismos cursos de SUBSANACiON, PRESENCiALES O TRABAJADORES.</p>
		<br />
	</div>
	<br /><br />
    <!-- <div id="jsGrid1"></div> -->
	<div>
		<table id="tb_evidencias">
		</table>
	</div>
	<br /><br />
	<div>
		<table id="tb_tareas">
		</table>
	</div>
	<br /><br />
	<div>
		<table id="tb_quiz">
		</table>
	</div>
	<br /><br />
	<div>
		<table id="tb_foros">
		</table>
	</div>
	<br /><br />
	<div>
		<table id="tb_resumen">
		</table>
	</div>
	
<!-- 	<div>
		<p><span class="span_insertar"> insertar/Actualizar Notas de inducci&oacute;n</span> (Extrae Notas del Curso de inducci&oacute;n - el sistema lo busca)</p>
		<table border="1">
			<tbody>
				<tr>
					<td><span class="span_insertar">id Tarea induccion</span></td>
					<td><input type="text" class="form-control" /></td>
					<td><a type="button" class="btn btn-primary"><i class="fa fa-file-text-o" aria-hidden="true"></i> insertar o Actualizar Notas</button></td>
				</tr>
			</tbody>
		</table>
	</div> -->
	
    <script>		
	//extraer de url o handler o request *******************************************************************
	var id_curso = 7892;
	var id_user = 6518;

	var ajax_url_root = "http://localhost/Proyecto/Api/Api/DAO";

	function load2() {
		valor = $( ".campo" ).find('option:selected').text();
		
		alert(valor);
		
		// $("#jsGrid5  .jsgrid-grid-body .jsgrid-table tbody tr").append("td").text("Nueva Fila");
	}
    

	$(function() { //no va

        $("#jsGrid2").jsGrid({
            height: "50%",
            width: "100%",
			paging: true,
			autoload: true,
            controller: db,
            fields: [				 
				{ name: "id", type: "number",width: 20,
					headerTemplate: function(value) {
						return $("<div>").addClass("address").append(value).text("id Sinfo");
					}
				},
				{ name: "id_SV", type: "number",width: 20},
				{ name: "Apellidos" , type: "text",width: 20, title: "Apellidos, Nombres"},
				{ name: "Email" , type: "text",width: 20},
				{ name: "Status_Sinfo" , type: "text",width: 20},
				{ name: "Grupo" , type: "text",width: 20},
				{ name: "Campus" , type: "text",width: 20},
				{ name: "Bloque" , type: "number",width: 20},
				{ name: "Tarea_Unidad01" , type: "number",width: 20},
				{ name: "Tarea_Unidad02" , type: "number",width: 20},
				{ name: "Evaluacion_U01" , type: "number",width: 20},
				{ name: "Caso_EstudioU01" , type: "number",width: 20},
				{ name: "Evaluacion_U02" , type: "number",width: 20},
				{ name: "Caso_EstudioU02" , type: "number",width: 20},
				{ name: "Evidencias_Entregadas" , type: "number",width: 20},
				{ name: "Porcentaje_Entregadas" , type: "number",width: 20},
				{ name: "Promedio_Ponderado" , type: "number",width: 20},
				{ name: "Estado_Actual" , type: "number",width: 20}
            ]
        });

    });

	//load data for table 1
	$.ajax({
		url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=Total_Grupos&id_cursox="+ id_curso,
        async: false,
		type: "GET",
		contentType: "application/json;charset=utf-8",
		dataType: "json",
		success: function(result){
			var html = "";	
			$.each(result, function(key,item) {
				html += "<tr><td>"+item.lastname+", "+item.firstname+"</td><td><select name=&quot;grupos_dropdown&quot;>";
				$.ajax({
					url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=Lista_Grupos&id_cursox="+ id_curso + "&proxe_id=" + item.userid,
					type: "GET",
					contentType: "application/json;charset=utf-8",
					dataType: "json",
					success: function(result){
						$.each(result, function(key,item2) {
							html =+ "<option value=&quot;"+item2.id+"&quot;>"+item2.name+"</option>";
						});
					},
					error : function(xhr,errmsg,err) {
						 console.log(xhr.status + ": " + xhr.responseText);
					}
				});
				html =+ "</select></td><td>"+item.grupo+"</td></tr>";
				$(".tbody_tutores_grupos").html(html);
			});
		},
		error : function(xhr,errmsg,err) {
			 console.log(xhr.status + ": " + xhr.responseText);
		}
	});


	var tiene_grupos;
	var existe_ponderacion;
	var permite_subsanacion;

	var nombre_curso;
	var subx;
	var indux;
	var id_publico;
	var presencial;
	var id_tarea_induccion;

	var es_subsanacion;
	var es_presencial;
	var es_induccion;
	var id_publico;

	var mensaje_head; 

	var nombre_tareas = [];
	var nombre_quiz = [];
	var nombre_foros = [];

	var total_tarea_ok = [0,0,0,0,0,0,0,0,0,0];
	var total_tarea_no_envio = total_tarea_ok.slice();
	var total_tarea_falta_calificar = total_tarea_ok.slice();	
	var total_quiz_no_intento = total_tarea_ok.slice();
	var total_quiz_ok = total_tarea_ok.slice();
	var total_foro_falta_calificar = total_tarea_ok.slice();
	var total_foro_no_posteo = total_tarea_ok.slice();
	var total_foro_ok = total_tarea_ok.slice();

	var total_aprobados=0;
	var total_desaprobados=0;
	var total_pasan_a_subsa=0;
	var total_ya_no_pasan_a_subsa=0;

	var total_aprobados_ret=0;
	var total_desaprobados_ret=0;
	var total_pasan_a_subsa_ret=0;
	var total_ya_no_pasan_a_subsa_ret=0;

	var total_evidencias=0;
	var total_evidencias_reales=0;

	var c4 = 0;
	var total_tareas = 0;
	var total_quiz = 0;
	var total_foros = 0;

	//verificar grupo
	$.ajax({
		url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=VerificarPonderacion&id_cursox="+ id_curso,
        async: false,
		type: "GET",
		contentType: "application/json;charset=utf-8",
		dataType: "json",
		success: function(result){
			tiene_grupos = result.existe;
		},
		error : function(xhr,errmsg,err) {
			 console.log(xhr.status + ": " + xhr.responseText);
		}
	});
	//existe ponderacion
	$.ajax({
		url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=VerificarPonderacion&id_cursox="+ id_curso,
        async: false,
		type: "GET",
		contentType: "application/json;charset=utf-8",
		dataType: "json",
		success: function(result){
			if (result.tiene_pond == 0) {
				tiene_pond = false;
			} else {
				tiene_pond = true;
			}
		},
		error : function(xhr,errmsg,err) {
			 console.log(xhr.status + ": " + xhr.responseText);
		}
	});
	//tiene subsanacion
	$.ajax({
		url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=ListaCurso&id_cursox="+ id_curso,
        async: false,
		type: "GET",
		contentType: "application/json;charset=utf-8",
		dataType: "json",
		success: function(result){			
			nombre_curso=result.fullname;
			subx=result.subsanacion;
			indux=result.induccion;
			id_publico=result.id_publico;
			presencial=result.presencial;
			id_tarea_induccion=result.id_tarea_induccion;
		},
		error : function(xhr,errmsg,err) {
			 console.log(xhr.status + ": " + xhr.responseText);
		}
	});

	if (presencial=="s") {
		es_presencial="SI";
		mensaje_head="ESTE ES UN CURSO PRESENCIAL.";
	}
	if (subx=="s") {
		es_subsanacion="SI";
		mensaje_head="ESTE ES UN CURSO PRESENCIAL.";
	} else {
		es_subsanacion="NO";
	}
	if (indux=="s") {
		es_induccion="SI";
	   	mensaje_head="ESTE ES UN CURSO DE INDUCCION.";
	} else {
		es_induccion="NO";
	}
	if (id_publico=="5") {
		mensaje_head="ESTE ES UN CURSO PARA TRABAJADORES DEL SENATI, LA NOTA APROBATORIA ES MAYOR O IGUAL A 13.";
	}
	if (es_subsanacion!="s" && presencial!="s" && es_induccion=="NO" && id_publico=="3") {
		permite_subsanacion = true;
	} else {
		permite_subsanacion = false;
	}

	// $enlace="<a href='view.php?id=". $id_cursox . "'>". $nombre_curso . "</a> &gt; " . $titulo_pagina; 
	// print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");
	// ************** IMPRIMIR HEADER


	var html_evid = ""; //tabla principal
	var tipo_tarea = "";
	var contador_evid = 0;
	//columnas fijas
	html_evid+="<thead><TR bgcolor=#dddddd height=23><td>Id SINFO</td><td>Id SV</td><td>Apellidos, Nombres</td><td>Email</td><td>Status SINFO</td><td>Grupo</td><td>Campus</td><td>Bloque</td>";

	total_evidencias=0;
	total_evidencias_reales=0;

	//tareas
	$.ajax({
		url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=PerformingSql&id_cursox="+ id_curso,
		type: "GET",
	    async: false,
		contentType: "application/json;charset=utf-8",
		dataType: "json",
		success: function(result){
			$.each(result, function(key,item) {
				contador_evid++;
				id_asignacion = item.id;
				peso_recurso = item.peso_recurso;

				if (peso_recurso!=0 && peso_recurso!="") {
					total_evidencias++;
				}
				total_tareas++;
				nombre_tareas.push(item.name);

				if(item.assignmenttype=="offline") {
					tipo_tarea = "<BR><font color=red>(Tarea Offline)</font>";
					if(peso_recurso!=0 && peso_recurso!="") {
						total_evidencias_reales++;
					}
				}

				html_evid+="<td title=&quot;Tarea "+key+"&quot;>"+item.name+tipo_tarea+"<BR>Peso :"+peso_recurso+"%<BR><font color=black style=&quot;font-size:11px&quot;>(id tarea="+id_asignacion+")</font></td>";

			});
		},
		error : function(xhr,errmsg,err) {
			 console.log(xhr.status + ": " + xhr.responseText);
		}
	});
	//quiz
	$.ajax({
		url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=PerformingSqlD&id_cursox="+ id_curso,
		type: "GET",
	    async: false,
		contentType: "application/json;charset=utf-8",
		dataType: "json",
		success: function(result){
			$.each(result, function(key,item) {
				peso_recurso = item.peso_recurso;

				if (peso_recurso!=0 && peso_recurso!="") {
					total_evidencias++;
					total_evidencias_reales++;
				}

				total_quiz++;
				nombre_quiz.push(item.name);
				html_evid+="<td title=&quot;Cuestionario "+key+"&quot;>"+item.name+"<BR>Peso :"+peso_recurso+"%</td>";
			});
		},
		error : function(xhr,errmsg,err) {
			 console.log(xhr.status + ": " + xhr.responseText);
		}
	});
	//foros
	$.ajax({
		url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=ListaForoDistinct&id_cursox="+ id_curso,
		type: "GET",
	    async: false,
		contentType: "application/json;charset=utf-8",
		dataType: "json",
		success: function(result){
			$.each(result, function(key,item) {
				peso_recurso = item.peso_recurso;
				total_foros++;
				nombre_foros.push(item.name);

				if (peso_recurso!=0 && peso_recurso!="") {
					total_evidencias++;
					total_evidencias_reales++;
				}

				html_evid+="<td title=&quot;"+item.name+"&quot;>"+item.name+"<BR>Peso :"+peso_recurso+"%</td>";
		});
	},
		error : function(xhr,errmsg,err) {
			 console.log(xhr.status + ": " + xhr.responseText);
		}
	});
	
	html_evid+="<TD align=center><strong>Evidencias Entregadas</strong></TD><TD align=center><strong>% Evidencias Entregadas</strong></TD><TD align=center><strong>PROMEDIO PONDERADO</strong></TD><TD align=center><strong>ESTADO ACTUAL</strong></TD></TR>";
	html_evid+="<TR><TD align=center bgcolor=yellow colspan=8><strong>TOTAL EVIDENCIAS ENTREGABLES :"+total_evidencias_reales+"</strong></TD></TR>";
	html_evid+="</thead><tbody>";

	var total_retirados = 0;
	var evidencias_entregadas = 0;
	var evidencias_entregadas_reales = 0;
	var retirado = false;
	//lista_grupos_estudiantes
	$.ajax({
		url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=ListaGrupoE&id_cursox="+ id_curso,
        async: false,
		type: "GET",
		contentType: "application/json;charset=utf-8",
		dataType: "json",
		success: function(result){
			$.each(result, function(key,item) {
				id_user = item.userid;
				if (item.status_sinfo == "RET") {
					total_retirados++;
					retirado=true;
				}
				var nombre_alumno = item.lastname+", "+item.firstname;

				html_evid+="<TR><td align=right>"+item.pidm_banner+"</td><td align=right>"+id_user+"</td>";
				html_evid+="<td><a href=&quot;http://virtual.senati.edu.pe/user/view.php?id="+id_user+"&course=1&quot; target=_blank><u>"+nombre_alumno+"</u></a></td>";
				html_evid+="<td>"+item.email+"</td><td align=&quot;center&quot;>&nbsp;<strong style=&quot;color:red&quot;>"+item.status_sinfo+"</strong>&nbsp;</td>";
				html_evid+="<td>"+item.grupo+" </td><td>"+item.nombre_centro+"</td><td>"+item.bloque+"</td>";

				//tareas
				var lista_notas_ok = "";
				var lista_notas_bad = "";
				var suma_ponderada = 0;
				var numero_de_tarea = 0;
				var numero_de_quiz = 0;
				var numero_de_foro = 0;

				$.ajax({
					url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=ListaTarea&id_userx="+ id_user + "&id_cursox=" + id_curso,
					type: "GET",
				    async: false,
					contentType: "application/json;charset=utf-8",
					dataType: "json",
					success: function(result){
						$.each(result, function(key2,item2) {
							numero_de_tarea++;
							tipo_tarea = item2.assignmenttype;
							var nota = item2.Grade;
							var faraxi = false;
							var linkix = "http://virtual.senati.edu.pe/mod/assignment/submissions.php?id="+item2.id_link+"&userid="+id_user+"&mode=single&offset=2";

							var num_files = parseInt(item2.numfiles);
							if (item2.nota_maxima > 0) {
								nota = 20*nota/item2.nota_maxima;
							} else {
								nota = 0;
							}
							if (nota < 0) {
								nota = 0;
							}
							if (nota == 0 || nota == -1 || nota == '') {
								nota = 0;
							} else {
								suma_ponderada = suma_ponderada + nota*item2.peso_recurso;
							}
							var estilo_fondo = "";
							var mesaf_tareas = "";
							fecha_marked=parseInt(item2.timemarked);
							fecha_modified=parseInt(item2.timemodified);

							if (num_files>=1 && fecha_marked || (item2.Grade == "" && tipo_tarea=="offline")|| (num_files >=1 && item2.Grade=="-1")) {
								mesaf_tareas = "<a target=_blank href='"+linkix+"'><font color=blue><u>Falta calificar</u></font></a>";
								estilo_fondo="bgcolor=yellow";
								faraxi = true;
							}
							if (numfiles>=1 && fecha_marked!=0 && fecha_marked < fecha_modified) {
							   mesaf_tareas = nota.toString()+"&nbsp;<a target=_blank href='"+linkix+"'><font color=blue><u>Falta Recalificar</u></font></a>";
							   estilo_fondo = "bgcolor=yellow";
							   faraxi = true;
							} 
							if (numfiles==0 && tipo_de_tarea != "offline") {
								mesaf_tareas="<font color=red>No envi&oacute; tarea</font>";
							}

							var aux = false;
							if (mesaf_tareas == ""){
								mesaf_tareas = nota.toString();
								total_tarea_ok[numero_de_tarea]++;
								aux = true;
							}
							if (nota != 0 && mesaf_tareas == "") {
								mesaf_tareas = nota.toString();
								if (!aux) {
									total_tarea_ok[numero_de_tarea]++;
								}
							}
							if (mesaf_tareas=="<font color=red>No envi&oacute; tarea</font>") {
								total_tarea_no_envio[numero_de_tarea]++;
							}
							if (faraxi) {
								total_tarea_falta_calificar[numero_de_tarea]++;
							}
							if (mesaf_tareas!="<font color=red>No envi&oacute; tarea</font>" && tipo_de_tarea!="offline") {
								evidencias_entregadas++;
							}

							if (tipo_de_tarea=="offline") {
								if (item2.Grade>0) {
									evidencias_entregadas_reales++;
								}
							} else {
								if (numfiles*1+1-1 >=1) {
									evidencias_entregadas_reales++;
								}
							}

							lista_notas_ok=lista_notas_ok+","+nota+"*"+item2.peso_recurso;
							lista_notas_bad=lista_notas_bad+","+nota+"*"+item2.peso_recurso;

							if (nota != 0 && mesaf_tareas=="<font color=red>No envi&oacute; tarea</font>") {
								mesaf_tareas+="&nbsp;"+nota.toString();
							}

							html_evid += "<td align=right nowrap "+estilo_fondo+">"+mesaf_tareas+"</td>";
						}); 
					},
					error : function(xhr,errmsg,err) {
						 console.log(xhr.status + ": " + xhr.responseText);
					}
				});

				//quiz
				$.ajax({
					url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=ListaQuizz&id_userx="+ id_user + "&id_cursox=" + id_curso,
					type: "GET",
				    async: false,
					contentType: "application/json;charset=utf-8",
					dataType: "json",
					success: function(result){
						$.each(result, function(key2,item2) {
							var peso = item2.peso_recurso;
							var nota = item2.nota_grande;
							if (peso == "") {
								peso = 0;
							}
							if (item2.nota_maxima > 0) {
								nota = 20*nota/item2.nota_maxima;
							} else {
								nota = 0;
							}
							if (nota < 0) {
								nota = 0;
							}
							if (nota== 0 || nota==-1 ||	nota=='') {
								nota=0;
							} else {	
								suma_ponderada += nota*peso;
								evidencias_entregadas++;
								evidencias_entregadas_reales++;
							}
							numero_de_quiz++;
							var aux1 = "";
							var aux2 = "";
							var mesaq = "";
							if (nota == 0) {
							   aux1="<font color=red>";
							   aux2="</font>";
							}
							if (nota == "") {
								mesaq = "<font color=red>No intent&oacute;</font>";
								total_quiz_no_intento[numero_de_quiz]++;
							} else {
								mesaq = aux1 + " " + nota.toString() + " " + aux2;
								total_quiz_ok[numero_de_quiz]++;
							}

							lista_notas_ok = lista_notas_ok + ","+ nota + "*" + peso;
							lista_notas_bad = lista_notas_bad + ","+ nota + "*" + peso;

							html_evid += "<td align=right>"+mesaq+"</td>";
						});
					},
					error : function(xhr,errmsg,err) {
						 console.log(xhr.status + ": " + xhr.responseText);
					}
				});

				//foros
				$.ajax({
					url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=ListaForoDistinct&id_cursox="+ id_curso,
					type: "GET",
				    async: false,
					contentType: "application/json;charset=utf-8",
					dataType: "json",
					success: function(result){
						$.each(result, function(key2,item2) {
							var estilo_fondo = "";
							numero_de_foro++;
							// id_foro = item2.id;
							// nota_maxima = item2.scale;
							// peso_rec = item2.peso_recurso;
							var nota_mas_alta = 0;
							var tnf = 0;
							var suma_nota_foro = 0;
							var peso_recox = 0;
							var total_post = 0;

							var id_discuss = 0;
							var nota = 0;
							$.ajax({
								url: ajax_url_root+"/EVIDENCIASCOMPLETAS?action=ListaForos&id_userx="+ id_user + "&id_cursox=" + id_curso + "&id_foro=" + item2.id,
								type: "GET",
							    async: false,
								contentType: "application/json;charset=utf-8",
								dataType: "json",
								success: function(result){
									$.each(result, function(key3,item3) {
										id_discuss = item3.discuss;
										total_post++;
										nota = item3.rating;
										if (item2.scale > 0) {
											nota = 20*nota/item2.scale;
										} else {
											nota = 0;
										}
										if (nota < 0) {
											nota = 0;
										}
										if (nota_mas_alta < nota) {
											nota_mas_alta = nota;
										}
										suma_nota_foro+=nota;
										peso_recox = item3.peso_recurso;
										tnf++;
									});
								},
								error : function(xhr,errmsg,err) {
									 console.log(xhr.status + ": " + xhr.responseText);
								}
							});
							if (tnf != 0) {
								if ($id_cursox > 523) {
									nota=$nota_mas_alta;
								} else {
									nota=$suma_nota_foro/$tnf;
								/// esto es para promediar ANTES !!!!!!!!!!!! CURSOS DEL 2008 !!!!!!!!!
								}
							} else {
								nota=0;
							}
							if (nota == 0 | nota==-1 || nota=='') {
								nota = 0;
							} else {
								suma_ponderada+= nota * item2.peso_recurso;
							}
							if (total_post != 0) {
								evidencias_entregadas++;
								evidencias_entregadas_reales++;
							}
							var mesa_foro = "";
							if (total_post == "" || total_posts==0) {
								mesa_foro="<font color=red>No poste&oacute;</font>";
			   					total_foro_no_posteo[numero_de_foro]++;
							}
							if(total_posts>=1 && nota==0) {
								mesa_foro="<a href='../mod/forum/discuss.php?d=" + id_discuss + "' target=_blank title='" + nombre_alumno + "'><font color=blue><u>Falta Calificar</u></font></a>";
								total_foro_falta_calificar[numero_de_foro]++;
								estilo_fondo="bgcolor=yellow";
							}
							if (mesa_foro == "") {
								mesa_foro = nota;
								total_foro_ok[numero_de_foro]++;
							}

							lista_notas_ok += ", " + nota + "*" + item2.peso_recurso;
							lista_notas_bad += ", " + nota + "*" + peso_recox;

							html_evid += "<td align=right nowrap "+estilo_fondo+">"+mesa_foro+"</td>";
						});
					},
					error : function(xhr,errmsg,err) {
						 console.log(xhr.status + ": " + xhr.responseText);
					}
				});
				html_evid += "<td align=center><strong>" + evidencias_entregadas_reales + "</strong></td>";
				var porcentrega = 0;
				var mensajex = "";
				if (total_evidencias_reales != 0) {
					porcentrega = 100*evidencias_entregadas_reales/total_evidencias_reales;
				}
				if (porcentrega >= 40 && suma_ponderada >= 400 && suma_ponderada <= 1050 && permite_subsanacion) {
					mensajex="<font color=green>PASA A SUBSANACION</font>";
				} else {
					if (suma_ponderada >= 1050) {
						mensajex="<font color=blue>APROBADO</font>";
					} else {
						mensajex="<font color=red>DESAPROBADO</font>";
					}
				}
				if (es_subsanacion == "SI") {
					if (suma_ponderada >= 1050) {
						mensajex="<font color=blue>APROBADO</font>";
					} else {
						mensajex="<font color=red>DESAPROBADO</font>";
					}
				}
				if (presencial == "s") {
					if (suma_ponderada >= 1050) {
						mensajex="<font color=blue>APROBADO</font>";
					} else {
						mensajex="<font color=red>DESAPROBADO</font>";
					}
				}
				if (id_publico=="5") {
					if (suma_ponderada >= 1300) {
						mensajex="<font color=blue>APROBADO</font>";
					} else {
						mensajex="<font color=red>DESAPROBADO</font>";
					}
				}
				
				if (suma_ponderada >= 1041 && suma_ponderada <= 1049) {
					suma_ponderada = 1040;
				}
				var nota_finay = suma_ponderada/100;
				if (mensajex=="<font color=green>PASA A SUBSANACION</font>" && nota_finay==10.5) {
				   	mensajex="<font color=blue>APROBADO</font>";
				}
				if (mensajex=="<font color=blue>APROBADO</font>" && nota_finay==10.4) {
				   	nota_finay="10.5";
				}
				if (es_induccion=="SI" && mensajex=="<font color=green>PASA A SUBSANACION</font>") {
				   	mensajex="<font color=red>DESAPROBADO</font>";
				}   
				if (es_subsanacion=="SI" && mensajex=="<font color=green>PASA A SUBSANACION</font>") {
					mensajex="<font color=red>DESAPROBADO</font>";
				}

				if (mensajex.lastIndexOf(">APROBADO<")>2) {
					total_aprobados++;
				}
				if (mensajex.lastIndexOf(">DESAPROBADO<")>2) {
					total_desaprobados++;
				}
				if (mensajex.lastIndexOf(">PASA A SUBSANACION<")>2) {
					total_pasan_a_subsa++;
				}

				if (mensajex.lastIndexOf(">APROBADO<")>2 && retirado) {
					total_aprobados_ret++;
				}
				if (mensajex.lastIndexOf(">DESAPROBADO<")>2 && retirado) {
					total_desaprobados_ret++;
				}
				if (mensajex.lastIndexOf(">PASA A SUBSANACION<")>2 && retirado) {
					total_pasan_a_subsa_ret++;
				}

				html_evid += "<td align=center><strong>" + porcentrega_round + " %</strong></td>";
				html_evid += "<td align=center><strong>" + nota_finay + "</strong></td><td align=center><strong>"+ mensajex +"</strong></td></TR>";
			});
		},
		error : function(xhr,errmsg,err) {
			 console.log(xhr.status + ": " + xhr.responseText);
		}
	});
	html_evid += "</tbody>";
	$("#tb_evidencias").html(html_evid);

	//tb_tareas
	var html_tareas = "<thead><TR bgcolor=#dddddd><TD><strong>Tarea</strong></TD><TD><strong>Nombre Tarea</strong></TD><TD style='color:red'>No enviaron tarea</TD><TD style='color:blue'>Falta (Re)Calificar</TD><TD>Tienen Nota</TD><TD><strong>TOTAL</strong></TD></TR></thead>";
	html_tareas += "<tbody>";

	for (var i = 0; i < total_tareas.length; i++) {
		// total_tareas[i]
		var total = total_tarea_no_envio[i]+total_tarea_falta_calificar[i]+total_tarea_ok[i];
		var estilo = "";
		if (total_tarea_falta_calificar != 0) {
			estilo = "bgcolor=yellow";
		}
		html_tareas += "<TR><TD align=center>"+i+"</TD><TD>"+nombre_tareas[i]+"</TD><TD align=right>"+total_tarea_no_envio[i]+"</TD><TD align=right "+estilo+">"+total_tarea_falta_calificar[i]+"</TD><TD align=right>"+total_tarea_ok[i]+"</TD><TD align=right>"+total+"</TD></TR>";
	};
	html_tareas += "</tbody>";
	$("#tb_tareas").html(html_tareas);

	//tb_quiz
	var html_quiz = "<thead><TR bgcolor=#dddddd><TD><strong>Cuestionario</strong></TD><TD><strong>Nombre Cuestionario</strong></TD><TD style='color:red'>No intentaron</TD><TD>Tienen nota</TD><TD><strong>TOTAL</strong></TD></TR></thead>";
	html_quiz += "<tbody>";
	for (var i = 0; i < total_quiz.length; i++) {
		// total_quiz[i]
		var total = total_quiz_no_intento[i] + total_quiz_ok[i];
		html_quiz += "<TR><TD align=center>"+i+"</TD><TD>"+nombre_quiz[i]+"</TD><TD align=right>"+total_quiz_no_intento[i]+"</TD><TD align=right>"+total_quiz_ok[i]+"</TD><TD align=right>"+total+"</TD></TR>";
	};
	html_quiz += "</tbody>"
	$("#tb_quiz").html(html_quiz);

	//tb_foros
	var html_foros = "<thead><TR bgcolor=#dddddd><TD><strong>Foro</strong></TD><TD><strong>Nombre Foro</strong></TD><TD style='color:red'>No postearon</TD><TD style='color:blue'>Falta Calificar</TD><TD>Tienen nota</TD><TD><strong>TOTAL</strong></TD></TR></thead>";
	html_foros += "<tbody>";
	for (var i = 0; i < total_foros.length; i++) {
		// total_foros[i]
		var total = total_foro_no_posteo[i] + total_foro_falta_calificar[i] + total_foro_ok[i];
		var estilo = "";
		if (total_foro_falta_calificar[i] != 0) {
			estilo = "bgcolor=yellow";
		}

		html_foros += "<TR><TD align=center>"+i+"</TD><TD>"+nombre_forox[i]+"</TD><TD align=right>"+total_foro_no_posteo[i]+"</TD><TD align=right "+estilo+">"+total_foro_falta_calificar[i]+"</TD><TD align=right>"+total_foro_ok[i]+"</TD><TD align=right>"+total+"</TD></TR>";
	};
	html_foros += "</tbody>";
	$("#tb_foros").html(html_foros);

	//tb_resumen
	var total_final = total_aprobados + total_desaprobados + total_pasan_a_subsa + total_ya_no_pasan_a_subsa;
	var html_resumen = "";

	html_resumen += "<TR><TD bgcolor='#dddddd'><strong>ESTADOS FINALES</strong></TD><TD bgcolor='#dddddd'><strong>TOTAL</strong></TD><TD bgcolor='#dddddd'><strong>RETIRADOS DE SINFO</strong></TD></TR>";
	html_resumen += "<TR><TD align=right><strong><font color=blue>APROBADO</font></strong></TD><TD align=right>"+total_aprobados+"</TD><TD align=right>"+total_aprobados_ret+"</TD></TR>";
	html_resumen += "<TR><TD align=right><strong><font color=red>DESAPROBADO</font></strong></TD><TD align=right>"+total_desaprobados+"</TD><TD align=right>"+total_desaprobados_ret+"</TD></TR>";
	html_resumen += "<TR><TD align=right><strong><font color=green>PASA A SUBSANACION</font></strong></TD><TD align=right>"+total_pasan_a_subsa+"</TD><TD align=right>"+total_pasan_a_subsa_ret+"</TD></TR>";
	html_resumen += "<TR><TD align=right><strong>TOTALES</strong></TD><TD align=right><strong>"+total_final+"</strong></TD><TD align=right><strong style='color:red'>"+total_retirados+"</strong></TD></TR>";

	//insertar, actualizar notas de induccion
	var html_ind = "";
	if (id_user == 2 && es_induccion != "SI") {
		html_ind += "<form name=forma_induccion id=forma_induccion method=post target=_blank action='inserta_notas_induccion.php'>";
		html_ind += "<P><strong>Insertar/Actualizar Notas de Inducci&oacute;n</strong> (Extrae Notas del Curso de Inducci&oacute;n - el sistema lo busca)";
		html_ind += "<TABLE border=1 cellspacing=1 cellpadding=3 bordercolor='gray'>";
		html_ind += "<tr><td><strong>ID_TAREA_INDUCCION</strong></td>";
		html_ind += "<td><input type=text value='"+id_tarea_induccion +"' id='"+id_tarea_induccion +"' maxlength=5 size=5>";
		html_ind += "<input type=hidden value='"+id_curso +"' id='"+id_curso +"'>";
		html_ind += "<input type=hidden value='"+nombre_curso +"' id='"+nombre_curso +"'>";
		html_ind += "</TD><td><INPUT type=submit value='Insertar o Actualizar Notas'></td></TR></TABLE></p></form>";
	}
	</script>
	<img src="../../img/image002.png" />     
	<script src="../../js/filter/filter.js"></script>
	<script src="../../js/filter/thead.js"></script>
	<script src="../../js/filter/search.js"></script>
</body>		
</html>
