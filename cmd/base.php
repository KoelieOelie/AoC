<?php
use CHH\Optparse\Parser;
/**
 * Get options from the command line or web request
 * 
 * @param string $options
 * @param array $longopts
 * @return array
 */
function getoptreq($options, $longopts)
{
    if (PHP_SAPI === 'cli' || empty($_SERVER['REMOTE_ADDR']))  // command line
    {
        return getopt($options, $longopts);
    } else if (isset($_REQUEST))  // web script
    {
        $found = array();

        $shortopts = preg_split('@([a-z0-9][:]{0,2})@i', $options, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $opts = array_merge($shortopts, $longopts);

        foreach ($opts as $opt) {
            if (substr($opt, -2) === '::')  // optional
            {
                $key = substr($opt, 0, -2);

                if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key]))
                    $found[$key] = $_REQUEST[$key];
                else if (isset($_REQUEST[$key]))
                    $found[$key] = false;
            } else if (substr($opt, -1) === ':')  // required value
            {
                $key = substr($opt, 0, -1);

                if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key]))
                    $found[$key] = $_REQUEST[$key];
            } else if (ctype_alnum($opt))  // no value
            {
                if (isset($_REQUEST[$opt]))
                    $found[$opt] = false;
            }
        }

        return $found;
    }

    return false;
}
class base_cmd
{
    protected $help="No help found";
    protected $cli;
    protected function init_cli() {
        $this->cli = new Parser($this->help);
        
    }
    /**
     * ## Adds a flag to the parser.
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
        //$flag = new Flag($name, $options, $callback);

        //foreach ($flag->aliases as $alias) {
            //$this->flags[$alias] = $flag;
        //}

        return $this;
    }
    public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        return json_encode(["data"=> "\x1b3".htmlentities($arguments[1]) . ": command not found.\x1b0"]);
        echo  "/*Calling object method '$name' ". print_r($arguments,true) . "\n*/";
    }
    function __toString()
    {
        //$opts = getoptreq('abc:d:e::f::', array('one', 'two', 'three:', 'four:', 'five::'));
        return $this->help;//json_encode($opts);
    }
}
