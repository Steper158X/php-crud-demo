<?php

require_once('main.class.php');

class Index {
    
        use ConnecntDatabase;
        use FetchData;
    
        public function __construct() {

            //connect to database
            $this->connect();


        }

    
}