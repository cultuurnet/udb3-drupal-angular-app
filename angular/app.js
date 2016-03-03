(function(settings) {
  'use strict';

  /**
   * @ngdoc overview
   * @name udbApp
   * @description
   * # udbApp
   *
   * Main module of the application.
   */
  angular
    .module('udbApp', [
      'ngCookies',
      'ngSanitize',
      'udb.core'
    ])
    .config(udbAppConfig)
    .run(function (udbApi, $rootScope, $window) {
      udbApi.getMe();

      $rootScope.$on('$locationChangeStart', redirectOnLocationChange);

      function redirectOnLocationChange(event, newUrl, oldUrl) {
        if (oldUrl && newUrl !== oldUrl) {
          event.preventDefault();
          $window.location.href = newUrl;
        }
      }
    })
    .constant('appConfig', settings.appConfig)
    .constant('moment', moment)
    .constant('eventId', settings.eventId || null)
    .constant('placeId', settings.placeId || null)
    .constant('offerType', settings.offerType || null);

  udbAppConfig.$inject = ['$sceDelegateProvider', '$translateProvider', 'uiSelectConfig', 'appConfig',
    'queryFieldTranslations', 'dutchTranslations', '$locationProvider'];

  function udbAppConfig($sceDelegateProvider, $translateProvider, uiSelectConfig, appConfig,
                        queryFieldTranslations, dutchTranslations, $locationProvider) {

    $sceDelegateProvider.resourceUrlWhitelist([
      'self',
      appConfig.baseUrl + '**'
    ]);

    // Translation configuration
    var defaultTranslations = _.merge(dutchTranslations, queryFieldTranslations.nl);

    $translateProvider
      .translations('nl', defaultTranslations)
      .preferredLanguage('nl');
    // end of translation configuration

    uiSelectConfig.theme = 'bootstrap';
    $locationProvider.html5Mode({
      enabled: true,
      requireBase: true
    });
  }
})(drupalSettings.culturefeed_udb3_app);
