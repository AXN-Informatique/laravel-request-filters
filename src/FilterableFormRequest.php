<?php

namespace Axn\RequestFilters;

trait FilterableFormRequest
{
    /**
     * Get the filters that apply to the request.
     *
     * @return array
     */
    public function filters()
    {
        return [];
    }

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
        $this->replace(
            Filters::filtering(
                $this->all(),
                $this->filters()
            )
        );

        return true;
    }
}
