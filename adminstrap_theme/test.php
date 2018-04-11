<html>

<head>

//css

<style>

table

{

border-style:solid;

border-width:2px;

border-color:pink;

}

</style>

</head>

<body bgcolor="#EEFDEF">

<?php
require_once 'config.php';
/*$con = mysql_connect("localhost","root","");

if (!$con)

  {

  die('Could not connect: ' . mysql_error());

  }

 

mysql_select_db("smart", $con);

*/ 

$sql ="SELECT expid,taskid FROM taskexp";

 

echo "<table border='1'>

<tr>

<th>expid</th>

<th>taskid</th>

</tr>";

 if($result = $pdo->query($sql)){
echo"dd";
while($row = $result->fetch())

  {

  echo "<tr>";

  echo "<td>" . $row['expid'] . "</td>";

  echo "<td>" . $row['taskid'] . "</td>";

  echo "</tr>";

  }
 }
echo "</table>";

 

//mysql_close($con);

?>

</body>

</html>