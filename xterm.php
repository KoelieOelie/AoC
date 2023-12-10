<?php
    require_once 'vendor/autoload.php';
    use CHH\Optparse;
    header("Content-Type: text/javascript");
    spl_autoload_register(function ($class_name) {
        if (str_contains($class_name,"_cmd")) {
            include "cmd/".str_replace("_cmd","",$class_name) . '.php';
        } else {
            include $class_name . '.php';
        }
        
        
    });
    $response =array("data"=>"","run"=> "addLine");
    $cmd = (urlencode($_GET["cmd"])=== "%F0%9F%8E%85") ? "banner" : html_entity_decode($_GET["cmd"], ENT_SUBSTITUTE) ;

    $cmd_list=array(
        "banner"=>new banner_cmd,
        "help"=> "You obviously already know what this does"
    );
    if (strtolower($cmd)==="br") {
        $response["run"] = "br";
    }elseif ($cmd==="help") {
        $data=array();
        foreach ($cmd_list as $key => $value) {

            $data[]="\x1b2$key\x1b0\t\t\t".((is_string($value))? $value: $value->__toString());
        }
        $response["data"] = $data;
        $response["run"] = "loopLines";
    }elseif ($cmd==="man") {
        $response["data"] = htmlentities($cmd) . ": command not found.";
    }elseif (isset($cmd_list[$cmd])) {
        $data= json_decode($cmd_list[$cmd]->run(),true);
        $response["run"] = $data["run"];
        $response["data"] = $data["data"];
    }else {
        $response["data"] = htmlentities($cmd) . ": command not found";
    }
    echo "s0(".json_encode($response).");";