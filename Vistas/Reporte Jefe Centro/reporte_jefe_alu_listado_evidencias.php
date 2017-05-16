<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV:  Reporte para Jefes de Centro - Evidencias de un Curso</title>
      <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

   
    <link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../css/theme.css" />
    <link rel="stylesheet" type="text/css" href="../../css/font-awesome.css">

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
<body>	       <img src="../../img/image001.png" />   
   
    
    <div id="notas">
        <table class="table_reporte_alu_histo">
			<tbody>
				<tr>
					<th>Campus</th>
					<td>CFP Ca&ntilde;ete (70)</td>
				</tr>
				<tr>
					<th>iD-CURSO</th>
					<td>7647</td>
				</tr>
				<tr>
					<th>NOMBRE CURSO</th>
					<td>Seguridad e higiene industrial (SHiN) - 201620 - SUBSANACiON - Grupo C2 - ZONAL LiMA CALLAO</td>
				</tr>
				<tr>
					<th>PERiODO</th>
					<td>201620</td>
				</tr>
			</tbody>
          
        </table>
    </div>

	<div id="jsGridEvidencias"></div>
	
	<div id="notas">
		<table>
			<thead class="lightblue">
				<tr> 
					<th>Tarea</th>
					<th>Nombre Tarea</th>
					<th>No enviaron tarea</th>
					<th>Falta Calificar</th>
					<th>Tienen Nota</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						1
					</td>
					<td>
						Tarea U01
					</td>
					<td>
						0
					</td>
					<td>
						0
					</td>
					<td>
						10
					</td>
					<td>
						10
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="">
		<table class="table_reporte_alu_evidencias">
			<thead class="lightblue">
				<tr> 
					<th>Cuestionario</th>
					<th>Nombre Cuestionario</th>
					<th>No intentaron</th>
					<th>Tienen nota</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						1
					</td>
					<td>
						Caso de Estudio U01
					</td>
					<td>
						4
					</td>
					<td>
						10
					</td>
					<td>
						14
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="notas">
		<table class="table_reporte_alu_evidencias">
			<thead class="lightblue">
				<tr> 
					<th>Foro</th>
					<th>Nombre Foro</th>
					<th>No postearon</th>
					<th>Falta Calificar</th>
					<th>Tienen Nota</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						1
					</td>
					<td>
						Caso de Estudio U01
					</td>
					<td>
						No
					</td>
					<td>
						10
					</td>
					<td>
						14
					</td>
					<td>
						14
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<script>
		$(function() {

            $("#jsGridEvidencias").jsGrid({
                height: "25%",
                width: "100%",
                autoload: true,
                selecting: true,
                sorting: true,
                paging: true,
                pageSize: 1,
                controller: db,
                fields: [
                    { name: "id", type: "text", width: 30, title: "iD SiNFO"},
                    { name: "id_SV", type: "number", width: 30, title: "iD SV" },
                    { name: "Apellidos", type: "text", width: 30, title: "Apellidos, Nombres" },
                    { name: "Status_Sinfo", type: "text",width: 30, title: "Status SiNFO"},
                    { name: "Bloque", type: "number", width: 30},
					{ name: "Grupo", type: "text", width: 30},
					{ name: "Tutor", type: "text", width: 30},
					{ name: "Tarea_Unidad01", type: "number", width: 30,title: "Tarea U01 Peso : 32% (id tarea=14125)"},
					{ name: "Tarea_Unidad02", type: "number", width: 30, title: "Tarea U02 Peso : 32% (id tarea=14126)"},
					{ name: "Caso_EstudioU01", type: "number", width: 30, title: "Caso de Estudio U01 Peso : 8 %"},
					{ name: "Evaluacion_U02", type: "number", width: 30, title: "Evaluaci&oacute;n de la Unidad U01 Peso : 10 %"},
					{ name: "Caso_EstudioU02", type: "number", width: 30, title: "Caso de Estudio U02 Peso : 8 %"},
					{ name: "Evaluacion_U02", type: "number", width: 30, title: "Evaluaci&oacute;n U02 Peso : 10 %"}
                ]
            });
        });
    
	</script>
   
   
   
       <img src="../../img/image002.png" />     </body>	
</html>