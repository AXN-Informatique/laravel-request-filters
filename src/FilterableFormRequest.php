<?php

namespace Axn\RequestFilters;

trait FilterableFormRequest
{
    /**
     * Get the filters that apply to the request before the validation.
     *
     * @return array
     */
    public function filtersBeforeValidation()
    {
        return [];
    }

    /**
     * Get the filters that apply to the request after the validation.
     *
     * @return array
     */
    public function filtersAfterValidation()
    {
        return [];
    }

    /**
     * Get the filters that apply to the request.
     *
     * @deprecated Since 2.2.0, will be removed in 3.0.0
     * @return array
     */
    public function filters()
    {
        return [];
    }

    public function validate()
    {
        $instance = $this->getValidatorInstance();

        $this->applyFiltersBeforeValidation();

        if (! $this->passesAuthorization()) {
            $this->failedAuthorization();
        } elseif (! $instance->passes()) {
            $this->failedValidation($instance);
        }

        $this->applyFiltersAfterValidation();
    }

    protected function applyFiltersBeforeValidation()
    {
        $this->replace(
            Filters::filtering(
                $this->all(),
                array_merge($this->filtersBeforeValidation(), $this->filters()) // back compat for filters method
            )
        );
    }

    protected function applyFiltersAfterValidation()
    {
        $this->replace(
            Filters::filtering(
                $this->all(),
                $this->filtersAfterValidation()
            )
        );
    }
}
