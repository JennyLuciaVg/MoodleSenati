<!DOCTYPE html>
<html>
<head>
		<meta http-equiv="X-UA-Compatible" content="iE=edge">
			<meta charset="UTF-8">
		<title>SV: Reporte de Evidencias por Tutor - Grupo</title>
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
	<div>
    	<h4 class="blue">Report de Evidencias por Tutor - Grupo - Bloque</h4>
    </div>
    <div>
    	<h3 class="green">ESTE ES UN CURSO DE iNDUCCiON</h3>
    </div>

    <div >
        <p class="span_insertar">REPORTE DE 
            <select class="form-control">
                <option>Todos los Tutores</option>
                <option>Andrade Lore, Daniel</option>
                <option>Asta Barrila, Giana</option>
            </select>
            <button  type="button" class="btn btn-primary"> <i class="fa fa-address-card-o" aria-hidden="true"></i> Ver Evidencias del Tutor indicado</button>
        </p>
    </div>
	
	<div>
		<table>
			<thead></thead>
			<tbody>
				<tr>
					<th>Total Alumnos NO RETiRADOS</th>
					<td>250</td>
				</tr>
				<tr>
					<th class="red">Total Alumnos RETiRADOS</th>
					<td>250</td>
				</tr>
				<tr>
					<th class="blue">Total Tareas</th>
					<td>250</td>
				</tr>
				<tr>
					<th class="blue">Total Foros</th>
					<td>250</td>
				</tr>
				<tr>
					<th>Total Tutores</th>
					<td>250</td>
				</tr>
				<tr>
					<th>Total Grupos</th>
					<td>250</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="notas">
		<span class="blue">Reporte de Todos los Tutores</span> 
		<br>
		<span class="span_insertar">TAREAS</span>
		<table>
			<thead class="lightblue">
				<tr>
					<th>id Tareas</th>
					<th>Nombre</th>
					<th>Enviaron Tarea</th>
					<th>No Enviaron Tarea</th>
					<th>Total</th>
					<th>Unidad</th>
					<th>Peso</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>19171</td>
					<td>
						<span class="span_insertar">Tarea de inducci&oacute;n</span>
						<table>
							<thead class="lightblue">
								<tr>
									<th>Tutor</th>
									<th>id Grupo</th>
									<th>Grupo</th>
									<th>Calificadas</th>
									<th>NO Calificadas</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>ALEMAN GONZALES, AMPARO DEL PiLAR</td>
									<td>45904</td>
									<td>ALEMAN GONZALES_Grupo_01</td>
									<td>12</td>
									<td>0</td>
								</tr>
								<tr>
									<td colspan="3"> TOTALES**</td>
									<td>179</td>
									<td>0</td>

								</tr>
							</tbody>
						</table>
					</td>	
					<td>190</td>
					<td>60</td>
					<td>250</td>
					<td>1</td>
					<td>30%</td>
				</tr>
			</tbody>
			
		</table>
		<span class="span_insertar">**La suma de los TOTALES debe ser igual a la cantidad en la columna "Enviaron Tarea".</span>
	</div>
   
   
   <div>
		<span class="span_insertar">FOROS</span>
		<table>
			<thead class="lightblue">
				<tr>
					<th>id Foro</th>
					<th>Nombre</th>
					<th>Total posts</th>
					<th>Unidad</th>
					<th>Peso</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>19171</td>
					<td>
						<span class="span_insertar" >Foro Temático del Curso</span>
						<table>
							<thead class="lightblue">
								<tr>
									<th>Tutor</th>
									<th>id Grupo</th>
									<th>Grupo</th>
									<th>Posts Calificadas</th>
									<th>Posts NO Calificadas</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>ALEMAN GONZALES, AMPARO DEL PiLAR</td>
									<td>45904</td>
									<td>ALEMAN GONZALES_Grupo_01</td>
									<td>12</td>
									<td><a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reconocidas/35.2.reporte_evidencias_tutor_foro.html">0</a></td>
								</tr>
								<tr>
									<td colspan="3"> TOTALES**</td>
									<td>179</td>
									<td>0</td>

								</tr>
							</tbody>
						</table>
					</td>	
					<td>190</td>
					<td>60</td>
					<td>250</td>
				</tr>
			</tbody>
			
		</table>
		<span class="span_insertar">**La suma de los TOTALES debe ser igual a la cantidad en la columna "Total Posts".</span>
		<p class="nota_importante">NOTA: EN TODOS LOS CALCULOS solo se toman en cuenta los Alumnos NO RETiRADOS</p>
	</div>
	       <img src="../../img/image002.png" />     </body>		
</html>
