<?php
/* * * * * * * * * * * * * *
 *   Application config    *
 * * * * * * * * * * * * * */


$config = array(
    'applicationPath' => __DIR__ . '/./../',
    'view' => array(
        'defaultLayout' => __DIR__ . '/../DefaultModule/templates/layout.phtml'
    ),
    'modules' => array(

    ),
    'routes' => __DIR__ . '/./routing.php'
);

return new \Literal\Common\Parameters\ArrayParameters($config);