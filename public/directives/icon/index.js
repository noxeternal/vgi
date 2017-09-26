(function () {
  let app = angular.module('icon', [])

  app.directive('icon', function () {
    return {
      restrict: 'E',
      link: function (scope, element, attrs) {
        let className = 'fa fa-' + attrs.name
        element.addClass(className)
      }
    }
  })
})()
// (function () {
//   let app = angular.module('icon', [])

//   app.controller('icon', function () {
//   })

//   app.directive('icon', function () {
//     return {
//       restrict: 'E',
//       scope: {
//         name: '@'
//       },
//       template: '<span class="icon-black icon-{{name}}"></span>'
//     }
//   })
// })()
