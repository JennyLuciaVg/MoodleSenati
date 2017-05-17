<?php
	
        class Conexion  {
            
            
			function initConnection(){
			    $servername = "192.168.1.40";
			    $username = "root";
			    $password = "Standar*1";
			    $db = "moodle";
			    // Create connection
				
				try {

						$conn = new mysqli($servername, $username, $password,$db);
						return $conn;
					}
					catch (Exception $e) {
					    // not a MySQL exception
					    echo $e->getMessage();
					   
				}	

			}
        }
 	

?>