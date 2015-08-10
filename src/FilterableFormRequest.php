<?php

namespace Axn\RequestFilters;

trait FilterableFormRequest
{
    protected $filters = [];

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
                Filters::filtering(
                    $this->filters,
                    $this->all()
                )
            );
        }
        catch (Exception $e) {
        }

        return true;
    }
}
