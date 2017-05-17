<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
    <meta charset="UTF-8">
    <title>iMPORTACiON de Matricula</title>
     <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../css/theme.css" />

    <script src="../../js/jquery/jquery-1.8.3.js"></script>
    <script src="../../js/jquery/jquery-1.8.3.js"></script>
    <script src="../../js/jsgrid/jsgrid.core.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.field.js"></script>
</head>
<body>        <img src="../../img/image001.png" />   	
	<div >
		<div id="jsGridActualizacionDeUnidades"></div>
		<table>
			<thead class="lightblue">
				<tr>
				  <th colspan="2">Actualizacion de Unidades (sections) y Recursos</th>
				</tr>
			</thead>
			<tbody>
				  <tr>
					  <td class="th">Curso</td>
					  <td>ATCL 201620 - Grupo B - Zonal Loreto</td>          
				  </tr>
				  <tr>
					  <td class="th">iD Moodle</td>
					  <td>7214</td>           
				  </tr>
				  <tr>
					  <td class="th">Fecha de inicio</td>
					  <td>Lunes 26-09-2016 (D/M/A)</td>           
				  </tr>
				  <tr>
					  <td class="th">Fecha Actual</td>
					  <td>12-10-2016 (D/M/A)</td>           
				  </tr>      
			</tbody>
		</table>
	</div>
  
	<p><b>mdl_course_sections</b></p>
	
	<div>
		<table id="tabla05">
			<thead class="lightblue">
				<tr>
					<th class="int">iD</th>
					<th class="int">Section</th>
					<th class="int">Visible</th>
					<th>Resumen</th>
				</tr>
			</thead>

		  <tr>
			<td class="int">47622</td>
			<td class="int center"><b>0</b></td>
			<td class="int center">
			  <select name="select" class="form-control">
				<option value="value1" selected>Si</option> 
				<option value="value2">No</option>
			  </select>
			</td>
			<td>
			  <p><b>MODULOS: 1</b></p>
			  <table id="tabla05_1">
				<tr>
				  <th class="int2">iD Mod</th>
				  <th class="int2">Tipo</th>
				  <th>Tabla e iD</th> 
				  <th>Nombre o Contenido</th>
				  <th class="int2">Visible</th>   
				  <th class="int2">Extras</th>          
				</tr>
				<tr>
				  <td class="int2">131390</td>
				  <td class="int2">Etiqueta</td>
				  <td>mdl_label (250990)</td> 
				  <td>
					<table id="tabla05_1_1">
					  <tr>
						<td class="banner" colspan="3"></td>
					  </tr>
					  <tr>
						<th class="center">ETAPAS</th>
						<th class="center">iNiCiO</th>
						<th class="center">FiN</th>
					  </tr>
					  <tr>
						<td>PRiMERA UNiDAD</td>
						<td>26 de Septiembre</td>
						<td>09 de Octubre</td>
					  </tr>
					  <tr>
						<td>SEGUNDA UNiDAD</td>
						<td>10 de Octubre</td>
						<td>23 de Octubre</td>                    
					  </tr>
					  <tr>
						<td>CALiFiCACi&oacute;N DE EViDENCiAS</td>
						<td>24 de Octubre</td>
						<td>25 de Octubre</td>                    
					  </tr>
					  <tr>
						<td>EVALUACi&oacute;N PRESENCiAL - REGULAR</td>
						<td>15 de Octubre</td>
						<td>03 de Noviembre</td>                    
					  </tr>
					  <tr>
						<td>PUBLiCACi&oacute;N DE PROMEDiOS</td>
						<td>05 de Noviembre</td>
						<td>06 de Noviembre</td>                    
					  </tr>
					  <tr>
						<td>PAGO DE SUBSANACi&oacute;N</td>
						<td>07 de Noviembre</td>
						<td>19 de Noviembre</td>                    
					  </tr>
					</table>
				  </td>
				  <td class="int2 center">
					<select name="select" class="form-control">
					  <option value="value1" selected>Si</option> 
					  <option value="value2">No</option>
					</select>
				  </td>
				  <td class="int2"></td>             
				</tr>            
			  </table>
			</td>
		  </tr>
	  </table>	
	</div>

	<script>
		$(function() {

    //         $("#jsGridNotasSinfo").jsGrid({
    //             height: "30%",
    //             width: "100%",
    //             autoload: true,
    //             selecting: true,
    //             sorting: true,
    //             paging: true,
    //             pageSize: 1,
    //             controller: db,
    //             fields: [
    //                 { name: "id", type: "text", width: 30, title: "id "},
    //                 { name: "id_SV", type: "number", width: 30, title: "id Sinfo" },
    //                 { name: "Apellidos", type: "text", width: 30, title: "Apellidos, Nombres" },
    //                 { name: "id", type: "text",width: 30, title: "PDiM"},
    //                 { name: "Nrc", type: "number", width: 30, title: "NRC"},
				// 	{ name: "Periodo", type: "numer", width: 30, title: "Periodo"},
				// 	{ name: "Nota_SV", type: "number", width: 30, title: "NOTA SV"},
				// 	{ name: "Nota_Sinfo", type: "number", width: 30, title: "Nota Sinfo"},
				// 	{ name: "Estado_Sv", type: "text", width: 30, title: "Estado Sv"},
				// 	{ name: "Status_Sinfo", type: "text", width: 30, title: "Status Sinfo"},
				// 	{ name: "Tutor_Sinfo", type: "text", width: 30, title: "Tutor Sinfo"},
				// 	{ name: "Bloque", type: "number", width: 30, title: "Bloque"},
				// 	{ name: "Camp", type: "number", width: 30, title: "Camp"},
				// 	{ name: "CARR", type: "number", width: 30,},
				// 	{ name: "Carrera", type: "text", width: 30},
				// 	{ name: "iD_Alumno_Moodle", type: "number", width: 30, title: "id Alumno Moodle"},
				// 	{ name: "Grupo", type: "text", width: 30}
					
				// ]
    //         });

            var dataActualizacionUnidades = [
			    { nameColumn: "Curso", nameDescription: "ATCL 201620 - Grupo B - Zonal Loreto"},
			    { nameColumn: "iD Moodle", nameDescription: "7214" },
			    { nameColumn: "Fecha de Inicio", nameDescription: "Lunes 26-09-2016 (D/M/A)" },
			    { nameColumn: "Fecha Actual", nameDescription: "12-10-2016 (D/M/A)" }
			];


            $("#jsGridActualizacionDeUnidades").jsGrid({
                height: "auto",
                width: "50%",
                autoload: true,
                sorting: true,
                paging: true,
                pageSize: 4,
                selecting: false,
                //	controller: db,

                controller: {
			        loadData: function() {
			            return dataActualizacionUnidades;
			        }
			    },

                headerRowRenderer: function() {
			        var $result = $("<tr>").height(0);
			            
			        return $result = $result.add($("<tr>")
			            .append($("<th>").attr("colspan", 3).text("Actualizacion de Unidades (sections) y Recursos")
			            	.addClass('lightblue').css('text-align', 'left')));
			    },
                fields: [
                    { type: "text", name: "nameColumn", width: 10 },
        			{ type: "text", name: "nameDescription" , width: 10 }
				]
            });
        });
    
	</script>
  

	       <img src="../../img/image002.png" />     </body>		
</html>
