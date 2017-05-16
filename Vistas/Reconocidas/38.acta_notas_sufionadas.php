<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="UTF-8">	
    <title>SV:   Acta de Notas de Cursos Fusionados (UNA NOTA) :</title>
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
<body>        <img src="../../img/image001.png" />   	
   
    <div>
		<a href="#">VER NOTAS FUSiONADAS SiN RETiRADOS DE SiNFO</a>
	</div>
    <div id="notas">
		<table>
			<tbody>
				<tr>
					<th>id del Curso: </th>
					<td>7646</td>
				</tr>
				<tr>
					<th colspan="2">Este curso esta asociado a un curso regular</th>			
				</tr>
				<tr>
					<th>Lista de Cursos:</th>	
					<td> 7647,7268</td>
				</tr>
			</tbody>
		</table>
		
		
		<h3>CURSOS:</h3>
		<p class="blue">Seguridad e higiene industrial (SHiN) - 201620 - Grupo C2 - ZONAL LiMA CALLAO (id=7268)</p>
        <p class="bold">CURSO SiNFO :SEGURiDAD E HiGiENE iNDUSTRiAL (42 Horas Dual)(CGEU-164</p>
		<button type="button" class="btn btn-primary"><i class="fa fa-file-text" aria-hidden="true"></i> Leer Notas SiNFO SHRCMRK</button><br><br>
		<button type="button" class="btn btn-primary"><i class="fa fa-file-text" aria-hidden="true"></i> Leer Tutores SiNFO SHACRSE (iNB Historia Academica)</button><br><br>
		<button type="button" class="btn btn-primary"><i class="fa fa-file-text" aria-hidden="true"></i> Leer Tutores SiNFO</button>
		<p class="bold">Leer desde la linea <input type="text" class="form-control"/></p> 
    </div>

	

	<div id="jsGridNotasSinfo"></div>
	
	<div id="notas">
		<h3>DE HiSTORiA ACADEMiCA</h3>
		<table>
			<thead>
				<tr> 
					<th colspan="3">Resumen</th>
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
	
	<div>
		<button type="button" href="#" class="btn btn-primary"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Ver tabla para Copiar a Excel</button><br><br>
		<textarea rows="6" cols="70"></textarea>
	</div>
	
	<div>
		<h4>PARA ADMiNiSTRACi&oacute;N</h4>
		<div>
			<p class="bold">NRCS</p>
			<input type="text" class="form-control"/>
		</div>
		<div>
			<p class="bold">PERiODO</p>
			<input type="text" class="form-control"/>
		</div>
		<div>
			<p class="bold">Total NRCS</p>
			<input type="text" class="form-control"/>
		</div>
	</div>
	<div id="notas">	
		<table>
			<thead class="lightblue">
				<tr>
					<th>DATOS SENATi ViRTUAL (NRC-CAMP-CAMPUS)</th>
				</tr>
				
			</thead>
			<tbody>
				<tr>
					<td>16054 - 37 - CFP Cerro de Pasco</td>
				</tr>
			</tbody>
			
		</table>
	</div>
	
	
	<script>
		$(function() {

            $("#jsGridNotasSinfo").jsGrid({
                height: "50%",
                width: "100%",
				autoload: true,
				sorting: true,
				paging: true,
				pageSize: 2,
				selecting: true,
                controller: db,
                fields: [
                    { name: "id_SV", type: "number", width: 30, title: "id Sinfo" },
                    { name: "Apellidos", type: "text", width: 30, title: "Apellidos, Nombres" },
                    { name: "id", type: "text",width: 30, title: "PDiM"},
                    { name: "Nrc", type: "number", width: 30, title: "NRC"},
					{ name: "Periodo", type: "numer", width: 30, title: "Periodo"},
					{ name: "Nota_SV", type: "number", width: 30, title: "NOTA SV"},
					{ name: "Nota_Sinfo", type: "number", width: 30, title: "Nota Sinfo SHRCMRK"},
										{ name: "Nota_Sinfo", type: "number", width: 30, title: "Nota Sinfo SHRCMRKSE"},
					{ name: "Estado_Sv", type: "text", width: 30, title: "Estado SV"},
					{ name: "Status_Sinfo", type: "text", width: 30, title: "Status Sinfo"},
					{ name: "Tutor_Sinfo", type: "text", width: 30, title: "Tutor Sinfo"},
					{ name: "Bloque", type: "number", width: 30, title: "Bloque"},
					{ name: "Camp", type: "number", width: 30, title: "Camp"},
					{ name: "Campus", type: "number", width: 30,},
					{ name: "iD_Alumno_Moodle", type: "number", width: 30, title: "id Alumno Moodle"},
					{ name: "Grupo", type: "text", width: 30},
					{ name: "id", type: "number", width: 30, title: "id Tutor"}
					
				]
            });
        });
    
	</script>
   
   
	       <img src="../../img/image002.png" />     </body>		
</html>