<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
    <meta charset="UTF-8">
    <title>SV: Consolidaci&oacute;n de Matriculas con SiNFO</title>
    <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../css/theme.css" />
    <link rel="stylesheet" type="text/css" href="../../css/font-awesome.css">

    <script src="../../js/jquery/jquery-1.8.3.js"></script>
    <script src="../../js/jquery/jquery-1.8.3.js"></script>
    <script src="../../js/jsgrid/jsgrid.core.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.field.js"></script>
</head>
<body>        <img src="../../img/image001.png" />   	

  <div id="etiquetas">
    <p class="blue">Consolidaci&oacute;n de Matriculas con SiNFO </p>
  </div> 

  <div> 
    <table >
        <tr>
            <th >iD Curso Moodle</th>
            <td>7214</td>
        </tr>
        <tr>
            <th>Nombre Curso Moodle</th>
            <td>
              <a href="http://virtual.senati.edu.pe/course/view.php?id=7775"> ATC 201620 - Grupo B - Zona Loreto </a>
            </td>          
        </tr>
        <tr>
            <th>Materia-Curso SiNFO</th>
            <td>CGEU-165</td>          
        </tr>
        <tr>
            <th>Periodo SiNFO</th>
            <td>201620</td>          
        </tr>
        <tr>
            <th>Fecha de inicio</th>
            <td>29-09-2016</td>          
        </tr>
        <tr>
            <th>
              <a href="http://virtual.senati.edu.pe/course/teacher.php?id=7822" >Tutor(es)</a> </th>
            <td>MOiSES, PANDURO CORAL</td>          
        </tr>
        <tr>
            <th class="th">Total Alumno</th>
            <td>104</td>          
        </tr>
        <tr>
            <th>Retirados de SiNFO</th>
            <td>0</td>          
        </tr>
    </table>
  </div>

  <div id="notas">
    <table >
      <thead class="lightblue">
        <tr>
            <th colspan="2">Datos para extraer a los alumnos que no estan matriculados acá pero si en SiNFO</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <th>Campos distintos</th>
              <td>
                <input type="text" class="form-control" value="'56'">  
                <p>CFP Tacna (56) - Alumnos : 125</p>
             </td>        
        </tr>
        <tr>
            <th>PiDMS distintos</th>
            <td>
              <label id="pidms" style="display: none;">PiDMS distintos </label>
              <textarea class="form-control" ></textarea>
            </td>  
        </tr>
        <tr>
            <th >Curso SiNFO</th>
            <td> 
              <input class="form-control" type="input" value="CGUE-165">  
            </td>              
        </tr>
        <tr>
            <th>BLOQUES SiNFO para matricula Paso 1 &oacute; :</th>
            <td>
              <input class="form-control" type="input" value="'56MSUDFB01','56EEiDE301','56AMODFB01','56MMADE302','56MMADFB01','56AMODFB03'">
              <div id="btn_alumnos">
                <button class="btn btn-primary" type="button"> <i class="fa fa-book" aria-hidden="true"></i>  Leer Alumnos en esos BLOQUES desde SiNFO</button>     
              </div>
            </td>     
        </tr>
        <tr>
            <th>NRCS SiNFO para matricula Paso 1 &oacute; :</th>
            <td >
              <input class="form-control" type="input" value="'28684','29696','24082','28210','32566','20130'">
              <div id="btn_alumnos">
                <button class="btn btn-primary" type="button"> <i class="fa fa-book" aria-hidden="true"></i> Leer Alumnos con esos NRCS desde SiNFO</button>   
              </div>
            </td>           
        </tr>
        <tr>
            <th>PiDMS SiNFO para matricula Paso 1 &oacute; :</th>
            <td >
               <input class="form-control" type="input" value="'28684','29696','24082','28210','32566','20130'">
              <div id="btn_alumnos">
                <button class="btn btn-primary" type="button"> <i class="fa fa-book" aria-hidden="true"></i> Leer Alumnos con esos PiDMS desde SiNFO</button>   
              </div>           
            </td>            
        </tr>
        <tr>
            <th>PASO 1</th>
            <td>
              <div id="btn_alumnos">
                <button type="button" class="btn btn-primary"> <i class="fa fa-book" aria-hidden="true"></i> Leer Alumnos en esos CAMPOS desde SiNFO</button>
              </div>
            </td>           
        </tr>
        <tr>
            <th>PASO 2</th>
            <td>
              <div id="btn_alumnos">
                <button type="button" disabled id="" class="btn btn-primary"> <i class="fa fa-balance-scale" aria-hidden="true"></i> Comparar Alumnos Faltantes</button>
              </div>
            </td>           
        </tr>
        <tr>
            <th>PASO 3</th>
            <td>
              <div id="btn_alumnos">
              <button type="button"  disabled id="" class="btn btn-primary"> <i class="fa fa-file-o" aria-hidden="true"></i> Matricular Alumnos Faltantes</button>
              </div>
            </td>           
        </tr>
        <tr>
            <th>PASO 4</th>
            <td>
              <a href="http://virtual.senati.edu.pe/course/groups.php?id=7775"><i class="fa fa-users" aria-hidden="true"></i> ir a la página de Grupos</a>  o <a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Lista%20Alumnos/editar_matriculas.html">ir a Editar Matriculas <i class="fa fa-arrow-right"></i></a>  
            </td>           
        </tr>
      </tbody>
    </table>
  </div>
	       <img src="../../img/image002.png" />     </body>		
</html>
