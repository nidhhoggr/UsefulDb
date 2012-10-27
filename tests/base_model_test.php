<?php

require_once('UsefulDb/base_model.class.php');


//SET THE CONNECTION HERE
$dbuser = '';
$dbpassword  = '';
$dbname = '';
$dbhost = '';

$connection_args = compact('dbuser','dbname','dbpassword','dbhost');

//EXTEND THE BASE MODEL
class ConnectionTestModel extends BaseModel {


    public function __construct($args) {
        parent::__construct($args);
    }

    //SET THE TABLE OF THE MODEL AND THE IDENTIFIER
    protected function configure() {
        $this->dbtable  = "testing";
    }

}

//INSTANTIATE THE MODEL
$ctm = new ConnectionTestModel($connection_args);

