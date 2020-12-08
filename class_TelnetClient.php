<?php

class TelnetClient{

    private $sock = null;

    function __construct()
    {
        
    }
    function connect($address, $port){
        if(!is_null($this->sock))
            $this->disconnect();
        $this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect ( $this->sock, $address, $port );
        socket_set_option($this->sock,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>1,"usec"=>0));
    }
    function disconnect(){
        if(!is_null($this->sock)){
            socket_close($this->sock);
            $this->sock = null;
        }
    }
    function getStream(){
        if(is_null($this->sock))
            return '';
        $str = '';
        while($a = socket_read($this->sock, 20408)){
            $str .= $a;
        }
        return $str;
    }
    function sendStream($message){
        socket_write ( $this->sock, $message."\r");
        socket_write ( $this->sock, "\n");
    }
}