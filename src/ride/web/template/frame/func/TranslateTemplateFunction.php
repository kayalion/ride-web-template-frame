<?php

namespace ride\web\template\frame\func;

use frame\library\func\TemplateFunction;
use frame\library\TemplateContext;

use ride\library\i18n\I18n;

class TranslateTemplateFunction implements TemplateFunction {

    private $i18n;

    public function __construct(I18n $i18n) {
        $this->i18n = $i18n;
    }

    public function call(TemplateContext $context, array $arguments) {
        if (!$arguments) {
            throw new Exception('No key found to translate');
        }

        $key = $arguments[0];
        $variables = null;
        if (isset($arguments[1])) {
            if (!is_array($arguments[1])) {
                throw new Exception('Translation variables should be an array');
            }

            $variables = $arguments[1];
        }

        $locale = null;
        if (isset($arguments[2])) {
            $locale = $arguments[2];
        }

        $translator = $this->i18n->getTranslator($locale);

        return $translator->translate($key, $variables);
    }

}
