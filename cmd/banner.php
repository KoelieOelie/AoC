<?php
class banner_cmd extends base_cmd
{
    public function __construct() {
        $this->help = "Display the header";
    }
    function run() : string {
        $banner_play = new Playscii("AoC_files/Banner.psci");
        //$banner = file_get_contents("AoC_files/banner.ans");
        //$banner = str_replace("ESC", "\x1b", $banner);
        //$d="";
        //for ($i = 0; $i < 255; $i++){
        //    $d.= iconv("cp437", 'utf-8', chr($i));
        //}
        //file_put_contents("AoC_files/Playscii_Charsets/dos_loopmap_d.char",$d);
        return json_encode(array("data" => $banner_play, "run" => "loopLines"), 128);
    }
}
