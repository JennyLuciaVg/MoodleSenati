<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="iE=edge">
		<meta charset="UTF-8">
        <title>SV: Menu de Reportes de Evidencias</title>
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
    		<p align="center"> <a href="http://virtual.senati.edu.pe/course/view.php?id=7715" > inducci&oacute;n 201710 - Grupo A - Zona iquitos</a> </p>
    	</div>

        <div id="notas">
            <table class="table_center">
                <caption class="blue">  Alumnos por campus carrera</caption>
                <thead class="lightblue">
                    <tr>
                        <th>Carr</th>
                        <th>Carrera</th>
                        <th>Camp</th>
                        <th>Campus</th>
                        <th>Alumnos</th>
                    </tr>
                </thead>
                <tbody >
                    
                    <tr>
                        <td>PDSD</td>
                        <td>Elctricista Automotriz</td>
                        <td>29</td>
                        <td>UCP iQUiTOS PNi-C. iDiOMAS-NiV</td>
                        <td>31</td>
                    </tr>
                    <tr>
                        <td>PDSD</td>
                        <td></td>
                        <td>29</td>
                        <td>UCP iQUiTOS</td>
                        <td>62</td>
                    </tr>
                    <tr>
                        <th colspan="3">Total por campus</th>
                        <td><a href="#">UCP iQUiTOS</a></td>
                        <td>93</td>
                    </tr>
                    <tr>
                        <td>PDSD</td>
                        <td></td>
                        <td>78</td>
                        <td>UCP iQUiTOS</td>
                        <td>11</td>
                    </tr>
                    <tr>
                        <th colspan="3">Total por campus</th>
                        <td><a href="#">UCP iQUiTOS</a></td>
                        <td>11</td>
                    </tr>
                </tbody>
                <tfoot class="lightblue">
                    <tr>
                        <th colspan="4">Total alumnos</th>
                        <td>104</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div>
        <strong class="blue"> Reporte de Evidencias por CAMPUS</strong>	
        </div>
		<div id="jsGridEvicenciaCampus"></div>
	
		<div id="notas">
			<table >
				<thead class="lightblue">
					<tr>
						<th>Tarea</th>
						<th>Nombre Tarea</th>
						<th class="">No enviaron tarea</th>
						<th class="">Falta Calificar</th>
						<th>Tienen Nota</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>Práctica 01 : Crear tu perfil de alumno y enviar mensaje al tutor</td>
						<td>0</td>
						<td>0</td>
						<td>41</td>
						<td>41</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div>
			<table>
				<thead class="lightblue">
					<tr>
						<th>Cuestionario</th>
						<th>Nombre Cuestionario</th>
						<th class="">No intentaron</th>
						<th>Tienen nota	</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>Evaluaci&oacute;n del curso</td>
						<td>4</td>
						<td>37</td>
						<td>41</td>
					</tr>
					
				</tbody>		
			</table>
		</div>
		
		<div id="notas">
			<table>
				<thead class="lightblue">
					<tr>
						<th>Foro</th>
						<th>Nombre Foro</th>
						<th class="">No postearon</th>
						<th class="">Falta Calificar	</th>
						<th>Tienen nota</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>Foro Temático del curso</td>
						<td>7</td>
						<td>0</td>
						<td>34</td>
						<td>41</td>
					</tr>
					
				</tbody>		
			</table>
		</div>
		 <script>
        $(function() {

            $("#jsGridEvicenciaCampus").jsGrid({
                height: "45%",
                width: "100%",
                autoload: true,
                selecting: true,
                paging: true,
                pageSize: 1,
				sorting: true,
                controller: db,
                fields: [
                    { name: "N°", type: "number", width: 10},
                    { name: "PiDM_SiNFO", type: "number", width: 20, title: "PiDM SiNFO"},
                    { name: "Apellidos", type: "text", width: 20, title: "Apellidos, Nombres"},
                    { name: "Grupo", type: "text", width: 23, title: "Grupo"},
                    { name: "Status_Sinfo", type: "text", width: 20, title: "Status Sinfo" },
                    { name: "Campus", type: "text", width: 20,title: "Campus"},
                    { name: "Bloque", type: "number", width: 20, title: "Bloque"}, 
                    { name: "id", type: "number", width: 20, title: "iD Moodle"},
					{ name: "Tarea_Unidad01", type: "number", width: 20, title: "Práctica 01 : Crear tu perfil de alumno y enviar mensaje al tutor Peso : 25%"}, 
                    { name: "Tarea_Unidad02", type: "number", width: 20, title: "Tarea de inducci&oacute;n Peso : 30%"},  
					{ name: "Evaluacion_U01", type: "number", width: 20, title: "Evaluaci&oacute;n del curso Peso : 15 %"}, 
                    { name: "Evaluacion_U02", type: "number", width: 20, title: "Evaluaci&oacute;n del caso de estudio Peso : 10 %"},
					{ name: "Tarea_Unidad02", type: "number", width: 20, title: "Foro 1 Peso : 20%"}
					
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