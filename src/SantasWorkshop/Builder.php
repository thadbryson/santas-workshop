<?php

namespace TCB\SantasWorkshop;

class Builder
{
    protected $templator = null;
    protected $config    = null;

    public function __construct($config)
    {

    }

    /**
     * Setup ouptput directory under /gifts directory.
     */
    protected function setupGift()
    {

    }

    /**
     * Copy over template files to new gift location.
     */
    protected function copy()
    {

    }

    /**
     * Rename all *.exclude files. Drop the .exclude.
     */
    protected function doExcludes()
    {

    }
}