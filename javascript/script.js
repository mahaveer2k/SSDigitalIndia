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
app.controller("mainController", function($scope, $http){

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

$scope.upload = function(){

    var uploadForm = new FormData();

    console.log("$scope.items = ",$scope.items);

    uploadForm.append('support_images[]', $scope.files[0]._file);
    uploadForm.append('submit', "submit");

    return;
    $http.post('photo_upload.php', uploadForm, {
        withCredentials: true,
        transformRequest:angular.identity, 
        headers: {'Content-Type':undefined, 'Process-Data': false},
        uploadEventHandlers: {
            progress: function(e){
                if (e.lengthComputable) {
                    var progressBar = (e.loaded / e.total) * 100;
                    console.log(progressBar);
                    //here you will get progress, you can use this to show progress
                }
            }
        }
    }).then(function(response){
        console.log(response);
        
    })



};


$scope.uploadTest = function(){
    console.log($scope.files);

    var formdata = new FormData();
    formdata.append("fileToUpload", $scope.files);

    $http({
        method : "POST",
        url : "/imageUpload.php",
        headers: {
            'Content-Type': undefined
        },
        params: {
            formdata
          },
        data:{
            formdata
        },
        transformRequest: angular.identity,
        withCredentials : false,
    }).
    then(function(result) {
        console.log(result);
      
    });

}

});