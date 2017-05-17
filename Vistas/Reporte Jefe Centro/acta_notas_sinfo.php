<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV:  Acta de Notas para SiNFO</title>
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
		<p class="blue">CURSO Moodle : Seguridad e higiene industrial (SHiN) - 201620 - SUBSANACiON - Grupo C2 - ZONAL LiMA CALLAO </p>
        <p class="bold">CURSO SiNFO :SEGURiDAD E HiGiENE iNDUSTRiAL (42 Horas Dual)(CGEU-164</p>
		<button type="button" class="btn btn-primary"> <i class="fa fa-book" aria-hidden="true"></i> Leer Notas SiNFO</button><br><br>
		<button type="button" class="btn btn-primary"> <i class="fa fa-book" aria-hidden="true"></i> Leer Tutores SiNFO</button>
		
    </div>

	

	<div id="jsGridNotasSinfo"></div>
	
	<div id="notas">
		<p class="bold">DE HiSTORiA ACADEMiCA</p>
		<table class="table_reporte_alu_evidencias">
			<thead class="lightblue">
				<tr> 
					<th colspan="3">Detalles</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>
						Aprobados
					</th>
					<td>
						10
					</td>
					<td>
						71,4%
					</td>
					
				</tr>
				<tr>
					<th>
						Desaprobados
					</th>
					<td>
						10
					</td>
					<td>
						71,4%
					</td>
					
				</tr>
				
				<tr>
					<th>
						Total
					</th>
					<td>
						14
					</td>
					<td>
						100%
					</td>
					
				</tr>
			</tbody>
		</table>
		<p class="bold">RETiRADOS DE SiNFO: 0</p>
	</div>
	
	
	
	<script>
		$(function() {

            $("#jsGridNotasSinfo").jsGrid({
                height: "30%",
                width: "100%",
                autoload: true,
                selecting: true,
                sorting: true,
                paging: true,
                pageSize: 1,
                controller: db,
                fields: [
                    { name: "id", type: "text", width: 30, title: "id "},
                    { name: "id_SV", type: "number", width: 30, title: "id Sinfo" },
                    { name: "Apellidos", type: "text", width: 30, title: "Apellidos, Nombres" },
                    { name: "id", type: "text",width: 30, title: "PDiM"},
                    { name: "Nrc", type: "number", width: 30, title: "NRC"},
					{ name: "Periodo", type: "numer", width: 30, title: "Periodo"},
					{ name: "Nota_SV", type: "number", width: 30, title: "NOTA SV"},
					{ name: "Nota_Sinfo", type: "number", width: 30, title: "Nota Sinfo"},
					{ name: "Estado_Sv", type: "text", width: 30, title: "Estado Sv"},
					{ name: "Status_Sinfo", type: "text", width: 30, title: "Status Sinfo"},
					{ name: "Tutor_Sinfo", type: "text", width: 30, title: "Tutor Sinfo"},
					{ name: "Bloque", type: "number", width: 30, title: "Bloque"},
					{ name: "Camp", type: "number", width: 30, title: "Camp"},
					{ name: "CARR", type: "number", width: 30,},
					{ name: "Carrera", type: "text", width: 30},
					{ name: "iD_Alumno_Moodle", type: "number", width: 30, title: "id Alumno Moodle"},
					{ name: "Grupo", type: "text", width: 30}
					
				]
            });
        });
    
	</script>
   
   
   
       <img src="../../img/image002.png" />     </body>	
</html>