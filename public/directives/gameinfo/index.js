(function () {
  let app = angular.module('gameinfo', [])
  app.directive('gameInfo', function () {
    return {
      restrict: 'E',
      templateUrl: 'directives/gameinfo',
      // controller: 'vgDisplay as display',
      scope: {
        model: '=ngModel',
        game: '=?'
      }
    }
  })
})()
