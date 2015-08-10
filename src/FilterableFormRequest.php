<?php

namespace Axn\RequestSanitizer;

trait FilterableFormRequest
{
    protected $sanitizes = [];

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $this->formRequestFilter();

        return parent::getValidatorInstance();
    }

    protected function formRequestFilter()
    {
        try
        {
            $this->replace(
                Sanitizer::sanitize(
                    $this->sanitizes,
                    $this->all()
                )
            );
        }
        catch (Exception $e) {
        }

        return true;
    }
}
