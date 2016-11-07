<?php

namespace ride\web\template\huqis\func;

use huqis\func\TemplateFunction;
use huqis\TemplateContext;

use ride\library\router\Router;

class UrlTemplateFunction implements TemplateFunction {

    private $router;

    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function call(TemplateContext $context, array $arguments) {
        $id = '';
        $parameters = [];
        $queryParameters = [];
        $querySeparator = '&';

        foreach ($arguments as $index => $argument) {
            switch ($index) {
                case 0:
                    $id = $argument;

                    break;
                case 1:
                    $parameters = $argument;

                    break;
                case 2:
                    $queryParameters = $argument;

                    break;
                case 3:
                    $querySeparator = $argument;

                    break;
                default:
                    throw new RuntimeTemplateException('Could not call url: invalid argument count');
            }
        }

        $baseUrl = $context->getVariable('app.url.script');

        return $this->router->getRouteContainer()->getUrl($baseUrl, $id, $parameters, $queryParameters, $querySeparator);
    }

}
