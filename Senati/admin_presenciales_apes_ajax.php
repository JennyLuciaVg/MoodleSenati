<?PHP
	require_once("../config.php");

	$apex=trim($_POST["apellidos"]);


	$query1 ="SELECT id, pidm_banner, firstname, lastname, campus from mdl_user where deleted=0 and upper(lastname) like '".  $apex. "%'";
	$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
	
echo "<table cellpsacing=2 cellpadding=2 border=1 bordercolor=blue>";
echo "<TR bgcolor=silver>\n";
echo "<TD><strong>ID User SV</strong></TD><TD><strong>Apellidos, Nombre</strong></TD><TD><strong>PIDM SINFO</strong></TD>\n";
echo "</TR>\n";

while($rot=pg_fetch_array($result1)) 
	{
	$id_sv=$rot["id"];
	$pidm=$rot["pidm_banner"];
	$firstname=$rot["firstname"];
	$lastname=$rot["lastname"];
	echo "<TR>\n";
	echo "<TD>". $id_sv ."</TD>\n";
	echo "<TD>". $lastname. ", ". $firstname ."</TD>\n";
	echo "<TD>". $pidm ."</TD>\n";
	echo "</TR>\n";
	}
echo "</TABLE>\n";
?>