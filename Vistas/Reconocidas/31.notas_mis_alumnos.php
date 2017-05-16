<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="iE=edge">
		<meta charset="UTF-8">	
        <title>SV: Mis Notas - TUTOR</title>
          <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
		<link rel="stylesheet" type="text/css" href="../../css/theme.css" />

		<script src="../../js/jquery/jquery-1.8.3.js"></script>
		<script src="../../data/db.js"></script>

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
			<label class="bold">Seleccione grupo</label>
			<select class="form-control">
				<option>Grupo1</option>
				<option>Grupo2</option>
				<option>Grupo3</option>
				<option>Grupo4</option>
			</select>
		</div>
		<div id="jsGridEvicenciaCampus"></div>
		 <script>
        $(function() {

            $("#jsGridEvicenciaCampus").jsGrid({
                height: "40%",
                width: "100%",
                autoload: true,
                sorting: true,
                paging: true,
                pageSize: 1,
                selecting: true,
                controller: db,
                fields: [
                    { name: "N°", type: "number", width: 6},
                    { name: "id", type: "number", width: 10, title: "id Sinfo"},
                    { name: "id_SV", type: "number", width: 10, title: "id SV"},
                    { name: "Apellidos", type: "text", width: 20, title: "Apellidos, Nombres" , align:"center" },
                    { name: "Email", type: "text", width: 25},
                    { name: "Status_Sinfo", type: "text", width: 20,title: "Status Sinfo"},
                    { name: "Grupo", type: "number", width: 27}, 
                    { name: "Campus", type: "text", width: 20},
					{ name: "Bloque", type: "number", width: 20}, 
                    { name: "Tarea_Unidad02", type: "number", width: 20, title: "Evaluaci&oacute;n U01"},  
					{ name: "Tarea_induccion", type: "number", width: 20, title: "Evaluaci&oacute;n U02"}, 
                    { name: "Evaluacion_U01", type: "number", width: 20, title: "Evaluaci&oacute;n U03"},
					{ name: "Foro", type: "number", width: 20, title: "Evaluaci&oacute;n U04"},
					{ name: "Evidencas_Entregadas", type: "number", width: 20, title: "	Evidencias Entregadas"},
					{ name: "Evidencas_Entregadas", type: "number", width: 20, title: "	%  Evidencias Entregadas"},
					{ name: "Evidencas_Entregadas", type: "number", width: 20, title: "Promedio Ponderado"},
					{ name: "Evidencas_Entregadas", type: "number", width: 20, title: "	Estado Actual"},
					
				]
            });

         
        });
    </script>
           <img src="../../img/image002.png" />     </body>		
</html>
</html>