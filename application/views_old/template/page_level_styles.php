<?php 
$url = $this->uri->segment(1);
$addition_css = "";
if(!empty($url)){
  if($url == 'category'){
    $addition_css = "";
  }
}
echo $addition_css;
?>