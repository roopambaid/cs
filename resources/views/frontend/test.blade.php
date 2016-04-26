 <!-- LOAD JQUERY -->
 <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
 <!-- LOAD ANGULAR -->
 <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.0/angular.min.js"></script>

 <!-- PROCESS FORM WITH AJAX (NEW) -->
 <script>

    // define angular module/app
    var formApp = angular.module('formApp', [], function($interpolateProvider) {
    	$interpolateProvider.startSymbol('<%');
    	$interpolateProvider.endSymbol('%>');});

    // create angular controller and pass in $scope and $http
    function formController($scope, $http) {
    	// create a blank object to hold our form information
      // $scope will allow this to pass between controller and view
      $scope.formData = {};

       // process the form
       $scope.processForm = function() {
       	
       	$http({
       		method  : 'POST',
       		url     : '/form-data',
		    data    : $.param($scope.formData),  // pass in data as strings
		    headers : { 'Content-Type': 'application/x-www-form-urlencoded'}  // set the headers so angular passing info as form data (not request payload)
		})
       	.success(function(data) {
       		console.log(data);

       		if (!data.success) {
	      // if not successful, bind errors to error variables
	      $scope.errorName = data.errors.name;
	      $scope.errorSuperhero = data.errors.superheroAlias;
	  } else {
      // if successful, bind success message to message
      $scope.message = data.message;
  }
});
       };

   }

</script>
</head>

<!-- apply the module and controller to our body so angular is applied to that -->
<body ng-app="formApp" ng-controller="formController">
	<div id="messages" ng-show="message"><% message %></div>
	<!-- FORM -->
	<form ng-submit="processForm()">
		<div id="name-group" class="form-group" ng-class="{ 'has-error' : errorName }">
			<label>Name</label>
			<input type="text" name="name" class="form-control" placeholder="Bruce Wayne" ng-model="formData.name">
			<span class="help-block"></span>
		</div>

		<!-- SUPERHERO NAME -->
		<div id="superhero-group" class="form-group" ng-class="{ 'has-error' : errorSuperhero }">
			<label>Superhero Alias</label>
			<input type="text" name="superheroAlias" class="form-control" placeholder="Caped Crusader" ng-model="formData.superheroAlias">
			<span class="help-block"></span>
		</div>

		<!-- SUBMIT BUTTON -->
		<button type="submit" class="btn btn-success btn-lg btn-block">
			<span class="glyphicon glyphicon-flash"></span> Submit!
		</button>
	</form>

	<!-- SHOW DATA FROM INPUTS AS THEY ARE BEING TYPED -->
	<pre>
		<% formData %>
	</pre>
