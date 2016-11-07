<?php

namespace ride\web\template\huqis\func;

use huqis\func\TemplateFunction;
use huqis\TemplateContext;

use ride\library\dependency\DependencyInjector;

class DecorateTemplateFunction implements TemplateFunction {

    private $dependencyInjector;

    public function __construct(DependencyInjector $dependencyInjector) {
        $this->dependencyInjector = $dependencyInjector;
    }

    public function call(TemplateContext $context, array $arguments) {
        $value = '';
        $id = '';

        foreach ($arguments as $index => $argument) {
            switch ($index) {
                case 0:
                    $value = $argument;

                    break;
                case 1:
                    $id = $argument;

                    break;
                default:
                    throw new RuntimeTemplateException('Could not call decorate: invalid argument count');
            }
        }

        $decorator = $this->dependencyInjector->get('ride\\library\\decorator\\Decorator', $id);

        return $decorator->decorate($value);
    }

}
