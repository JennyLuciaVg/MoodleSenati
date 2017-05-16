<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="UTF-8">
    <title>SV: Reporte de retirados por periodo</title>
	  <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
		<link rel="stylesheet" type="text/css" href="../../css/theme.css" />

		<script src="../../js/jquery/jquery-1.8.3.js"></script>
		<script src="../../data/db.js"></script>
			<link rel="stylesheet" type="text/css" href="../../css/font-awesome.css">
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

    <style>
        .sort-panel {
            padding: 10px;
            margin: 10px 0;
            background: #fcfcfc;
            border: 1px solid #e9e9e9;
            display: inline-block;
        }
    </style>
</head>
<body>        <img src="../../img/image001.png" />   	
    <h1>Reportes de jefe de centro</h1>
    <div class="sort-panel">
        <label>Seleccione un periodo
            <select id="sortingField" class="form-control">
                <option>201510</option>
                <option>201520</option>
                <option>201530</option>
            </select>
            <a type="button" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Listar</a>
        </label>
    </div>

	<p class="bold">REPORTE DEL PERiODO : <span>201510</span> </p>
    <div id="jsGridRetiradosPeriodo"></div>

    <script>
        $(function() {

            $("#jsGridRetiradosPeriodo").jsGrid({
                height: "20%",
                width: "100%",
                autoload: true,
                paging: true,
                pageSize: 1,
                selecting: true,
				sorting: true,
                controller: db,
                fields: [
                    { name: "N°", type: "number", width: 20},
                    { name: "id", type: "number", width: 20, title: "id Moodle"},
                    { name: "PiDM_SiNFO", type: "number", width: 20, title: "PiDM SiNFO"},
                    { name: "Name", type: "text", width: 20},
                    { name: "Curso", type: "text", width: 20 },
                    { name: "iD_Alumno_Moodle", type: "number", width: 20,title: "id Curso"},
                    { name: "Camp", type: "number", width: 20}, 
                    { name: "Campus", type: "number", width: 20}  
                ]
            });

            $("#sort").click(function() {
                var field = $("#sortingField").val();
                $("#jsGrid").jsGrid("sort", field);
            });

        });
    </script>
       <img src="../../img/image002.png" />     </body>		
</html>
