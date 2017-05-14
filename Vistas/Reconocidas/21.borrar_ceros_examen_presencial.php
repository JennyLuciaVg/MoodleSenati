<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="UTF-8">
    <title>Borrar Ceros de Cuestionarios (quiz) (Solo Administradores)</title>
    <link rel="stylesheet" type="text/css" href="../../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../css/theme.css" />


    <script src="../../js/jquery/jquery-1.8.3.js"></script>
    <script src="../../js/jsgrid/jsgrid.core.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.field.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/font-awesome.css">


</head>

<body>        <img src="../../img/image001.png" />   

    <div id="etiquetas">
        <h4 class="blue"> SHiN 201620 - Presencial Grupo C - CFP Chincha (7043)</h4>
     </div>


    <div id="etiquetas">
        <caption><strong> LiSTA DE QUiZES Y CRONOGRAMA </strong></caption>
        <table>
            <thead class="lightblue">
                <tr >
                    <th>id Quiz</th>
                    <th>Nombre Quiz</th>
                    <th>Fecha de Apertura</th>
                    <th>Fecha de Cierre</th>
                    <th>Tiempo Límite</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>17717</td>
                    <td>Evaluaci&oacute;n U01</td>
                    <td>Sábado 10-09-2016  02:00</td>
                    <td>Sábado 10-09-2016  22:50</td>
                    <td>15</td>
                </tr>
            </tbody>
        </table>
    </div>

    
    <div id="notas">
        <caption> <strong> LiSTA DE iNTENTOS con CERO </strong></caption>
        <table>
            <thead class="lightblue">
                <tr>
                   <th>Borrar<br><a href="sss" class="btn_todo">Seleccionar Todos</a></th>
                    <th>id intento</th>
                    <th>Nombre Quiz</th>
                    <th>id Quiz</th>
                    <th>Alumno</th>
                    <th>Timestart</th>
                    <th>Timefinish</th>
                    <th>Timemodified</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>5</td>
                    <td>Caso de Estudio U02</td>
                    <td>18058</td>
                    <td>José Velasques</td>
                    <td>10:30:00</td>
                    <td>11:15:00</td>
                    <td>&nbsp</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div id="etiquetas">
        <p class="bold">iNTENTOS CON CERO: 0</p>
    </div>
    
    <div id="botenes">
        <button   class="btn btn-primary" type="button"> <i class="fa fa-trash-o" aria-hidden="true"></i> Borrar los intentos seleccionados</button>
    </div>
	       <img src="../../img/image002.png" />     </body>		

</html>