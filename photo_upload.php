

 <?php
function millitime() {
    $microtime = microtime();
    $comps = explode(' ', $microtime);
  
    // Note: Using a string here to prevent loss of precision
    // in case of "overflow" (PHP converts it to a double)
    return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
  }



//   echo millitime();


  if(isset($_POST['submit']))           
{
 extract($_POST);

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
                  $size = $_FILES['support_images']['size'][$i];

                   list($txt, $ext) = explode(".", $name);
                   $file= time().substr(str_replace(" ", "_", $txt), 0);
                   $info = pathinfo($file);
                   $filename = $file.".".$ext;
                   if(move_uploaded_file($_FILES['support_images']['tmp_name'][$i], $path.$filename)) 
                   { 
                      $file_name_all.=$filename."*";
                   }
             }
              $filepath = rtrim($file_name_all, '*').$path;   
              echo $filepath; 
        //  $query=mysqli_query($con,"INSERT into propertyimages (`propertyimage`) VALUES('".addslashes($filepath)."'); ");
        }

    }
    else
    {
        $filepath="";
    }

    // if($query)
    // {
    //    header("Location: admin_profile.php");
    // }
}

 ?>