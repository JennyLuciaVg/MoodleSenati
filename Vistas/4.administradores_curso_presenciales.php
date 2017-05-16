<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV:Administradores de Cursos Presenciales</title>
    <link rel="stylesheet" type="text/css" href="../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../css/theme.css" />

    <script src="../js/jquery/jquery-1.8.3.js"></script>
	<link rel="stylesheet" href="../css/font-awesome.css">
	 <script src="../data/administradores_curso_presenciales.js"></script>
    <script src="../js/jsgrid/jsgrid.core.js"></script>
    <script src="../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.field.js"></script>


</head>

<body>	          
   
	<div>
		<h3><a href=""> Administraci&oacute;n de Cursos </a>- Administradores de Cursos Presenciales</h3>
	</div>

   <div id="jsGrid"></div>

    <div id="etiquetas">
		<caption><strong>Inscribir a TODO como Tutores a Cursos presenciales del Periodo :</strong> <input type="text" class="form-control"/> 
		<button type="button" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>   Asignar como Tutores</button></caption>
	</div>
	<div id="notas">
	
		<table>
			<thead class="lightblue">
				<tr>
					<th colspan="3"> Búsqueda de Personas</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>BUSCAR POR APELLIDOS</td>
					<td><input type="text" class="form-control" id="txt_apellido"></td>
					<td> <a type="button" class="btn btn-primary" onclick="buscar_apellido();" ><i class="fa fa-search" aria-hidden="true"></i> Buscar</a>   </td>
				</tr>
				<tr>
					 <td>BUSCAR POR PIDM</td>
					<td><input type="text" class="form-control"></td>
					<td> <button type="button" class="btn btn-primary" id="txt_pidm" onclick="buscar_pidm();"><i class="fa fa-search" aria-hidden="true"></i> Buscar </button>   </td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="tb_buscar">
		<table>
			<thead class="lightblue">
				<tr>
					<th>ID User SV</th>
					<th>Apellidos, Nombre</th>
					<th>PiDM SiNFO</th>
				</tr>
			</thead>
			<tbody class="tbody">
				
			</tbody>
		</table>
	</div>
	<br>
	<div id="tb_buscar_pidm">
		<table>
			<thead class="lightblue">
				<tr>
					<th>ID User SV</th>
					<th>Apellidos, Nombre</th>
					<th>PIDM SINFO</th>
				</tr>
			</thead>
			<tbody class="tbpdim">
				
			</tbody>
		</table>
	</div>
	<br>
	<div>
		<table>
			<thead class="lightblue">
				<tr>
					<th colspan="2"> NUEVO ADMINISTRADOR DE CAMPUS</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>ID User SV</td>
					<td><input type="text" class="form-control" id="user_sv"></td>
					
				</tr>
				<tr>
					 <td>CAMPUS</td>
					<td>
						<select class="form-control" id="campus">
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp</td>
					<td> <a type="button"  class="btn btn-primary" onclick="registrar();"><i class="fa fa-save"></i> Registrar</a> </td>
				</tr>
			</tbody>
		</table>

	</div>
    
	<div>
		 <p class="bold">EMAiLS DE TODOS LOS ADMiNiSTRADORES</p>
         <textarea rows="10" cols="63"></textarea>
	</div>
           
	<div id="etiquetas">
		<a href="#" class="btn btn-primary">Administrar Datos de Cursos Presenciales <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
	</div>

	 <script>
		$(document).ready(function(){
			lista_centros();
			
		});
	 
        $(function() {

            $("#jsGrid").jsGrid({
                height: "30%",
                width: "100%",
				autoload: true,
				sorting: true,
				paging: true,
				pageSize: 2,
				selecting: true,
				controller: {
						loadData: function() {
							var d = $.Deferred();
							$.ajax({
								url: "http://localhost:80/Api/Api/DAO/ADMINISTRADORES_CURSOS_PRESENCIALES.php?action=ListaProfesores",
								dataType: "json"
						}).done(function(response) {
							d.resolve(response.value);
						});
		 
						return d.promise();
					}
				}, 
                // controller: db,
                fields: [
                    { name: "nombre_zonal",type: "text",width: 180, title: "Zonal" },
                    { name: "camp_user", type: "text",width: 40, title: "Camp" },
                    { name: "nombre_centro",  type: "text",width: 180, title: "Campus" },
                    {
                        headerTemplate:function(){
                            return $("<p>").text("Administrador");
                            },
                            itemTemplate:function(_,item){
                                return $("<a>").attr("href","#").attr("target","_blank").text(item.lastname + item.firstname).on("click",function(){

                                });
                            },
                            width: 180
                    },
               
                    { name: "id_user",    type: "number",    width: 55 , title:"ID User SV" },
                    { name: "pidm_banner",    type: "number",    width: 65 , title:"PIDM SINFO" },
                    {
                        headerTemplate:function(){
                            return $("<p>").text("Acciones");
                            },
                            itemTemplate:function(_,item){
                                return $("<input>").attr("type","button").attr("class","btn btn-danger").attr("value","Borrar").attr("size",5)

                            },
                            width: 50
                    }
                                    
                ]
            });

        });
		
		var co = 0;
		function buscar_apellido(){
			var apellidos= document.getElementById("txt_apellido").value;
	
		
			$.ajax({
				url: "http://localhost/Api/Api/DAO/ADMINISTRACION_GENERAL.php?action=BuscaApe&last="+ apellidos,
				type: "GET",
				contentType: "application/json;charset=utf-8",
				dataType: "json",
				success: function(object){
					if(co != 1)
					{
						var html = "";
						$.each(result, function(key,item)
						{
							html +='<td>'+ item.id +'</td>';
							html +='<td>'+ item.lastname +', '+ item.firstname +'</td>';
							html +='<td>'+ item.pidm_banner +'</td>';
							
						});
					
						$(".tbody").html(html);
						$(".tbody").css("display","block")
						co = 1;
						
					}else{
						$(".tbody").css("display","none")
						co = 0;
					}
					
				},
				error : function(xhr,errmsg,err) {
					 console.log(xhr.status + ": " + xhr.responseText);
				}
			});	
		}
		
		
		var pidm = 0;
		function buscar_pidm(){
			var pidm= document.getElementById("txt_pidm").value;
		
		
			$.ajax({
				url: "http://localhost/Api/Api/DAO/ADMINISTRACION_GENERAL.php?action=BuscaPIDM&pidm="+ pidm,
				type: "GET",
				contentType: "application/json;charset=utf-8",
				dataType: "json",
				success: function(object){
					if(pidm != 1)
					{
						var html = "";
          
						$.each(result, function(key,item)
						{
							html +='<td>'+ item.id +'</td>';
							html +='<td>'+ item.lastname +', '+ item.firstname +'</td>';
							html +='<td>'+ item.pidm_banner +'</td>';
							
						});
					
						$(".tbpdim").html(html);
						$(".tbpdim").css("display","block")
						pidm = 1;
						
					}else{
						$(".tbpdim").css("display","none")
						pidm = 0;
					}
					
				},
				error : function(xhr,errmsg,err) {
					 console.log(xhr.status + ": " + xhr.responseText);
				}
			});	
		}
		
		
		function lista_centros(){
			
			$.ajax({
				url : "http://localhost/Api/Api/DAO/ADMINISTRADORES_CURSOS_PRESENCIALES.php?action=ListarCentros",
				type: "GET",
				contentType: "application/json;charset=utf-8",
				dataType: "json",
				success: function(data2){
						$.each(data2, function(key,items)
						{
							var option = $(document.createElement('option'));
							option.text(this.nombre_centro);
							option.val(this.id_centro);
							$("#campus").append(option);	
						});
								
					},
					error : function(xhr,errmsg,err) {
					console.log(xhr.status + ": " + xhr.responseText);
				}
			});	
		}

		function registrar(){
			var camp = document.getElementById('campus').options[document.getElementById('campus').selectedIndex].text;
			var id_user_sv = document.getElementById("user_sv").value;

			if (camp!="" && id_user_sv!="")
			{
				$.ajax({
					url: "http://localhost/Api/Api/DAO/ADMINISTRADORES_CURSOS_PRESENCIALESphp?action=Existe_Dupla&id_svx="+ id_user_sv + "&campx=" + camp,
					type: "GET",
					contentType: "application/json;charset=utf-8",
					dataType: "json",
					success: function(result){
						
							var html = "";
							var existe="";
							$.each(result, function(key,item)
							{
								if(item.existe == "1")
								{
									
									
								}else{
									
									$.ajax({
										url : "http://localhost/Api/Api/DAO/ADMINISTRADORES_CURSOS_PRESENCIALES.php?action=Guarda",
										type: "GET",
										contentType: "application/json;charset=utf-8",
										dataType: "json",
										success: function(data2){
												
											alert("agreado correctamente");
										},
										error : function(xhr,errmsg,err) {
										console.log(xhr.status + ": " + xhr.responseText);
										}
									});	
									
								}
								
							});
						
							
						
						
					},
					error : function(xhr,errmsg,err) {
						 console.log(xhr.status + ": " + xhr.responseText);
					}
				});	
			}	
		}
		
    </script>

	              
	<script src="../js/filter/filter.js"></script>
</body>	
</html>
