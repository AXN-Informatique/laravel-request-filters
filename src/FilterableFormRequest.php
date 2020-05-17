<?php

namespace Axn\RequestFilters;

trait FilterableFormRequest
{
    public function filters()
    {
        return [];
    }

    public function validateResolved()
    {
        $this->applyFilters();

        parent::validateResolved();
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
