<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV: Historia Academica - Acta de Notas Oficial</title>
    <link rel="stylesheet" type="text/css" href="../../css/demos.css"/>
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

</head>
<body>	       <img src="../../img/image001.png" />   

	<div>
		<p class="blue"><a href="#"> Historia Academica </a> - Actas de Notas Oficial</p>
	</div>
	<div>
		 <table >
		   <tbody>
				<tr>
					<th>iD Curso SENATi</th>
					<td>43</td>
				</tr>
				<tr>
					<th>Nombre Curso SENATi</th>
					<td>
						<a href="sss"> ATENCiON AL CLiENTE(ATCL)</a>
					</td>
				</tr>
				<tr>
					<th>iD Curso Moodle</th>
					<td>7305</td>
				</tr>            
				<tr>
					<th>Nombre Curso Moodle</th>
					<td>
						<a href="sss"> ATENCiON AL CLiENTE(ATCL) 201620 - Grupo B - Zonal LiMA CALLAO</a>
					</td>
				</tr>
				<tr>
					<th>Fecha de inicio</th>
					<td>24-10-2016</td>
				</tr>
				<tr>
					<th>Tutor(es)</th>
					<td>JOSE, CiEZA HERMOZA</td>
				</tr>                   
		   </tbody>
		</table>
	</div>
   
   
    <div id="botones">
		<a type="button" href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Historia%20Academica/7.1.1.2EditarActa.html" class="btn btn-primary">Editar Acta </a>
    </div>
    <div id="jsGrid1"></div>
    <div>
		 <table>
			<thead class="lightblue">
				<tr>
					<th>N°</th>
					<th>id Moodle</th>
					<th>id SiNFO</th>
					<th>Apellidos, Nombres</th>
					<th>Camp</th>
					<th>NRC</th>
					<th>Período</th>
					<th>Bloque</th>
					<th>Carrera</th>
					<th>Nota</th>
					<th>Estado</th>
				</tr>
			</thead>    
		   <tbody>
				<tr>
					<td>1</td>
					<td>181678</td>
					<td>887303</td>
					<td>ABAD MAGUi&ntilde;A, AARON SANTiAGO</td>
					<td>19</td>
					<td></td>
					<td>201300</td>
					<td>19</td>
					<td></td>
					<td>16.5</td>
					<td>Aprobado</td>
				</tr>
		   </tbody>
		</table>
    </div>
	
	<div id="notas">
		 <table>
			<tbody>
				<tr>
					<td>Aprobados</td>
					<td>0</td>
				</tr>
				 <tr>
					<td>Desaprobados</td>
					<td>0</td>
				</tr>
				 <tr>
					<td>Retirados</td>
					<td>0</td>
				</tr>
				 <tr>
					<td>No participaron</td>
					<td>0</td>
				</tr>            
				 <tr>
					<th>iNSCRiTOS</th>
					<td>489</td>
				</tr>
			</tbody>
		</table>
    
	</div>
		
	<div>
		<caption>Estadísticas por Campus - Carrera</caption>
		<table>
			<thead class="lightblue">
				<tr>
					<th>Camp</th>
					<th>Campus</th>
					<th>Carr</th>
					<th>Carrera</th>
					<th>Estado</th>
					<th>Alumnos</th>
				</tr>
			</thead>    
		   <tbody >
				<tr>
					<td>63</td>
					<td>CFP Callao - Ventanilla<td>
					<td>&nbsp</td>
					<td>&nbsp</td>
					<td>38</td>
				</tr>
				<tr>
					<th colspan="5">TOTAL</th>
					<th>489</th>
				</tr>
		   </tbody>
		</table>
	</div>
    
	<div id="notas">
		 <caption>Estadísticas por CAMPUS</caption>
		<table>
			<thead class="lightblue">
				<tr>
					<th>Camp</th>
					<th>Campus</th>
					<th>Estado</th>
					<th>Alumnos</th>    
				</tr>
			</thead>    
		   <tbody>
				<tr>
					<td>63</td>
					<td>CFP Callao - Ventanilla<td>
					<td>38</td>           
				</tr>
				<tr>
					<th colspan="3">TOTAL</th>
					<th>489</th>
				</tr>
		   </tbody>
		</table>
	
	</div>

	<script>

		var dataActa = [
			{ 
				"numero": 1,
				"idMoodle": 123123,
				"idSiNFO": 9876544,
				"apellidos_nombres": "ABAD MAGUiñA, AARON SANTiAGO",
				"Camp": "12",
				"NRC": 15,
				"periodo": "1",
				"bloque": "12",
				"carrera": "Ing",
				"Nota": 12,
				"Estado": "Aprobado"
			},
			{ 
				"numero": 2,
				"idMoodle": 7894566,
				"idSiNFO": 1234565,
				"apellidos_nombres": "ABAD, AARON SANTiAGO",
				"Camp": "12",
				"NRC": 12,
				"periodo": "1",
				"bloque": "12",
				"carrera": "Ing",
				"Nota": 15,
				"Estado": "Aprobado"
			},
						{ 
				"numero": 3,
				"idMoodle": 456456,
				"idSiNFO": 1234565,
				"apellidos_nombres": "ABAD MAGUiñA, SANTiAGO",
				"Camp": "12",
				"NRC": 19,
				"periodo": "1",
				"bloque": "12",
				"carrera": "Ing",
				"Nota": 13,
				"Estado": "Aprobado"
			}
		]
		
        $("#jsGrid1").jsGrid({
            height: "auto",
            width: "70%	",
            autoload: true,
            sorting: true,
            paging: true,
            pageSize: 4,
            selecting: false,
            //	controller: db,
            controller: {
		        loadData: function() {
		            return dataActa;
		        }
		    },
            fields: [
                { type: "number", name: "numero", width: 10, title: "N°" },
    			{ type: "number", name: "idMoodle" , width: 10, title: "id Moodle" },
    			{ type: "number", name: "idSiNFO", width: 10, title: "id SiNFO"},
    			{ type: "text", name: "apellidos_nombres" , width: 35, title: "Apellidos, Nombres" },
    			{ type: "text", name: "Camp", width: 10, title: "Camp"},
    			{ type: "text", name: "NRC", width: 10, title: "NRC"},
    			{ type: "text", name: "periodo", width: 10, title: "Periodo"},
    			{ type: "text", name: "bloque", width: 10, title: "Bloque"},
    			{ type: "text", name: "carrera", width: 10, title: "Carrera"},
    			{ type: "text", name: "Nota", width: 10, title: "Nota"},
    			{ type: "text", name: "Estado", width: 10, title: "Estado"}


			]
        });



	</script>

   


       <img src="../../img/image002.png" />     </body>	
</html>