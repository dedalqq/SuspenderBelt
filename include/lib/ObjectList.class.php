<?php
/**
 * Description of ObjectList
 *
 * @author dedal.qq
 */
abstract class ObjectList {
    
    /**
     * @var Object
     */
    protected $object;
    
    /**
     * @var MySql
     */
    private $sql;
    
    /**
     * @var string
     */
    private $html;

    public function __construct() {
        $this->html = '';
        $this->sql = MySql::getInstance();
    }
    
    public function __toString() {
        
        $this->sql->db_select_table($this->object->getTableName());
        $data = $this->sql->db_exec(true);
        
        foreach ($data as $i => $v) {
            $this->object->setData($v);
            $this->html.= (string)$this->object->printToList();
            //$this->object->reset();
        }
        
        return $this->html;
    }
}

?>
