<?php
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
    function helpLS(){
        return "List directory contents";
    }
    function helpMKDIR(){
        return "Create the DIRECTORY(ies), if they do not already exist.";
    }
    function helpTOUCH(){
        return "Create the DIRECTORY(ies), if they do not already exist.";
    }
    function help($cmd_name) : string {

        $u=call_user_func('os_cmd::help'. strtoupper($cmd_name));
        if ($u==null) {
            $u="\x1b3 help text for " . htmlentities($cmd_name) . " not found.\x1b0";
        }
        return $u;
    }
    /**
     * TODO: usage for all bulidin func's
     */
    function usageMKDIR()
    {
        return "Usage: mkdir [OPTIONS] DIRECTORY...";
    }
    function usageLS()
    {

        return "Usage: ls [-1AaCxdLHRFplinshrSXvctu] [-w WIDTH] [FILE]...";
    }
    function usageTOUCH(){
        return "Usage: touch [-c] [-d DATE] [-t DATE] [-r FILE] FILE..";
    }
    
    function runLS() {

        /*$flagNames = explode(' ', 'l');

        $data = "Parsed arguments:\n";
        foreach ($flagNames as $flag) {
            $param = var_export($this->cli->getOption($flag), true);
            $data .= sprintf(' %6s %s', $flag, $param) . "\n";
        }*/
        $dir=file_path.DIRECTORY_SEPARATOR.$this->pwd;
        $files = scandir($dir);
        $data=[]; 
        foreach($files as $file)
        {
            if(is_dir($dir.$file)){
                $data[]=[$file,"d"];
            }else {
                $data[]=[$file,"f"];
            }
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
        
        switch ($cmd_name) {
            case 'pwd':
                $this->params=false;
                break;
            case 'ls':
                $this->init_cli();
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
            $u=call_user_func('os_cmd::usage'. strtoupper($cmd_name));
            if ($u==null) {
                $u="Usage: " . $cmd_name . " [ options ]";
            }
            $this->cli->addHead("$u\n");
            $this->cli->addHead($this->help($cmd_name) . "\n");
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
