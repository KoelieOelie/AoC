<?php
    require_once 'vendor/autoload.php';
    session_start();
    header("Content-Type: text/javascript");
    define("file_path","AoC_files/");
    spl_autoload_register(function ($class_name) {
        if (str_contains($class_name,"_cmd")) {
            include "cmd/".str_replace("_cmd","",$class_name) . '.php';
        } else {
            include $class_name . '.php';
        }
        
        
    });
    $response =array("data"=>"","run"=> "addLine");
    $cmd = (urlencode($_GET["cmd"])=== "%F0%9F%8E%85") ? "init" : html_entity_decode($_GET["cmd"], ENT_SUBSTITUTE) ;
    $argv = (!isset($_GET["argv"])) ? "[]" : html_entity_decode(base64_decode($_GET["argv"]), ENT_SUBSTITUTE);
    if (isset($_SESSION["os"])) {
        $os = unserialize($_SESSION["os"]);
    }else {
        $os = new os_cmd();
    }
    $cmd_list=array(
        "banner"=>new banner_cmd,
        "help"=> "You obviously already know what this does",
        "ls"=> $os->help("ls"),
        "cd" => $os->help("cd"),
        "mdir" => $os->help("mdir"),
        "mfile" => $os->help("mfile"),
        "pwd" => $os->help("pwd"),
        //"sl"=>new sl_cmd,
        //"cowsay"=>new cowsay
    );
    if (strtolower($cmd)==="br") {
        $response["run"] = "br";
    }elseif ($cmd=== "init") {
        $data = json_decode($cmd_list["banner"]->serve($argv, "banner"), true);
        if (isset($data["run"])) {
            $response["run"] = $data["run"];
        }
        $response["data"] = $data["data"];
        echo "//setPWD:/root\n";
        $os = new os_cmd;
        $os->setPWD("/root");
    }elseif ($cmd === "cd" || $cmd === "ls" || $cmd === "mdir"|| $cmd ==="mfile" || $cmd === "pwd") {
        $data = json_decode($os->serve($argv, $cmd), true);
        if (isset($data["run"])) {
            $response["run"] = $data["run"];
        }
        echo "//setPWD:". $os->pwd."\n";
        $response["data"] = $data["data"];
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
        $data= json_decode($cmd_list[$cmd]->serve($argv, $cmd),true);
        if (isset($data["run"])) {
            $response["run"] = $data["run"];
        }
        $response["data"] = $data["data"];
    }else {
        $response["data"] = htmlentities($cmd) . ": command not found";
    }
    echo "s0(".json_encode($response,128).");";
$_SESSION["os"]=serialize($os);