<?php
/**
 * Description of SystemInfo
 *
 * @author dedal.qq
 */
class SystemInfo {
    
    private static $object;
    
    private function __construct() {
        
    }

    /**
     * @return SystemInfo
     */
    static public function getInstance() {
        if (!(self::$object != NULL && self::$object instanceof self)) {
            self::$object = new self;
        }
        return self::$object;
    }
    
    public function __toString() {
        return 'Память: '.byt_format(memory_get_usage()).'<br>
                Число запросов: '.MySql::getInstance()->sql_num();
    }
}

?>
