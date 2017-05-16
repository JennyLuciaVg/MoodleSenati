<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV: Historia Academica</title>
    <link rel="stylesheet" type="text/css" href="../../css/demos.css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../css/theme.css" />

    <script src="../../js/jquery/jquery-1.8.3.js"></script>
	<link rel="stylesheet" href="../css/font-awesome.css">
	<script src="../../data/db.js"></script>
    <script src="../../js/jsgrid/jsgrid.core.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.field.js"></script>

</head>
<body>
	       <img src="../../img/image001.png" />   
	 <div>
		<p class="blue">Historia Academica - Seleccione un Curso</p>
	</div>
   
    <!-- <table class="select_course" > -->
        <!-- <thead class="lightblue"> -->
            <!-- <tr > -->
                <!-- <th>C&oacute;digo</th> -->
                <!-- <th>Nombre</th> -->
                <!-- <th>Categoria</th> -->
                <!-- <th>Dictado (N° de Veces)</th> -->
            <!-- </tr> -->
        <!-- </thead>     -->
       <!-- <tbody> -->
            <!-- <tr> -->
                <!-- <td>BRHV-101</td> -->
                <!-- <td> -->
                    <!-- <a href="file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Historia%20Academica/7.1Cursos_Dictados.html" target="_blank">ADMiNiSTRACiON ESTRATEGiCA DEL CAPiTAL HUMANO</a> -->
                <!-- </td> -->
                <!-- <td>Gesti&oacute;n de Recursos Humanos</td> -->
                <!-- <td>10</td> -->
            <!-- </tr> -->
       <!-- </tbody> -->
    <!-- </table> -->
	
	<div id="jsGridHistoriaA"></div>
	
	       <img src="../../img/image002.png" />     
	
	
	<script>
        $(function() {

            $("#jsGridHistoriaA").jsGrid({
                height: "30%",
                width: "100%",
                autoload: true,
				sorting: true,
				paging: true,
				pageSize: 2,
                controller: db,
                fields: [
                    { name: "Codigo",type: "text",width: 20},
                    {
                        headerTemplate:function(){
                            return $("<p>").text("Nombre");
                            },
                            itemTemplate:function(_,item){
                                return $("<a>").attr("href","file:///C:/Users/CristhianEnriqueSaav/Desktop/Senati/Modulo/Vistas/Historia%20Academica/7.1Cursos_Dictados.html").attr("target","_blank").text("AGUiLAR MURRiEL, ALVARO").on("click",function(){

                                });
                            },
                                width: 40
                    },
               
                    { name: "Categoria",    type: "number",    width: 30},
                    { name: "Veces",    type: "number",    width: 20 , title:"Dictado (N° de Veces)" }
                                    
                ]
            });

        });
		
		var co = 0;
		function buscar(){
			
			
			 
			 if(co != 1)
			 {
				document.getElementByid("tb_buscar").style.display = "block";
				co = 1;
				
			 }else{
				document.getElementByid("tb_buscar").style.display = "none";
				co = 0;
			 }
		}

    </script>
</body>	
</html>