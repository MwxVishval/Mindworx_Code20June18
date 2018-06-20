<?php

$con1 = mysqli_connect("localhost", "root", "root", "Qmobilityv2");
$con2 = mysqli_connect("localhost", "root", "root", "Qmobilityv3");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = 'SELECT DISTINCT value FROM `qm_product_line`';
$result = $con1->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
		
		echo "<pre>";
		print_r($row['value']);
		echo "</pre>";
       
         $sql2 = 'INSERT INTO `qm_select_value (task_type_id,select_option_id,option_value,depond_value) VALUES(1,25,'.$row["value"].',"")';
         if ($con2->query($sql2) === TRUE) {
         echo "New record created successfully";
        } else {
           echo "Error: " . $sql2 . "<br>" . $con2->error;
        }
}
} else {
    echo "0 results";
}
$con1->close();
?>

