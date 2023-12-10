<?php
class banner_cmd extends base_cmd
{
    public function __construct() {
        $this->help = "Display the header";
    }
    function run() : string {
        $banner = file_get_contents("AoC_files/banner.ans");
        $banner = str_replace("ESC", "\x1b", $banner);
        return json_encode(array("data"=>explode("\r\n", $banner),"run"=> "loopLines"));
    }
}
