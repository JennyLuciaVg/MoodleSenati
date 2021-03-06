<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV: Administraci&oacute;n de Cursos de SENATi ViRTUAL</title>
    <link rel="stylesheet" type="text/css" href="../css/demos.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../css/theme.css" />
    <script src="../js/jquery/jquery-1.8.3.js"></script>
	<link rel="stylesheet" href="../css/font-awesome.css">
	
    <script src="../js/jsgrid/jsgrid.core.js"></script>
    <script src="../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../js/jsgrid/jsgrid.field.js"></script>
 
</head>
<body>	          
    <div>
        <p class="blue">   <a href="#"> Adimistraci&oacute;n de Cursos </a> -    Administraci&oacute;n General   </p>
    </div>
	 <div class="espacio">
        <label class="bold">Seleccionar a&ntilde;o:</label>
            <select id="yearField" class="form-control">
              
            </select>
            <button type="button" class="btn btn-primary" onclick="listar();"><i class="fa fa-list"></i> Listar</button>
            <button type="button" class="btn btn-primary"><i class="fa fa-save"></i> SALVAR</button>
        
    </div>

    <div>
        <p> <span class="nota_importante">NOTA 1 :</span> El campo <strong>"Abierto"</strong> siempre debe estar en <strong>No</strong>,  pues nosotros matriculamos manualmente a los usuarios.</p>
        <p> <span class="nota_importante">NOTA 2 :</span> Se pueden ordenar los cursos haciendo click en los campos subrayados (color blanco).</>
    </div>

   
   <div id="notas">
		<table id="tables">
			<thead class="lightblue">
				<tr>
					<th onclick="sortTable(0)">N°</th>
					<th onclick="sortTable(1)">id Curso</th>
					<th onclick="sortTable(2)">Período</th>
					<th onclick="sortTable(3)">Visible</th>
					<th onclick="sortTable(4)">Abierto</th>
					<th onclick="sortTable(5)">Patr&oacute;n</th>
					<th onclick="sortTable(6)">Subsanaci&oacute;n</th>
					<th onclick="sortTable(7)">inducci&oacute;n</th>
					<th onclick="sortTable(8)">Presencial</th>
					<th onclick="sortTable(9)">Público</th>
					<th onclick="sortTable(10)"> Fecha de inicio </th>
					<th onclick="sortTable(11)">Nombre</th>
					<th onclick="sortTable(12)">Secciones</th>
					<th onclick="sortTable(13)">inscritos</th>
					<th onclick="sortTable(14)">AP-HA</th>
					<th onclick="sortTable(15)">DE-HA </th>
					<th onclick="sortTable(16)"> RE/NP-HA </th>
				</tr>
			</thead>
			<tbody id="myTable" class="tbody">

				
			</tbody>
		</table>
		 <div class=" text-center">
			<ul class="pagination pagination-lg pager" id="myPager"></ul>
		</div>
   </div>
  
	
	 <div>
        <label><strong>LEYENDA :</strong></label>
        
        <ul >
            <li> <strong>AP-HA </strong> : Aprobados - de Historia Academica</li>
            <li> <strong> DE-HA </strong> : Desaprobados - de Historia Academica</li>
            <li> <strong>RE/NP-HA </strong> : Retirados y No participaron - de Historia Academica</li>
        </ul>
		<br>
         <button input="button" class="btn btn-primary" onclick="save();"><i class="fa fa-save"></i> SALVAR</button>
    </div> 

<script src="../js/filter/filter.js"></script>
<script src="../js/filter/thead.js"></script>

<script>
		var year="";
		function aunto_incre(){
			var select, i, option,actual;
			var fecha = new Date();
			year = fecha.getFullYear();
			select = document.getElementById("yearField");
			//document.getElementById("fecha").innerHTML = year;
			for (i=year;i>2005;i--)
			{	
				option = document.createElement('option');
				option.value = option.text = i;
				select.add( option );	
			}		
		}

	
		$(document).ready(function(){	 
			aunto_incre();
			listar();
		});
		
		var id = "";
		function listar(){
			$.ajax({
				url: "http://localhost/Api/Api/DAO/ADMINISTRACION_GENERAL.php?action=ListarA&ano_listar=" + year,
				type: "GET",
				dataType: "json",
				contentType: "application/json;charset=utf8",
				success: function (result) {
					 var html = "";
          
					var id_publico="";
					$.each(result, function(key,item)
					{
						html += '<tr>';
						html +='<td>1</td>';
						html +='<td>'+ item.id +'</td>';
						id= item.id;
						html +='<td id="periodo">'+ item.periodo +'</td>'
						
						if(item.visible =="1")
						{							 
							 html +='<td><label class="switch"><input type="checkbox" id="visible" checked><div class="slider round"></div></label></td>';	 
						}
						else
						{	
							 html +='<td><label class="switch"><input type="checkbox" id="visible"><div class="slider round"></div></label></td>';	 
						}
						
						if (item.enrollable =="1")
						{ 
							html +='<td><label class="switch"><input type="checkbox" id="enrollable" checked><div class="slider round"></div></label></td>';	 
						}
						else
						{	html +='<td><label class="switch"><input type="checkbox" id="enrollable"><div class="slider round"></div></label></td>';	 
						}
						
					    if(item.patron =="s")
					    {
							html +='<td><label class="switch"><input type="checkbox" id="patron" checked><div class="slider round"></div></label></td>';	 
					    }
						else
					    {
							html +='<td><label class="switch"><input type="checkbox" id="patron" ><div class="slider round"></div></label></td>';	 
					    }
						
						var subsax="";
						if(item.subsanacion=="s" || item.subsanacion =="S" )
						  {
							html +='<td><label class="switch"><input type="checkbox" id="subsanacion" checked><div class="slider round"></div></label></td>';	 
							subsax="s";
							
						  }
						else
						{
							  html +='<td><label class="switch"><input type="checkbox" id="subsanacion" ><div class="slider round"></div></label></td>';	 
							  subsax="n";
						}
						
						if(item.induccion =="s")
					    {
							html +='<td><label class="switch"><input type="checkbox" id="induccion" checked><div class="slider round"></div></label></td>';
							
					    }
						else
						{
							html +='<td><label class="switch"><input type="checkbox" id="induccion" ><div class="slider round"></div></label></td>';	
					    }
						

						if(item.presencial =="s")
					    {
							html +='<td><label class="switch"><input type="checkbox" id="presencial" checked><div class="slider round"></div></label></td>';
							
					    }
						else
					    {
							html +='<td><label class="switch"><input type="checkbox" id="presencial" ><div class="slider round"></div></label></td>';
					    }
					   
					    html += '<td><SELECT id="sel_publico" name="sel_publico"><OPTION  value="">N/E</OPTION><OPTION value="1">Ex Alumnos</OPTION><OPTION  value="2">Tr. Emp. Apor.</OPTION><OPTION  value="3">Alumnos SENATI</OPTION><OPTION value="4">Publico General</OPTION><OPTION value="5">Trabajadores SENATI</OPTION><OPTION  value="6">Equipo SENATI VIRTUAL</OPTIO</SELECT></td>';
						id_publico = item.id_publico;
						
						html +='<td>'+ item.startdate +'</td>';
						html +='<td> '+ item.fullname +'</td>';
						
						
						html +='<td>'+ item.numsections+'</td>';
						
						var total_inscritos="";
						if (item.Inscritos != "")  
						{
							html +='<td>'+ item.Inscritos +'</td>';
							total_inscritos=total_inscritos + 1 - 1 + item.inscritos;
						}
						
						var total_aprobado="";
						if (item.aprobados != "")  
						{
							html +='<td>'+ item.aprobados +'</td>';
							total_aprobado=total_aprobado + 1 - 1 + item.aprobados;
						}
						
						var total_desaprobados="";
						if (item.desaprobados != "")  
						{
							html +='<td>'+ item.desaprobados +'</td>';
							total_desaprobados=total_desaprobados + 1 - 1 + item.desaprobados;
						}
						
						var total_retinp="";
						if (item.retinp != "")  
						{
							html +='<td>'+ item.retinp +'</td>'
							total_retinp=total_retinp + 1 - 1 + item.retinp;
						}
					
						html +='</tr>';
						
						
						html +='<tr>';
						html +='<td colspan="9">Total</td>';
						html +='<td>'+ total_inscritos +'</td>';
						html +='<td>'+ total_aprobado +'</td>';
						html +='<td>'+ total_desaprobados +'</td>';
						html +='<td>'+ total_retinp +'</td>';
						html +='</tr>';
					});

					

					$('.tbody').html(html);
					select_publico(id_publico);		
					
				},
				error: function (errormessage) {
					alert(errormessage.responseText);
				}
			});
			
		}
	
		function save(){
			 var enrollable = document.getElementById("enrollable").checked;
			 var val_enrollable ="";
			 
			 if(val_enrollable === true)
			 {
				 val_enrollable = 1;
			 }else{
				 val_enrollable = 0;
			 }
			 
			 var visible = document.getElementById("visible").checked;
			 var val_visible =""; 
			 if(visible === true)
			 {
				 val_visible = 1;
			 }else{
				 val_visible = 0;
			 }
			 
			 var induccion = document.getElementById("induccion").checked;
			 var val_induccion =""; 
			 if(induccion === true)
			 {
				 val_induccion = "s";
			 }else{
				 val_induccion = "n";
			 }
	
			 
			 var subsana = document.getElementById("subsanacion").checked;
			 var val_subsana =""; 
			 if(subsana === true)
			 {
				 val_subsana = "s";
			 }else{
				 val_subsana = "n";
			 }
			 
			 
			 var presen = document.getElementById("presencial").checked;
			 var val_presenc =""; 
			 if(subsana === true)
			 {
				 val_presenc = "s";
			 }else{
				 val_presenc = "n";
			 }
			 
			var object = {
				periodo: $("#periodo").val(),
				enrollable: val_enrollable,
				visible: val_visible,
				subsanacion: val_subsana,
				induccion: val_induccion,
				presencial: val_presenc,
				id_publico: document.getElementById('sel_publico').options[document.getElementById('sel_publico').selectedIndex].text,
				id: id		
			};
			
			
			$.ajax({
				url: "http://localhost/Api/Api/DAO/ADMINISTRACION_GENERAL.php?action=ActualizarCAdmin",
				type: "GET",
				contentType: "application/json;charset=utf-8",
				dataType: "json",
				success: function(object){
				
								
				},
				error : function(xhr,errmsg,err) {
					 console.log(xhr.status + ": " + xhr.responseText);
				}
			});		
			
		}
	
		function select_publico(id_publico){
			if (id_publico == null)
			{
				$("#sel_publico option[value="+ null +"]").attr("selected",true);
									
			}		
			if (id_publico =="1")
			{
				$("#sel_publico option[value="+ 1 +"]").attr("selected",true);
									
			}	

			if (id_publico =="2")
			{
				$("#sel_publico option[value="+ 2 +"]").attr("selected",true);
			}

			if (id_publico =="3")
			{
				$("#sel_publico option[value="+ 3 +"]").attr("selected",true);
			}
								
			if (id_publico =="4")
								{
				$("#sel_publico option[value="+ 4 +"]").attr("selected",true);
			}
								
			if (id_publico =="5")
			{
				$("#sel_publico option[value="+ 5 +"]").attr("selected",true);
			}
								
			if (id_publico =="6")
			{
					$("#sel_publico option[value="+ 6 +"]").attr("selected",true);
			
			}
		}	
	

</script>

</body>	
</html>
