<?php
class timer{
    var $StartTime = 0;
    var $StopTime = 0;

    private function get_microtime(){
        list($usec, $sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }
    public function start(){
        $this->StartTime = $this->get_microtime();
    }
    public function stop(){
        $this->StopTime = $this->get_microtime();
    }
    public function spent(){
        return round(($this->StopTime - $this->StartTime) * 1000, 1);
    }
}
$timer = new timer;
$timer->start();
?>