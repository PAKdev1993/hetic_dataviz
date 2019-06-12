<?php
namespace App\dataviz\datavizs;

class FilterList
{
    private $list = array();

    public function add(Filter $filter) {
        //si le filtre existe deja on l'efface pour le remplacer par le nouveau
        foreach($this->list as $key => $item){
            if( $item->name() === $filter->name() ) {
                unset($this->list[$key]);
            }
        }
        //sinon on l'ajoute
        $this->list[] = $filter;
    }

    public function getList() {
        return $this->list;
    }

    public function reduce(array $availableFilters) {
        if(count($this->getList()) != 0) {
            foreach($this->getList() as $key => $filter) {
                if( !in_array($filter->name(), $availableFilters) ) {
                    unset($this->list[$key]);
                }
            }
        }        
    }

    public function remove($filter = null, $key = null) {
        if($key) unset($this->list[$key]);
    }

    public function isEmpty() {
        return ! (bool) count($this->list);
    }
}