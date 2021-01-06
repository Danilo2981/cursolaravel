<?php

namespace Tests;

trait TestHelpers
{
    protected function withData(array $custom = [])
    {
        return array_merge($this->defaultData(), $custom);
    }

    protected function defaultData()
    {
        return $this->defaultData;
    }

}