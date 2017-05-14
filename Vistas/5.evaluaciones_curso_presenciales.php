<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV: Evaluaciones de Curso Presenciales</title>
     <link rel="stylesheet" type="text/css" href="../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../css/theme.css" />

    <script src="../js/jquery/jquery-1.8.3.js"></script>
	<link rel="stylesheet" href="../css/font-awesome.css">
    <script src="../js/jsgrid/jsgrid.core.js"></script>
    <script src="../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.field.js"></script>
</head>
<body>	          

    <div >
		<p class="blue"><a href="#"> Adimistraci&oacute;n de Cursos </a> - Evaluaciones de Cursos Presenciales  </p>
    </div>
    <p class="nota_importante"> CAMP: 43, PERiODO: 201620 </p>

    <table class="campo_periodo">
        <tbody>
			<thead class="lightblue">
				<tr>
					<th colspan="2" >CAMPUS Y PERiODO</th>
				</tr>
			</thead>
			
			<tbody>
			
			</tbody>
            
            <tr>
                <td>Seleccione el Campus</td>
                <td> 
                    <select class="form-control"> 
                        <option>AQP-UFP Automotores (51A)</option>
                        <option>AQP-UFP Electrotecnia (51E)</option>
                        <option>AQP-UFP Metal Mecánica (51M)</option>
                        <option>CFP Abancay (48)</option>
                        <option>CFP Andahuaylas (43)</option>    
                        <option>CFP Ayacucho (42)</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>ingrese el Periodo</td>
                <td> <input type="text" value="201620" class="form-control"> </td>
            </tr>
            <tr>
                <td>&nbsp</td>
                <td> <button type="button" class="btn btn-primary"><i class="fa fa-list"></i> Listar</button> </td>
            </tr>
        </tbody>
    </table>

	<div id="notas">
		 <table>
			<thead class="lightblue">
				<tr  >
					<th>iD Curso</th>
					<th>Curso</th>
					<th>Estado del Curso</th>
				</tr>
			</thead>
			<tbody>
				
				<tr>
					<td>7537</td>
					<td>SHiN 201620 - Presencial de Subsa Grupo C - CFP Andahuaylas  </td>
					<td>Cerrado  cambiar 
						<select class="form-control">
							<option> Dejarlo Cerrado</option>
							<option> Abrir curso</option>
						</select> 
					</td>    
				</tr>

				<tr>
					<td colspan="3">
						<table>
							<thead class="lightblue">
								 <tr>
									<th>iD Cuestionario</th>
									<th>Nombre Cuestionario</th>
									<th>Password</th>
									<th>iP de Acceso</th>
									<th>Estado de Cuestionario</th>
									<th>Estado de la Secci&oacute;n</th>
								</tr>
							</thead>
							<tbody >
								<tr>
									<td>18642</td>
									<td>Evaluaci&oacute;n 01</td>
									<td> fielsubsashin201620</td>
									<td>&nbsp</td>
									<td>Abierto</td>
									<td>Abierto</td>
								</tr>   
							</tbody>
						</table>
					 </td>   
				  
				</tr>
			</tbody>
		</table>

	</div>

    <a href="#"  class="btn btn-primary"><i class="fa fa-save"></i> Guardar Cambios</a> 
   
	              
<script src="../js/filter/filter.js"></script>
</body>	
</html>
