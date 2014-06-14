var prodeServices = angular.module('prodeServices', ['ngResource']);

prodeServices.factory('Predictions', ['$resource',
    function ($resource) {
        var route = Routing.generate('predictions_list') + "/:predictionId";
        return $resource(route, {}, {
            query: {method: 'GET', isArray: true, params: {predictionId: ".json"}}
//            partialUpdate: {method:'PATCH', params:{}}
        });
    }]);