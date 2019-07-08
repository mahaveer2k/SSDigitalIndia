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
    <script src="javascript/script.js" type="text/javascript"></script>
    <style>
        /* html,
        body {
        height: 100%
        } */
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

<div class="center-to-pg" >
  <div class="mx-auto align-middle" style="background:red">
    <div class="card">
        <div class="card-header">
            Login
        </div>
        <div class="card-body">
            <form action="" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="uname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="username">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
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
  console.log('callback - particles.js config loaded');
});
</script>
</body>
</html>
