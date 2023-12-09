<?php
/*
$banner = file_get_contents("FAFA.ans");
$banner = str_replace("ESC", "\x1b", $banner);
$banner= explode("\r\n", $banner);
*/
class banner_cmd extends base_cmd
{
    public function __construct() {
        $this->help = "Show the loging banner";
    }
}
