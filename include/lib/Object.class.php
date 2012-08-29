<?php

/**
 * Description of object
 *
 * @author dedal.qq
 */
abstract class Object {
    
    protected $id;
    
    public function __construct($id = 0) {
        if ($id != 0) {
            $this->id = $id;
            $this->load();
        }
    }
    
    abstract public function getTableName();

    /**
     * ��������� ������ � ���� ������
     */
    public function save() {
        $sql = MySql::getInstance();
        if ($this->id == 0) {            
            $this->id = $sql->db_insert($this->getTableName(), $this->getData());
        }
        else {
            $sql->db_update($this->getTableName(), '`id`='.$this->id, $this->getData());
        }
        return $this->id;
    }
    
    /**
     * ����� �������� ������� �� ����
     */
    public function load($where = '') {
        if ($where == '') {
            if ((bool)$this->id) {
                $where = '`id`='.$this->id;
            }
            else {
                $this->id = null;
                return false;
            }
        }
        $sql = MySql::getInstance();

        $sql->db_select_table($this->getTableName());
        $sql->db_select_where($where);
        $sql->db_select_limit(0, 1);

        $data = $sql->db_exec();
        if (isset($data['id']) && (bool)$data['id']) {
            return $this->setData($data);
        }
        else {
            $this->id = null;
            return false;
        }
    }
    
    public function getId() {
        return $this->id;
    }
    
    /**
     * ����� ��������� ������ ������ �������
     */
    public function getData() {
        return get_object_vars($this);
    }
    
    /**
     * ���������� ������ ������� �� ������
     * @param type $array 
     */
    public function setData($array) {
        foreach(get_object_vars($this) as $i => $v) {
            if (isset($array[$i])) {
                $this->$i = $array[$i];
            }
        }
        return true;
    }
    
    /*
     * ���������� ������ � �������������� ���������
     */
    public function reset() {
        foreach(get_object_vars($this) as $i => $v) {
            $this->$i = null;
        }
        return true;
    }
    
    public function printToList() {
        return (string)$this;
    }

    /**
     * ��������� ������ ���� ������� ������� ��������� � http request
     * @param type $method 
     */
    public function parsHttpData($method = 'post') {
        if ($method == 'post') {
            foreach($_POST as $i => $v) {
                $data[$i] = iconv('UTF-8', 'windows-1251', $_POST[$i]);
            }
        }

        $this->setData($data);
    }
    
    public function getDate() {
        if (isset($this->date)) {
            return Date::format($this->date);
        }
    }
    
    public function __destruct() {
        //$this->save();
    }
    
}
/**
 * @todo �������� ����� setData ��� ���� ������� ��� ��������� ����� ��� �������� �� ����,
 * � ��� �� ������� �����, ��� ������� ��� ��������� ��������� ����� ������,
 * ��� �������� ����� ���� �����, ��� ��������� ������� ������ ��� ��������� ����� ��������
 * �� ������ �������� �� ���� ��������� ������ �������
 * 
 * @todo ������ ����� ���� ������� ���������� ��� �� ������������������ ��������
 * ���� ��� ����� ��������� ������ ����� �������������, ������� ����� � ����
 * �������� ����� �������, ���� ���������� ��� ����� ��� ����,
 * ����  ��������� ������� ������� ����� ���������� ������� ����������, � ��������
 * �������� ���������� ����� �������� � ������ �������� ������� �� ����, �� ���
 * ��������� ������������������ ����� ������� �������
 */
?>
