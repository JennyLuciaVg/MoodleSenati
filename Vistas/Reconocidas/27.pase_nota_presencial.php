<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
    <meta charset="UTF-8">
    <title>SV: Notas de Cursos con Examenes Presenciales para pasar a Cursos Regulares</title>
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
        <span class="span_insertar"> Notas de Examenes Presenciales a pasar a Tareas de Cursos Regulares  </span>
        <br>
        <span class="nota_importante"> (Solo puede ser ejecutado por el ADMiNiSTRADOR DE SENATi ViRTUAL)</span>
        <br>
        <span class="span_insertar"> NOMBRE DEL CURSO _ MMTR 201710 - Presencial Grupo A - CFP Sullana </span>
        <br>
        <span class="span_insertar"> iD DEL CURSO : 7896</span>
        <br>
        <span class="span_insertar"> PRESENCiAL DEL CURSO : 7777 </span>
    </div>

    <div id="etiquetas">
        <span  class="span_insertar"> TUTORES del PRESENCiAL:</span> LANDiVAR CASTiLLO, MARLYN
        <br>
        <span  class="span_insertar"> Emails: </span> mlandivar@senati.edu.pe; gcamacho@senati.edu.pe
    </div>

    <p class="nota_importante">NOTA : NO SE TOMAN EN CUENTA LOS RETiRADOS</p>
    <div >
        <p class="span_insertar">iD TAREA 1 : <input type="text" value="14415" class="form-control"> </p>
        <p class="span_insertar">iD TAREA 2 : <input type="text" value="14416" class="form-control"> </p>
    </div>

    <div>
        <button type="button" class="btn btn-primary"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Pasar Notas</button> <span class="blue">(SOLO PASARAN LAS NOTAS DE LOS QUE iNTENTARON)</span>
    </div>

   
    <div id="notas">
        <table id="tables">
            <thead class="lightblue">
                <tr>
                    <th onclick="sortTable(0)">id SiNFO</th>
                    <th onclick="sortTable(1)">id SV</th>
                    <th onclick="sortTable(2)">Apellidos, Nombres</th>
                    <th onclick="sortTable(3)">Status SiNFO</th>           
                    <th onclick="sortTable(4)">Evaluaci&oacute;n U01</th>
                    <th onclick="sortTable(5)">Evaluaci&oacute;n U02</th>
                    <th onclick="sortTable(6)">Evaluaci&oacute;n U03</th>
                    <th onclick="sortTable(7)">Evaluaci&oacute;n U04</th>
                </tr>
            </thead>
            <tbody id="myTable">
                <tr>
                    <td>884014</td>
                    <td>221618</td>
                    <td> <a href="http://virtual.senati.edu.pe/user/view.php?id=147705&course=1" target="_blank" > ABARCA QUiSPE, JORDYN BRYAN</a>   </td>
                    <td>&nbsp</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                </tr>
                 <tr>
                    <td>999014</td>
                    <td>423432</td>
                    <td> <a href="http://virtual.senati.edu.pe/user/view.php?id=147705&course=1" target="_blank" > ABARCA QUiSPE, CARLOS BRYAN</a>   </td>
                    <td>&nbsp</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                </tr>
                 <tr>
                    <td>233014</td>
                    <td>212618</td>
                    <td> <a href="http://virtual.senati.edu.pe/user/view.php?id=147705&course=1" target="_blank" > ABARCA QUiSPE, CRiSTHiAN BRYAN</a>   </td>
                    <td>&nbsp</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                </tr>
				<tr>
                    <td>32432432</td>
                    <td>3432432432</td>
                    <td> <a href="http://virtual.senati.edu.pe/user/view.php?id=147705&course=1" target="_blank" > ABARCA QUiSPE, RAFAEL BRYAN</a>   </td>
                    <td>&nbsp</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                    <td class="red">No intent&oacute;</td>
                </tr>
            </tbody>    
        </table>
        <div class="col-md-12 text-center">
            <ul class="pagination pagination-lg pager" id="myPager"></ul>
        </div>
    </div>
     
    
  
    <div id="notas">
        <table class="quiz_sinfo"> 
            <thead class="lightblue">
                <tr>
                    <th>Cuestionario</th>
                    <th>Nombre Cuestionario</th>
                    <th class="">No intentaron</th>
                    <th>Tienen nota</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Evaluaci&oacute;n Presencial 01</td>
                    <td>40</td>
                    <td>0</td>
                    <td>40</td>
                </tr>
            </tbody>    
        </table>
    </div>
    
           <img src="../../img/image002.png" />     
	<script src="../../js/filter/filter.js"></script>
	<script src="../../js/filter/thead.js"></script>
	</body>      
</html>