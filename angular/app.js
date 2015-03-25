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
      'ngAnimate',
      'ngCookies',
      'ngSanitize',
      'udb.core'
    ])
    .config(udbAppConfig)
    .run(function (udbApi) {
      udbApi.getMe();
    })
    .constant('appConfig', settings.appConfig)
    .constant('moment', moment)
    .constant('eventId', settings.eventId || null)
    .constant('placeId', settings.placeId || null)
    .constant('offerType', settings.offerType || null);

  udbAppConfig.$inject = ['$sceDelegateProvider', '$translateProvider', '$locationProvider', 'uiSelectConfig', 'appConfig',
    'queryFieldTranslations', 'dutchTranslations'];

  function udbAppConfig($sceDelegateProvider, $translateProvider, $locationProvider, uiSelectConfig, appConfig,
                        queryFieldTranslations, dutchTranslations) {

    // Enable html5 mode for pages that have tabbed content.
    if (appConfig.enableHtml5Mode) {
      $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
      });
    }

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
  }
})(drupalSettings.culturefeed_udb3_app);
