<?php

namespace Axn\RequestFilters;

trait FilterableFormRequest
{
    public function filters()
    {
        return [];
    }

    public function validate()
    {
        $this->applyFilters();

        parent::validate();
    }

    protected function applyFilters()
    {
        $this->replace(
            Filters::filtering(
                $this->all(),
                $this->filters()
            )
        );
    }
}
