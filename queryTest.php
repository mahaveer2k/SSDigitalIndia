<?php 

require "./connection.php";

$stmt = $conn->prepare('SELECT * FROM orders');

$stmt->execute();
$result = $stmt->get_result();

$rates = '{

    "03.00" :"3.5 x 5",
    "06.00" : "4 x 6",
    "08.00" : "5 x 7",
    "10.00" : "6 x 8",
    "15.00" : "8 x 10",
    "20.00" : "8 x 12",
    "25.00" : "10 x 12",
    "30.00" : "12 x 15",
    "35.00" : "12 x 18",
    "40.00" : "12 x 24",
    "50.00" : "12 x 36",
    "60.00" : "16 x 20",
    "80.00" : "20 x 24",
    "150.00" : "20 x 30",
    "180.00" : "24 x 36",
    "200.00" : "30 x 40",
    "32" : "passport"
  
  
  }';



  $ratesJson = json_decode( $rates, true );


  echo $ratesJson["35.00"];





while($row= $result->fetch_assoc()){
    
    // print_r($row);
    echo $row["id"]. " " .$row["size"]. " " .$row["quantity"]. " " . $row["amount"] . " " 
    . $row["order_id"]. " " . $row["created_at"]. " " . $row["first_name"]. " " . $row["mobile"]. " "  . $row["email"]. " " 
    . $row["address"]. " " . $row["city"]. " " . $row["pin_code"]. " " . $row["country"]. " " . $row["payment_status"]. " " . $row["image_path"];
    echo "<br>";
    echo "<br>";
    echo "<br>";
}

?> 