<?php
class chess_cmd extends base_cmd
{
    public function __construct() {
        $this->help = "Chess program";
    }
    function serve() : string {
        return json_encode(array("run" => "process_s"));
    }
    function init() {
        return new self;
    }
}