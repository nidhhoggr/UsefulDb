<?php

require_once(dirname(__FILE__). '/../BaseModel.class.php');


//SET THE CONNECTION VARS HERE
$dbuser = '';
$dbpassword  = '';
$dbname = '';
$dbhost = '';

$connection_args = compact('dbuser','dbname','dbpassword','dbhost');

//EXTEND THE BASE MODEL
class ConnectionTestModel extends BaseModel {

    //SET THE TABLE OF THE MODEL AND THE IDENTIFIER
    protected function configure() {
        $this->setTable("testing");
    }

}

//INSTANTIATE THE MODEL
$ctm = new ConnectionTestModel($connection_args);


//DUMP THE RECORDS OF THE TABLE
var_dump($ctm->find());
