<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<div class="col-md-12">
			<h1>
				My Workouts
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?=base_url()?>dashboard/">Dashboard</a></li>
				<li><a href="<?=base_url()?>dashboard/assessments">Assessments</a></li>
				<li class="active">My Workouts</li>
			</ol>
		</div>
    </section>

    <!-- Main content -->
    <section class="content">
		<!-- Info boxes -->
		<?php
			$selecteddate = '';
			$maindata = array();
			$uniquedatearray = array();
			$sortdate = array();	
		?>
		
		<div class="row" style="">
			<div class="col-md-12">
			<?php
				error_reporting(E_ERROR | E_PARSE);
				//print_r($workouts);
				function parse_youtube($link){
		
					$regexstr = '~
						# Match Youtube link and embed code
						(?:				 				# Group to match embed codes
							(?:<iframe [^>]*src=")?	 	# If iframe match up to first quote of src
							|(?:				 		# Group to match if older embed
								(?:<object .*>)?		# Match opening Object tag
								(?:<param .*</param>)*  # Match all param tags
								(?:<embed [^>]*src=")?  # Match embed tag to the first quote of src
							)?				 			# End older embed code group
						)?				 				# End embed code groups
						(?:				 				# Group youtube url
							https?:\/\/		         	# Either http or https
							(?:[\w]+\.)*		        # Optional subdomains
							(?:               	        # Group host alternatives.
							youtu\.be/      	        # Either youtu.be,
							| youtube\.com		 		# or youtube.com 
							| youtube-nocookie\.com	 	# or youtube-nocookie.com
							)				 			# End Host Group
							(?:\S*[^\w\-\s])?       	# Extra stuff up to VIDEO_ID
							([\w\-]{11})		        # $1: VIDEO_ID is numeric
							[^\s]*			 			# Not a space
						)				 				# End group
						"?				 				# Match end quote if part of src
						(?:[^>]*>)?			 			# Match any extra stuff up to close brace
						(?:				 				# Group to match last embed code
							</iframe>		         	# Match the end of the iframe	
							|</embed></object>	        # or Match the end of the older embed
						)?				 				# End Group of last bit of embed code
						~ix';
					
					preg_match($regexstr, $link, $matches);
					
					if(isset($matches[1]) && $matches[1]!="")
						return $matches[1];
					else
						return false;
					
				}
				function parse_vimeo($link){
		
					$regexstr = '~
						# Match Vimeo link and embed code
						(?:<iframe [^>]*src=")?		# If iframe match up to first quote of src
						(?:							# Group vimeo url
							https?:\/\/				# Either http or https
							(?:[\w]+\.)*			# Optional subdomains
							vimeo\.com				# Match vimeo.com
							(?:[\/\w]*\/videos?)?	# Optional video sub directory this handles groups links also
							\/						# Slash before Id
							([0-9]+)				# $1: VIDEO_ID is numeric
							[^\s]*					# Not a space
						)							# End group
						"?							# Match end quote if part of src
						(?:[^>]*></iframe>)?		# Match the end of the iframe
						(?:<p>.*</p>)?		        # Match any title information stuff
						~ix';
					
					preg_match($regexstr, $link, $matches);
					
					if(isset($matches[1]) && $matches[1]!="")
						return $matches[1];
					else
						return false;
					
				}
				
				$flag = false;
				
							
				foreach($workouts as $works){
					echo '<h2 class="datehead" style="margin-top:0;">'.$works->assessment_date.'</h2>';
					echo '<div class="videoslist">';
					if(isset($works->llvideos) && $works->llvideos!=""){
						foreach($works->llvideos as $ll){
							$id = '';
							$content = '';
							if(parse_vimeo($ll->code)) {
								$id = parse_vimeo($ll->code);
								try{
									$data = file_get_contents("https://vimeo.com/api/v2/video/$id.json");
									$data = json_decode($data);
									$thumbnail = $data[0]->thumbnail_medium;
									if($thumbnail=='')
										$thumbnail = base_url().'/public/images/no-image.png';
								}catch(exception $e){
									$thumbnail = base_url().'/public/images/no-image.png';
								}
								$content = '<a data-fancybox="gallery" data-autoplayvideo="false"  data-caption="<h2>'.$ll->title.'</h2><p>'.$ll->description.'</p>" data-playvideoonclick="false" data-ratio="2" href="https://vimeo.com/'.$id.'?autoplay=0"><img class="card-img-top img-fluid" src="'.$thumbnail.'"></a>';
							} else if(parse_youtube($ll->code)) {
								$id = parse_youtube($ll->code);
								$content = '<a data-fancybox="gallery" data-autoplayvideo="false" data-caption="Caption for single image" data-playvideoonclick="false" href="https://www.youtube.com/watch?v='.$id.'&autoplay=0"><img class="card-img-top img-fluid" src="https://img.youtube.com/vi/'.$id.'/mqdefault.jpg"></a>';
							} else {
								$content = $ll->code;
							}
				
							//$popup = '<a class="viewdet" data-toggle="modal" data-target="#modal-default'.$ll->id.'">View More</a><div class="modal fade" id="modal-default'.$ll->id.'"><div class="modal-dialog"><div class="modal-content" style="color:black;"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">'.$ll->title.'</h4></div><div class="modal-body"><p>'.$ll->description.'</p></div><div class="modal-footer"><button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button></div></div></div></div>';
							//echo '<div class="individualvideo"><div>'.$content.'</div><div>'.$ll->title.'</div></div>';
							echo '<div class="breakdownclass"><div>'.$content.'</div><h2><b>'.$ll->title.'</b><br/><span>'.$ll->description.'</span><a class="viewdet">View More</a></h2></div>';
							$flag = true;
						}
					}
					//echo '</div>';
					
					if(isset($works->sflsblvideos) && $works->sflsblvideos!=""){
						//echo '<div class="videoslist">';
						foreach($works->sflsblvideos as $ll){
							$id = '';
							$content = '';
							if(parse_vimeo($ll->code)) {
								$id = parse_vimeo($ll->code);
								try{
									$data = file_get_contents("https://vimeo.com/api/v2/video/$id.json");
									$data = json_decode($data);
									$thumbnail = $data[0]->thumbnail_medium;
									if($thumbnail=='')
										$thumbnail = base_url().'/public/images/no-image.png';
								}catch(exception $e){
									$thumbnail = base_url().'/public/images/no-image.png';
								}
								$content = '<a data-fancybox="gallery" data-autoplayvideo="false"  data-caption="<h2>'.$ll->title.'</h2><p>'.$ll->description.'</p>" data-playvideoonclick="false" data-ratio="2" href="https://vimeo.com/'.$id.'?autoplay=0"><img class="card-img-top img-fluid" src="'.$thumbnail.'"></a>';
							} else if(parse_youtube($ll->code)) {
								$id = parse_youtube($ll->code);
								$content = '<a data-fancybox="gallery" data-autoplayvideo="false"  data-caption="<h2>'.$ll->title.'</h2><p>'.$ll->description.'</p>" data-playvideoonclick="false" href="https://www.youtube.com/watch?v='.$id.'&autoplay=0"><img class="card-img-top img-fluid" src="https://img.youtube.com/vi/'.$id.'/mqdefault.jpg"></a>';
							} else {
								$content = $ll->code;
							}
							//$popup = '<a class="viewdet" data-toggle="modal" data-target="#modal-default'.$ll->id.'">View More</a><div class="modal fade" id="modal-default'.$ll->id.'"><div class="modal-dialog"><div class="modal-content" style="color:black;"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">'.$ll->title.'</h4></div><div class="modal-body"><p>'.$ll->description.'</p></div><div class="modal-footer"><button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button></div></div></div></div>';
							//echo '<div class="individualvideo"><div>'.$content.'</div><div>'.$ll->title.'</div></div>';
							echo '<div class="breakdownclass"><div>'.$content.'</div><h2><b>'.$ll->title.'</b><br/><span>'.$ll->description.'</span><a class="viewdet">View More</a></h2></div>';
							$flag = true;
						}
						//echo '</div>';
					}
					
					if(isset($works->sblvideos) && $works->sblvideos!=""){
						//echo '<div class="videoslist">';
						foreach($works->sblvideos as $ll){
							
							
							$id = '';
							$content = '';
							//$popup = '<a class="viewdet" data-toggle="modal" data-target="#modal-default'.$ll->id.'">View More</a><div class="modal fade" id="modal-default'.$ll->id.'"><div class="modal-dialog"><div class="modal-content" style="color:black;"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">'.$ll->title.'</h4></div><div class="modal-body"><p>'.$ll->description.'</p></div><div class="modal-footer"><button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button></div></div></div></div>';
							
							if(parse_vimeo($ll->code)) {
								$id = parse_vimeo($ll->code);
								try{
									$data = file_get_contents("https://vimeo.com/api/v2/video/$id.json");
									$data = json_decode($data);
									$thumbnail = $data[0]->thumbnail_medium;
									if($thumbnail=='')
										$thumbnail = base_url().'/public/images/no-image.png';
								}catch(exception $e){
									$thumbnail = base_url().'/public/images/no-image.png';
								}
								$content = '<a data-fancybox="gallery" data-autoplayvideo="false"  data-caption="<h2>'.$ll->title.'</h2><p>'.$ll->description.'</p>" data-playvideoonclick="false" data-ratio="2" href="https://vimeo.com/'.$id.'?autoplay=0"><img class="card-img-top img-fluid" src="'.$thumbnail.'"></a>';
							} else if(parse_youtube($ll->code)) {
								$id = parse_youtube($ll->code);
								$content = '<a data-fancybox="gallery" data-autoplayvideo="false"  data-caption="<h2>'.$ll->title.'</h2><p>'.$ll->description.'</p>" data-playvideoonclick="false" href="https://www.youtube.com/watch?v='.$id.'&autoplay=0"><img class="card-img-top img-f   luid" src="https://img.youtube.com/vi/'.$id.'/mqdefault.jpg"></a>';
							} else {
								$content = $ll->code;
							}
								
							//echo '<div class="individualvideo"><div>'.$content.'</div><div>'.$ll->title.'</div></div>';
							echo '<div class="breakdownclass"><div>'.$content.'</div><h2><b>'.$ll->title.'</b><br/><span>'.$ll->description.'</span><a class="viewdet">View More</a></h2></div>';
							$flag = true;
						}
						//echo '</div>';
					}
					
					if(isset($works->splvideos) && $works->splvideos!=""){
						//echo '<div class="videoslist">';
						foreach($works->splvideos as $ll){
							$id = '';
							$content = '';
							if(parse_vimeo($ll->code)) {
								$id = parse_vimeo($ll->code);
								try{
									$data = file_get_contents("https://vimeo.com/api/v2/video/$id.json");
									$data = json_decode($data);
									$thumbnail = $data[0]->thumbnail_medium;
									if($thumbnail=='')
										$thumbnail = base_url().'/public/images/no-image.png';
								}catch(exception $e){
									$thumbnail = base_url().'/public/images/no-image.png';
								}
								$content = '<a data-fancybox="gallery" data-autoplayvideo="false"  data-caption="<h2>'.$ll->title.'</h2><p>'.$ll->description.'</p>" data-playvideoonclick="false" data-ratio="2" href="https://vimeo.com/'.$id.'?autoplay=0"><img class="card-img-top img-fluid" src="'.$thumbnail.'"></a>';
							} else if(parse_youtube($ll->code)) {
								$id = parse_youtube($ll->code);
								$content = '<a data-fancybox="gallery" data-autoplayvideo="false"  data-caption="<h2>'.$ll->title.'</h2><p>'.$ll->description.'</p>" data-playvideoonclick="false" href="https://www.youtube.com/watch?v='.$id.'&autoplay=0"><img class="card-img-top img-fluid" src="https://img.youtube.com/vi/'.$id.'/mqdefault.jpg"></a>';
							} else {
								$content = $ll->code;
							}
							//$popup = '<a class="viewdet" data-toggle="modal" data-target="#modal-default'.$ll->id.'">View More</a><div class="modal fade" id="modal-default'.$ll->id.'"><div class="modal-dialog"><div class="modal-content" style="color:black;"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">'.$ll->title.'</h4></div><div class="modal-body"><p>'.$ll->description.'</p></div><div class="modal-footer"><button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button></div></div></div></div>';
							
							//echo '<div class="individualvideo"><div>'.$content.'</div><div>'.$ll->title.'</div></div>';
							echo '<div class="breakdownclass"><div>'.$content.'</div><h2><b>'.$ll->title.'</b><br/><span>'.$ll->description.'</span><a class="viewdet">View More</a></h2></div>';
							$flag = true;
						}
					}
					
					echo '</div>';
					
					if($flag)
						break;
				}
			?>
			</div>
		</div>
		
		<div style="clear:both;"></div>
    </section>
    <!-- /.content -->
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>

<style>
a[data-fancybox=gallery]:hover:after{
	opacity: 1;
}
a[data-fancybox=gallery]:after {
    content: '';
    background: url(https://portal.baselinemotion.com/public/images/vimeo-play-button-png.png);
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    opacity: 0.6;
    background-position: center;
    background-size: 80px;
    background-repeat: no-repeat;
}
a[data-fancybox=gallery] {
    position: relative;
    float: left;
    width: 100%;
}
@media only screen and (min-width: 768px) {
	.fancybox-is-open .fancybox-stage .fancybox-slide {
		padding-bottom: 265px!important;
	}
	.fancybox-caption .fancybox-caption__body{
		height: 220px!important;
	}
}
.videoslist .breakdownclass h2{
	cursor: pointer;
}
.fancybox-caption.fancybox-caption--separate h2 {
    text-transform: capitalize;
}
.breakdownclass{
	width: 31.3%;
}
.fancybox-caption .fancybox-caption__body {
    max-width: 1100px;
    margin: auto;
    height: 100px;
}
.breakdownclass h2 b {
    font-weight: 600;
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    float: left;
    text-overflow: ellipsis;
	text-transform: capitalize;
}
.videoslist img{
	width: 100%;
}
.videoslist .individualvideo > div:nth-child(2) {
    background: black;
    padding: 0 10px 10px 10px;
    color: white;
    text-align: center;
    text-transform: uppercase;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
    width: 250px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}
h2.datehead {
    float: left;
    width: 100%;
    padding: 10px 15px;
    clear: both;
}
hr.datehr {
    float: left;
    width: calc(100% - 30px);
    clear: both;
    border-color: black;
    margin: 0 15px 15px 15px;
}
.videoslist{
	display: flex;
    clear: both;
    width: 100%;
    flex-wrap: wrap;
}
.videoslist .individualvideo{
	display: flex;
	flex-direction: column;
	border: 2px solid black;
    margin: 10px;
    padding: 20px 0 0 0;
    background: black;
}

.videoslist .individualvideo iframe {
    height: auto!important;
	min-height: 250px;
    width: 100%!important;
}

.summarydiv{
	display: flex;
    clear: both;
    width: 100%;
    justify-content: center;
    align-items: center;
}
.summarydiv .summarycls {
    flex: 1;
    text-align: center;
    border: 2px solid;
    padding: 0;
    /* box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.5), 0 2px 5px 0 rgba(0, 0, 0, 0.6); */
}
.summarydiv .summarycls .summaryclshead{
	background-color: gray;
	font-weight: bold;
	font-size: 20px;
	padding: 10px;
	border-bottom:3px solid black;
	color: white;
}
.summarydiv .summarycls .summaryclsbody:nth-child(2n){
	background-color: #f6f6f6;
	font-weight: normal;
	font-size: 17px;
	border-bottom:1px solid black;
}
.summarydiv .summarycls .summaryclsbody:nth-child(2n+1){
	background-color: #fff;
	font-weight: normal;
	font-size: 17px;
	border-bottom:1px solid black;
}
.summarydiv .summarycls .summaryclsbody {
    display: flex;
}
.summarydiv .summarycls .summaryclsbody * {
    flex: 1;
    padding: 10px;
}
.callout{
    float: left;
    width: 100%;
    margin: 0 0 1px 0;
}
.callout span{
	float: right;
}
.breakdownclass p img {
    max-width: 400px;
    float: left;
    clear: both;
    padding: 10px;
}
.callout * {width: 33%;float: left;}

.callout span {
    text-align: right;
}

.callout i {
    text-align: center;
}

.summarydiv .summarycls .summaryclsbody i {
    background: black;
    font-weight: 700;
    font-size: 22px;
    padding: 0;
    align-items: center;
    justify-content: center;
    display: flex;
	color: white;
	border-bottom: 1px solid white;
}

.summarydiv .summarycls .summaryclsbody:last-child, .summarydiv .summarycls .summaryclsbody:last-child i {
    border-bottom: 0px none;
}

.breakdownclass h2 > span
{
	padding-top: 20px;
	font-weight: 400;
	font-size: 16px;
	line-height: 22px;
	float: left;
	height: 88px;
	overflow: hidden;
	text-align: justify;
}
.breakdownclass h2 > span.active{
	height: auto!important;
}
.modal-body {
    font-size: 16px;
    text-align: justify;
    line-height: 24px;
    border: 0px none;
}
.modal-body p {
    border: 0px none!important;
    padding: 0 0 20px 0!important;
}
h4.modal-title {
    text-transform: capitalize;
    font-size: 3rem;
}
.fb-caption{
	position: absolute;
	left: 0;
	right: 0;
	bottom: -30px;
	z-index: 99996;
	pointer-events: none;
	text-align: center;
	transition: opacity 200ms;
	background: none;
}

.breakdownclass h2{
	padding-bottom: 45px;
	position: relative;
}
.breakdownclass h2 a {
    position: absolute;
    right: 5px;
    bottom: 5px;
    border: 0px none;
    font-size: 14px;
    text-transform: capitalize;
    text-decoration: underline;
    cursor: pointer;
}

@media only screen and (max-width: 768px) {
	.callout * {width: 100%; text-align: center!important; clear: both;}
	.summarydiv{flex-direction: column;}
	.fancybox-caption__body {
		max-height: 35vh!important;
	}
	.fancybox-caption .fancybox-caption__body{
		height: auto;
	}
	.fancybox-caption.fancybox-caption--separate h2{
		font-size: 24px;
	}
	.videoslist{
		padding: 0px 15px;
	}
	.videoslist .breakdownclass{
		width: 100%!Important;
	}
}
</style>
<!-- /.content-wrapper -->
<script>
	document.title = 'Workout | Baseline Motion';
	selectedlink =  "workoutlinkmenu";
</script>