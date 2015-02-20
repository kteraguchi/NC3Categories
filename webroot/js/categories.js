/**
 * Categories Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, modalStack)} Controller
 */
NetCommonsApp.controller('Categories',
    function($scope, NetCommonsBase, $modalStack) {

      $scope.categoryList = {};
      $scope.categoryForm = {};
      $scope.CategoryParams = {_method: 'POST', data: {}};

      $scope.init = function(data) {
        $scope.categoryList = data.categoryList;
console.log($scope.categoryList);
      };

      $scope.addCategory = function() {
        var addCategory = {Category: {id: '', key: '', name: ''}};
        $scope.categoryList.list.push(addCategory);
      };

      $scope.deleteCategory = function(index) {
        $scope.categoryList.list.splice(index, 1);
      };

      $scope.sortCategory = function(moveType, index) {
        var destIndex = (moveType === 'up') ? index -1 : index + 1;
        if (angular.isUndefined($scope.categoryList.list[destIndex])) {
          return false;
        }

        var destCategory = angular.copy($scope.categoryList.list[destIndex]);
        var targetCategory = angular.copy($scope.categoryList.list[index]);
        $scope.categoryList.list[index] = destCategory;
        $scope.categoryList.list[destIndex] = targetCategory;
      };

      $scope.saveCategory = function() {
        $scope.plugin.setController('categories');
        $scope.CategoryParams.data = $scope.categoryList;
        NetCommonsBase.save(
            $scope.categoryForm,
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.CategoryParams,
            function(data) {
              $scope.flash.success(data.name);
              $scope.setLatestCategory(data.results);
              $modalStack.dismissAll('saved');
            });
      };

      $scope.clearAllValidationCategory = function(categoryForm) {
        angular.forEach(categoryForm, function(value, index) {
          $scope.serverValidationClear(value, 'name');
        });
      };

    });
