<?php

namespace App\dataviz\datavizs;

use App\dataviz\Entities\Entite;
use App\model\DAOFactory;

class Dataviz
{
    protected $db;

    protected $filters;

    public function __construct( $db = null ) {
        $this->db = $db;
    }

    public function filter(FilterList $filters) {
        $this->filters = $filters;
        $this->filters->reduce(static::AVAILABLE_FILTERS);
        return $this;
    }
}