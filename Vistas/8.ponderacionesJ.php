<!DOCTYPE html> 
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
   <title>SV:  SV : Historia Academica - Acta de Aprobados - Lista Unificada</title>
    <link rel="stylesheet" type="text/css" href="../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../css/theme.css" />

    <script src="../external/jquery/jquery-1.8.3.js"></script>
    <script src="db.js"></script>
    <link rel="stylesheet" href="../css/font-awesome.css">
    <script src="../js/jquery/jquery-1.8.3.js"></script>
    <script src="../data/evaluaciones_curso_presenciales.js"></script>
    <script src="../js/jsgrid/jsgrid.core.js"></script>
    <script src="../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.field.js"></script>
</head>

<body>	          

    <div>
		 <p><strong>PONDERACION DE NOTAS DE TAREAS y/o CUESTiONARiOS correspondientes al Curso :</strong></p>
         <p> <span class="blue"> inducci&oacute;n Titulaci&oacute;n Egresados - 2017 ELECTRONiCA ZLC GRUPO 1 </span> (<span class="bold">iD del CURSO </span> : 7788)</p>
    </div> 

    <!-- TABLA: TAREAS (Assignments) -->
    <div id="jsGridTareas"></div>
	<div>
		<!--<table>
			<thead class="lightblue">
				<tr>
					<th>TAREAS (assignments)</th>
					<th>Ponderaci&oacute;n</th>
					<th>Unidad</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Tarea de inducci&oacute;n (14463)</td>
					<td><input type="text" size="4" maxlength="3" class="form-control" /> </td>
					<td> 1</td>
				</tr>
			</tbody>
		</table>-->
	</div>

    <!-- TABLA: CUESTIONARIOS (QUIZ) -->
    <div id="jsGridCuestionarios"></div>
	<div id="notas">
		<!--<table >
			<thead class="lightblue">
				<tr>
					<th>CUESTiONARiOS (quiz)</th>
					<th>Ponderaci&oacute;n</th>
					<th>Unidad</th>
				</tr>
			</thead>
			<tbody>
				<tr >
					<td>Evaluaci&oacute;n del curso (19147)</td>
					<td><input type="text" size="4" maxlength="3" class="form-control"/> </td>
					<td> 1</td>
				</tr>
			</tbody>
		</table>-->
    </div>
    <div id="jsGridForos"></div>
	<div>
		<!--<table>
			<thead class="lightblue">
				<tr>
					<th>FOROS (forums)</th>
					<th>Ponderaci&oacute;n</th>
					<th>Unidad</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Foro Temático del curso (14463)</td>
					<td><input type="text" size="4" maxlength="3" class="form-control"></td>
					<td> 1</td>
				</tr>
			</tbody>
    	</table>-->
	</div>

	<div id="etiquetas">
		<a type="button" class="btn btn-primary"><i class="fa fa-save"></i> Salvar Datos </a>
	</div>
   
    <div id="etiquetas">
        <p class="blue">NOTA : La suma de todos los pesos de ponderaci&oacute;n debe ser igual a 100</p>
		<hr>
		<p>PATRON SEMiLLA 
		<input id="patron_semilla" type="text" size="8" class="form-control" />
		<a type="button" href="#" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Leer Ponderaciones desde la Semilla</a></p>
    </div>
	
    <div>
       <p><a href="#" class="btn btn-primary"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar al Curso</a></p>
	   <p><a href="#" class="btn btn-primary">ir a Datos Generales <i class="fa fa-arrow-right" aria-hidden="true"></i></a></p>
    </div>
      
              </body>	
</html>
    <script>
        // estos datos deben ser extraidos de sesion y del url
        var id_curso = 7788;
        var id_user = 78945;

        var tareas = [];
        var quizes = [];
        var foros = [];

        $.ajax({
            url: "http://localhost/Api/Api/DAO/PONDERACIONES?action=Ponderacion_Patron_Semilla&id_cursox="+ id_curso,
            type: "GET",
            contentType: "application/json;charset=utf-8",
            dataType: "json",
            success: function(result){
                $(#patron_semilla).value = result.id_patron_semilla;
                // document.getElementById("patron_semilla").value = id_curso;
            },
            error : function(xhr,errmsg,err) {
                 console.log(xhr.status + ": " + xhr.responseText);
            }
        });

        $(function() {
            $("#jsGridTareas").jsGrid({
                width: "40%",
    			height: "auto",
                autoload: true,
                sorting: true,
                //paging: true,
                pageSize: 2,
                selecting: true,
                pagePrevText: "<",
                pageNextText: ">",
                pageFirstText: "<<",
                pageLastText: ">>",
                pageNavigatorNextText: "&#8230;",
                pageNavigatorPrevText: "&#8230;",
                onRefreshed: function ( args ) {
                    mostrar();
                },
                controller: {
                    loadData: function() {
                        var data = $.Deferred();
                        $.ajax({
                            type: "GET",
                            contentType: "application/json; charset=utf-8",
                            url: "http://localhost:80/Api/Api/DAO/PONDERACiONES.php?action=Ponderacion_Performing_Tarea&id_cursox="+id_curso,
                            dataType: "json"
                            }).done(function(response){
                                $.each(response, function(key,item) {
                                    tareas.push({
                                        id: item.id,
                                        name: item.name,
                                        peso: item.peso_recurso,
                                        unidad: item.section
                                    });
                                });
                                data.resolve(response);
                            });
                            return data.promise();
                }},
                fields: [       
                    { name: "tareas", type: "text", width: 30, title:"TAREAS (assignments)"},
                    {
                        name: "ponderado_tareas",
                        type: "number",
                        headerTemplate: function() {
                        return $("<p>").text("Ponderación"); 
                        }, 
                        itemTemplate: function(_, item) { 
                        return $("<input style='text-align:left' type='text' size='4' maxlength='3' class='form-control' />").text(item.Ponderación_HA);
                        },
                        width: 15
                    },
                    { name: "unidad_tarea",  type: "number",  width:10  , title:"Unidad" },
                ]
            });

            $("#jsGridCuestionarios").jsGrid({
                width: "40%",
                height: "auto",
                autoload: true,
                sorting: true,
                //paging: true,
                pageSize: 2,
                selecting: true,
                pagePrevText: "<",
                pageNextText: ">",
                pageFirstText: "<<",
                pageLastText: ">>",
                pageNavigatorNextText: "&#8230;",
                pageNavigatorPrevText: "&#8230;",
                onRefreshed: function ( args ) {
                    mostrar();              
                },
                controller: {
                    loadData: function() {
                        var data = $.Deferred();
                        $.ajax({
                            type: "GET",
                            contentType: "application/json; charset=utf-8",
                            url: "http://localhost:80/Api/Api/DAO/PONDERACiONES.php?action=Ponderacion_Performing_Quiz&id_cursox="+id_curso,
                            dataType: "json"
                            }).done(function(response){
                                $.each(response, function(key,item) {
                                    quizes.push({
                                        id: item.id,
                                        name: item.name,
                                        peso: item.peso_recurso,
                                        unidad: item.section
                                    });
                                });
                                data.resolve(response);
                            });
                            return data.promise();
                }},
                fields: [       
                    { name: "cuestionarios", type: "text", width: 30, title:"CUESTIONARIOS (QUIZ)"},
                    {
                        name: "ponderado_cuestionario",
                        type: "number",
                        headerTemplate: function() {
                        return $("<p>").text("Ponderación"); 
                        }, 
                        itemTemplate: function(_, item) { 
                        return $("<input style='text-align:left' type='text' size='4' maxlength='3' class='form-control' />").text(item.Ponderación_HA);
                        },
                        width: 15
                    },
                    { name: "unidad_cuestionario",  type: "number",  width:10  , title:"Unidad" },
                ]
            });

            $("#jsGridForos").jsGrid({
                width: "40%",
                height: "auto",
                autoload: true,
                sorting: true,
                //paging: true,
                pageSize: 2,
                selecting: true,
                pagePrevText: "<",
                pageNextText: ">",
                pageFirstText: "<<",
                pageLastText: ">>",
                pageNavigatorNextText: "&#8230;",
                pageNavigatorPrevText: "&#8230;",
                onRefreshed: function ( args ) {
                    mostrar();              
                },
                controller: {
                    loadData: function() {
                        var data = $.Deferred();
                        $.ajax({
                            type: "GET",
                            contentType: "application/json; charset=utf-8",
                            url: "http://localhost:80/Api/Api/DAO/PONDERACiONES.php?action=Ponderacion_Performing_Forum&id_cursox="+id_curso,
                            dataType: "json"
                            }).done(function(response){
                                $.each(response, function(key,item) {
                                    foros.push({
                                        id: item.id,
                                        name: item.name,
                                        peso: item.peso_recurso,
                                        unidad: item.section
                                    });
                                });
                                data.resolve(response);
                            });
                            return data.promise();
                }},
                fields: [       
                    { name: "foros", type: "text", width: 30, title:"FOROS (forums)"},
                    {
                        name: "ponderado_foros",
                        type: "number",
                        headerTemplate: function() {
                        return $("<p>").text("Ponderación"); 
                        }, 
                        itemTemplate: function(_, item) { 
                        return $("<input style='text-align:left' type='text' size='4' maxlength='3' class='form-control' />").text(item.ponderado_foros);
                        },
                        width: 15
                    },
                    { name: "unidad_foros",  type: "number",  width:10  , title:"Unidad" },
                ]
            });
        });
        
        function aunto_incre(){
            var select, i, option,actual;
            var fecha = new Date();
            var year = fecha.getFullYear();
            select = document.getElementById("yearField");
            document.getElementById("fecha").innerHTML = year;
            for (i=year;i>=2005;i--)
            {   
                option = document.createElement('option');
                option.value = option.text = i;
                select.add( option );   
            }             
        }
    
        //fecha
        var anio;
        function fecha(){
            var imprimirResultado = function () {
                anio = $("#yearField option:selected").text();
                var fecha = document.getElementById("fecha");
                fecha.innerHTML = anio;
                //alert(anio);
            }
            $("#yearField").on("change", imprimirResultado).find("option:contains(2017)").prop("selected", true);
        }
    
        function mostrar(){
            var f = $("#jsGrid .jsgrid-grid-body .jsgrid-table tbody tr").attr("id","demo");
            $(f).each(function (index){
                var campo1, campo2, campo3;
                $(this).children("td").each(function (index2){
                    switch (index2) {
                        case 0: campo1 = $(this).text(); $(this).attr("id","tareas");
                                break;
                        case 1: campo2 = $(this).text(); $(this).attr("id","Ponderación_HA")
                                break;
                        case 2: campo3 = $(this).text(); $(this).attr("id","unidad")
                                break;                               
                    }
                    //$(this).css("background","#b6dbed");                    
                })
            });

        }

        function insertar_pesos() {
            //update values if changed on the jsGrid
            var numero_tareas = tareas.length;
            var numero_quizes = quizes.length;
            var numero_foros = foros.length;
            var total_registros;
            var total_pesos = 0;

            $(tareas).each(function (key, value) {
                total_pesos+=value.peso_recurso
            }
            $(quizes).each(function (key, value) {
                total_pesos+=value.peso_recurso
            }
            $(foros).each(function (key, value) {
                total_pesos+=value.peso_recurso
            }
            if (total_pesos==100) {
                $(tareas).each(function (key, value) {
                    $.ajax({
                        url: "http://localhost/Api/Api/DAO/PONDERACiONES?action=TotalTarea&id_cursox="+ id_curso + "&valor_id_assign=" + value.id,
                        type: "GET",
                        contentType: "application/json;charset=utf-8",
                        dataType: "json",
                        success: function(result){
                            if (result.total==0) {
                                $.ajax({
                                    url: "http://localhost/Api/Api/DAO/PONDERACiONES?action=InsertarPesosRecursos&valor_id_assign="+value.id+"&valor_peso_assign="+value.peso_recurso+"&id_cursox="+id_curso+"&id_usuario="+id_user,
                                    type: "GET",
                                    contentType: "application/json;charset=utf-8",
                                    dataType: "json",
                                    success: function(result){},
                                    error : function(xhr,errmsg,err) {
                                         console.log(xhr.status + ": " + xhr.responseText);
                                    }
                                });
                            } else {
                                $.ajax({
                                    url: "http://localhost/Api/Api/DAO/PONDERACiONES?action=UpdatePesosRecursos&valor_peso="+value.peso_recurso+"&id_usuario="+id_user+"&id_cursox="+id_curso+"&tiporecurso=1&valor_id_quiz="+value.id,
                                    type: "GET",
                                    contentType: "application/json;charset=utf-8",
                                    dataType: "json",
                                    success: function(result){},
                                    error : function(xhr,errmsg,err) {
                                         console.log(xhr.status + ": " + xhr.responseText);
                                    }
                                });
                            }
                        },
                        error : function(xhr,errmsg,err) {
                             console.log(xhr.status + ": " + xhr.responseText);
                        }
                    });

                });
                $(quizes).each(function (key, value) {
                    $.ajax({
                        url: "http://localhost/Api/Api/DAO/PONDERACiONES?action=TotalRecursos&id_cursox="+ id_curso + "&valor_id_quiz=" + value.id,
                        type: "GET",
                        contentType: "application/json;charset=utf-8",
                        dataType: "json",
                        success: function(result){
                            if (result.total==0) {
                                $.ajax({
                                    url: "http://localhost/Api/Api/DAO/PONDERACiONES?action=InsertarPesosRecursos&valor_id_assign="+value.id+"&valor_peso_assign="+value.peso_recurso+"&id_cursox="+id_curso+"&id_usuario="+id_user,
                                    type: "GET",
                                    contentType: "application/json;charset=utf-8",
                                    dataType: "json",
                                    success: function(result){},
                                    error : function(xhr,errmsg,err) {
                                         console.log(xhr.status + ": " + xhr.responseText);
                                    }
                                });
                            } else {
                                $.ajax({
                                    url: "http://localhost/Api/Api/DAO/PONDERACiONES?action=UpdatePesosRecursos&valor_peso="+value.peso_recurso+"&id_usuario="+id_user+"&id_cursox="+id_curso+"&tiporecurso=2&valor_id_quiz="+value.id,
                                    type: "GET",
                                    contentType: "application/json;charset=utf-8",
                                    dataType: "json",
                                    success: function(result){},
                                    error : function(xhr,errmsg,err) {
                                         console.log(xhr.status + ": " + xhr.responseText);
                                    }
                                });
                            }
                        },
                        error : function(xhr,errmsg,err) {
                             console.log(xhr.status + ": " + xhr.responseText);
                        }
                    });

                });
                $(foros).each(function (key, value) {
                    $.ajax({
                        url: "http://localhost/Api/Api/DAO/PONDERACiONES?action=TotalForo&id_cursox="+ id_curso + "&valor_id_foro=" + value.id,
                        type: "GET",
                        contentType: "application/json;charset=utf-8",
                        dataType: "json",
                        success: function(result){
                            if (result.total==0) {
                                $.ajax({
                                    url: "http://localhost/Api/Api/DAO/PONDERACiONES?action=InsertarPesosRecursos&valor_id_assign="+value.id+"&valor_peso_assign="+value.peso_recurso+"&id_cursox="+id_curso+"&id_usuario="+id_user,
                                    type: "GET",
                                    contentType: "application/json;charset=utf-8",
                                    dataType: "json",
                                    success: function(result){},
                                    error : function(xhr,errmsg,err) {
                                         console.log(xhr.status + ": " + xhr.responseText);
                                    }
                                });
                            } else {
                                $.ajax({
                                    url: "http://localhost/Api/Api/DAO/PONDERACiONES?action=UpdatePesosRecursos&valor_peso="+value.peso_recurso+"&id_usuario="+id_user+"&id_cursox="+id_curso+"&tiporecurso=3&valor_id_quiz="+value.id,
                                    type: "GET",
                                    contentType: "application/json;charset=utf-8",
                                    dataType: "json",
                                    success: function(result){},
                                    error : function(xhr,errmsg,err) {
                                         console.log(xhr.status + ": " + xhr.responseText);
                                    }
                                });
                            }
                        },
                        error : function(xhr,errmsg,err) {
                             console.log(xhr.status + ": " + xhr.responseText);
                        }
                    });

                });
            }
    
        }

        $(document).ready(function(){
            mostrar();
            //fecha();
            //aunto_incre();
        });
    </script>
