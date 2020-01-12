<?php

namespace Morshadun\RepositoryPattern\Facades;

use Illuminate\Support\Facades\Facade;

class RepositoryPattern extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'repositorypattern';
    }
}
