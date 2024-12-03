<?php
class base_cmd
{
    protected $help="No help found";
    protected $cli;
    protected function init_cli() {
        $this->cli = new OptionParser;
        $this->cli->addHead($this->help);
        
    }
    /**
     * ## Adds a flag to the parser.
     * @deprecated since 3-12-2024
     * 
     * Flags are arguments which typically begin with either one or two dashes.
     * @param string $name - Name of the flag. By default the flag's argument name is "--$name".
     * @param array $options - Array of options (default: array()):
     * #####           'alias'  - Alias(es) for the flag, for example '-h'. By default the only
     * ######                     alias is the flag's name prefixed with two dashes.
     * #####        'has_value' - Denotes that the argument following this flag
     * ######                         is the flag's value (default: false).
     * #####         'default'   - Default value, when the flag is not passed (default: null).
     * #####         'required'  - Throw an exception when the flag is omitted (default: false).
     * #####         'var'       - Reference to a variable which should be set to the flag's value.
     */
    function addFlag($name, $options = array(), $callback = null)
    {
        $this->cli->addFlag($name, $options, $callback);

        return $this;
    }
    public function __call($name, $arguments)
    {
        //echo $name;
        //// Note: value of $name is case sensitive.
        //if (!isset($arguments[1])) {
        //    $arguments=[$name];
        //}
        return json_encode(["data"=> "\x1b3".htmlentities($name) . ": command not found.\x1b0"]);
        //echo  "/*Calling object method '$name' ". print_r($arguments,true) . "\n*/";
    }
    function cmd_fall($name) {
        return $this->__call($name,null);
    }
    function __toString()
    {
        //$opts = getoptreq('abc:d:e::f::', array('one', 'two', 'three:', 'four:', 'five::'));
        return $this->help;//json_encode($opts);
    }
}
