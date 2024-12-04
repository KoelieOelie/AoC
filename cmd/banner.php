<?php
class banner_cmd extends base_cmd
{
    public function __construct() {
        $this->help = "Display the header";
    }
    function serve() : string {
        $banner_play = new Playscii(file_path."boot/Banner.psci");
        return json_encode(array("data" => $banner_play, "run" => "loopLines"), 128);
    }
}
