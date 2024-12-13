<?php
class os_cmd extends base_cmd
{
    protected $pwd;
    protected $prosses=null;
    function active_process() : bool {
        return $this->prosses!==null;
    }
    function start_process($ps) {
        $this->prosses = $ps->init();
        return $this->prosses->get_banner();
    }






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
        return "Update the last-modified date on the given FILE[s]";
    }
    function help($cmd_name) : string {
        if (method_exists($this,'help' . strtoupper($cmd_name))) {
            $u = call_user_func('os_cmd::help' . strtoupper($cmd_name));
        } else {
            $u = "\x1b3 help text for " . htmlentities($cmd_name) . " not found.\x1b0";
        }
        return "$u->";
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
    private function FIX($str) {
        return str_replace("\/", DIRECTORY_SEPARATOR, $str);
    }
    
    function runLS() {

        /*$flagNames = explode(' ', 'l');

        $data = "Parsed arguments:\n";
        foreach ($flagNames as $flag) {
            $param = var_export($this->cli->getOption($flag), true);
            $data .= sprintf(' %6s %s', $flag, $param) . "\n";
        }*/
        $dir=$this->FIX(file_path . DIRECTORY_SEPARATOR . $this->pwd);
        //$dir = str_replace(DIRECTORY_SEPARATOR. DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $dir);
        $files = glob("$dir/*");
        $data=[]; 
        echo '/*'.print_r($files,true)."*/";
        foreach($files as $file)
        {
            if(is_dir($file)){
                $data[]=[str_replace($dir.DIRECTORY_SEPARATOR,"",$file),"d"];
            }else {
                $data[]=[str_replace($dir.DIRECTORY_SEPARATOR,"",$file),"f"];
            }
        }
        //$data[] = [$dir, "?"];
        //$data .= "\nRemaining arguments: " . implode(' ', $args) . "\n";
        return $this->FIX($this->output($data,true));
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
                /**
                 * Usage: ls [-1AaCxdLHRFplinshrSXvctu] [-w WIDTH] [FILE]...
                 *
                 * List directory contents
                 *  
                 *         -1      One column output
                 *         -a      Include entries which start with .
                 *         -A      Like -a, but exclude . and ..
                 *         -x      List by lines
                 *         -d      List directory entries instead of contents
                 *         -L      Follow symlinks
                 *         -H      Follow symlinks on command line
                 *         -R      Recurse
                 *         -p      Append / to dir entries
                 *         -F      Append indicator (one of * /=@|) to entries
                 *         -l      Long listing format
                 *         -i      List inode numbers
                 *         -n      List numeric UIDs and GIDs instead of names
                 *         -s      List allocated blocks
                 *         -lc     List ctime
                 *         -lu     List atime
                 *         --full-time     List full date and time
                 *         -h      Human readable sizes (1K 243M 2G)
                 *         --group-directories-first
                 *         -S      Sort by size
                 *         -X      Sort by extension
                 *         -v      Sort by version
                 *         -t      Sort by mtime
                 *         -tc     Sort by ctime
                 *         -tu     Sort by atime
                 *         -r      Reverse sort order
                 *         -w N    Format N columns wide
                 *         --color[={always,never,auto}]   Control coloring
                 * 
                 */
                $this->init_cli();
                $this->params = true;
                $this->cli->addRule('l', "use a long listing format");
                //$this->cli->addFlag("long", array("alias" => "-l", "default" => false, "help" => "Use a long listing format"));
                # code...
                break;
            case 'touch':
                /**
                 * Usage: touch [-c] [-d DATE] [-t DATE] [-r FILE] FILE...
                 *
                 *   Update the last-modified date on the given FILE[s]
                 *   
                 *           -c      Don't create files
                 *           -h      Don't follow links
                 *           -d DT   Date/time to use
                 *           -t DT   Date/time to use
                 *           -r FILE Use FILE's date/time
                 */
                $this->init_cli();
                $this->params = true;
                $this->cli->addRule('l', "use a long listing format");
                break;
            case 'mkdir':
                /**
                 * Usage: mkdir [OPTIONS] DIRECTORY...
                 *  Create DIRECTORY
                 *              
                 *          -m MODE Mode
                 *          -p      No error if exists; make parent directories as needed
                 */
                $this->init_cli();
                $this->params = true;
                $this->cli->addRule('l', "use a long listing format");
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
