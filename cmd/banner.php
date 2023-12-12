<?php
class banner_cmd extends base_cmd
{
    public function __construct() {
        $this->help = "Display the header";
    }
    function run() : string {
        $banner_play = new Playscii(file_path."Banner.psci");
        return json_encode(array("data" => $banner_play, "run" => "loopLines"), 128);
    }
}
