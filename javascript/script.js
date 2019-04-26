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
app.controller("mainController", function($scope){

$scope.items = [];
$scope.grandAmountArray = [];

$scope.getSum = function(total, num) {
    return total + num;
  }


$scope.try = function(){
    console.log($scope.items);
    console.log($scope.grandAmount);
};

$scope.deleteImage = function(imageIndex){

    $scope.files.splice(imageIndex, 1); $scope.grandAmountArray.splice(imageIndex, 1)



}

});