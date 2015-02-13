(function() {
  'use strict';

  /**
   * @ngdoc function
   * @name udbApp.controller:HeaderCtrl
   * @description
   * # HeaderCtrl
   * udbApp controller
   */
  angular
    .module('udbApp')
    .controller('HeaderCtrl', HeaderController);

  HeaderController.$inject = ['uitidAuth', '$scope'];

  function HeaderController(uitidAuth, $scope) {
    $scope.login = uitidAuth.login;
    $scope.logout = uitidAuth.logout;

    $scope.$watch(function () {
      return uitidAuth.getUser();
    }, function (user) {
      $scope.user = user;
    }, true);
  }

  angular
    .module('udb.event-form')
    .config(function($provide) {
      $provide.decorator('udbEventFormExtrasDirective', ['$delegate', function ($delegate) {
        var directive = $delegate[0];
        directive.template = '<div ng-controller="testCtrl"><div ng-show="test">show</div></div>';
        return $delegate;
      }]);
    });

})();
