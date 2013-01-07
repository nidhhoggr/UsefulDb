<?php

require_once(dirname(__FILE__). '/../BaseModel.class.php');


//SET THE CONNECTION VARS HERE
$dbuser = 'root';
$dbpassword  = 'root';
$dbname = 'testdb';
$dbhost = 'localhost';

$connection_args = compact('dbuser','dbname','dbpassword','dbhost');

//EXTEND THE BASE MODEL
class BirdModel extends BaseModel {

    //SET THE TABLE OF THE MODEL AND THE IDENTIFIER
    protected function configure() {
        $this->setTable("bird");
    }

}
//INSTANTIATE THE MODEL
$ctm = new ConnectionTestModel($connection_args);
