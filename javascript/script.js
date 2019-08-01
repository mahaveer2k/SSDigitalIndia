var app = angular.module("ssApp", []);

app.directive('ngFileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.ngFileModel);
            var isMultiple = attrs.multiple;
            var modelSetter = model.assign;
            element.bind('change', function () {
                var values = [];
                angular.forEach(element[0].files, function (item) {
                    var value = {
                       // File Name 
                        name: item.name,
                        //File Size 
                        size: item.size,
                        //File URL to view 
                        url: URL.createObjectURL(item),
                        // File Input Value 
                        _file: item
                    };
                    values.push(value);
                });
                scope.$apply(function () {
                    if (isMultiple) {
                        modelSetter(scope, values);
                    } else {
                        modelSetter(scope, values[0]);
                    }
                });
            });
        }
    };
}]);
app.controller("mainController", function($scope, $http, $q){

$scope.items = [];
$scope.grandAmountArray = [];

var rates = {

    "03.00" :"",
    "06.00" : "",
    "08.00" : "",
    "10.00" : "",
    "15.00" : "",
    "20.00" : "",
    "25.00" : "",
    "30.00" : "",
    "35.00" : "",
    "40.00" : "",
    "50.00" : "",
    "60.00" : "",
    "80.00" : "",
    "150.00" : "",
    "180.00" : "",
    "200.00" : "",
    "32" : "passport"


};

$scope.states = [
    {
        "state": "Arunachal Pradesh"
    },
    {
        "state": "Assam"
    },
    {
        "state": "Bihar"
    },
    {
        "state": "Chandigarh"
    },
    {
        "state": "Chhattisgarh"
    },
    {
        "state": "Dadra Nagar Haveli"
    },
    {
        "state": "Daman Diu"
    },
    {
        "state": "Delhi"
    },
    {
        "state": "Goa"
    },
    {
        "state": "Gujarat"
    },
    {
        "state": "Haryana"
    },
    {
        "state": "Himachal Pradesh"
    },
    {
        "state": "Jammu Kashmir"
    },
    {
        "state": "Jharkhand"
    },
    {
        "state": "Karnataka"
    },
    {
        "state": "Kerala"
    },
    {
        "state": "Lakshadweep"
    },
    {
        "state": "Madhya Pradesh"
    },
    {
        "state": "Maharashtra"
    },
    {
        "state": "Manipur"
    },
    {
        "state": "Meghalaya"
    },
    {
        "state": "Mizoram"
    },
    {
        "state": "Nagaland"
    },
    {
        "state": "Odisha"
    },
    {
        "state": "Puducherry"
    },
    {
        "state": "Punjab"
    },
    {
        "state": "Rajasthan"
    },
    {
        "state": "Sikkim"
    },
    {
        "state": "Tamil Nadu"
    },
    {
        "state": "Telangana"
    },
    {
        "state": "Tripura"
    },
    {
        "state": "Uttar Pradesh"
    },
    {
        "state": "Uttarakhand"
    },
    {
        "state": "West Bengal"
    }
]


$scope.getSum = function(total, num) {
    return total + num;
  }


$scope.try = function(){
    console.log($scope.items);
    console.log($scope.grandAmount);
};

$scope.deleteImage = function(imageIndex){

    $scope.files.splice(imageIndex, 1); $scope.grandAmountArray.splice(imageIndex, 1)
};

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

$scope.upload = function(e){

    e.preventDefault();

    $('#registerModal').modal('toggle')

    var uploadForm = new FormData();

    console.log("$scope.items = ",$scope.items);

    for(i =0;i < $scope.files.length;i++){
        uploadForm.append('support_images['+i+']', $scope.files[i]._file);
        uploadForm.append("data["+i+"]", JSON.stringify($scope.items[i]));
        console.log($scope.items[i]);
    }
    
    console.log("getFormData($('#payment_form')) = ",getFormData($('#payment_form')));
    uploadForm.append("customer", JSON.stringify(getFormData($('#payment_form'))));
    uploadForm.append('submit', "submit");


    // return;
    $scope.showProgress = true;

    var res = Array.from(uploadForm.entries(), ([key, prop]) => (
        {[key]: {
          "ContentLength": 
          typeof prop === "string" 
          ? prop.length 
          : prop.size
        }
      }));

    console.log(res);



    $http.post('photo_upload.php', uploadForm, {
        withCredentials: true,
        transformRequest:angular.identity, 
        headers: {'Content-Type':undefined, 'Process-Data': false},
        timeout:300000,
        uploadEventHandlers: {
            progress: function(e){
                if (e.lengthComputable) {
                    var progressBar = (e.loaded / e.total) * 100;
                    $scope.progressNow= Math.round(progressBar);
                    console.log(progressBar);
                    //here you will get progress, you can use this to show progress
                }
            }
        }
    }).then(function(response){
        console.log(response);
        $scope.showProgress = false;
        launchBOLT();
    }, function(err){
        alert("error occur!!");
        $scope.showProgress = false;
        console.log("err", err);
    })



};
});