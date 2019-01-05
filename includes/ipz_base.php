<?php

namespace Puzzle;

class Base
{
    protected $lg = '';
    protected $db_prefix = '';

    public function __construct($lg, $db_prefix)
    {
        $this->db_prefix = $db_prefix;
        $this->lg = $lg;
    }
}