

 <?php
// function millitime() {
//     $microtime = microtime();
//     $comps = explode(' ', $microtime);
  
//     // Note: Using a string here to prevent loss of precision
//     // in case of "overflow" (PHP converts it to a double)
//     return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
//   }
// Include the Simple ORM class
include 'SimpleOrm.class.php';

// Connect to the database using mysqli
$conn = new mysqli('localhost', 'akshay', 'akshay@123');

if ($conn->connect_error)
  die(sprintf('Unable to connect to the database. %s', $conn->connect_error));

// Tell Simple ORM to use the connection you just created.
SimpleOrm::useConnection($conn, 'ssdigitalindia');

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
  $stringData = json_decode($_POST["data"][0], true);
  echo $stringData["price"]." <br>";
  // echo  extract($_POST);
    if(isset($_FILES['support_images']['name']))
    {
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
                
                   $filename= time().basename($_FILES['support_images']['name'][$i]);                   
                   if(move_uploaded_file($_FILES['support_images']['tmp_name'][$i], $path.$filename)) 
                   { 
                      $file_name_all.=$filename."*";
                      echo "</br> $path"."$filename </br>";
                      echo json_encode($stringData, JSON_PRETTY_PRINT) ."<br>";

                      
                   }
             }
              $filepath = rtrim($file_name_all, '*').$path;   
                 
              // echo "Filepath = ".$filepath; 
        //  $query=mysqli_query($con,"INSERT into propertyimages (`propertyimage`) VALUES('".addslashes($filepath)."'); ");
        }

    }
    else
    {
        $filepath="";
        echo "Failed";
    }

    // if($query)
    // {
    //    header("Location: admin_profile.php");
    // }
}else{
  header('Location: '."/");
}

class Order extends SimpleOrm { 


}
 ?>