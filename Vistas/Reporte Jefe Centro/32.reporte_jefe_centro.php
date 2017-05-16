<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>Reportes de jefe de centro</title>
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
<body>	       <img src="../../img/image001.png" />   
    <h1>Reporte retirados</h1>
    <div class="sort-panel">
        <label>Seleccione un Campus - Período
            <select class="form-control">
                <option>CFP Ca&ntilde;ete</option>
                <option>CFP Ca&ntilde;ete</option>
                <option>CFP Ca&ntilde;ete</option>
            </select>
            <a type="button" class="btn btn-primary"> <i class="fa fa-search" aria-hidden="true"></i> Ver cursos</a>
        </label>
    </div>
    
    <div id="notas">
        <table>
			<thead class="lightblue">
				<tr>
					<th colspan="2">REPORTE</th>
				</tr>
			</thead>
			<tbody>

				<tr>
					<td>CAMP</td>
					<td >70</td>
				</tr>
				<tr>
					<td>CAMPUS</td>
					<td >CFP CA&ntilde;ETE</td>
				</tr>
				<tr>
					<td>PERiODO</td>
					<td >201620</td>
				</tr>
			</tbody>
          
        </table>
    </div>

    <div id="jsGridReporteC"></div>
      <div>
        <p><b>*Es la cantidad de alumnos de ese campus + periodo en ese curso</b></p>
        <p><b>**Es el acta final de notas Curso regular + subsanaci&oacute;n</b></p>
    </div>

	<div id="notas">
		<p>LiSTA DE TUTORES DEL CURSO :</p>
	    <p>Seguridad e higiene industrial (SHiN) - 201620 - SUBSANACiON - Grupo C2 - ZONAL LiMA CALLAO (7647)</p>

		<table class="table_reporte_tutor">
			<thead>
				<tr>
					<th>TUTOR</th>
					<th>EMAiL</th>
					<th>Foto</th>
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<td>
						<a href="#">FERNANDO GUiLLERMO, ARCE ViZCARRA</a><br>
						CFP Villa El Salvador</td>
					<td>farce@senati.pe</td>
					<td><img src="#"> </td>
				</tr>
			</tbody>
		</table>
	</div>
	
	 <div >
        <div class="treeview">
            <ul>
                <li><a href="#">Más reportes</a>
					<ul>
						<li><a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reporte%20Jefe%20Centro/Busqueda%20Alumno/reporte_jefes_busca.html"><i class="fa fa-search" aria-hidden="true"></i> Búsqueda de alumnos</a></li>
						<li><a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reporte%20Jefe%20Centro/Alumno%20Curso%20por%20Periodo/alumno_curso_por_periodo.html"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Alumnos-curso x periodo</a></li>
						<li><a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reporte%20Jefe%20Centro/Alumnos%20Campus%20Zonal%20x%20Periodo/campus_zona_por_periodo.html"><i class="fa fa-university" aria-hidden="true"></i> Alumnos por Campus-zonal x periodo</a></li>
					</ul>
                </li>
              </ul>
        </div>
    </div>


    <script>
        $(function() {

            $("#jsGridReporteC").jsGrid({
                height: "50%",
                width: "100%",
                autoload: true,
                sorting: true,
                pageSize: 1,
                selecting: true,
                controller: db,
                fields: [
                    { name: "id", type: "text", width: 40, title: "iD CURSO"},
                    { name: "Nombre_Curso", type: "number", width: 150, title: "Nombre Curso" },
                    { name: "Alumnos", type: "number", width: 50, title: "Alumnos*" },
                     {  
                          headerTemplate: function() { 
                         return $("<p>").text("Ver");  
                          },  
                         itemTemplate: function(_, item) {  
                          return $("<a>").attr("href","file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reporte%20Jefe%20Centro/reporte_jefes_alu_listado.html").attr("target", "_blank").text("listado")  
                                     .on("click", function () {   
                                        
                                  });  
                          },  
                          align: "center",  
                         width: 50  
                     },
                     {  
                          headerTemplate: function() { 
                         return $("<p>").text("Ver");  
                          },  
                         itemTemplate: function(_, item) {  
                          return $("<a>").attr("href","file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reporte%20Jefe%20Centro/reporte_jefe_alu_listado_evidencias.html").attr("target", "_blank").text("Evidencias")  
                                     .on("click", function () {   
                                        
                                  });  
                          },  
                          align: "center",  
                         width: 50  
                     },
                     {  
                          headerTemplate: function() { 
                         return $("<p>").text("Ver(tabla abajo)");  
                          },  
                         itemTemplate: function(_, item) {  
                          return $("<a>").attr("href","#").attr("target", "_blank").text("Tutores")  
                                     .on("click", function () {   
                                        
                                  });  
                          },  
                          align: "center",  
                         width: 50  
                     },
                     {  
                          headerTemplate: function() { 
                         return $("<p>").text("Ver");  
                          },  
                         itemTemplate: function(_, item) {  
                          return $("<a>").attr("href","file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reporte%20Jefe%20Centro/acta_notas_sinfo.html").attr("target", "_blank").text("Acta de notas")  
                                     .on("click", function () {   
                                        
                                  });  
                          },  
                          align: "center",  
                         width: 50  
                     },
                     {  
                          headerTemplate: function() { 
                         return $("<p>").text("Ver**");  
                          },  
                         itemTemplate: function(_, item) {  
                          return $("<a>").attr("href","file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Reporte%20Jefe%20Centro/acta_notas_sinfo_fusionadas.html").attr("target", "_blank").text("Acta de notas fusionadas")  
                                     .on("click", function () {   
                                        
                                  });  
                          },  
                          align: "center",  
                         width: 50  
                     }
                       
                ]
            });

            $("#sort").click(function() {
                var field = $("#sortingField").val();
                $("#jsGrid").jsGrid("sort", field);
            });

        });
		
	</script>
	       <img src="../../img/image002.png" />     
	<script src="../../js/filter/list.js"></script>
	</body>	
</html>
