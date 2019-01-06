<?php
/**
 *
 */
class main_api
{
  private $htmlAttr = array();
  private $header = array();
  private $headerThemplateParts = array();
  private $bodyAttr = array();
  private $footer = array();
  private $footerThemplateParts = array();
  private $themplate_parts = array();
  private $public_directory = "";
  private $extends = array();
  private $constants = array();
  private $values = array();

  function __construct($dir)
  {
     
    $this->public_directory = $dir;
  }
    public function setValue($name, $value){
        $this->values[$name] = $value;
    }
    public function getValue($name){
        return $this->values[$name];
    }
  public function setConstant($name, $value)
  {
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;
     

    $this->constants[$name] = $value;
  }
  public function getConstant($name)
  {
     
    $constantValue = "";
    foreach ($this->constants as $key => $value) {
      if($value["name"] == $name){
        $constantValue = $value["value"];
        break;
      }
       
    }
    return $constantValue;
  }
  public function _extends($className, $classDir){
    $attr = array();
    $attr["className"] = $className;
    $attr["classDir"] = $classDir;
     

    $this->extends[] = $attr;
  }
  public function getExtends($name){
    $className = "";
    $classDir = "";
    foreach ($this->extends as $key => $value) {
       
      if($value["className"] == $name){
        $className = $value["className"];
        $classDir = $value["classDir"];
        break;
      }
    }
    if($className == "") return null;
    include_once(dirname(__FILE__)."/".$classDir);
    $class = new $className;

    return $class;
  }
  //**************************************
  public function setHtmlAttr($name, $value)
  {
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;
     

    $this->htmlAttr[] = $attr;
  }
  private function getHtmlAttr(){
    return $this->htmlAttr;
  }
  //**************************************
  public function setHeader($name, $value)
  {
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;
     
    $i = -1;
    foreach ($this->header as $key => $value) {
       
      if($name == $value["name"]){
        $i = $key;
        break;
      }
    }
    if($i != -1){
      unset($this->header[$i]);
    }
    $this->header[] = $attr;
  }
  private function getHeader(){
    return $this->header;
  }
  //***************************************
  public function setBodyAttr($name, $value)
  {
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;
     

    $this->bodyAttr[] = $attr;
  }
  private function getBodyAttr()
  {
     
    return $this->bodyAttr;
  }
  //**************************************
  public function setFooter($name, $value)
  {
     
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;

    $this->footer[] = $attr;
  }
  private function getFooter($name, $value){
    return $this->footer;
  }
  //**************************************
  public function setThemplate_parts($name, $value)
  {
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;

    $this->themplate_parts[] = $attr;
  }
  private function getThemplate_parts()
  {
    return $this->themplate_parts;
  }
  //*****************************************
  public function setHeaderThemplateParts($name, $value)
  {
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;

    $this->headerThemplateParts[] = $attr;
  }
  private function getHeaderThemplateParts(){
    return $this->headerThemplateParts;
  }
  //*******************************************
  public function setFooterThemplateParts($name, $value)
  {
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;

    $this->footerThemplateParts[] = $attr;
  }
  private function getFooterThemplateParts()
  {
    return $this->footerThemplateParts;
  }


  //*******init***************************
  public function init()
  {
    ob_start();

    $this->includeThemplateParts();
    $contents = ob_get_contents();
    ob_end_clean();
    echo  $this->getHtmlTag();
    echo "<head>";
    echo  $this->sanitize_output($this->getHeaderincludes());
    echo  $this->includeHeaderThemplateParts();
    echo "</head>";
    echo  $this->getBodyTag();
          print $this->sanitize_output($contents);
    echo  $this->sanitize_output($this->getFooterincludes());
    echo  $this->includeFooterThemplateParts();
    echo "</body></html>";
  }
  //**************************************
  private function getHtmlTag(){
    $attrs_html = "";
    foreach ($this->getHtmlAttr() as $key => $value) {
      $attrs_html .= $value["name"].'='.'"'.$value["value"].'" ';
    }
    $html_tag = "<!DOCTYPE html><html ".$attrs_html.">";
    return $html_tag;
  }
  private function getHeaderincludes(){

    $headervalues = "";
    foreach ($this->getHeader() as $key => $value) {
      $headervalues .= $value["value"];
    }

    return $headervalues;
  }
  private function getBodyTag(){
    $attr_body = "";
    foreach ($this->getBodyAttr() as $key => $value) {
      $attr_body .= $value["name"].'='.'"'.$value["value"].'" ';
    }
    $body_tag = "<body ".$attr_body.">";
    return $body_tag;
  }
  private function includeThemplateParts()
  {

    foreach ($this->themplate_parts as $key => $value) {
      include_once($this->public_directory."/".$value["value"]);
    }
  }
  private function includeHeaderThemplateParts()
  {
    foreach ($this->headerThemplateParts as $key => $value) {
        $contents = file_get_contents($this->public_directory."/".$value["value"]);
        print $this->sanitize_output($contents);
    }
  }
  private function includeFooterThemplateParts()
  {
    foreach ($this->footerThemplateParts as $key => $value) {
     $contents = file_get_contents($this->public_directory."/".$value["value"]);
        print $this->sanitize_output($contents);
        
    }
  }
  private function getFooterincludes(){
    $footervalues = "";
    foreach ($this->footer as $key => $value) {

      $footervalues .= $value["value"];
    }
    return $footervalues;
  }
  private function get_themplate_part($dir){
    include_once($this->public_directory."/".$dir);
  }

    function sanitize_output($buffer) {

    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // Remove HTML comments
    );
          

    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );
    $buffer = preg_replace('/(?<=;)\s+\/\/[^\n]+/m', '', $buffer);
    $buffer = preg_replace($search, $replace, $buffer);
    $buffer = preg_replace('/\s+\/\/[^\n]+/m', '', $buffer);
        
    return $buffer;
}
   

}
