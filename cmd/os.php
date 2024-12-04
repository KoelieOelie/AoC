<?php
function Hi() {
    
}
class os_cmd extends base_cmd
{
    protected $pwd;
    public function __construct()
    {
        $this->init_cli();
        //$this->cli->addFlag("help", array("alias" => "-h"));
        $this->help = "Display the files in current dir";
    }
    function setPWD($path) : void {
        $this->pwd=$path;
    }
    /**
     * TODO: refactor hier onder
     */
    function help($i) : string {
        switch ($i) {
            case 'ls':
                return "List directory contents";
                break;
            
            default:
                return "\x1b3 help text for " . htmlentities($i) . " not found.\x1b0";
                break;
        }
    }
    /**
     * TODO: usage for all bulidin func's
     */
    /*function usageLS()
    {

        return json_encode(array("data" => $this->cli->getUsage()));
    }*/
    
    function runLS() {
        $flagNames = explode(' ', 'l');

        $data = "Parsed arguments:\n";
        foreach ($flagNames as $flag) {
            $param = var_export($this->cli->getOption($flag), true);
            $data .= sprintf(' %6s %s', $flag, $param) . "\n";
        }

        //$data .= "\nRemaining arguments: " . implode(' ', $args) . "\n";
        return $this->output($data,true);
    }
    function runPWD()
    {
        return $this->output($this->pwd);
    }
    

    function serve($args,$cmd_name): string
    {

        //$parser->parse();
        //$banner_play = new Playscii(file_path . "Banner.psci");
        //return json_encode(array("data" => $banner_play, "run" => "loopLines"), 128);
        $this->fix_cmd($args, $cmd_name);
        
        $this->cli->addHead("Usage: " . $cmd_name . " [ options ]\n");
        $this->cli->addHead($this->help($cmd_name) . "\n");
        switch ($cmd_name) {
            case 'pwd':
                $this->params=false;
                $this->cli->addRule('a', "A short flag with no parameter");
                $this->cli->addRule('b:', "A short flag with an optional parameter");
                $this->cli->addRule('c::', "A short flag with a required parameter");
                $this->cli->addRule('long-a', "A long flag with no parameter");
                $this->cli->addRule('long-b:', "A long flag with an optional parameter");
                $this->cli->addRule('long-c::', "A long flag with a required parameter");
                break;
            case 'ls':
                $this->params = true;
                $this->cli->addRule('l', "use a long listing format");
                //$this->cli->addFlag("long", array("alias" => "-l", "default" => false, "help" => "Use a long listing format"));
                # code...
                break;
            
            default:
                return $this->cmd_fall($cmd_name);
                break;
        }
        if ($this->params) {
            try {
                $this->cli->parse($args);
            } catch (\Throwable $e) {
                //throw $th;

                return $this->output($this->cli->getUsage());
            }
            if ($this->cli->help) {
                return $this->output($this->cli->getUsage());
                //return json_encode(array("data" => $this->cli->getUsage()));
            }
        }        
        
        $retv=call_user_func('os_cmd::run'. strtoupper($cmd_name));
        if ($retv==null) {
            return $this->cmd_fall('os_cmd::run' . strtoupper($cmd_name));
        }
        return $retv;
        
        //return json_encode(array("data"=> json_encode($this->cli->getRules(),128)));//$data));
    }//*/
}
