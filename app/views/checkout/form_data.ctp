<?
$this->layout = 'ajax';

echo $this->Javascript->object($this->Session->read("Checkout"));
