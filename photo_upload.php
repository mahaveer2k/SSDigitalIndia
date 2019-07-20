<?php
function millitime() {
    $microtime = microtime();
    $comps = explode(' ', $microtime);
  
    // Note: Using a string here to prevent loss of precision
    // in case of "overflow" (PHP converts it to a double)
    return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
  }

// Connect to the database using mysqli
require("./connection.php");

class Orders{ 

  var $size;
  var $quantity;
  var $amount;
  var $orderID;
  var $first_name;
  var $mobile;
  var $email;
  var $address;
  var $city;
  var $pin_code;
  var $country;
  var $c;
  var $image_path;

  function __construct($c){
    $this->c = $c;
  }

  function save(){
    $s = $this->size;
    $q = $this->quantity;
    $a = $this->amount;
    $o = $this->orderID;
    $f = $this->first_name;
    $m = $this->mobile;
    $e = $this->email;
    $add = $this->address;
    $ci = $this->city;
    $p = $this->pin_code;
    $country = $this->country;
    $i_path = $this->image_path;

    $stmt = $this->c->prepare('INSERT INTO orders (size, quantity, amount, order_id, first_name, mobile, email, address, city, pin_code, country, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param("ssssssssssss", $s, $q, $a, $o, $f, $m, $e, $add, $ci, $p, $country, $i_path);
    $stmt->execute();

  }
}

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

// echo(json_decode( $rates, true )["03.00"])."<br>";


  if(isset($_POST['submit']))           
{
 
  // echo  extract($_POST);
    if(isset($_FILES['support_images']['name']))
    {
        $customer = json_decode($_POST["customer"], true);
        // error_log($customer);
        
        $file_name_all="";
        for($i=0; $i<count($_FILES['support_images']['name']); $i++) 
        {
               $tmpFilePath = $_FILES['support_images']['tmp_name'][$i];    
               if ($tmpFilePath != "")
               {    
                  $path = "uploads/"; // create folder 
                  $name = $_FILES['support_images']['name'][$i];
                  // echo "<br> basename = ".basename($_FILES['support_images']['name'][$i])." <br>";
                  $size = $_FILES['support_images']['size'][$i];
                  $stringData = json_decode($_POST["data"][$i], true);
                
                   $filename= time()."_".basename($_FILES['support_images']['name'][$i]);                   
                   if(move_uploaded_file($_FILES['support_images']['tmp_name'][$i], $path.$filename)) 
                   { 
                      error_log(var_export($customer, true), 4);
                      error_log(var_export($stringData, true), 4);
                      $orders = new Orders($conn);
                      $orders->size = $stringData["size"];
                      $orders->quantity = $stringData["quantity"];
                      $orders->amount = $stringData["price"];
                      $orders->orderID = $customer["txnid"];
                      $orders->first_name = $customer["fname"];
                      $orders->mobile = $customer["mobile"];
                      $orders->email = $customer["email"];
                      $orders->address = $customer["address"];
                      $orders->city = $customer["city"];
                      $orders->pin_code = $customer["pin_code"];
                      $orders->country = $customer["country"];
                      $orders->image_path = $path.$filename;
                      $orders->save();

                      $file_name_all.=$filename."*";
                      echo "</br> $path"."$filename </br>";
                      echo json_encode($stringData, JSON_PRETTY_PRINT) ."<br>";

                      
                   }
             }
              $filepath = rtrim($file_name_all, '*').$path;   
                 
              // echo "Filepath = ".$filepath; 
        //  $query=mysqli_query($con,"INSERT into propertyimages (`propertyimage`) VALUES('".addslashes($filepath)."'); ");
        }

        http_response_code(200);

    }
    else
    {
        $filepath="";
        echo "files not found!";
        http_response_code(500);
    }

    // if($query)
    // {
    //    header("Location: admin_profile.php");
    // }
}else{
  header('Location: '."/");
}


 ?>