'use strict';

var JWTApp = angular.module('JWTApp', ['ngCookies']);

JWTApp.controller('mainCtrl', ['$scope', '$cookies', 'requestApi', function($scope, $cookies, requestApi) {
  $scope.data = {};

  $scope.login = function() {
    requestApi.login($scope.timeStart, $scope.timeLife).then(function(resp) {
      if (resp.status) {
        $scope.data.login = resp;
        $scope.access_token = resp.data.jwt;
        $cookies.put('jwt', resp.data.jwt);
      }
    });
  };

  $scope.request = function() {
    requestApi.request($scope.access_token).then(function(resp) {
      $scope.data.request = resp;
    });
  };
}]);

JWTApp.service('requestApi', ['$http', function($http) {
  var login = function(timeStart, timeLife) {
  	var url = "api/api-login.php?action=login&username=admin&password=123456";
    url = url + '&timeStart=' + timeStart + '&timeLife=' + timeLife;
  	return $http.get(url).then(function(response) {
  	  return response.data;
  	});
  };

  var request = function(access_token) {
    var url = "api/api-request.php?access_token=" + access_token;
    return $http.get(url).then(function(response) {
      return response.data;
    });
  };

  return {
  	login: login,
    request: request
  };
}]);