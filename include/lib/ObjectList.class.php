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
     * @var int
     */
    private $count;
    
    /**
     * @var string
     */
    private $html;

    public function __construct() {
        $this->html = '';
        $this->sql = MySql::getInstance();
    }
    
    public function getCount() {
        return $this->count;
    }
    
    /**
     * @todo Сделать так, что бы этот метод работал =)
     * @return boolean 
     */
    public function isEmpty() {
        if ($this->count == 0) {
            return true;
        }
        return false;
    }
    
    public function __toString() {
        /**
         * @todo разбить на страницы 
         */
        $this->sql->db_select_table($this->object->getTableName());
        $data = $this->sql->db_exec(true);
        if (!$data) {
            return '';
        }
        foreach ($data as $i => $v) {
            $this->object->setData($v);
            $this->html.= (string)$this->object->printToList();
            //$this->object->reset();
        }
        
        return $this->html;
    }
}

?>
