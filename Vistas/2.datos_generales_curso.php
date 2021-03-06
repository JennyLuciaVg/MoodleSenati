
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV: Datos Generales del Curso</title>
    <link rel="stylesheet" type="text/css" href="../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../css/theme.css" />

    <script src="../js/jquery/jquery-1.8.3.js"></script>
	<link rel="stylesheet" href="../css/font-awesome.css">
	
    <script src="../data/cursos_detallados.js"></script>
    <script src="../js/jsgrid/jsgrid.core.js"></script>
    <script src="../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.field.js"></script>
	 <script>
				
			// $(document).ready(function(){
  
				// $("input[name=check]").each(function (index) { 
				  
				   // if( $(this).prop('checked') ) {
						 // alert('Seleccionado');
				   // }else{
					  // alert("no selecionado")
					 
				   // }
				// });
			
			// });
				
	</script>
</head>
<body>	

	     

    <div>
		<p><span class="blue">TECE 2016 - Grupo B - Zonal Juliaca Puno  - Datos Generales del Curso </span> </p>
    </div>

    <table class="date_general">
		<thead>
			<tr>
                <td>&nbsp </td>
                <th class="lightblue">DATOS DEL CURSO</th>
            </tr>
		</thead>	
       <tbody class="tbody">
         
       </tbody>
    </table>

      
    <div id="notas">
        <button type="button" class="btn btn-primary" onclick="save();"><i class="fa fa-save"></i> Salvar </button>
        <button type="button" class="btn btn-default"><i class="fa fa-ban"></i> Cancelar </button> 
    </div>
    
    <a href="#" class="btn btn-primary"> ir A Ponderaciones <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
    <br>
	<script>
		$(document).ready(function(){
			load();	
			
			
		});

		var id = 1;
		function load()
		{
			$.ajax({
				url: "http://localhost:80/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=ListarCurso&id_curso_moodle="+ id,
				type: "GET",
				contentType: "application/json;charset=utf8",
				dataType: "json",
				success: function (result)
				{
					var html = "";
				  
					var camp_pres = "";
					var id_tarea_induccion = "";
					var id_publico="";
					var id_curso_Senati = "";
					var grupo="";
					var id_curso="";
					$.each(result, function(key,item)
					{
						
						html += '<tr>';
						html += ' <th class="">Curso Visible</th>';
						if(item.visible == 1)
						{
							html += '<td><label class="switch" id="agre"><input type="checkbox" id="visible" name="check" checked=' + item.visible + '><div class="slider round"></div></label></td>';
							
						}else{
							html += '<td><label class="switch" id="agre"><input type="checkbox" id="visible" name="check" ><div class="slider round"></div></label></td>';						
						}
						html += '</tr>';
						
						html += '<tr>';
						html += '<th>Nombre del Curso</th>';
						html += '<td><input type="text" class="form-control" value="'+ item.fullname +'" size="86" id="fullname_curso"> </td>';							
						html += '</tr>';
						
						html += '<tr>';
						html += '<th>Nombre Corto</th>';
						html += '<td><input type="text" value='+ item.shortname +' class="form-control" id="shortname"> </td>';							
						html += '</tr>';
						
						html += '<tr>';
						html += '<th>Relacionar con curso SENATI</th>>';
						html += '<td><select class="form-control" id="car"></select> <p>Relacion Actual : <span id="curso_actual"></span></p> </td>';							
						html += '</tr>';
						
						html += '<tr>';
						html += '<th>Materia - Curso SINFO</th>';
						html += '<td> <input type="text" size="7" class="form-control" value='+ item.materia_sinfo +' id="materia_sinf"><input type="text" size="7" class="form-control" id="curso_sinf" value='+ item.curso_sinfo +'></td>';
						html += '</tr>';

						html += '<tr>';
						html += '<th>Periodo</th>';
						html += '<td> <input type="text"  size="11" value='+ item.periodo +' class="form-control" id="period"> </td>';
						html += '</tr>';		
					
						html += '<tr>';
						html += ' <th>¿ Es Subsanaci&oacute;n?</th>';
						if(item.subsanacion =="s")
						{
							if(item.subsanacion_de === null)
							{
								html += '<td><label class="switch" id="agre"><input type="checkbox"  name="check" checked="checked" id="chck_subsa"><div class="slider round"></div></label><label class="bold">id del Curso al cual Subsana</label><input type="text" size="7" class="form-control" id="subsa_de"><label class="bold">o Curso con el cual Fusionar</label></td>';
							
								
							}else{
								html += '<td><label class="switch" id="agre"><input type="checkbox" name="check" checked="checked" id="chck_subsa"><div class="slider round"></div></label><label class="bold">id del Curso al cual Subsana</label><input type="text" size="7" class="form-control" value='+ item.subsanacion_de +' id="subsa_de"><label class="bold">o Curso con el cual Fusionar</label></td>';
							
							}
							
						}else{
							html += '<td><label class="switch" id="agre"><input type="checkbox"  name="check" id="chck_subsa"><div class="slider round"></div></label><label class="bold">id del Curso al cual Subsana</label><input type="text" size="7" class="form-control" value='+ item.subsanacion_de +' id="subsa_de"><label class="bold">o Curso con el cual Fusionar</label></td>';
													
						}
						html += '</tr>';	
					
						html += '<tr>';
						html += ' <th>¿ Es inducci&oacute;n?</th>';
						if(item.induccion =="s")
						{
							if(item.induccion === null)
							{
								html += '<td><label class="switch" id="agre"><input type="checkbox" name="check" checked="checked" id="chck_inducc"><div class="slider round"></div></label></td>';	
							}else{
								html += '<td><label class="switch" id="agre"><input type="checkbox" name="check" checked="checked" id="chck_inducc"><div class="slider round"></div></label></td>';	
							}	
						}else{
							
							html += '<td><label class="switch" id="agre"><input type="checkbox"  name="check" id="chck_inducc"><div  class="slider round"></div></label></td>';		
						}
						html += '</tr>';	
	  				
						
						html += '<tr>';
						html += ' <th>¿ Es Presencial? </th>';
						if(item.presencial =="s")
						{
							if(item.presencial_de === null && item.camp_pres === null)
							{
								html += '<td><label class="switch" id="agre"><input type="checkbox" id="chck_presen" name="check" checked="checked"><div class="slider round"></div></label><label>Id del Curso Padre</label><input type="text" size="7"  class="form-control"><label>Camp Presencial</label><input type="text" size="7" class="form-control"><p id="nom_camp_presencial"><p> </td>';	
								camp_pres = item.camp_pres;
							}else{
								html += '<td><label class="switch" id="agre"><input type="checkbox" id="chck_presen" name="check" checked="checked"><div class="slider round"></div></label><label>id del Curso Padre</label><input type="text" size="7" value='+ item.presencial_de +' class="form-control" id="pres_de"><label>Camp Presencial</label><input type="text" size="7" value='+ item.camp_pres +' class="form-control"  id="camp_pres"><p id="nom_camp_presencial"><p> </td>';
								camp_pres = item.camp_pres;
							}	
						}else{
							html += '<td><label class="switch" id="agre"><input type="checkbox" id="chck_presen" name="check" ><div class="slider round"></div></label><label>Id del Curso Padre</label><input type="text" size="7" value='+ item.presencial_de +' class="form-control" id="pres_de"><label>Camp Presencial</label><input type="text" size="7" value='+ item.camp_pres +' class="form-control" id="camp_pres"><p id="nom_camp_presencial"><p> </td>';		
							camp_pres = item.camp_pres;
						}
						html += '</tr>';
						
						
						html += '<tr>';
						html += ' <th>¿ Es un Curso Patr&oacute;n ?</th>';
						if(item.patron =="s")
						{
							if(item.patron === null)
							{
								html += '<td><label class="switch" id="agre"><input type="checkbox" id="chckpatron" name="check" checked="checked"><div class="slider round"></div></label></td>';	
							
							}else{
								html += '<td><label class="switch" id="agre"><input type="checkbox" id="chckpatron" name="check" checked="checked"><div class="slider round"></div></label></td>';
							}	
						}else{
							
							html += '<td><label class="switch" id="agre"><input type="checkbox" id="chckpatron" name="check" ><div class="slider round"></div></label></td>';		
				
						}
						html += '</tr>';
						
						
						html += '<tr>';
						html += ' <th>ID Tarea de inducci&oacute;n</th>';
						if(item.id_tarea_induccion >= 0)
						{
							html +='<td><input type="text" size="7" class="form-control" value='+ item.id_tarea_induccion +' id="tarea_induccion"><p id="nombre_induccion"></p></td>';
							id_tarea_induccion = item.id_tarea_induccion;
						}						
						html += '</tr>';
						
						
						html += '<tr>';
						html += ' <th>P&uacute;blico (dirigido a)&nbsp; </th>';
						html += '<td><SELECT id="sel_publico" name="sel_publico"><OPTION value="" >NO ESPECIFICADO</OPTION><OPTION value="1">Exalumno</OPTION><OPTION  value="2">Trabajadores Empresas Aportantes</OPTION><OPTION  value="3">Alumnos SENATI</OPTION><OPTION  value="4">Publico en General</OPTION><OPTION  value="5">Trabajador del SENATI</OPTION><OPTION value="6">Equipo de SENATI VIRTUAL</OPTION></SELECT></td>';
						id_publico = item.id_publico;
						html += '</tr>';
						
						html += '<tr>';
						html += ' <th>Grupo&nbsp;</th>';
						html += '<td><SELECT id="sel_grupo" name="sel_grupo"><OPTION value="">NO ESPECIFICADO</OPTION><OPTION  value="A">A</OPTION><OPTION  value="B">B</OPTION><OPTION  value="C">C</OPTION></td>';
						grupo = item.grupo;
						html += '</tr>';
						
						html +='<tr>';
						html +='<th>Id del Patr&oacute;n Semilla&nbsp;</th>';
						html += '<td> <input type="text" size="7" value='+ item.id_patron_semilla +' class="form-control" id="idpatron_semilla"><label class="blue" >'+ item.fullname +'</label></td>';					
						html +='</tr>';
						
						html +='<tr>';
						html +=' <td>&nbsp</td>';
						html +=' <th class="lightblue">CERTIFICADO</th>';				
						html +='</tr>';
						
						html +='<tr>';
						html +='<th>Título</th>';
						html +='<td><input type="text" size="7"  value="'+ item.titulo_certificado +'" class="form-control" id="titulo_certi"></td>';
							
						html +='</tr>';
						
						html +='<tr>';
						html +='<th>Tama&ntilde;o de Fuente</th>';
						html +='<td><input type="text"  size="7" value='+ item.font_titulo_certi +' class="form-control" id="font_titulo"> <span class="blue"> Para el Título del Certificado (el estandar es 16)</span></td>';				
						html +='</tr>';
						
						
						html += '<tr>';
						html += '  <th>Header Certificado</th>';
						if(item.header_certi =="s")
						{
								html += '<td><label class="switch" id="agre"><input type="checkbox" id="chck_he" name="check" checked="checked"><div class="slider round"></div></label> <span class="blue"> Certificado con Header o No</span></td>';		
						}else{
							
							html += '<td><label class="switch" id="agre"><input type="checkbox" id="chck_he" name="check" ><div class="slider round"></div></label> <span class="blue"> Certificado con Header o No</span></td>';		
						}
						html += '</tr>';
					
			
						$.ajax({
							url : "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=ListarCursos",
							type: "GET",
							contentType: "application/json;charset=utf-8",
							dataType: "json",
							success: function(data2){
							     $.each(data2, function(key,items)
								{
									var option = $(document.createElement('option'));
									 option.text(this.nombre_curso);
									 option.val(this.id_curso);
									 $("#car").append(option);

									
								});
								
							},
							error : function(xhr,errmsg,err) {
							  console.log(xhr.status + ": " + xhr.responseText);
							}
						 });
						 
						 $.ajax({
							url : "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=ListaRelaCurso&id_curso_moodle=" + id,
							type: "GET",
							contentType: "application/json;charset=utf-8",
							dataType: "json",
							success: function(data3){
								
							   var curso_actual = $("#curso_actual");
							 
							    $.each(data3, function(key,itera)
								{
									if (itera.nombre_curso !="")
								   {
										curso_actual.text(itera.nombre_curso);
										id_curso_Senati = itera.id_curso_senati;
								   }
								   else
								   {
									 curso_actual.text("NO TIENE");
									 id_curso_Senati = itera.id_curso_senati;
								   }
									
								   
								});
								
							},
							error : function(xhr,errmsg,err) {
							  console.log(xhr.status + ": " + xhr.responseText);
							}
						 });
								
						$.ajax({
							url : "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=ListaCentro&camp_pres="+ camp_pres,
							type: "GET",
							contentType: "application/json;charset=utf-8",
							dataType: "json",
							success: function(data4){
								
							   var nom_camp_presencial = $("#nom_camp_presencial");
							   
							  
							   
							    $.each(data4, function(key,itera)
								{
									if (itera.nombre_curso !="")
								   {
										nom_camp_presencial.text(itera.nombre_centro);
								   }
								});
								
							},
							error : function(xhr,errmsg,err) {
							  console.log(xhr.status + ": " + xhr.responseText);
							}
						 });
						 
						 $.ajax({
							url : "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=ListaTarea&id_tarea_induccion="+ id_tarea_induccion,
							type: "GET",
							contentType: "application/json;charset=utf-8",
							dataType: "json",
							success: function(data5){
								var nombre_induccion = $("#nombre_induccion");
							    $.each(data5, function(key,iteran)
								{
									nombre_induccion.text(iteran.name);		
								});
								select_rela_curso(id_curso_Senati);
							},
							error : function(xhr,errmsg,err) {
							  console.log(xhr.status + ": " + xhr.responseText);
							}
						 });
						


					});

					$('.tbody').html(html);
					select_publico(id_publico);
					select_grupo(grupo);	//id_curso_Senati
					
				},
				error: function (errormessage) {
					alert(errormessage.responseText);
				}

			});

		}
	
	
		function save() {
			var visible = document.getElementById("visible").checked;
			
				var val_visible ="";
				
				if(visible === true)
				{
					val_visible = 1;
				}else{
					val_visible = 0;
				}

				 var camp_pre = document.getElementById("chck_presen").checked;
				 var val_camp ="";
				 
				 if(camp_pre === true)
				 {
					 val_camp = 1;
				 }else{
					 val_camp = 0;
				 }
				
				var header = document.getElementById("chck_he").checked;
				
				var valheader="";
				
				if(header === true)
				{
					valheader = "s";
				}else{
					valheader="n";
				}
				
				var object = {
					tx_curso_sinfo: $("#curso_sinf").val(),
					tx_materia_sinfo: $("#materia_sinf").val(),
					nome_curso: $("#fullname_curso").val(),
					visiblex: val_visible,
					periocolo: $("#period").val(),
					camp_presencial: val_camp,
					patron_semilla: $("#idpatron_semilla").val(),
					tx_id_tarea_induccion: $("#tarea_induccion").val(),
					fuente: $("#font_titulo").val(),
					header: valheader,
					nombre_corto: $("#shortname").val(),
					id_curso_moodle: id
				};
				
					
				var objecta = {
					titulo_certi: $("#titulo_certi").val(),
					tx_curso_sinfo: $("#curso_sinf").val(),
					tx_materia_sinfo: $("#materia_sinf").val(),
					nome_curso: $("#fullname_curso").val(),
					visiblex: val_visible,
					periocolo: $("#period").val(),
					camp_presencial: val_camp,
					patron_semilla: $("#idpatron_semilla").val(),
					tx_id_tarea_induccion: $("#tarea_induccion").val(),
					fuente: $("#font_titulo").val(),
					header: $("#font_titulo").val(),
					nombre_corto: $("#shortname").val(),
					id_curso_moodle: id
				};	
			
				var certi = $("#titulo_certi").val();
				
				if(certi=="")
				{
					
					 $.ajax({
							url: "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=ActualizarCurso",
							type: "GET",
							data: {x:JSON.stringify(object)},
							cache: false,
							contentType: "application/json;charset=utf8",
							success: function (result) {
								
								alert("actualizado1");
							},
							error: function (errormessage) {
								alert(errormessage.responseText);
							}
					});
					
				}else{
					$.ajax({
							url: "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=ActualizarTituloCerti",
							type: "GET",
							data: {y:JSON.stringify(objecta)},
							cache: false,
							contentType: "application/json;charset=utf8",
							success: function (result) {
								alert("actualizado1.1");
							},
							error: function (errormessage) {
								alert(errormessage.responseText);
						}
					});
					
				}	
				
				$.ajax({
				url: "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=CursoExiste="+ id,
				type: "GET",
				contentType: "application/json;charset=utf8",
				success: function (result) {
					$.each(result, function(key,item)
					{
						var total = item.total;
						var valor_id_cs = 1;
									 
						var objetcse = {
							valor_id_cs: valor_id_cs,
							id_curso_moodle: id	
						};
						 
						if (total==0)
						{//SE HACE UN INSERT
							if(valor_id_cs!="")
							{
								$.ajax({
									url: "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=InsertRelaCursos",
									type: "GET",
									data: {f:JSON.stringify(objetcse)},
									cache: false,
									contentType: "application/json;charset=utf8",
									success: function (result) {
										alert("actualizo 3");
									},
									error: function (errormessage) {
										alert(errormessage.responseText);
									}
								});
							}
						}
						else
						{
							if(valor_id_cs!="")
							{	
								$.ajax({
								url: "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=ActualizarRelaCurso",
								type: "GET",
								data: {f:JSON.stringify(objetcse)},					
								cache: false,
								contentType: "application/json;charset=utf8",
								success: function (result) {
									alert("actualizo 4");
								},
								error: function (errormessage) {
										alert(errormessage.responseText);
								}
								});
							}
							else
							{  
												  
								$.ajax({
									url: "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=Eliminar_rela_cursos" + id,
									type: "GET",
									cache: false,
									contentType : "application/json;charset=utf-8",
									success: function (result)
									{
										alert("elimino");						
									},
									error: function (errormessage)
									{
										alert(errormessage.responseText);
									}

								});
							}
						}
					});		
				},
					error: function (errormessage) {
					alert(errormessage.responseText);
				}	
			});			
			//patron
			 var camp_pre = document.getElementById("chck_presen").checked;
			 var val_camps ="";
			 
			 if(camp_pre === true)
			 {
				 val_camps = 1;
			 }else{
				 val_camps = 0;
			 }
			
		
			var patronn = document.getElementById("chckpatron").checked;
			var val_patron="";
			
			if(patronn === true)
			{
				val_patron = "s";
			}else{
				val_patron ="n";
			}
			
			var inducc = document.getElementById("chck_inducc").checked;
			var val_inducc = "";
			
			if(inducc ===true)
			{
				val_inducc = "s";
			}else{
				val_inducc = "n";
			}
			
			var subsanacion = document.getElementById("chck_subsa").checked;
			var val_subsana = "";
			
			if(subsanacion ===true)
			{
				val_subsana = "s";
			}else{
				val_subsana = "n";
			}
			
			var indexpublico =  document.getElementById('sel_publico').options.selectedIndex;
			var grupotext = document.getElementById('sel_grupo').options[document.getElementById('sel_grupo').selectedIndex].text;
		
			var sub = {
				patronx: val_patron,
				publicox: indexpublico,
				presex: val_camps,
				subsax: val_subsana,
				indux: val_inducc,
				grupox: grupotext,
				subsanacion_de_post: $("#subsa_de").val(),
				presencial_de_post: $("#pres_de").val(), 
				id_curso_moodle: id
			};
	
			$.ajax({
					url: "http://localhost/Api/Api/DAO/DATOS_GENERALES_CURSO.php?action=ActualizarCursoPatron",
					type: "GET",
					data: {w:JSON.stringify(sub)},
					cache: false,
					contentType: "application/json;charset=utf8",
					success: function (result) {
						//alert(result);
						alert("actualizado 6");
					},
					error: function (errormessage) {
							alert(errormessage.responseText);
					}
			});		
			
			
			//patron
	}
				
		
		function select_publico(id_publico){
			if (id_publico == null)
			{
				$("#sel_publico option[value="+ null +"]").attr("selected",true);
									
			}		
			if (id_publico =="1")
			{
				$("#sel_publico option[value="+ 1 +"]").attr("selected",true);
									
			}	

			if (id_publico =="2")
			{
				$("#sel_publico option[value="+ 2 +"]").attr("selected",true);
			}

			if (id_publico =="3")
			{
				$("#sel_publico option[value="+ 3 +"]").attr("selected",true);
			}
								
			if (id_publico =="4")
								{
				$("#sel_publico option[value="+ 4 +"]").attr("selected",true);
			}
								
			if (id_publico =="5")
			{
				$("#sel_publico option[value="+ 5 +"]").attr("selected",true);
			}
								
			if (id_publico =="6")
			{
					$("#sel_publico option[value="+ 6 +"]").attr("selected",true);
			
			}
		}	
	
		function select_grupo(grupo){
			
			var A,B,C;
			if (grupo == null)
			{
				$("#sel_grupo option[value="+ null +"]").attr("selected",true);
			}
								
			if (grupo =="A")
			{
				$("#sel_grupo option[value="+ 'A' +"]").attr("selected",true);
			}
			if (grupo =="B")
			{
				$("#sel_grupo option[value="+ 'B' +"]").attr("selected",true);
			}
			if (grupo =="C")
			{
					$("#sel_grupo option[value="+ 'C' +"]").attr("selected",true);
			}			
		}
	
		function select_rela_curso(id_curso_Senati)
		{
			var car = document.getElementById("car");
			
		
			for (var i = 0; i < car.length; i++) {
			//  Aca haces referencia al "option" actual
				var opt = car[i].value;
				
				if(id_curso_Senati === opt)
				{
					$("#car option[value="+ opt +"]").attr("selected",true);
					
				}	
				
				
				
			}
			
			
			
			// if (id_curso_Senati === car)
			// {
				// $("#car option").attr("selected",true);
			// }
								
					
		}
	</script>
  </body>	
</html>