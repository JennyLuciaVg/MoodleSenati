<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV:  Reporte para Jefes de Centro - Alumnos por Campus-Periodo</title>
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
    <h4>Reporte para Jefes de Centro > Alumnos por Período</h4>
    <div class="sort-panel">
        <label>Seleccione un Período
            <select id="" class="form-control">
                <option>CFP Ca&ntilde;ete</option>
                <option>CFP Ca&ntilde;ete</option>
                <option>CFP Ca&ntilde;ete</option>
            </select>
            <a type="button" class="btn btn-primary"> <i class="fa fa-search-plus" aria-hidden="true"></i> Ver Reporte</a>
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
		
		<table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">N°</th>
					<th onclick="sortTable(1)">Campus</th>
					<th onclick="sortTable(2)">Camp</th>
					<th onclick="sortTable(3)">Zonal</th>
					<th onclick="sortTable(4)">Alumnos Distintos</th>
				</tr>
			</thead>
			
			<tbody id="myTable">
				<tr>
					<td>2</td>
					<td>CFP Arequipa </td>
					<td>323</td>
					<td>ZONAL AREQUiPA PUNO </td>
					<td>788</td>
				</tr>
				<tr>
					<td>3</td>
					<td>CFP Lima </td>
					<td>332</td>
					<td>ZONAL AREQUiPA PUNO </td>
					<td>788</td>
				</tr>
				<tr>
					<td>4</td>
					<td>CFP Lamas </td>
					<td>43</td>
					<td>ZONAL AREQUiPA PUNO </td>
					<td>788</td>
				</tr>
				<tr>
					<td>5</td>
					<td>CFP Ucallaly </td>
					<td>51</td>
					<td>ZONAL AREQUiPA PUNO </td>
					<td>788</td>
				</tr>
				<tr>
					<td>6</td>
					<td>CFP Tumbes </td>
					<td>767</td>
					<td>ZONAL AREQUiPA PUNO </td>
					<td>788</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-12 text-center">
    	<ul class="pagination pagination-lg pager" id="myPager"></ul>
    </div>
	
	 <div >
        <div class="treeview">
            <ul>
                <li><a href="#">Más reportes</a>
					<ul>
						<li><a href="#"><i class="fa fa-search" aria-hidden="true"></i> Búsqueda de Alumnos</a></li>
						<li><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Alumnos-Curso por Período</a></li>
					</ul>
                </li>
              </ul>
        </div>
    </div>

    
	       <img src="../../../img/image002.png" />     </body>

	<script src="../../../js/filter/filter.js"></script>
	<script src="../../../js/filter/thead.js"></script>
	<script src="../../../js/filter/list.js"></script>

</html>
