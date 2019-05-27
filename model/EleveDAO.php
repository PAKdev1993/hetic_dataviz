<?php

    class EleveDAO extends DAO{

        const TABLE_NAME = 'eleve';

        public function getOne($eleve) {
            
        }

        public function getAll() {

        }

        public function save($eleve) {
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