<?php

require_once(dirname(__FILE__). '/../BaseModel.class.php');


//SET THE CONNECTION VARS HERE
$dbuser = 'root';
$dbpassword  = 'root';
$dbname = 'bob_birdfinder';
$dbhost = 'localhost';

$connection_args = compact('dbuser','dbname','dbpassword','dbhost');

//EXTEND THE BASE MODEL
class ConnectionTestModel extends BaseModel {

    //SET THE TABLE OF THE MODEL AND THE IDENTIFIER
    protected function configure() {
        $this->setTable("bird");
    }

}

//INSTANTIATE THE MODEL
$ctm = new ConnectionTestModel($connection_args);


//DUMP THE RECORDS OF THE TABLE
//var_dump($ctm->find());


//DUMP A FIELD FOR EACH RECORD FROM A RAW QUERY
$query = "select * from bird";
$ctm->query($query);

while($row = $ctm->fetchNextObject()) {

    var_dump($row->name);
}
