<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="iE=edge">
	<meta charset="utf-8">
    <title>SV: Historia Academica - Acta de Notas Oficial</title>
    <link rel="stylesheet" type="text/css" href="../../css/demos.css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../../css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../css/theme.css" />

    <script src="../../js/jquery/jquery-1.8.3.js"></script>
	<script src="../../data/db.js"></script>
	<link rel="stylesheet" href="../../css/font-awesome.css">
    <script src="../../js/jsgrid/jsgrid.core.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-indicator.js"></script>
    <script src="../../js/jsgrid/jsgrid.load-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.sort-strategies.js"></script>
    <script src="../../js/jsgrid/jsgrid.field.js"></script>

</head>
<body>	       <img src="../../img/image001.png" />   

	<div>
		<p class="blue"><a href="#"> Historia Academica </a> - Actas de Notas Oficial</p>
	</div>
	<div>
		 <table >
		   <tbody>
				<tr>
					<th>iD Curso SENATi</th>
					<td>43</td>
				</tr>
				<tr>
					<th>Nombre Curso SENATi</th>
					<td>
						<a href="#"> ATENCiON AL CLiENTE(ATCL)</a>
					</td>
				</tr>
				<tr>
					<th>iD Curso Moodle</th>
					<td>7305</td>
				</tr>            
				<tr>
					<th>Nombre Curso Moodle</th>
					<td>
						<a href="#"> ATENCiON AL CLiENTE(ATCL) 201620 - Grupo B - Zonal LiMA CALLAO</a>
					</td>
				</tr>
				<tr>
					<th>Fecha de inicio</th>
					<td>24-10-2016</td>
				</tr>
				<tr>
					<th>Tutor(es)</th>
					<td>JOSE, CiEZA HERMOZA</td>
				</tr>                   
		   </tbody>
		</table>
	</div>
   
    <div>
		<p class="red">NOTA: La sesi&oacute;n de modificaci&oacute;n de estos datos será registrada en detalle por motivos de seguridad  </p>
    </div>
    <div id="botones">
		<a type="button" href="#" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Acta </a>
        <a type="button" href="#" class="btn btn-primary"><i class="fa fa-retweet" aria-hidden="true"></i> Resetear </a>
        <a type="button" href="#" class="btn btn-primary"><i class="fa fa-reply" aria-hidden="true"></i> Regresar </a>
        <a type="button" href="#" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> GUARDAR </a> 
    </div>

    <div>
		 <table>
			<thead class="lightblue">
				<tr>
					<th>N°</th>
					<th>id Moodle</th>
					<th>PiDM SiNFO</th>
					<th>Apellidos, Nombres</th>
					<th>NRC</th>
					<th>Ciudad</th>
					<th>Nota</th>
					<th>Estado</th>
				</tr>
			</thead>    
		   <tbody>
				<tr>
					<td>1</td>
					<td>181678</td>
					<td>887303</td>
					<td>ABAD MAGUi&ntilde;A, AARON SANTiAGO</td>
					<td>19</td>
					<td>Lima</td>
					<td><input type="text" class="form-control" size=4/></td>
					<td><select class="form-control">
							<option>Aprobado</option>
							<option>Desaprobado</option>
							<option>Retirado</option>
							<option>No particip&oacute;</option>
						</select>
					</td>
				</tr>
		   </tbody>
		</table>
    </div>

    <div id="jsGrid1"></div>
	

	<script>

		var dataActa = [
			{ 
				"numero": 1,
				"idMoodle": 123123,
				"PiDM": 9876544,
				"apellidos_nombres": "ABAD MAGUiñA, AARON SANTiAGO",
				"NRC": 15,
				"ciudad": "Lima",
				"Nota": 12,
				"Estado": 2
			},
			{ 
				"numero": 2,
				"idMoodle": 7894566,
				"PiDM": 1234565,
				"apellidos_nombres": "ABAD, AARON SANTiAGO",
				"NRC": 12,
				"ciudad": "Lima",
				"Nota": 15,
				"Estado": 2
			},
						{ 
				"numero": 3,
				"idMoodle": 456456,
				"PiDM": 1234565,
				"apellidos_nombres": "ABAD MAGUiñA, SANTiAGO",
				"NRC": 19,
				"ciudad": "Lima",
				"Nota": 13,
				"Estado": 2
			}
		]
		
        $("#jsGrid1").jsGrid({
            height: "auto",
            width: "70%	",
            autoload: true,
            sorting: true,
            paging: true,
            pageSize: 4,
            selecting: false,
            //	controller: db,
            controller: {
		        loadData: function() {
		            return dataActa;
		        }
		    },
            fields: [
                { type: "number", name: "numero", width: 10, title: "N°" },
    			{ type: "number", name: "idMoodle" , width: 10, title: "id Moodle" },
    			{ type: "number", name: "PiDM", width: 10, title: "PiDM SiNFO"},
    			{ type: "text", name: "apellidos_nombres" , width: 35, title: "Apellidos, Nombres" },
    			{ type: "text", name: "NRC", width: 10, title: "NRC"},
    			{ type: "text", name: "ciudad", width: 10, title: "Cuidad"},
    			{
                	headerTemplate: function(){
               			return $("<p>").text("Nota");
               		},
              		itemTemplate: function(_, item){
                		return $("<input type='text'>").addClass('form-control').attr('size', '4');
               		},
               		width:15
                },
                {
                  	headerTemplate: function(){
                  		return $("<p>").text("Estado");
                  	},
                  	itemTemplate: function(_, item){

						var myOptions = {
							'0' : 'Aprobado',
							'1' : 'Desaprobado',
							'2' : 'Retirado',
							'3' : 'No participó'
						};

						var _select = $('<select>');
						$.each(myOptions, function(val, text) {
							if(val == item.publico)
								return $('<option>', {val: val, text: text}).appendTo(_select).attr('selected', 'selected');
							else
								return $('<option>', {val: val, text: text}).appendTo(_select);
						});
						
						return $('<select>').append(_select.html());
					},
					width: 25
                }



			]
        });



	</script>
	

       <img src="../../img/image002.png" />     </body>	
</html>