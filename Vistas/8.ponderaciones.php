<!DOCTYPE html> 
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
   <title>SV:  SV : Historia Academica - Acta de Aprobados - Lista Unificada</title>
    <link rel="stylesheet" type="text/css" href="/public/css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="/public/css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="/public/css/theme.css" />

    <script src="/public/data/db.js"></script>
	<link rel="stylesheet" href="/public/css/font-awesome.css">
    <script src="/public/js/jquery/jquery-1.8.3.js"></script>
    <script src="/public/data/evaluaciones_curso_presenciales.js"></script>
    <script src="/public/js/jsgrid/jsgrid.core.js"></script>
    <script src="/public/js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="/public/js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="/public/js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="/public/js/jsgrid/jsgrid.field.js"></script>
</head>

<body>	          

    <div>
		 <p><strong>PONDERACiON DE NOTAS DE TAREAS y/o CUESTiONARiOS correspondientes al Curso :</strong></p>
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
		<input type="text" size="8" class="form-control">
		<a type="button" href="#" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Leer Ponderaciones desde la Semilla</a></p>
    </div>
	
    <div>
       <p><a href="#" class="btn btn-primary"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar al Curso</a></p>
	   <p><a href="#" class="btn btn-primary">ir a Datos Generales <i class="fa fa-arrow-right" aria-hidden="true"></i></a></p>
    </div>
      
              </body>	
</html>
    <script>
        
        
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
                controller: db, 
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
                controller: db, 
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
                controller: db, 
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

        $(document).ready(function(){
            mostrar();
            //fecha();
            //aunto_incre();
        });
    </script>