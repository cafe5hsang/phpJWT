<!DOCTYPE html>
<html ng-app="JWTApp">
<head>
	<title>Json Web Token</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="js/bootstrap/bootstrap.min.css" rel="stylesheet" media="screen">
	<style>
		body{
			padding-top:70px;
		}
	</style>
	
</head>

<body> 
    <div class="container" ng-controller="mainCtrl">
    	<h1 class="text-center">JWT test</h1>
    	<div class="col-xs-3">
    	</div>
    	<div class="col-xs-6">
    		<button class="btn btn-info" ng-click="login()">Login</button>
			<button class="btn btn-primary" ng-click="request()">Request</button>
			<form class="form form-horizontal">
				<div class="col-xs-9">
					<span>Thời gian sống token (giây)</span>
				</div>
				<div class="col-xs-3">
					<input class="form-control" type="text" name="timeLife" ng-init="timeLife=3600" ng-model="timeLife" required>
				</div>
				<div class="clearfix"></div>
				<div class="col-xs-9">
					<span>Thời gian bắt đầu token (giây)</span>
				</div>
				<div class="col-xs-3">
					<input class="form-control" type="text" name="timeStart" ng-init="timeStart=5" ng-model="timeStart" required>
				</div>
			</form>
    		<br>
    		<h3>Response</h3>
    		<p>login</p>
    		<pre class="text-primary">
			{{data.login | json}}
			</pre>
    		<p>request</p>
    		<pre ng-class="{'text-warning ': !data.request.status, 'text-primary': data.request.status}">
    		{{data.request | json}}
    		</pre>
    	</div>
    </div>

    <script src="js/bootstrap/jquery.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/angular/angular.min.js"></script>
    <script src="js/angular/angular-cookies.min.js"></script>
    <script src="js/angular/ui-bootstrap-2.5.0.min.js"></script>
	<!-- APP script -->
    <script src="js/app.js"></script>
</body>
</html>