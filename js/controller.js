'use strict';


app.controller('MainCtrl', ['$scope', '$http', '$location', '$routeParams' , function($scope, $http, $location, $routeParams) {
  $scope.master = {};
  $scope.activePath = null;


  $http.get('api/users').success(function(data) {
    $scope.users = data;
  });

  $scope.deleteUser = function (user) { 
   var a = confirm('Are you sure you want to delete customer ' + user.name +'?');
   if (a) {
     $http.delete('api/users/' + user.id).success(function(){
      $location.path('/adminlist')
    });
   }
  }

 $scope.addUser = function(user, AddNewForm) {
    console.log(user);
    $http.post('api/addUser', user).success(function(){
      $scope.reset();
      $scope.activePath = $location.path('/');
    });
    $scope.reset();
  };

 $scope.reset = function() {
    $scope.user = angular.copy($scope.master);
  };
}]);



app.controller('UserCtrl', ['$scope', '$http', '$routeParams', '$resource', '$location', function($scope, $http, $routeParams, $resource, $location) {
  var userId = $routeParams.id;
  $scope.master = {};
  $scope.activePath = null;
    
  if (userId) {
      var User = $resource('api/user/' + userId);
      // Get User from API
      $scope.user = User.get();
  }   


  $scope.updateUser = function(user, AddNewForm) {
    console.log(user);
    $http.put('api/edit/' + $routeParams.id, user).success(function(){
      $scope.reset();
      $scope.activePath = $location.path('/');
    });
    $scope.reset();
};

 $scope.reset = function() {
    $scope.user = angular.copy($scope.master);
  };
}]);