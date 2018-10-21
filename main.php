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

  function __construct($dir)
  {
    // code...
    $this->public_directory = $dir;
  }
  public function setConstant($name, $value)
  {
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;
    // code...

    $this->constants[] = $attr;
  }
  public function getConstant($name)
  {
    // code...
    $constantValue = "";
    foreach ($this->constants as $key => $value) {
      if($value["name"] == $name){
        $constantValue = $value["value"];
        break;
      }
      // code...
    }
    return $constantValue;
  }
  public function extends($className, $classDir){
    $attr = array();
    $attr["className"] = $className;
    $attr["classDir"] = $classDir;
    // code...

    $this->extends[] = $attr;
  }
  public function getExtends($name){
    $className = "";
    $classDir = "";
    foreach ($this->extends as $key => $value) {
      // code...
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
    // code...

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
    // code...
    $i = -1;
    foreach ($this->header as $key => $value) {
      // code...
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
    // code...

    $this->bodyAttr[] = $attr;
  }
  private function getBodyAttr()
  {
    // code...
    return $this->bodyAttr;
  }
  //**************************************
  public function setFooter($name, $value)
  {
    // code...
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;
    // code...

    $this->footer[] = $attr;
  }
  private function getFooter($name, $value){
    return $this->footer;
  }
  //**************************************
  public function setThemplate_parts($name, $value)
  {
    // code...
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;
    // code...

    $this->themplate_parts[] = $attr;
  }
  private function getThemplate_parts()
  {
    return $this->themplate_parts;
  }
  //*****************************************
  public function setHeaderThemplateParts($name, $value)
  {
    // code...
    // code...
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;
    // code...

    $this->headerThemplateParts[] = $attr;
  }
  private function getHeaderThemplateParts(){
    return $this->headerThemplateParts;
  }
  //*******************************************
  public function setFooterThemplateParts($name, $value)
  {
    // code...
    $attr = array();
    $attr["name"] = $name;
    $attr["value"] = $value;
    // code...

    $this->footerThemplateParts[] = $attr;
  }
  private function getFooterThemplateParts()
  {
    // code...
    return $this->footerThemplateParts;
  }


  //*******init***************************
  public function init()
  {
    ob_start();

    $this->includeThemplateParts();

    $contents = ob_get_contents();
    ob_end_clean();
    // code...
    echo  $this->getHtmlTag();

    echo "<head>";
    echo  $this->getHeaderincludes();
    echo  $this->includeHeaderThemplateParts();
    echo "</head>";
    echo  $this->getBodyTag();
          print $contents;
    echo  $this->getFooterincludes();
    echo  $this->includeFooterThemplateParts();
echo "</body></html>";
  }
  //**************************************
  private function getHtmlTag(){
    $attrs_html = "";
    foreach ($this->getHtmlAttr() as $key => $value) {
      // code...
      $attrs_html .= $value["name"].'='.'"'.$value["value"].'" ';
    }
    $html_tag = "<!DOCTYPE html><html ".$attrs_html.">";
    return $html_tag;
  }
  private function getHeaderincludes(){

    $headervalues = "";
    foreach ($this->getHeader() as $key => $value) {
      // code...
      $headervalues .= $value["value"];
    }

    return $headervalues;
  }
  private function getBodyTag(){
    $attr_body = "";
    foreach ($this->getBodyAttr() as $key => $value) {
      // code...
      $attr_body .= $value["name"].'='.'"'.$value["value"].'" ';
    }
    $body_tag = "<body ".$attr_body.">";
    return $body_tag;
  }
  private function includeThemplateParts()
  {

    foreach ($this->themplate_parts as $key => $value) {
      // code...
      include_once($this->public_directory."/".$value["value"]);
    }
    // code...
  }
  private function includeHeaderThemplateParts()
  {
    // code...
    foreach ($this->headerThemplateParts as $key => $value) {
      // code...
      include_once($this->public_directory."/".$value["value"]);
    }
  }
  private function includeFooterThemplateParts()
  {
    // code...
    foreach ($this->footerThemplateParts as $key => $value) {
      // code...
      include_once($this->public_directory."/".$value["value"]);
    }
  }
  private function getFooterincludes(){
    $footervalues = "";
    foreach ($this->footer as $key => $value) {
      // code...

      $footervalues .= $value["value"];
    }
    return $footervalues;
  }
  private function get_themplate_part($dir){
    include_once($this->public_directory."/".$dir);
  }

}
