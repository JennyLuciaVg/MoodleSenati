<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
    <meta charset="UTF-8">
    <title>SV: importaci&oacute;n de Matriculas para Cursos Presenciales</title>
	 <link rel="stylesheet" type="text/css" href="../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../css/theme.css" />
    <script src="../js/jquery/jquery-1.8.3.js"></script>
	<link rel="stylesheet" href="../css/font-awesome.css">
	<script src="../data/importar_matriculas_presenciales.js"></script>
    <script src="../js/jsgrid/jsgrid.core.js"></script>
    <script src="../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.field.js"></script>
</head>
<body>	          

    <div>
        <p class="blue">importaci&oacute;n de Matriculas para Cursos Presenciales  </p>
    </div>
	
    <div id="etiquetas">
        <label><strong>Seleccionar el Período:</strong></label>
        <input type="text" size=5px class="form-control"></input>
        <a type="button" class="btn btn-primary"><i class="fa fa-list"></i> Listar</a>
    </div>

    <div id="jsGrid"></div>

	<div id="etiquetas">
        <a   href="#" type="button" class="btn btn-primary"><i class="fa fa-share-square-o" aria-hidden="true"></i> importar Matriculas</a>
    </div>   
    <script>
        $(function() {

            $("#jsGrid").jsGrid({
                height: "50%",
                width: "100%",
                autoload: true,
				sorting: true,
				paging: true,
				pageSize: 3,
                controller: db,
                fields: [
                    { name: "No", type: "number", width: 8, align:"center", title:"N°" },
                    { name: "id_Curso", type: "number", width: 25,  align: "center",    title:"id Curso" },
                    { name: "Curso_Presencial", type: "text", width: 210,  title:"Curso Presencial" },
                    { name: "id_Curso_Padre", type: "number", width: 40 ,   align:"center", title: "id Curso Padre" },
                    { name: "Camp_Presencial", type: "number", width: 45,  align:"center", title:"Camp Presencial"  },
                    { name: "Campus_Presencial", type: "text", width: 100, align:"left",  title:"Campus Presencial" },
                    { name: "Matriculas", type: "number", width: 30, align:"right" }
                ]
            });

            $("#sort").click(function() {
                var field = $("#sortingField").val();
                $("#jsGrid").jsGrid("sort", field);
            });

        });
    </script>

     
              

</body>	
</html>
