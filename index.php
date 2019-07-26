<?php
$test = true;

function millitime()
{
    $microtime = microtime();
    $comps = explode(' ', $microtime);

    // Note: Using a string here to prevent loss of precision
    // in case of "overflow" (PHP converts it to a double)
    return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
}
if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {
    //Request hash
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if (strcasecmp($contentType, 'application/json') == 0) {
        $data = json_decode(file_get_contents('php://input'));
        // $hash=hash('sha512', $data->key.'|'.$data->txnid.'|'.$data->amount.'|'.$data->pinfo.'|'.$data->fname.'|'.$data->email.'|||||'.$data->udf5.'||||||'.$data->salt);
        $hash = hash('sha512', $data->key . '|' . $data->txnid . '|' . $data->amount . '|' . $data->pinfo . '|' . $data->fname . '|' . $data->email . '|||||' . $data->udf5 . '||||||' . $data->salt);
        $json = array();
        $json['success'] = $hash;
        echo json_encode($json);

    }
    exit(0);
}

function getCallbackUrl()
{
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . 'response.php';
}

?>

<html ng-app="ssApp">

<head>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="theme-color" content="#118496" />

    <link rel="stylesheet" href="stylesheets//bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="javascript/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="stylesheets/style.css">
    <script src="javascript/script.js" type="text/javascript"></script>

    <link href="images/favicon.png"  rel="icon" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <?php  if($test){ ?>
        <!-- BOLT Sandbox/test //-->
        <script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="images/SS_Digital_India_logo.png"></script> 
    <?php }else{
    ?>
        <!-- BOLT Production/Live //-->
        <script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="images/SS_Digital_India_logo.png"></script>

    <?php }?>

    <style>
    img#logo {
        width: 20%;
    }

    @media only screen and (max-width: 768px) {
        img#logo {
            width: 80%;
        }

    }
    </style>
</head>

<body ng-controller="mainController">
    <!-- Image and text -->
    <nav class="navbar  text-white justify-content-center ">
        <a class="navbar-brand text-white" href="/">
            <!-- <img src="/docs/4.3/assets/brand/bootstrap-solid.svg" width="30" height="30"          class="d-inline-block align-top" alt=""> -->
            <h2 class="font-weight-bold text-center mt-3">
                <img src="images/SS_Digital_India_logo.png" alt="Online web studio..." title="Online web studio..."
                    class="img-fluid mx-auto" id="logo">
            </h2>
        </a>
    </nav>
    <!-- <h1>Mahaveer Prasad Meena </h1> -->
    <div class="container p-5 mb-5 bg-light    ">
        <label class="btn btn-primary shadow-sm " style="background: #d87715; border-color:#d87715;">
            <strong>Choose Files</strong>
            <input i1d="fileupload" type="file" multiple="multiple" accept="image/*" style="display:none;"
                ng-file-model="files" />
        </label>
        <hr />
        <b>Live Preview</b>
        <br>

        <span class="badge badge-pill badge-success" id="imageCount" ng-show="files">
            {{files.length + " Total Images"}}
        </span>
        <br />
        <br />
        <div id="dvPreview">
        </div>

        <div class="row">
            <div class=" d-inline-block my-1 card col-md-6 text-center" ng-repeat="file in files">
                <button type="button" class="close" ng-click="deleteImage($index);" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row">
                    <div class="col-md-4 col-12 p-1">
                        <img src="{{file.url}}" alt="" class="d-block img-fluid"
                            style="background-position: center center; background-repeat: no-repeat;">
                    </div>
                    <div class="col-md-3">

                        <p class="text-muted">Size (inche) :</p>

                        <select id="mySelect" ng-model="items[$index].size" class="form-control"
                            style="font-size: small;color: #d87715;" ng-disabled="!files.length">
                            <option value disabled>Select</option>
                            <optgroup label="Passport Size">
                                <option value="32">Passport</option>

                            </optgroup>
                            <optgroup label="Standard Size">
                                <option value="03.00">3.5 x 5"</option>
                                <option value="06.00">4 x 6"</option>
                                <option value="08.00">5 x 7"</option>
                                <option value="10.00">6 x 8"</option>
                                <option value="15.00">8 x 10"</option>
                                <option value="20.00">8 x 12"</option>
                            </optgroup>
                            <option value="25.00">10 x 12"</option>
                            <option value="30.00">12 x 15"</option>
                            <option value="35.00">12 x 18"</option>
                            <option value="40.00">12 x 24"</option>
                            <option value="50.00">12 x 36"</option>
                            <option value="60.00">16 x 20"</option>
                            <option value="80.00">20 x 24"</option>
                            <option value="150.00">20 x 30"</option>
                            <option value="180.00">24 x 36"</option>
                            <option value="200.00">30 x 40"</option>
                        </select>

                    </div>
                    <div class="col-md-3">

                        <p class="text-muted">Quantity :</p>
                        <select id="qtyn" class="form-control" ng-model="items[$index].quantity"
                            ng-if="items[$index].size != 32" style="font-size: small;color: #d87715;"
                            ng-disabled="!files.length">
                            <option value disabled>Qty</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>

                        <select id="qtyn" class="form-control" ng-model="items[$index].quantity"
                            ng-if="items[$index].size == 32" style="font-size: small;color: #d87715;"
                            ng-disabled="!files.length">
                            <option value disabled>Qty</option>
                            <option value="1">32</option>

                        </select>

                    </div>

                    <div class="col-md-2">
                        <p class="text-muted">Amount</p>
                        <p id="qdemo" class="p-2 h6 align-middle text-success text-nowrap" style="font-size: small;"
                            ng-if="items[$index].size && items[$index].quantity && files.length">
                            Rs. {{ items[$index].price =  items[$index].size * items[$index].quantity }} </p>
                        <span init="{{$parent.grandAmountArray[$index] = items[$index].price}}"></span>


                    </div>

                </div>

            </div>


        </div>

    </div>
    <hr>
    <br>
    <div class="container bg-white">



        <div class="row ">
            <div class="col-12 text-center">
                <p id="qdemo" class="p-2 h4 align-middle text-success" ng-if="grandAmountArray.reduce(getSum)"
                    style="font-family: DejaVu Sans; font-size:20px">
                    Payable Amount: <span style="color:#d87715;">Rs. {{grandAmountArray.reduce(getSum)}}</span>
                </p>
            </div>

        </div>
    </div>

    <hr>

    <div class="text-center align-items-center bg-white">
        <div class="container" ng-if="showProgress">
            <div class="progress ">
                <div class="progress-bar progress-bar-striped progress-bar-animated  bg-success" role="progressbar" 
                    aria-valuenow="{{progressNow}}" aria-valuemin="0" aria-valuemax="100" style="width: {{progressNow}}%">{{progressNow}}%</div>
            </div>
        </div>
        <p ng-if="!showProgress">
            <button id="porder" class="btn btn-success font-weight-bold" data-toggle="modal"
                data-target="#registerModal" ng-disabled=" !grandAmountArray.length || !files.length"
                n1g-click="upload()">Place
                Order</button>
        </p>
        <!-- <button ng-click="uploadTest()"> Upload</button> -->
    </div>


    <!-- Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Order Now</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <form action="" id="payment_form">
                            <input type="hidden" id="udf5" name="udf5" value=" " />
                            <!-- <input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" /> -->
                            <input type="hidden" id="surl" name="surl" value="<?php echo getCallbackUrl(); ?>" />
                            <input type="hidden" id="key" name="key" placeholder="Merchant Key" value="aJMIEQV4" />
                            <input type="hidden" id="salt" name="salt" placeholder="Merchant Salt" value="6ShWIUoEIp" />

                            <?php
$txnid = "SSDIN-" . millitime();
?>

                            <input type="hidden" id="txnid" name="txnid" placeholder="Transaction ID"
                                value="<?php echo $txnid; ?>" />
                            <input type="hidden" id="amount" name="amount" placeholder="Amount"
                                ng-value="grandAmountArray.reduce(getSum)" readonly />
                            <input type="hidden" id="pinfo" name="pinfo" placeholder="Product Info" value="P01,P02" />


                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text" id="fname" name="fname" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile No.</label>
                                <input type="text" id="mobile" name="mobile" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="pin">Pin Code</label>
                                <input type="text" id="pin" name="pin_code" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <input readonly type="text" id="country" name="country" value="India" class="form-control" />
                            </div>
                            <input type="hidden" id="hash" name="hash" placeholder="Hash" value="" />
                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="submit" class="btn btn-primary" onclick="launchBOLT(); return false;" >Save changes</button> -->
                    <button type="button" class="btn btn-primary" ng-click="upload()">Place Order</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-white text-center footer navbar-fixed-bottom z--1000">
        <div class="container">
            <div class="h6">
                <!-- <div> Quick Links </div> -->
                <nav class="navbar navbar-expand-lg navbar-light justify-content-center  text-white">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">About us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="service.html">Service</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faq.html">FAQs</a>
                        </li>
                    </ul>
                </nav>
            </div>


        </div>
        <div class="card-footer text-muted text-center">
            All Right Reserved | © 2019 SS Digital India
        </div>
    </footer>

    <script type="text/javascript">
    <!--
    $('#payment_form').bind('keyup blur', function() {
        console.log("$('#salt').val() = ",$('#salt').val());
        $.ajax({
            url: 'index.php',
            type: 'post',
            data: JSON.stringify({
                key: $('#key').val(),
                salt: $('#salt').val(),
                txnid: $('#txnid').val(),
                amount: $('#amount').val(),
                pinfo: $('#pinfo').val(),
                fname: $('#fname').val(),
                email: $('#email').val(),
                mobile: $('#mobile').val(),
                udf5: $('#udf5').val()
            }),
            contentType: "application/json",
            dataType: 'json',
            success: function(json) {
                if (json['error']) {
                    $('#alertinfo').html('<i class="fa fa-info-circle"></i>' + json['error']);
                } else if (json['success']) {
                    $('#hash').val(json['success']);
                }
            }
        });
    });
    //-->
    </script>

    <script type="text/javascript">
    <!--
    function launchBOLT() {
        bolt.launch({
            key: $('#key').val(),
            txnid: $('#txnid').val(),
            hash: $('#hash').val(),
            amount: $('#amount').val(),
            firstname: $('#fname').val(),
            email: $('#email').val(),
            phone: $('#mobile').val(),
            productinfo: $('#pinfo').val(),
            udf5: $('#udf5').val(),
            surl: $('#surl').val(),
            furl: $('#surl').val(),
            mode: 'dropout'
        }, {
            responseHandler: function(BOLT) {
                console.log(BOLT.response.txnStatus);
                if (BOLT.response.txnStatus != 'CANCEL') {

                    var fr = '<form action=\"' + $('#surl').val() + '\" method=\"post\">' +
                        '<input type=\"hidden\" name=\"key\" value=\"' + BOLT.response.key + '\" />' +
                        // '<input type=\"hidden\" name=\"salt\" value=\"' + $('#salt').val() + '\" />' +
                        '<input type=\"hidden\" name=\"txnid\" value=\"' + BOLT.response.txnid + '\" />' +
                        '<input type=\"hidden\" name=\"amount\" value=\"' + BOLT.response.amount + '\" />' +
                        '<input type=\"hidden\" name=\"productinfo\" value=\"' + BOLT.response.productinfo +
                        '\" />' +
                        '<input type=\"hidden\" name=\"firstname\" value=\"' + BOLT.response.firstname +
                        '\" />' +
                        '<input type=\"hidden\" name=\"email\" value=\"' + BOLT.response.email + '\" />' +
                        '<input type=\"hidden\" name=\"udf5\" value=\"' + BOLT.response.udf5 + '\" />' +
                        '<input type=\"hidden\" name=\"mihpayid\" value=\"' + BOLT.response.mihpayid +
                        '\" />' +
                        '<input type=\"hidden\" name=\"status\" value=\"' + BOLT.response.status + '\" />' +
                        '<input type=\"hidden\" name=\"hash\" value=\"' + BOLT.response.hash + '\" />' +
                        '</form>';
                    var form = jQuery(fr);
                    jQuery('body').append(form);
                    form.submit();
                }
            },
            catchException: function(BOLT) {
                alert(BOLT.message);
            }
        });
    }
    //--
    </script>
</body>

</html>