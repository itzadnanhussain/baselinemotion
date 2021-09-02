<?php 
$url = $this->uri->segment(1);
$addition_js;
if(!empty($url)){
  if($url == 'category'){
  	?>
    <script src="<?=base_url()?>public/dist/js/pages/category.js"></script>
    <?php 
  }
}
// echo $addition_js;
?>