<?php
/**
 * Application wiring configuration for the Injector component
 */

$config = array(
    'dependencies' => array(
        'Router' => array(
            'class' => 'Literal\\Routing\\Router',
            'constructor' => array(
                'routes' => '@Routes',
                'defaultRouteResolver' => '@RouteResolver'
            )
        ),
        'Routes' => function() {
            return include __DIR__ . '/routes.config.php';
        },
        'RouteResolver' => array(
            'class' => 'Literal\\Routing\\Resolver\\RouteResolver'
        ),

        // Listeners
        'RequestListener' => array(
            'class' => 'Literal\\Application\\Listener\\RequestListener'
        ),
        'RouterListener' => array(
            'class' => 'Literal\\Application\\Listener\\RouterListener',
            'constructor' => array(
                'router' => '@Router'
            )
        ),
        'DispatchListener' => array(
            'class' => 'Literal\\Application\\Listener\\DispatchListener'
        ),
        'DispatchErrorListener' => array(
            'class' => 'Literal\\Application\\Listener\\DispatchErrorListener',
            'constructor' => array(
                'errorController' => '@ErrorController'
            )
        ),
        'ResponseListener' => array(
            'class' => 'Literal\\Application\\Listener\\ResponseListener'
        ),

        // Default error controller
        'ErrorController' => array(
            'class' => 'LiteralCMS\\DefaultModule\\Controller\\ErrorController'
        )

    ),

    'parameters' => array(

    )
);

$definitions = new \Literal\Di\Definitions();
$definitions->exchangeArray($config);

return $definitions;