<?php 
session_start();

if($_POST["uname"] == "Mahaveer" && $_POST["pass"]=="J3X(YUfz" && !$logedin){

    $_SESSION["logedin"] = true;
    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    exit;
}

$logedin = $_SESSION["logedin"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Area</title>

    <link rel="stylesheet" href="stylesheets//bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="javascript/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="stylesheets/style.css">
    <!-- <script src="javascript/script.js" type="text/javascript"></script> -->
    <style>
        html,
        body {
        height: 100%;
        overflow:hidden;
        
        }
        img#logo {
            width: 20%;
        }

        @media only screen and (max-width: 768px) {
            img#logo {
                width: 80%;
            }

        }
        .center-to-pg{
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body style="background : #252222;">

<?php
    if($logedin){
        require("./connection.php");
        $result = $conn->query("SELECT * FROM orders");

        ?>
<div class="container-fluid">
    <h1 class="text-white text-center my-2">Orders</h1>
       <table class="table table-hover table-dark">
  <thead>
    <tr>
      
      <th scope="col">Order ID</th>
      <th scope="col">Size</th>
      <th scope="col">Quantity</th>
      <th scope="col">Amount</th>
      <th scope="col">First Name</th>
      <th scope="col">Mobile</th>
      <th scope="col">Email</th>
      <th scope="col">Address</th>
      <th scope="col">City</th>
      <th scope="col">Pin Code</th>
      <th scope="col">Payment Status</th>
      <th scope="col">Image Path</th>
    </tr>
  </thead>
  <tbody> 

<?php         
        while($row = $result->fetch_assoc()){
?>


    <tr>
      
      <td><?php echo $row["order_id"];  ?></td>
      <td><?php echo $row["size"];  ?></td>
      <td><?php echo $row["quantity"];  ?></td>
      <td><?php echo $row["amount"];  ?></td>
      <td><?php echo $row["first_name"];  ?></td>
      <td><?php echo $row["mobile"];  ?></td>
      <td><?php echo $row["email"];  ?></td>
      <td><?php echo $row["address"];  ?></td>
      <td><?php echo $row["city"];  ?></td>
      <td><?php echo $row["pin_code"];  ?></td>
      <td><?php echo $row["payment_status"] ?  "Success" : "Failed";  ?></td>
      <td><a target="_black" href='<?php echo $row["image_path"];  ?>'> <?php echo $row["image_path"];  ?> </a></td>
      
    </tr>
   
 <?php  
    };

    ?>


</tbody>
    </table>
    </div>
<?php
    }else{
?>

<div class="center-to-pg" >
  <div class="mx-auto align-middle" style="background:red">
    <div class="card">
        <div class="card-header">
            Login
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="uname" name="uname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="username">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
  </div>
</div>

    <div id="particles-js">
        <nav class="navbar  text-white justify-content-center ">
        <a class="navbar-brand text-white" href="/">
            <!-- <img src="/docs/4.3/assets/brand/bootstrap-solid.svg" width="30" height="30"          class="d-inline-block align-top" alt=""> -->
            <h2 class="font-weight-bold text-center mt-3">
                <img src="images/SS_Digital_India_logo.png" alt="Online web studio..." title="Online web studio..."
                    class="img-fluid mx-auto" id="logo">
            </h2>
        </a>
    </nav>
    </div>

   




<script src="javascript/particles.min.js" ></script>
<script>
particlesJS.load('particles-js', 'javascript/particlesjs-config.json', function() {
  console.log('config loaded');
});
</script>

<?php }?>
</body>
</html>
