<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="iE=edge">   
    <meta name="keywords" content="moodle, SV : Reporte de Evidencias Completas " />
    <title>SV : Reporte de Evidencias Completas</title>
	
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
<body>       <img src="../../img/image001.png" />   
    <div id="jsGrid1"></div>
	<div id="">
		<p class="red">NOTA iMPORTANTE : En la Tabla abajo mostrada se puede identificar al Tutor del GRUPO usando la tabla de arriba.</p>
		<a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reconocidas/14.notas_historia_academica.html">Pasar a Historia Academica(Regular, Presencial o induccion)</a>
	</div>
	

	<div id="notas">
		<p>Los criterios para pasar a SUBSANACiON son : el % de evidencias entregadas debe ser mayor a 40% y la nota obtenida MAYOR a 4.
		<br>Los Cursos de iNDUCCiON NO TiENEN SUBSANACiON al igual que los mismos cursos de SUBSANACiON, PRESENCiALES O TRABAJADORES.</p>
		<div class="input-group">
            <!-- USE TWiTTER TYPEAHEAD JSON WiTH APi TO SEARCH -->
            <input class="form-control" id="system-search" name="q" placeholder="Buscar"  style="display:none;">
            <span class="input-group-btn">
               <a   type="button" class="btn btn-warning"><i class="fa fa-search"></i></a>
            </span>
        </div>
		<table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">id Sinfo</th>
					<th onclick="sortTable(1)">id SV</th>
					<th onclick="sortTable(2)">Apellidos, Nombres</th>
					<th onclick="sortTable(3)">Email</th>
					<th onclick="sortTable(4)">Status Sinfo</th>
					<th onclick="sortTable(5)">Grupo</th>
					<th onclick="sortTable(6)">Campus</th>
					<th onclick="sortTable(7)">Bloque</th>
					<th onclick="sortTable(8)">Tarea Unidad01</th>
					<th onclick="sortTable(9)">Tarea Unidad02</th>
					<th onclick="sortTable(10)">Evaluacion_U01</th>
					<th onclick="sortTable(11)">Caso EstudioU01</th>
					<th onclick="sortTable(12)">Evaluacion U02</th>
					<th onclick="sortTable(13)">Caso_EstudioU02</th>
					<th onclick="sortTable(14)">Evidencias Entregadas</th>
					<th onclick="sortTable(15)">Porcentaje Entregadas</th>
					<th onclick="sortTable(16)">Promedio Ponderado</th>
					<th onclick="sortTable(17)">Estado Actual</th>
					
				</tr>
			</thead>
			<tbody id="myTable">
				<tr>
					<td colspan="8" class="yellow"><h4 class="centrar">Total Evidencias Entregables:  3</h4></td>
					<td colspan="10"></td>
				</tr>
				<tr>
					<td>895864</td>
					<td>195078</td>
					<td>AViLEZ ACEVEDO, OSVALDO</td>
					<td>895864@senati.pe</td>
					<td></td>
					<td>ESPiRiTU VERA_Grupo_01</td>
					<td></td>
					<td>CFP Río Negro</td>
					<td>Falta Claificar</td>
					<td>Falta Calificar</td>
					<td>Falta Calificar</td>
					<td>4.0</td>
					<td>No envi&oacute; tarea</td>
					<td>No envi&oacute; tarea</td>
					<td>15.0</td>
					<td>20%</td>
					<td>18</td>
					<td>No intento</td>
				</tr>
				<tr>
					<td>32323</td>
					<td>656565</td>
					<td>AViLEZ ACEVEDO, OSVALDO</td>
					<td>895864@senati.pe</td>
					<td></td>
					<td>ESPiRiTU VERA_Grupo_01</td>
					<td></td>
					<td>CFP Río Negro</td>
					<td>Falta Claificar</td>
					<td>Falta Calificar</td>
					<td>Falta Calificar</td>
					<td>4.0</td>
					<td>No envi&oacute; tarea</td>
					<td>No envi&oacute; tarea</td>
					<td>15.0</td>
					<td>20%</td>
					<td>18</td>
					<td>No intento</td>
				</tr>
				<tr>
					<td>45545</td>
					<td>756565</td>
					<td>AViLEZ ACEVEDO, OSVALDO</td>
					<td>895864@senati.pe</td>
					<td></td>
					<td>ESPiRiTU VERA_Grupo_01</td>
					<td></td>
					<td>CFP Río Negro</td>
					<td>Falta Claificar</td>
					<td>Falta Calificar</td>
					<td>Falta Calificar</td>
					<td>4.0</td>
					<td>No envi&oacute; tarea</td>
					<td>No envi&oacute; tarea</td>
					<td>15.0</td>
					<td>20%</td>
					<td>18</td>
					<td>No intento</td>
				</tr>
				<tr>
					<td>34343</td>
					<td>98567</td>
					<td>AViLEZ ACEVEDO, OSVALDO</td>
					<td>895864@senati.pe</td>
					<td></td>
					<td>ESPiRiTU VERA_Grupo_01</td>
					<td></td>
					<td>CFP Río Negro</td>
					<td>Falta Claificar</td>
					<td>Falta Calificar</td>
					<td>Falta Calificar</td>
					<td>4.0</td>
					<td>No envi&oacute; tarea</td>
					<td>No envi&oacute; tarea</td>
					<td>15.0</td>
					<td>20%</td>
					<td>18</td>
					<td>No intento</td>
				</tr>
			</tbody>
		</table>
		<div class="text-center">
		  <ul class="pagination pagination-lg pager" id="myPager"></ul>
		</div>
	</div>
	<div id="jsGrid2"></div>
	<!-- TABLA: TAREA -->
	<div id="jsGrid3"></div>
	<div>
		<table>
			<thead class="lightblue">
				<tr>
					<th>Tarea</th>
					<th>Nombre Tarea</th>
					<th>No enviaron tarea</th>
					<th>Falta (Re)Calificar</th>
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
					<td>21</td>
					<td>21</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Tarea de inducci&oacute;n</td>
					<td>3</td>
					<td>0</td>
					<td>18</td>
					<td>21</td>
				</tr>
			</tbody>
		</table>
    </div>
    <!-- TABLA: CUESTIONARIO -->

	<div >
		<table>
			<thead class="lightblue">
				<tr>
					<th>Cuestionario</th>
					<th>Nombre Cuestionario</th>
					<th>No intentaron</th>
					<th>Tienen Nota</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>Evaluaci&oacute;n Presencial de la Unidad 01</td>
					<td>24</td>
					<td>0</td>
					<td>24</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="jsGrid4"></div>
	<div id="jsGrid5"></div>
	
	<div>
		<table>
			<thead class="lightblue">
				<tr>
					<th>Foro</th>
					<th>Nombre Foro</th>
					<th>No postearon</th>
					<th>Falta Calificar</th>
					<th>Tienen nota</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>Foro Temático del curso</td>
					<td>2</td>
					<td>0</td>
					<td>19</td>
					<td>21</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="jsGrid6"></div>

	
	<div id="notas">
		<table>
			<thead class="lightblue">
				<tr>
					<th>Estados Finales</th>
					<th>Total</th>
					<th>Retirados de Sinfo</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Aprobado</td>
					<td>16</td>
					<td>0</td>
				</tr>
				<tr>
					<td>DESAPROBADO</td>
					<td>5</td>
					<td>0</td>
				</tr>
				<tr>
					<td>PASA A SUBSANACiON</td>
					<td>0</td>
					<td>0</td>
				</tr>
				<tr>
					<td>Totales</td>
					<td>21</td>
					<td>0</td>
				</tr>
			</tbody>
			<tbody>
			
			</tbody>
		</table>
	</div>
	
	<div>
		<p><span class="span_insertar"> insertar/Actualizar Notas de inducci&oacute;n</span> (Extrae Notas del Curso de inducci&oacute;n - el sistema lo busca)</p>
		<table border="1">
			<tbody>
				<tr>
					<td><span class="span_insertar">id Tarea induccion</span></td>
					<td><input type="text" class="form-control" /></td>
					<td><a type="button" class="btn btn-primary"><i class="fa fa-file-text-o" aria-hidden="true"></i> insertar o Actualizar Notas</button></td>
				</tr>
			</tbody>
		</table>
	</div>
	
    <script>		
		
		function load2() 
		{
				valor = $( ".campo" ).find('option:selected').text();
				
				alert(valor);
				
				$("#jsGrid5  .jsgrid-grid-body .jsgrid-table tbody tr").append("td").text("Nueva Fila");
				
		}
        
		
		$(function() {

            $("#jsGrid1").jsGrid({
                height: "18%",
                width: "50%",
				
				sorting: true,
				paging: true,
				autoload: true,
				
				editing: true,
                controller: db,
                fields: [
					
                    { name: "Name", type: "text", width: 20, title: "Tutores" },
                    { name: "Groupe", type: "select",width: 20, items: db.Group, valueField: "id", textField: "Name", title: "Grupos",
						editTemplate: function() {
							var $select = jsGrid.fields.select.prototype.editTemplate.apply(this, arguments);
						$select.addClass("campo");
						$select.change(function() {
							load2();
							});
						return $select;
						
						}
					},
					{ name: "TotalGrupo", type: "text", width: 20, title: "Total Grupos"}
                ]

            });

		
        });

		 $(function() {

            $("#jsGrid2").jsGrid({
                height: "50%",
                width: "100%",
				paging: true,
				sorting: true,
				autoload: true,
                controller: db,
                pageSize: 3,
                //
       //          rowRenderer: function() {
			    //     var $result = $("<tr>").height(0);
			            
			    //     return $result = $result.add($("<tr>")
			    //         .append($("<th>").attr("colspan", 2).text("Actualizacion de Unidades (sections) y Recursos")
			    //         	.addClass('lightblue').css('text-align', 'left')));
			    // },
			    //
                headerRowRenderer: function() {
			        var $result = $("<tr>").height(0);
			            
			        $result = $result.add($("<tr>")
			            .append($("<th>").attr("colspan", 1).text("Id Sinfo")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Id SV")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Apellidos, Nombres")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Email")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Status Sinfo")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Grupo")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Campus")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Bloque")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Tarea Unidad01")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Tarea Unidad02")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Evaluacion_U01")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Caso EstudioU01")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Evaluacion U02")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Caso_EstudioU02")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Evidencias Entregadas")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Porcentaje Entregadas")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Promedio Ponderado")
			            	.addClass('lightblue').css('text-align', 'left'))
			            .append($("<th>").attr("colspan", 1).text("Estado Actual")
			            	.addClass('lightblue').css('text-align', 'left'))

			            );

			        return $result = $result.add($("<tr>")
			        	.append($("<th>").attr("colspan", 8).text("Total Evidencias Entregables:" + " 3")
			            	.addClass('lightblue').css('text-align', 'left'))
			        	);

			
			    },
                fields: [
				 
					{ name: "id", type: "number",width: 5,
						 headerTemplate: function(value) {
							 return $("<div>").addClass("address").append(value).text("id Sinfo");
						 }
					},
					{ name: "id_SV", type: "number",width: 5},
					{ name: "Apellidos" , type: "text",width: 5, title: "Apellidos, Nombres"},
					{ name: "Email" , type: "text",width: 5},
					{ name: "Status_Sinfo" , type: "text",width: 5},
					{ name: "Grupo" , type: "text",width: 5},
					{ name: "Campus" , type: "text",width: 5},
					{ name: "Bloque" , type: "number",width: 5},
					{ name: "Tarea_Unidad01" , type: "number",width: 5},
					{ name: "Tarea_Unidad02" , type: "number",width: 5},
					{ name: "Evaluacion_U01" , type: "number",width: 5},
					{ name: "Caso_EstudioU01" , type: "number",width: 5},
					{ name: "Evaluacion_U02" , type: "number",width: 5},
					{ name: "Caso_EstudioU02" , type: "number",width: 5},
					{ name: "Evidencias_Entregadas" , type: "number",width: 5},
					{ name: "Porcentaje_Entregadas" , type: "number",width: 5},
					{ name: "Promedio_Ponderado" , type: "number",width: 5},
					{ name: "Estado_Actual" , type: "number",width: 5}
                ]
            });

        });
		
		 $(function() {

            $("#jsGrid3").jsGrid({
                height: "18%",
                width: "60%",
				paging: true,
				autoload: true,
                controller: db,
                fields: [
					{ name: "Tarea", type: "number",width: 50},
					{ name: "Nombre_Tarea", type: "text",width: 50, title: "Nombre Tarea"},
					{ name: "No_Enviaron" , type: "number",width: 50, title: "No enviaron tarea"},
					{ name: "Falta_Calificar" , type: "number",width: 50, title: "Falta (Re) Calificar"},
					{ name: "Tienen_Nota" , type: "number",width: 50, title: "Tienen Nota"},
					{ name: "Total" , type: "number",width: 50}
                ]
            });
        });
		
		$(function() {
            $("#jsGrid4").jsGrid({
                height: "auto",
                width: "60%",
				paging: true,
				autoload: true,
                controller: db,
                fields: [
					{ name: "Cuestionario", type: "number",width: 50},
					{ name: "Nombre_Cuestionario", type: "text",width: 50, title: "Nombre Cuestionario"},
					{ name: "No_intentaron" , type: "number",width: 50, title: "No intentaron"},
					{ name: "Tienen_Nota" , type: "number",width: 50, title: "Tienen nota"},
					{ name: "Total" , type: "number",width: 50},
					{ 
						 headerTemplate: function() { 
						 return $("<p>").text("elige");  
						},  
						itemTemplate: function(_, item) {  
						return $("<select>").append($('<option>',{
								value: item.id,
								text: item.Valor
							}));
						},  
						 align: "center",
						 width: 50  
					} 			
                ]
            });

        });
		
	
		$(function() {
            $("#jsGrid5").jsGrid({
                height: "auto",
                width: "60%",
				paging: true,
				autoload: true,
                controller: db,
                fields: [
					{ name: "Foro", type: "number",width: 50},
					{ name: "Nombre_Foro", type: "text",width: 50, title: "Nombre Foro"},
					{ name: "No_Postearon" , type: "number",width: 50, title: "No Postearon"},
					{ name: "Falta_Calificar" , type: "number",width: 50, title: "Falta Calificar"},
					{ name: "Tienen_Nota" , type: "number",width: 50, title: "Tienen Nota"},
					{ name: "Total", type: "number", width: 50}
                ]
            });

        });

		$(function() {
            $("#jsGrid6").jsGrid({
                height: "auto",
                width: "60%",
				autoload: true,
                controller: db,
				onRefreshed: function(args) {
					  var items = args.grid.option("db");
					  var total = { Name: "Total", "Sum": 0 };
					  var $totalRow = $("<tr>").addClass("total-row");
					    $(items).each(function(item) {
							total.Sum += item.Sum;
						  });
					  args.grid._renderCells($totalRow, total);
					  
					  args.grid._content.append($totalRow);
				},

                fields: [
					{ name: "Estado_Final", type: "text",width: 50, title: "Estados Finales"},
					{ name: "Sum", type: "number",width: 50, title: "Totales"},
					{ name: "Retirados_Sinfo" , type: "number",width: 50, title: "Retirados de Sinfo"}
					
                ]
				
				
            });

        });
		
   </script>
	       <img src="../../img/image002.png" />     
	<script src="../../js/filter/filter.js"></script>
	<script src="../../js/filter/thead.js"></script>
	<script src="../../js/filter/search.js"></script>
	</body>		
</html>
