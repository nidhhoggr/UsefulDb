<?php

require_once(dirname(__FILE__) . '/DBAL.class.php');

/**
* @author: joseph persie
*
* this is the base model class to configure and extend
* the configuration method must be implemented to set the 
* identifier and the table name. Basic crud operations can be performed
* by this model extedning the functioanlity of the DBAL
*/

abstract class BaseModel extends DBAL {

    private 
        $dbtable = null,
        $dbhost = "",
        $dbuser = "",
        $dbpassword = "",
        $dbname = "",
        $identifier = "id";

    function __construct($args) {
        $this->setConnection($args);
        parent::__construct($this->dbname,$this->dbhost,$this->dbuser,$this->dbpassword);
        $this->configure();
    }

    private function setConnection($args) {

	$array_vars = array('dbname','dbhost','dbuser','dbpassword');

	foreach($array_vars as $av) {
	    if(empty($args[$av]))
	        die("Must provide all 4 paramaters for a db connection");

            $this->$av = $args[$av];
	}

    }


    abstract protected function configure();

    public function find($conditions = null,$fields = '*') {

        if(empty($conditions))
            return parent::find($this->dbtable,$fields);
        else
            return parent::findBy($this->dbtable,$fields,$conditions);
    }

    public function findOne($conditions = null,$fields = '*') {
        return parent::findOneBy($this->dbtable,$fields,$conditions);
    }

    public function save() {
        $identifier = $this->identifier;
        $attributes = $this->_getAttributes();
        $conditions = null;

        if(!empty($attributes[$identifier]))
            $conditions = $identifier . ' = "' . $attributes[$identifier] . '"';

        //the record already exists by the specified identifier
        if($this->findOne($conditions) && !empty($conditions)) {
            $this->_update();

            //return the modified id
            return $attributes[$identifier];
        }
        //the record doesnt exist yet create a new one
        else {
            $this->_insert();

            //return the last insertion id
            return $this->lastInsertedId();
        }

    }

    public function setTable($table) {
        $this->dbtable = $table;
    }

    public function setIdentifier($id) {
        $this->identifier = $id;
    }

    private function _getAttributes() {
 
        $attributes = array();
  
        $columns = $this->getColumnsByTable($this->dbtable);

        foreach($columns as $col) {
            if(!empty($this->$col))
                $attributes[$col] = $this->$col;
        }

        return $attributes;
    }

    private function _insertAttributes() {

        $attributes = $this->_getAttributes();
  
        $attr['columns'] = '`' . implode('`,`',array_keys($attributes)) . '`';        
        $attr['values'] = '"' . implode('","',array_values($attributes)) . '"';

        return $attr;
    }

    private function _updateAttributes() {
        $identifier = $this->identifier;

        $attributes = $this->_getAttributes();

        foreach($attributes as $k=>$v) {
            if($k != $identifier)
                $statements[] = '' . $k . ' = "'. $v . '"';
        }

        return ' SET ' . implode(',',$statements) . ' WHERE ' . $identifier .' = '. $attributes[$identifier];
    }

    private function _insert() {
 
        $attributes = $this->_insertAttributes();

        extract($attributes);

        $sql = 'INSERT INTO ' . $this->dbtable . '('.$columns.') VALUES('.$values.')';
 
        $this->execute($sql);
    }

    private function _update() {
        $attributes = $this->_updateAttributes();

        $sql = 'UPDATE ' . $this->dbtable . ' ' . $attributes;

        $this->execute($sql);
    }
}
