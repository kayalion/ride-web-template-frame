<?php

namespace ride\web\template\huqis\func;

use huqis\func\TemplateFunction;
use huqis\TemplateContext;

use ride\library\dependency\DependencyInjector;

class ParsleyAttributesTemplateFunction implements TemplateFunction {

    public function call(TemplateContext $context, array $arguments) {
        $attributes = [];
        $validators = [];
        $type = null;

        foreach ($arguments as $index => $argument) {
            switch ($index) {
                case 0:
                    $attributes = $argument;

                    break;
                case 1:
                    $validators = $argument;

                    break;
                case 2:
                    $type = $argument;

                    break;
                default:
                    throw new RuntimeTemplateException('Could not call parsley: invalid argument count');
            }
        }

        if (!$attributes) {
            return $attributes;
        }

        foreach ($validators as $validator) {
            $options = $validator->getOptions();
            $class = get_class($validator);

            switch ($class) {
                case 'ride\\library\\validation\\validator\\EmailValidator':
                    $attributes['data-parsley-type'] = 'email';

                    break;
                case 'ride\\library\\validation\\validator\\RequiredValidator':
                    $attributes['data-parsley-required'] = 'true';

                    break;
                case 'ride\\library\\validation\\validator\\MinMaxValidator':
                    if (isset($options['minimum']) && isset($options['maximum'])) {
                        $attributes['data-parsley-range'] = '[' . $options['minimum'] . ', ' . $options['maximum'] . ']';
                    } elseif (isset($options['minimum'])) {
                        $attributes['min'] = $options['minimum'];
                    } elseif (isset($options['maximum'])) {
                        $attributes['max'] = $options['maximum'];
                    }

                    break;
                case 'ride\\library\\validation\\validator\\NumericValidator':
                    if ($type !== 'date') {
                        $attributes['data-parsley-type'] = 'number';
                    }

                    break;
                case 'ride\\library\\validation\\validator\\RegexValidator':
                    if (isset($options['regex'])) {
                        $attributes['pattern'] = $options['regex'];
                    }
                case 'ride\\library\\validation\\validator\\SizeValidator':
                    if (isset($options['minimum'])) {
                        $attributes['minlength'] = $options['minimum'];
                    }
                    if (isset($options['maximum'])) {
                        $attributes['maxlength'] = $options['maximum'];
                    }

                    break;
                case 'ride\\library\\validation\\validator\\WebsiteValidator':
                    $attributes['data-parsley-type'] = 'url';

                    break;
            }
        }

        return $attributes;
    }

}
