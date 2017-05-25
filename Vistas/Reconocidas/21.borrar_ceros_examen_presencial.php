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
    <style type="text/css">
        .hide{
           display:none;
        }
    </style>

</head>

<body>        <img src="../../img/image001.png" />   

    <div id="etiquetas">
        <h4 class="blue"> SHiN 201620 - Presencial Grupo C - CFP Chincha (7043)</h4>
     </div>


    <div id="etiquetas">
        <caption><strong> LiSTA DE QUiZES Y CRONOGRAMA </strong></caption>
        <!--table>
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
        </table-->
        <div id="jsGridListaCeros"></div>
    </div>

    
    <div id="notas">
        <caption> <strong> LiSTA DE iNTENTOS con CERO </strong></caption>
        <!--table>
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
        </table-->
        <div id="jsGridBorrarIntentos"></div>
    </div>
    
    <div id="etiquetas">
        <p class="bold">iNTENTOS CON CERO: 0</p>
    </div>
     
    
    <div id="botenes">
        <button id="save" class="btn btn-primary" type="button"> <i class="fa fa-trash-o" aria-hidden="true"></i> Borrar los intentos seleccionados</button>
    </div>
	       <img src="../../img/image002.png" />  

        <script>
        var id_curso = 7799;
        var id_user = 142;
        var nombre_curso;
        function isAdmin(){
            return true;
        }
        $("#save").click(function() {
            var table = $("#jsGridBorrarIntentos .jsgrid-grid-body");
            table.find('tr').each(function (i) {
                var $tds = $(this).find('td'),
                    id_intento = $tds.eq(1).text(),// N°
                    id_alux = $tds.eq(7).text(),
                    id_quix = $tds.eq(8).text(),
                    chk = $tds.eq(0).find('input').is(":checked");// accion
                if (chk) {
                    $.ajax({
                        url: "http://localhost/Api/Api/DAO/BORRA_CEROS?action=EliminarIntento&id_intento="+ id_matricula,
                        type: "GET",
                        async: false,
                        contentType: "application/json;charset=utf-8",
                        dataType: "json",
                        success: function(result){
                            console.log("intento eliminado");
                        },
                        error : function(xhr,errmsg,err) {
                            console.log(xhr.status + ": " + xhr.responseText);
                        }
                    });
                     $.ajax({
                        url: "http://localhost/Api/Api/DAO/BORRA_CEROS?action=InsertarLog&id_user="+ id_user+"&id_alux="+ id_alux+"&id_intento="+ id_intento+"&id_cursox="+ id_cursox+"&id_quix="+id_quix,
                        type: "GET",
                        async: false,
                        contentType: "application/json;charset=utf-8",
                        dataType: "json",
                        success: function(result){
                            console.log("intento guardado en log");
                        },
                        error : function(xhr,errmsg,err) {
                            console.log(xhr.status + ": " + xhr.responseText);
                        }
                    });
                }
            });
        });
        $("#selecAllCheckbox").click(function(){
            $("input:checkbox").prop('checked', true);
        });

        if (isAdmin() || isteacher(id_curso)) {
            $.ajax({
                url: "http://localhost:8080/Api/DAO/BORRA_CEROS?action=NombreCurso&id_cursox="+ id_curso,
                type: "GET",
                async: false,
                contentType: "application/json;charset=utf-8",
                dataType: "json",
                success: function(result){
                    nombre_curso = result.fullname;
                },
                error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ": " + xhr.responseText);
                }
            });
        $(function() {
            $("#jsGridBorrarIntentos").jsGrid({
                height: "50%",
                width: "70%",
                autoload: true,
                sorting: true,
                paging: true,
                pageSize: 2,
                selecting: true,
                controller: listarIntentos,
                fields: [
                    { 
                        headerTemplate: function() {            
                            return $("<p>").text("Borrar").append("<br><a id='selecAllCheckbox' style='color: white;'>Seleccionar Todos</a>");
                        },  
                        itemTemplate: function(_, item) {
                            if (disabled) {
                                return $("<p>").text("");
                            } else {
                                return $("<input>").attr("type","checkbox");
                            }
                        },  
                        align: "center", 
                        width: 30 
                    } ,
                    { name: "id", type: "text",width: 20, title: "id intento"},
                    { name: "nombre_quiz", type: "text", width: 20, title: "Nombre Quiz"},
                    { name: "quiz", type: "text",width: 20, title: "id Quiz"},  
                    { name: "alumno", type: "text", width: 20, title: "Alumno"},
                    { name: "timestart", type: "text", width: 20, title: "Timestart"},
                    { name: "timefinish", type: "text", width: 20, title: "Timefinish"},
                    { name: "timemodified", type: "text", width: 20, title: "Timemodified"},
                    { name: "id_alumno",  type: "text", css: "hide", width: 0}
                    { name: "quiz", type: "text", css: "hide", width: 0}
                ]
            }); 
        });

        $(function() {
            $("#jsGridListaCeros").jsGrid({
                height: "50%",
                width: "70%",
                autoload: true,
                sorting: true,
                paging: true,
                pageSize: 2,
                selecting: true,
                controller: listarCeros,
                fields: [
                    { name: "id", type: "number",width: 20, title: "Id Quiz"},
                    { name: "name", type: "text", width: 20, title: "Nombre Quiz"},
                    { name: "timeopen", type: "text",width: 20, title: "Fecha de Apertura"},  
                    { name: "timeclose", type: "text", width: 20, title: "Fecha de Cierre"},
                    { name: "timelimit", type: "date", width: 20, title: "Tiempo Límite"},
                ]
            }); 
        });

        var listarIntentos =  function () {
            var data = $.Deferred();
                $.ajax({
                     type: "GET",
                    contentType: "application/json; charset=utf-8",
                    url: "http://localhost:8080/Api/DAO/BORRA_CEROS?action=BorraCeroLista&id_cursox="+ id_curso,
                    dataType: "json"
                    }).done(function(response){
                        data.resolve(response);
                    });
                    return data.promise();
        };

        var listarCeros =  function () {
            var data = $.Deferred();
                $.ajax({
                     type: "GET",
                    contentType: "application/json; charset=utf-8",
                    url: "http://localhost:8080/Api/DAO/BORRA_CEROS?action=CeroListaQuizes&id_cursox="+ id_curso,
                    dataType: "json"
                    }).done(function(response){
                        data.resolve(response);
                    });
                    return data.promise();
        };
    }
            


    </script>   
    </body>		

</html>