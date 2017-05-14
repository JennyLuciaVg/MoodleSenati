<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>Reportes de jefe de centro</title>
      <link rel="stylesheet" type="text/css" href="../../../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../../../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/theme.css" />
	 <link rel="stylesheet" type="text/css" href="../../../css/font-awesome.css">
    <script src="../../../js/jquery/jquery-1.8.3.js"></script>
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
<body>	       <img src="../../../img/image001.png" />   
    <h4>Reporte para Jefes de Centro > Alumnos por Campus-Zonal por Período</h4>
    <div class="sort-panel">
        <label>Seleccione un campus - periodo
            <select class="form-control">
                <option>CFP Ca&ntilde;ete</option>
                <option>CFP Ca&ntilde;ete</option>
                <option>CFP Ca&ntilde;ete</option>
            </select>
            <button type="button" class="btn btn-primary"><i class="fa fa-search-plus" aria-hidden="true"></i> Ver Reporte</button>
        </label>
    </div>
    
    <div id="notas" >
        <table>
        	<thead class="lightblue">
        		<tr>
					<th colspan="2">REPORTE</th>
				</tr>
        	</thead>
			<tbody >
				<tr>
					<td>PERiODO</td>
					<td >70</td>
				</tr>
			</tbody>
          
        </table>
    </div>

   
	<div >
		
		<table>
			<thead class="lightblue">
				<tr>
					<th>N°</th>
					<th>Siglas</th>
					<th>Nombre Curso</th>
					<th>Camp</th>
					<th>Campus</th>
					<th>Alumnos</th>
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<td>1</td>
					<td>ATENCiON AL CLiENTE (ATCL)</td>
					<td>51</td>
					<td>ZONAL AREQUiPA PUNO </td>
					<td>2</td>
					<td>2</td>
				</tr>
			</tbody>
		</table>
	</div>
	 <div >
        <div class="treeview">
            <ul>
                <li><a href="#">Más reportes</a>
					<ul>
						<li><a href="#"><i class="fa fa-search" aria-hidden="true"></i> Búsqueda de Alumnos</a></li>
					</ul>
                </li>
              </ul>
        </div>
    </div>
	
    
	       <img src="../../../img/image002.png" />     
	<script src="../../../js/filter/list.js"></script>
	</body>	
</html>
