<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="col-md-12">
	  <h1>
		  Video Analysis
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>dashboard/">Dashboard</a></li>
        <li class="active">Video Analysis</li>
      </ol>
	  </div>
    </section>
	
	<?php 		
		$user = '';
		$code = '';
		$id = '';
	?>

<!-- <iframe src="https://player.vimeo.com/video/134941077" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> -->
<script src="https://player.vimeo.com/api/player.js"></script>

<script>

   /* 	var iframe = document.querySelector('iframe');
		var player = new Vimeo.Player(iframe);
		player.on('ended', function() {
			//ENTER END TRIGGER FUNCTION HERE
			alert("Your Vimeo video has now ended");
		}); */
selectedlink =  "videolinkmenu";
</script>
    <!-- Main content -->
    <section class="content" style="clear:both;">
		<!-- <iframe
  id="p_1_zone_4_video" height="500px"
  style="width:100%; border:0 none;" 
  src="https://www.youtube.com/embed/b4Yx9eHfsuc?enablejsapi=1&playlist=1La4QzGeaaQ,F-1weFCiYBA"> -->
		<div class="container box">
			<div class="row pt-3" id="videos_data">
						<?php 
							if(isset($videoslist) && $videoslist!=""){
								foreach($videoslist as $workouts){
									$user = $workouts['user_id'];
									$code = $workouts['code'];
									$id = $workouts['id'];
									
									echo '<div class="col-md-12 col-sm-12 col-xs-12" ><div style="padding:20px;">';
									print_r($code);
									echo '</div></div>';
									
								}
							}
						?>
					
		</div>
		<div style="clear:both;"></div>
    </section>
    <!-- /.content -->
	<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<style>
#videos_data iframe{
	max-width:100%;
    width: 100%;
	height: 500px;
}

div#videos_data > div > div {
    display: flex;
    flex-direction: column;
    align-content: center;
    height: 500px;
    justify-content: center;
}
</style>
<!-- /.content-wrapper -->