(function (angular) {
    "use strict";
    var module = angular.module('ng.jasperReports', []);    

    module.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
        $httpProvider.defaults.transformRequest = function (data) {
            var result = angular.isObject(data) && String(data) !== '[object File]' ? $.param(data) : data;

            return result;
        };
    }]);

    module.factory('JasperReportsService', ['$http', '$rootScope', 'UrlService', function ($http, $rootScope, UrlService) {
        
        return {
            findAll: function ($scope, dataResultKey, entity_id, entity_type) {
                var data = {entity_id: entity_id, entity_type: entity_type};
                var url = MapasCulturais.createUrl('report', 'findAllByEntity', []);

                console.log(url, data);

                return $http.post(url, data).
                    success(function (data, status) {
                        $scope.data.dataResultKey = data;
                        $rootScope.$emit('jasperreports.findAll', {data: data, status: status});
                    }).
                    error(function (data, status) {
                        $rootScope.$emit('error', {message: "Cannot find report", data: data, status: status});
                    });
            },
        };
    }]);

    module.controller('JasperReportsSelectReport',['$scope', 'JasperReportsService', 'EditBox', function($scope, JasperReportsService, EditBox) {
        
        $scope.data = {
            reportList: [],
            reportSelected: null,
            applying = false
        };

        JasperReportsService.findAll($scope, 'reportList', MapasCulturais.entity.id, MapasCulturais.entity.type);
        
        $scope.openReport = (report_id, $event) => {
            $scope.data.reportSelected = report_id;
            EditBox.open('jasperreports-editbox', $event)
            return true;
        };

        $scope.closeReport = ($event) => {
            $scope.data.reportSelected = null;
            EditBox.close('jasperreports-editbox', $event);
            return true;
        };

        $scope.executeReport = (report_id, $event) => {
            console.log('Executar relatório');
            return true;
        };

        scope.isSelected = function(reportSelected, report_id){
            return (reportSelected == report_id);
        };

    }]);
})(angular);