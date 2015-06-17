'use strict';

var app = angular.module('mainApp', ['ngRoute', 'ngResource']);


app.config(function($routeProvider) {
	$routeProvider
	.when('/', {
		controller: 'MainCtrl',
		templateUrl: 'views/users.html'
	})
	.when('/addUser', {
		controller: 'MainCtrl',
		templateUrl: 'views/add.html'
	})
	.when('/edit/:id', {
		controller: 'UserCtrl',
		templateUrl: 'views/edit.html'
	})
	.when('/user/:id', {
		controller: 'UserCtrl',
		templateUrl: 'views/user.html'
	})
	.when('/about', {
		templateUrl: 'views/about.html'
	})
	.otherwise({
		redirectTo: '/'
	});
});
