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
     * Сохраняет объект в базе данных
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
     * Метод загрузки объекта из базы
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
     * Метод получения масива данных объекта
     */
    public function getData() {
        return get_object_vars($this);
    }
    
    /**
     * Установить объект данными из масива
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
     * Сбрасывает объект в первоначальнео состояние
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
     * Загрузить объект теми данными которые находятся а http request
     * @param type $method 
     */
    public function parsHttpData($method = 'post') {
        if ($method == 'post') {
            foreach($_POST as $i => $v) {
                $data[$i] = $_POST[$i];
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
 * @todo изменить метод setData что быон понимал как двумерный масив при загрузки из базы,
 * а так же обычный масив, или научить его принимать парамметр этого масива,
 * так наверное будет даже лучше, что выводимый элемент списка мог создавать пачки обьектов
 * из одного результа из базы передавая разные строчки
 * 
 * @todo помимо этого надо научить композиции как то инициализироваться полность
 * либо лдя этого прийжется делать метод инициализации, который будет у всех
 * вызывать метод сетДата, либо переделать сам метод сет даты,
 * либо  создавать фабрику которая будет возвращать готовую композицию, в принципи
 * элементы композиции можно получить и просто догрузив остатки из базы, но для
 * повышения производительности лучше заюзать фабрику
 * 
 * @todo добавить методы вывода элеменат в одиночку и вывода в список, подумать
 * как задавать типы вывода
 */
?>
