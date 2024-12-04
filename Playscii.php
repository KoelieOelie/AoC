<?php
class Charset
{
    public $font;
    private $about;
    public $size;
    public function __construct($filename) {
        //$this->var = $var;
        $tmp=mb_str_split(file_get_contents($filename),1, "utf-8");
        $ttemp="";
        $buffer=array();
        for ($i=0; $i < sizeof($tmp); $i++) {
            if ($tmp[$i] === "\n") {
                if (!str_starts_with($ttemp, "//")) {
                    $buffer[] = $ttemp;
                }
                
                $ttemp = "";
            } else {
                $ttemp .= $tmp[$i];
            }
        }
        if (!str_starts_with($ttemp, "//")) {
            $buffer[] = $ttemp;
        }
        ////echo "/*". $filename."*/";
        //$this->about= array(str_replace("// ","",$tmp[0]), $tmp[1]);
        //$font=array();
        unset($buffer[0]);
        unset($buffer[1]);
        $this->font = mb_str_split(join("", $buffer), 1, "utf-8");
    }
    private function get_size(string $size):array {
        $t= explode(",", str_replace(" ", "", $size));
        foreach ($t as $key => $value) {
            $t[$key]= intval($value);
        }
        return $t;
    }
    function getCharFromIndex($index) : string {
        if (!isset($this->font[$index])) {
            $this->font[$index] = "\x1b1h\xb10";
        }
        return $this->font[$index];
    }
}

class Playscii //implements JsonSerializable 
{
    private $data;
    private $charater_set = array();
    public function __construct($filename) {
        foreach (glob("AoC_files/os_hidden/Playscii_Charsets/*.char") as $filename_chr) {
           $this->charater_set[str_replace(array("AoC_files/os_hidden/Playscii_Charsets/",".char"),"", $filename_chr)]=new Charset($filename_chr);
        }
        $this->data = json_decode(file_get_contents($filename),true);
    }
    /*public function jsonSerialize()
    {
        $x=0;
        $y = "";
        $out=array();
        $charset= $this->charater_set[$this->data["charset"]];
        $out[]= $charset;
        foreach ($this->data["frames"][0]["layers"][0]["tiles"] as $cell) {
            $y .= $charset->getCharFromIndex($cell["char"]);
            //$y.= $cell["char"];
            if ($x=== $this->data["width"]-1) {
                $out[]= $y;
                $x = 0;
                $y = "";
            } else {
                $x++;
            }
            
            
        }
        return $out;
    }*/
    
}
