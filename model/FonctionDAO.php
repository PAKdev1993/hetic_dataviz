<?php

    class FonctionDAO extends DAO{

        const TABLE_NAME = 'fonction';

        public function getOne($id) {
            
        }

        public function getAll() {

        }

        public function save($fonction) {
            if( $eleve->id() === self::UNKNOWN_ID ) {
                //INSERT
            }
            else {
                //UPDATE
            }
        }

        public function delete() {

        }

        public function lastInsertId() {

        }
    }