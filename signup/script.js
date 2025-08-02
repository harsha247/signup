angular.module('SignupApp', [])
  .controller('SignupController', ['$scope', '$http', function($scope, $http) {
    $scope.user = {};
    $scope.response = {};
    
    // Password must contain at least 1 lowercase, 1 uppercase, and 1 special character
    $scope.passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/;

    $scope.submitForm = function() {
      if (
        !$scope.user.name ||
        !$scope.user.email ||
        !$scope.user.mobile ||
        !$scope.user.address ||
        !$scope.user.password ||
        !$scope.user.retypePassword ||
        $scope.user.password !== $scope.user.retypePassword ||
        !$scope.passwordPattern.test($scope.user.password) ||
        !/^\d{10}$/.test($scope.user.mobile)
      ) {
        $scope.response = { status: 'error', message: 'Please fill all fields correctly.' };
        return;
      }

      const postData = {
        name: $scope.user.name,
        email: $scope.user.email,
        mobile: $scope.user.mobile,
        address: $scope.user.address,
        password: md5($scope.user.password)
      };

      $http.post('api.php', postData).then(function(res) {
        $scope.response = res.data;
        if (res.data.status === 'success') {
          $scope.user = {};
          $scope.signupForm.$setPristine();
        }
      }, function() {
        $scope.response = { status: 'error', message: 'API request failed.' };
      });
    };
  }]);
