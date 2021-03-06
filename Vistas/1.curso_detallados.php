<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type"     content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SV: Acceso Directo a Cursos (Beta)</title>
    <link rel="stylesheet" type="text/css" href="../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>
	
    <link rel="stylesheet" type="text/css" href="../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../css/theme.css" />
    <script src="../js/jquery/jquery-1.8.3.js"></script>
    <script src="../data/cursos_detallados.js"></script>
	<link rel="stylesheet" href="../css/font-awesome.css">
	

    <script src="../js/jsgrid/jsgrid.core.js"></script>
    <script src="../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.field.js"></script>
	<script src="../js/jsgrid/fields/jsgrid.field.text.js"></script>
    <script src="../js/jsgrid/fields/jsgrid.field.number.js"></script>
    <script src="../js/jsgrid/fields/jsgrid.field.select.js"></script>
    <script src="../js/jsgrid/fields/jsgrid.field.checkbox.js"></script>
    <script src="../js/jsgrid/fields/jsgrid.field.control.js"></script>

</head>
<body>	
	
	<div>
	<h2 class="blue">  Acceso Directo a Cursos (Beta) - <a href="http://virtual.senati.edu.pe/course/cursos_adirecto.php"> ir a la Versi&oacute;n Anterior </a> - <a href="#"> ir a la Administraci&oacute;n de Cursos </a> </h2>
    </div>
    <div class="espacio">
        <label class="bold">Seleccionar a&ntilde;o:</label>
            <select id="yearField" class="form-control">
              
            </select>
            <button type="button" class="btn btn-primary" onclick="buscar();"><i class="fa fa-list"></i> Listar</button>
        
    </div>
    <div>
		<p class="green"> A�o Listado: <span id="fecha"></span></p>
    </div>



    <div id="jsGrid"></div>
	
	<div ><p class="color_patron">En este color est&aacute;n los Cursos Patron</p></div>

    <script>
		
		
		$(function() {

            $("#jsGrid").jsGrid({
                height: "50%",
                width: "100%",
                autoload: true,
				sorting: true,
				paging: true,
				pageSize: 2,
				selecting: true,
                pagePrevText: "<",
                pageNextText: ">",
                pageFirstText: "<<",
                pageLastText: ">>",
                pageNavigatorNextText: "&#8230;",
                pageNavigatorPrevText: "&#8230;",
				onRefreshed: function ( args ) {
					mostrar();				
				},
                controller: db,	
                fields: [		
                	{ name: "No", type: "number", width: 10 },
                    { name: "id", type: "number",	 width:19  , title:"Id Curso"},
                    { name: "periodo",  type: "number",	 width:20  , title:"Per�odo" },
                    { name: "subsanacion",  type: "text",	 width:20  },
                    { name: "subsanacion_de",  type: "number",	 width:20 },
                    { name: "startdate",   type: "number",	 width:30, title: "Inicio"},
                    {
						headerTemplate: function() {
						return $("<p>").text("Nombre"); 
						}, 
						itemTemplate: function(_, item) { 
						return $("<a>").attr("href","course/view.php?id=" + item.id).attr("target", "_blank").text(item.fullname) 
						.on("click", function () { 
	 					});
						},
	 					align: "start", 
	 					width: 100 

					},
               
                    { name: "inscritos",     type:"number",	 width:10, title: "Alus"},
                    { name: "visible",     type:"number",	 width:10},
                    { name: "reti_sinfo", 		type:"number", 	 width:8,   title:"Ret." },
 
                    {
                    headerTemplate: function() {
						return $("<p>").text("Grupos"); 
						}, 
						itemTemplate: function(_, item) { 
						return $("<a>").attr("href","#").attr("target", "_blank").text(item.total_grupox);
                        },
                        align: "center", 
                        width: 10 
					},

                    {
                    headerTemplate: function() {
						return $("<p>").text("Foros	"); 
						}, 
						itemTemplate: function(_, item) { 
						return $("<a>").attr("href","#").attr("target", "_blank").text(item.temas_foro) 
						.on("click", function () { 
	 					});
						},
	 					align: "left", 
	 					width: 20
					},
                    {
                    headerTemplate: function() {
						return $("<p>").text("Tutores"); 
						}, 
						itemTemplate: function(_, item) { 
						return $("<a>").attr("href","#").attr("target", "_blank").text(item.total_tutores) 
						.on("click", function () { 
	 					});
						},
	 					align: "center", 
	 					width: 20 

					},
                    {
						headerTemplate: function() {
						return $("<p>").text("Pond.") ; 

						}, 
						itemTemplate: function(_, item) { 

						return $("<a>").attr("href","http://192.168.1.61/theme/Modulo/Vistas/8.ponderaciones.php?id=" + item.id ).attr("target", "_blank").text(item.pondera) 
						.on("click", function () { 
							
							
	 					});
						},
	 					align: "center", 
	 					width: 20
					},
					{ name: "patron", 		type:"text", 	 width:8 , title: "Patron"},
					{ name: "hacademica", title: "H_A", align: "center"
						// itemTemplate: function(value, item) {
						// return $("<input>").attr("type", "checkbox").attr("checked", value || item.Checked);
						// // .on("change", function() {
							 // // item.Checked = $(this).is(":checked");
						 // //});
					  // }
					},
					{ name: "presencial",type:"text", 	 width:8 , title: "Presencial"},
                ]
				
				
				
            });
			
			
			
        });
	
	
		function aunto_incre(){
			var select, i, option,actual;
			var fecha = new Date();
			var year = fecha.getFullYear();
			select = document.getElementById("yearField");
			document.getElementById("fecha").innerHTML = year;
			for (i=year;i>=2005;i--)
			{	
				option = document.createElement('option');
				option.value = option.text = i;
				select.add( option );	
			}	
			
		}
	
		//fecha
		var anio;
		function fecha(){
			var imprimirResultado = function () {
				anio = $("#yearField option:selected").text();
				var fecha = document.getElementById("fecha");
				fecha.innerHTML = anio;
				//alert(anio);
			}
			$("#yearField").on("change", imprimirResultado).find("option:contains(2017)").prop("selected", true);
		}
	
		function mostrar(){
		 
			 
			var f = $("#jsGrid .jsgrid-grid-body .jsgrid-table tbody tr").attr("id","demo");
				
				  
			$(f).each(function (index) 
			{
				var campo1, campo2, campo3,campo4,campo5,campo6,campo7,campo8,campo9,campo10,campo11,campo12,campo13,campo14,campo15,campo16,campo17;
				$(this).children("td").each(function (index2) 
				{
					
					switch (index2) 
					{
						case 0: campo1 = $(this).text(); $(this).attr("id","numero");
								break;
						case 1: campo2 = $(this).text(); $(this).attr("id","id")
								break;
						case 2: campo3 = $(this).text(); $(this).attr("id","periodo")
								break;
						case 3: campo4 = $(this).text(); $(this).attr("id","subsanacion");
								break;
						case 4: campo5 = $(this).text(); $(this).attr("id","subsanacion_de");
								break;
						case 5: campo6 = $(this).text(); $(this).attr("id","inicio");
								break;
						case 6: campo7 = $(this).text(); $(this).attr("id","fullname");
								break;
						case 7: campo8 = $(this).text(); $(this).attr("id","inscritos");
								break;
						case 8: campo9 = $(this).text(); $(this).attr("id","visible");
								break;		
						case 9: campo10 = $(this).text(); $(this).attr("id","reti_sinfo");
								break;		
						case 10: campo11 = $(this).text(); $(this).attr("id","grupo");
								break;		
						case 11: campo12 = $(this).text(); $(this).attr("id","foros")
								break;	
						case 12: campo13 = $(this).text(); $(this).attr("id","tutores");
								break;	
						case 13: campo14 = $(this).text(); $(this).attr("id","pondera"); 
								break;				
						case 14: campo15 = $(this).text(); 
								break;
						case 15: campo16 = $(this).text(); $(this).attr("id","hacademica");
								break;	
						case 16: campo17 = $(this).text(); $(this).attr("id","presencial");
								break;									
					}
					
					$(this).css("background","#b6dbed");
					
					if(campo17 != undefined){
						if(campo17 == 's'){
							//$(this).parent().css("background","white");
							$(this).parent().find( "td" ).css("background","white");
						}
					}
					
				})
				
				
				
				//RETIRADOS SINFO EN ROJO
				if(campo10 === undefined)
				{
					
					
				}else{
						if (campo10 != "0")
						{
							var estilo_ret= $(this).find( "#reti_sinfo" );
							estilo_ret.css("color","red");
						}
						else
						{	
							var estilo_rete="";
						}
					
				}
			
				
				var pon="";
				var ponS="";
				if(campo14 === undefined )
				{
				}else{
					if(campo14 == "1")
					{ 
						ponS = $(this).find( "#pondera a" ).text("SI");
						// var estilo_pondera="";
					}
					else 
					{
						if(campo14 == "0"){
						ponS = $(this).find( "#pondera a" ).text("NO");
						var estilo_pondera=$(this).find( "#pondera" ).css("background","yellow");
						}
						if(campo14 =="NO"){
							var estilo_pondera=$(this).find( "#pondera" ).css("background","yellow");
							
						}
					}
				}
				
				var estilo_tutores="";  
				if (campo13 =="0")
				{
					estilo_tutores = $(this).find("#tutores").css("background","yellow");
				}
				
			
				var hacademica="";
				if(campo16 === undefined )
				{
				}else{
					if(campo16 == "1")
					{ 
						hacademica = $(this).find( "#hacademica" ).text("SI");
						// var estilo_pondera="";
					}
					else 
					{
						if(campo16 == "0"){
						hacademica = $(this).find( "#hacademica" ).text("NO");
						var estilo_ha=$(this).find( "#hacademica" ).css("background","yellow");
						}
						if(campo16 =="NO"){
							var estilo_ha=$(this).find( "#hacademica" ).css("background","yellow");
							
						}
					}
				}	
				
				
				
				
				// Si es patron lo pinto de color 6bb6de
				var estilo_td="";
				var clase="";
				if(campo15 === undefined )
				{
				}else{
					if (campo15 == "s")
					{	
						estilo_td = $("#jsGrid .jsgrid-grid-body .jsgrid-table tbody tr #fullname");
						
						estilo_td.css("background","#6bb6de");
						if (campo9 !="1")
						{
							 clase = $(this).find( "#fullname a" ).css("color","black");
						}
						
					}else
					{
						if (campo15 != "s"){
							if (campo9 !="1")
							{
								 clase = $(this).find( "#fullname a" ).css("color","gray");
								
							}
						}
						
					}
				}
				
				
				var estilo_foro="";
						
				if(campo11!=0)
					{
					if (campo12=="0" || campo12==0)
					{
						estilo_foro = $(this).find( "#foros" ).css("background","yellow");	
					}
				}
				
				
				
				
			
				
			   
			    var presen="";
				if(campo17 === undefined )
				{
				}else{
					if(campo17 == "s")
					{ 
						presen = $(this).find( "#numero" ).text("Pres");
						
					}
					
				}	
				var color_subsa="";
				if(campo4 === undefined )
				{
				}else{
					if(campo4 == "s")
					{ 
						color_subsa = $(this).find( "#numero" ).text("Subsa");
						color_subsa.css("background","#e9f8ff");
						var id = $(this).find("#id").css("background","#e9f8ff");
						var periodo = $(this).find("#periodo").css("background","#e9f8ff");
						var fecha = $(this).find("#inicio").css("background","#e9f8ff");
						var full = $(this).find("#fullname").css("background","#e9f8ff");
						if(campo17 == "s")
						{ 
							presen = $(this).find( "#numero" ).text("Pres_Subsa");
							
						}
					}
					
				}		
				
				// SI NO HAY ALUMNOS PINTO DE AMARILLO
				var ins="";
				if(campo8 == 0)
				{
					ins = $(this).find( "#inscritos" ).css("background","#f7f5b7");	
					
				}
				else
				{
				   ins="";
				}
			
			});
      
			
			
		}
	
		
		$(document).ready(function(){
			 
			mostrar();
			 fecha();
			aunto_incre();
		});
      
		// $(document).ready(function (){
			// modificar();
			
			
		// });
		
		// function modificar(){	
		
			
			// var sAux="";
			// var frm = document.getElementByid("checked");
			// for (i=0;i<frm.length;i++)
			// {
				// sAux +=  frm.elements[i].value + " ";
				
				// if(sAux ==="1"){
					// document.getElementsByTagName("input").checked = true;
					
				// }else{
					// document.getElementsByTagName("input").checked = false;
					
				// }
				
			// }
			// alert(sAux);
			
		// }	
      

		<!-- $(document).ready(function() -->
        <!-- { -->
                <!-- cargar(); -->
        <!-- });   -->

		
		// function cargar(){ 
	
				
				// var x = document.getElementByid("checked").innerHTML; 
				
				 // if(x == "1") 
				 // { 
					
					 // document.getElementsByTagName("input").checked = true; 
					 // document.getElementsByTagName("input").innerHTML = "true"; 
				  // }else{ 
					 // document.getElementsByTagName("input").checked = false; 
					 // document.getElementsByTagName("input").innerHTML ="false"; 
				 // }
			 // }
    </script>
	
<!--<style>
table {
    counter-reset: tableCount;     
}
#d:before {              
    content: counter(tableCount); 
    counter-increment: tableCount; 
}
</style>-->
	             
	
	</body>	
</html>
   



