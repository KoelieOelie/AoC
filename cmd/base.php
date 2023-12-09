<?php 
class base_cmd
{
    protected $help="No help found";
    function run() : string {
        return "WIP";
    }
    function __toString()
    {
        return $this->help;
    }
}
