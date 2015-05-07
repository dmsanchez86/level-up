<?php if(!class_exists('raintpl')){exit;}?><script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-route.js"></script>

<script type="text/javascript">
  
 var scotchApp = angular.module('scotchApp', ['ngRoute']);

    // configure our routes
    scotchApp.config(['$routeProvider', function($routeProvider) {
        
        $routeProvider

            // route for the home page
            .when('/', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/home.html',
                 controller  : 'mainController'
            })

            .when('/contacto', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/contacto.html',
                controller  : 'contactoController'
            })
            
            .when('/noticias', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/noticias.html',
                controller  : 'noticiaController'
            })
    
            .when('/eventos', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/eventos.html',
                controller  : 'eventoController'
            })
            
            .when('/custom', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/custom.html',
            })
            
            .otherwise({
                redirectTo: '/'
            });
    }]);

    // create the controller and inject Angular's $scope
    scotchApp.controller('eventoController', function($scope) {
        // create a message to display in our view
        $scope.message = 'Everyone come and see how good I look!';
        $scope.titulo_pagina = 'Eventos -- Level Up';
        jQuery("title").html($scope.titulo_pagina);
        jQuery('.navegador__contenedor').css('background-color','#ccc');
    });
    
    // create the controller and inject Angular's $scope
    scotchApp.controller('noticiaController', function($scope) {
        // create a message to display in our view
        $scope.titulo_pagina = 'Noticias -- Level Up';
        jQuery("title").html($scope.titulo_pagina);
        jQuery('.navegador__contenedor').css('background-color','#ccc');
    });

    // create the controller and inject Angular's $scope
    scotchApp.controller('contactoController', function($scope) {
        // create a message to display in our view
       $scope.titulo_pagina = 'Contacto -- Level Up';
        jQuery("title").html($scope.titulo_pagina);
        jQuery('.navegador__contenedor').css('background-color','#ccc');
    });
    // create the controller and inject Angular's $scope
    scotchApp.controller('mainController', function($scope) {
        // create a message to display in our vie
        $scope.message = 'Everyone come and see how good I look!';
        $scope.titulo_pagina = 'Home -- Level Up';
        jQuery("title").html($scope.titulo_pagina);
        jQuery('.navegador__contenedor').css('background-color','#555658');
    });

</script>

<div ng-app="scotchApp">

    <div ng-view>
        
    </div>

</div>