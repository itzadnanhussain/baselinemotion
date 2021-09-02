<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<div class="col-md-12">
			<h1>
				<span>Assessments <a href="<?php echo base_url(); ?>dashboard/workoutsobj" style="padding: 0px;margin: 0;color: black; border-radius: 50%; font-size: 18px; "><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a></span>
			
				<?php 
					
					$enddate = date('m-d-Y');
					$date = DateTime::createFromFormat('m-d-Y', '01-01-2018');
					$startdate = $date->format('m-d-Y');
					$startdate1 = $date->format('m-d-Y');
					$enddate1 = date('m-d-Y');
					if(isset($_REQUEST['start']) && $_REQUEST['start'] != "")
					{	
						$date = DateTime::createFromFormat('Y-m-d', $_REQUEST['start']);
						$startdate = $date->format('m-d-Y');
					}
					if(isset($_REQUEST['end']) && $_REQUEST['end'] != "")
					{	
						$date = DateTime::createFromFormat('Y-m-d', $_REQUEST['end']);
						$enddate = $date->format('m-d-Y');
					}
					
				?>
				<div class="input-group" style="float: right; margin-bottom: 30px;">
					<button type="button" class="btn btn-default pull-right btn-primary" id="daterange-btn" style="padding: 10px;">
						<span style="color: white; margin-right: 10px; font-size: 16px;">
							<i class="fa fa-calendar" style="padding: 0px 10px 5px 5px;"></i> <?php print_r( $startdate." - ".$enddate ); ?>
						</span>
						<i class="fa fa-caret-down" style="color: white;"></i>
					</button>
				</div>
				<ol class="breadcrumb" style="position: relative; top: 10px; right: 25px;">
					<li><a href="<?=base_url()?>dashboard/">Dashboard</a></li>
					<li class="active">Assessments</li>
				</ol>
			</h1>
		</div>
    </section>
	<!-- <pre>
	<?php print_r($res); ?>
	</pre> -->
    <!-- Main content -->
    <section class="content assessmentclass" >
		<?php
		
			$startdate1 = $date->format('Y-m-d');
			$enddate1 = date('Y-m-d');
		
			$maindata = array();
			$uniquedatearray = array();
			$practitionerarray = array();
			$practitionerclinicarray = array();
			$practitionerdate = array();
			$clinicdate = array();
			$clinicarray = array();
			$sortdate = array();
			$imagearray = array();
			$title = array();
			foreach($practitioner as $practitionerobj) {
				$practitionerarray[$practitionerobj->id] = $practitionerobj->name." ".$practitionerobj->surname;
				$practitionerclinicarray[$practitionerobj->id] = $practitionerobj->clinicId;
			}
			
			foreach($clinic as $clinicobj) {
				if($clinicobj->name != "")
					$clinicarray[$clinicobj->id] = $clinicobj->name;
				else
					$clinicarray[$clinicobj->id] = "BASELINE MOTION";
			}				
			
			foreach($res->romAssessments as $romsession){
				$data1 = array();
				$date=date_create($romsession->date);
				$t = date_format($date,"m-d-Y");
				$data1['date'] = $t;
				if($romsession->jointType == "SpineMid")
					$data1['type'] = 'Back '.$romsession->movementType;
				else
					$data1['type'] = $romsession->jointType.' '.$romsession->movementType;
				$data1['score'] = round($romsession->score * 100 ,2). "%";
				
				$iphoto = '';
				if(isset($romsession->assessmentFrames[0]->imagePath) && $romsession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $romsession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					if(@is_array(getimagesize("/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic)))
						$iphoto = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}
				
				if(isset($romsession->videoFilePath) && $romsession->videoFilePath!=""){
					$imgpath = $romsession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$foldername = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					$fdname = "/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					
					$foldername = str_replace(".zip","/",$foldername);
					$fdname = str_replace(".zip","/",$fdname);
					// print_r("1:::".$foldername."::".$fdname);
					$c = 1;
					$vc = '';
					if(is_dir($fdname)) {
						// print_r("1.1:::");
						if ($handle = opendir($fdname)) {
							// print_r("1.2:::");
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != "..") {
									if (strpos($entry, '.jpg') !== false)
									{
										$videoimagepath = $foldername.$entry;
										$iphoto = $videoimagepath;
										break;
									}
								}
							}
						}
					}
				}
				/*$data1['imagePath'] = $romsession->imagePath;
				$data1['videoFilePath'] = $romsession->videoFilePath;*/
				
				//print_r("<br/>=================".$iphoto);
				if(isset($_REQUEST['start']) && $_REQUEST['start'] != "" && isset($_REQUEST['end']) && $_REQUEST['end'] != ""){
					$t1 = date_format($date,"Y-m-d");
					$st = $_REQUEST['start'];
					$ed = $_REQUEST['end'];
					$cur = $t1;
					if( $cur >= $st && $ed >= $cur){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $romsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['romAssessments'][] = $data1;
					}
				}else{
					$t1 = date_format($date,"Y-m-d");
					$cur = $t1;
					/*print_r($cur);
					print_r($startdate1);
					print_r($enddate1);*/
					if( $cur >= $startdate1 && $cur <= $enddate1){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $romsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['romAssessments'][] = $data1;
					}
				}
				
				if($iphoto!=""){
					if(!isset($imagearray[$t]))
						$imagearray[$t] = $iphoto;
					else if($imagearray[$t] =="")
						$imagearray[$t] = $iphoto;
				}
			} 
		
			foreach($res->overheadSquatAssessments as $overheadsession){	
				$data1 = array();
				$date=date_create($overheadsession->date);
				$t = date_format($date,"m-d-Y");
				$data1['date'] = $t;
				$data1['type'] = 'Overhead Squat';
				$data1['score'] = round($overheadsession->score * 100 ,2). "%";
				/*$data1['imagePath'] = $overheadsession->imagePath;
				$data1['videoFilePath'] = $overheadsession->videoFilePath;*/
				$iphoto = '';
				if(isset($overheadsession->assessmentFrames[0]->imagePath) && $overheadsession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $overheadsession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					if(@is_array(getimagesize("/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic)))
						$iphoto = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}
				
				if(isset($overheadsession->videoFilePath) && $overheadsession->videoFilePath!=""){
					$imgpath = $overheadsession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$foldername = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					$fdname = "/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					
					$foldername = str_replace(".zip","/",$foldername);
					$fdname = str_replace(".zip","/",$fdname);
					// print_r("1:::".$foldername."::".$fdname);
					$c = 1;
					$vc = '';
					if(is_dir($fdname)) {
						// print_r("1.1:::");
						if ($handle = opendir($fdname)) {
							// print_r("1.2:::");
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != "..") {
									if (strpos($entry, '.jpg') !== false)
									{
										$videoimagepath = $foldername.$entry;
										$iphoto = $videoimagepath;
										break;
									}
								}
							}
						}
					}
				}
				
				
				if(isset($_REQUEST['start']) && $_REQUEST['start'] != "" && isset($_REQUEST['end']) && $_REQUEST['end'] != ""){
					$t1 = date_format($date,"Y-m-d");
					$st = $_REQUEST['start'];
					$ed = $_REQUEST['end'];
					$cur = $t1;
					
					if( $cur >= $st && $ed >= $cur){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $overheadsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['overheadAssessments'][] = $data1;
					}
				}else{
					$t1 = date_format($date,"Y-m-d");
					$cur = $t1;
					if( $cur >= $startdate1 && $cur <= $enddate1){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $overheadsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['overheadAssessments'][] = $data1;
					}
				}
				
				if($iphoto!=""){
					if(!isset($imagearray[$t]))
						$imagearray[$t] = $iphoto;
					else if($imagearray[$t] =="")
						$imagearray[$t] = $iphoto;
				}
				
			} 
		
			foreach($res->reverseLungeAssessments as $reverselungesession){
				$data1 = array();
				$date=date_create($reverselungesession->date);
				$t = date_format($date,"m-d-Y");
				$data1['date'] = $t;
				$data1['type'] = 'Reverse Lunge';
				$data1['score'] = round($reverselungesession->score * 100 ,2). "%";
				/*$data1['imagePath'] = $reverselungesession->imagePath;
				$data1['videoFilePath'] = $reverselungesession->videoFilePath;*/
				$iphoto = '';
				if(isset($reverselungesession->assessmentFrames[0]->imagePath) && $reverselungesession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $reverselungesession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					if(@is_array(getimagesize("/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic)))
						$iphoto = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}
				
				if(isset($reverselungesession->videoFilePath) && $reverselungesession->videoFilePath!=""){
					$imgpath = $reverselungesession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$foldername = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					$fdname = "/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					
					$foldername = str_replace(".zip","/",$foldername);
					$fdname = str_replace(".zip","/",$fdname);
					// print_r("1:::".$foldername."::".$fdname);
					$c = 1;
					$vc = '';
					if(is_dir($fdname)) {
						// print_r("1.1:::");
						if ($handle = opendir($fdname)) {
							// print_r("1.2:::");
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != "..") {
									if (strpos($entry, '.jpg') !== false)
									{
										$videoimagepath = $foldername.$entry;
										$iphoto = $videoimagepath;
										break;
									}
								}
							}
						}
					}
				}
				
				if(isset($_REQUEST['start']) && $_REQUEST['start'] != "" && isset($_REQUEST['end']) && $_REQUEST['end'] != ""){
					$t1 = date_format($date,"Y-m-d");
					$st = $_REQUEST['start'];
					$ed = $_REQUEST['end'];
					$cur = $t1;
					
					if( $cur >= $st && $ed >= $cur){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $reverselungesession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['reverselungeAssessments'][] = $data1;
					}
				}else{
					$t1 = date_format($date,"Y-m-d");
					$cur = $t1;
					if( $cur >= $startdate1 && $cur <= $enddate1){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $reverselungesession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['reverselungeAssessments'][] = $data1;
					}
				}
				
				if($iphoto!=""){
					if(!isset($imagearray[$t]))
						$imagearray[$t] = $iphoto;
					else if($imagearray[$t] =="")
						$imagearray[$t] = $iphoto;
				}
			} 
		
			foreach($res->wallAngelAssessments as $wallangelsession){	
				$data1 = array();
				$date=date_create($wallangelsession->date);
				$t = date_format($date,"m-d-Y");
				$data1['date'] = $t;
				$data1['type'] = 'Posture Angel';
				$data1['score'] = round($wallangelsession->score * 100 ,2). "%";
				/*$data1['imagePath'] = $wallangelsession->imagePath;
				$data1['videoFilePath'] = $wallangelsession->videoFilePath;*/
				
				$iphoto = '';
				if(isset($wallangelsession->assessmentFrames[0]->imagePath) && $wallangelsession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $wallangelsession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					if(@is_array(getimagesize("/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic)))
						$iphoto = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}
				
				if(isset($wallangelsession->videoFilePath) && $wallangelsession->videoFilePath!=""){
					$imgpath = $wallangelsession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$foldername = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					$fdname = "/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					
					$foldername = str_replace(".zip","/",$foldername);
					$fdname = str_replace(".zip","/",$fdname);
					// print_r("1:::".$foldername."::".$fdname);
					$c = 1;
					$vc = '';
					if(is_dir($fdname)) {
						// print_r("1.1:::");
						if ($handle = opendir($fdname)) {
							// print_r("1.2:::");
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != "..") {
									if (strpos($entry, '.jpg') !== false)
									{
										$videoimagepath = $foldername.$entry;
										$iphoto = $videoimagepath;
										break;
									}
								}
							}
						}
					}
				}
				
				if(isset($_REQUEST['start']) && $_REQUEST['start'] != "" && isset($_REQUEST['end']) && $_REQUEST['end'] != ""){
					$t1 = date_format($date,"Y-m-d");
					$st = $_REQUEST['start'];
					$ed = $_REQUEST['end'];
					$cur = $t1;
					
					if( $cur >= $st && $ed >= $cur){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $wallangelsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['wallangelAssessments'][] = $data1;
					}
				}else{
					$t1 = date_format($date,"Y-m-d");
					$cur = $t1;
					if( $cur >= $startdate1 && $cur <= $enddate1){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $wallangelsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['wallangelAssessments'][] = $data1;
					}
				}
				
				if($iphoto!=""){
					if(!isset($imagearray[$t]))
						$imagearray[$t] = $iphoto;
					else if($imagearray[$t] =="")
						$imagearray[$t] = $iphoto;
				}
				
			} 
		
			foreach($res->balanceAssessments as $balancesession){
				$data1 = array();
				$date=date_create($balancesession->date);
				$t = date_format($date,"m-d-Y");
				$data1['date'] = $t;
				$data1['type'] = 'Balance '.$balancesession->type;
				$data1['score'] = round($balancesession->score * 100 ,2). "%";
				/*$data1['imagePath'] = $balancesession->imagePath;
				$data1['videoFilePath'] = $balancesession->videoFilePath;*/
				
				$iphoto = '';
				if(isset($balancesession->assessmentFrames[0]->imagePath) && $balancesession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $balancesession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					if(@is_array(getimagesize("/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic)))
						$iphoto = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}
				if(isset($balancesession->videoFilePath) && $balancesession->videoFilePath!=""){
					$imgpath = $balancesession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$foldername = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					$fdname = "/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					
					$foldername = str_replace(".zip","/",$foldername);
					$fdname = str_replace(".zip","/",$fdname);
					// print_r("1:::".$foldername."::".$fdname);
					$c = 1;
					$vc = '';
					if(is_dir($fdname)) {
						// print_r("1.1:::");
						if ($handle = opendir($fdname)) {
							// print_r("1.2:::");
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != "..") {
									if (strpos($entry, '.jpg') !== false)
									{
										$videoimagepath = $foldername.$entry;
										$iphoto = $videoimagepath;
										break;
									}
								}
							}
						}
					}
				}
				
				
				if(isset($_REQUEST['start']) && $_REQUEST['start'] != "" && isset($_REQUEST['end']) && $_REQUEST['end'] != ""){
					$t1 = date_format($date,"Y-m-d");
					$st = $_REQUEST['start'];
					$ed = $_REQUEST['end'];
					$cur = $t1;
					
					if( $cur >= $st && $ed >= $cur){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $balancesession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['balanceAssessments'][] = $data1;
					}
				}else{
					$t1 = date_format($date,"Y-m-d");
					$cur = $t1;
					if( $cur >= $startdate1 && $cur <= $enddate1){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $balancesession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['balanceAssessments'][] = $data1;
					}
				}
				
				if($iphoto!=""){
					if(!isset($imagearray[$t]))
						$imagearray[$t] = $iphoto;
					else if($imagearray[$t] =="")
						$imagearray[$t] = $iphoto;
				}
			} 
		
			foreach($res->verticalJumpAssessments as $verticaljumpsession){
				$data1 = array();
				$date=date_create($verticaljumpsession->date);
				$t = date_format($date,"m-d-Y");
				$data1['date'] = $t;
				$data1['type'] = 'Vertical Jump';
				$data1['score'] = round($verticaljumpsession->score * 100 ,2). "%";
			/*	$data1['imagePath'] = $verticaljumpsession->imagePath;
				$data1['videoFilePath'] = $verticaljumpsession->videoFilePath;*/
				
				$iphoto = '';
				if(isset($verticaljumpsession->assessmentFrames[0]->imagePath) && $verticaljumpsession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $verticaljumpsession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					if(@is_array(getimagesize("/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic)))
						$iphoto = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}
				
				if(isset($verticaljumpsession->videoFilePath) && $verticaljumpsession->videoFilePath!=""){
					$imgpath = $verticaljumpsession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$foldername = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					$fdname = "/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					
					$foldername = str_replace(".zip","/",$foldername);
					$fdname = str_replace(".zip","/",$fdname);
					// print_r("1:::".$foldername."::".$fdname);
					$c = 1;
					$vc = '';
					if(is_dir($fdname)) {
						// print_r("1.1:::");
						if ($handle = opendir($fdname)) {
							// print_r("1.2:::");
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != "..") {
									if (strpos($entry, '.jpg') !== false)
									{
										$videoimagepath = $foldername.$entry;
										$iphoto = $videoimagepath;
										break;
									}
								}
							}
						}
					}
				}
				
				if(isset($_REQUEST['start']) && $_REQUEST['start'] != "" && isset($_REQUEST['end']) && $_REQUEST['end'] != ""){
					$t1 = date_format($date,"Y-m-d");
					$st = $_REQUEST['start'];
					$ed = $_REQUEST['end'];
					$cur = $t1;
					
					if( $cur >= $st && $ed >= $cur){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $verticaljumpsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['jumpAssessments'][] = $data1;
					}
				}else{
					$t1 = date_format($date,"Y-m-d");
					$cur = $t1;
					if( $cur >= $startdate1 && $cur <= $enddate1){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $verticaljumpsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
							
						}
						$maindata[$t]['jumpAssessments'][] = $data1;
					}
				}
				if($iphoto!=""){
					if(!isset($imagearray[$t]))
						$imagearray[$t] = $iphoto;
					else if($imagearray[$t] =="")
						$imagearray[$t] = $iphoto;
				}
			}
			
			/*
			echo '<pre>';
			print_r($res->functionalAssessments);
			echo '</pre>';
			*/
			foreach($res->functionalAssessments as $funassesssession){
				$data1 = array();
				$date=date_create($funassesssession->date);
				$tdate=date_format($date,"Y-m-d");
				$t = date_format($date,"m-d-Y");
				$data1['date'] = $t;
				
				$frame = $funassesssession->assessmentFrames[0];
				$data1['type'] = $funassesssession->tag;
				$funframe = $frame->jointCoordsBLOB;
				$fr1 = json_decode($funframe);
				
				
				$frame = $funassesssession->assessmentFrames[0];
				
				$iphoto = '';
				if(isset($frame->imagePath) && $frame->imagePath!=""){
					$imgpath = $frame->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					if(@is_array(getimagesize("/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic)))
						$iphoto = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}
				
				if(isset($funassesssession->videoFilePath) && $funassesssession->videoFilePath!=""){
					$imgpath = $funassesssession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$foldername = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					$fdname = "/var/www/html/public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					
					$foldername = str_replace(".zip","/",$foldername);
					$fdname = str_replace(".zip","/",$fdname);
					// print_r("1:::".$foldername."::".$fdname);
					$c = 1;
					$vc = '';
					if(is_dir($fdname)) {
						// print_r("1.1:::");
						if ($handle = opendir($fdname)) {
							// print_r("1.2:::");
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != "..") {
									if (strpos($entry, '.jpg') !== false)
									{
										$videoimagepath = $foldername.$entry;
										$iphoto = $videoimagepath;
										break;
									}
								}
							}
						}
					}
				}
				
				if(isset($_REQUEST['start']) && $_REQUEST['start'] != "" && isset($_REQUEST['end']) && $_REQUEST['end'] != ""){
					$t1 = date_format($date,"Y-m-d");
					$st = $_REQUEST['start'];
					$ed = $_REQUEST['end'];
					$cur = $t1;
					
					if( $cur >= $st && $ed >= $cur){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$sortdate[] = date_format($date,"Y-m-d");
							$maindata[$t]['date'] = $t;
							$practitionerdate[date_format($date,"Y-m-d")] = $funassesssession->practitionerId;
						}
						
						if($frame->notesAssessment != ""){
							if(isset($maindata[$t]['title']) && $maindata[$t]['title']!="")
							{
								if($maindata[$t]['title'] != '' )
									$maindata[$t]['title'] = $maindata[$t]['title'].' & '.$funassesssession->tag;
								else
									$maindata[$t]['title'] = $funassesssession->tag;
								
							}else{
								$maindata[$t]['title'] = $funassesssession->tag;
							}
						}
						$maindata[$t]['functionalAssessments'][] = $data1;
					}
				}else{
					$t1 = date_format($date,"Y-m-d");
					$cur = $t1;
					if( $cur >= $startdate1 && $cur <= $enddate1){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$sortdate[] = date_format($date,"Y-m-d");
							$maindata[$t]['date'] = $t;
							$practitionerdate[date_format($date,"Y-m-d")] = $funassesssession->practitionerId;
						}
						
						if($frame->notesAssessment != ""){
							if(isset($maindata[$t]['title']) && $maindata[$t]['title']!="")
							{
								if($maindata[$t]['title'] != '' )
									$maindata[$t]['title'] = $maindata[$t]['title'].' & '.$funassesssession->tag;
								else
									$maindata[$t]['title'] = $funassesssession->tag;
							}else{
								$maindata[$t]['title'] = $funassesssession->tag;
							}
						}
						$maindata[$t]['functionalAssessments'][] = $data1;
					}
				}
				
				if($iphoto!=""){
					if(!isset($imagearray[$t]))
						$imagearray[$t] = $iphoto;
					else if($imagearray[$t] =="")
						$imagearray[$t] = $iphoto;
				}
			}
		?>
	
		<?php
		
			
			function sortFunction( $a, $b ) {
				return strtotime($b) - strtotime($a);
			}
			
			if(sizeof($sortdate) > 1)
				usort($sortdate, "sortFunction");
			
			$flaglist = true;
			foreach($sortdate as $d1){
				
				$flaglist = false;
				$timestamp = strtotime($d1);
				$new_date = date("m-d-Y", $timestamp);
				
				$d = $maindata[$new_date];
				
				echo "<div class='breakdownclass'>";
				if(isset($imagearray[$new_date]) && $imagearray[$new_date]!=""){
					if(substr_count($imagearray[$new_date],'/') == 8)
						print_r('<img src="'.$imagearray[$new_date].'">');
					else
						print_r('<img src="'.$imagearray[$new_date].'">');
				}else{
					print_r('<img src="'.base_url().'/public/images/no-image.jpg">');
				}
				print_r('<h2>'.$new_date.' <a href="'.base_url().'dashboard/detailassessments?date='.$timestamp.'">Results</a> <a href="'.base_url().'dashboard/myworkout?date='.$timestamp.'" style="font-size: 20px; padding:0px; margin: 7px 10px; color: white; border: 0px none; background: transparent;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a> <span style="padding-top:10px;"><b>Assessment : &nbsp;</b>'.$d['title'].'</span><hr><span style="padding-bottom: 5px;"><b>Trainer : &nbsp;</b>'.$practitionerarray[$practitionerdate[$d1]].'</span><span><b>Clinic : &nbsp;</b>'.$clinicarray[$practitionerclinicarray[$practitionerdate[$d1]]].'</span></h2>');
				print_r('</div>');
			}
			
			if($flaglist){
				echo '<h4 style="float: left; margin: 0 0 0 15px;"> No assessments available.</h4>';
			}
		
		?>
	  <div style="clear:both;"></div>
    </section>
    <!-- /.content -->
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<!-- /.content-wrapper -->
<script>
	document.title = 'Assessments | Baseline Motion';
	selectedlink =  "assesslinkmenu";
</script>

<style>
.range_inputs .btn-success {
			background-color: #00ABEE!important;
			border-color: #00ABEE;
			opacity: 1;
		}
@media only screen and (max-width: 768px) {
			.input-group {
				float: left!important;
				width: 100%;
				clear: both;
				margin-top: 20px;
				margin-bottom: 0!important;
			}
			.input-group button#daterange-btn {
				float: left;
				width: 100%;
				margin: 20px 0;
			}
		}
@media only screen and (min-width: 1235px) {
	.assessmentclass .breakdownclass:nth-child(3n+1) {
		clear: both;
	}
}
@media only screen and (min-width: 768px) and (max-width: 1235px) {
	.assessmentclass .breakdownclass:nth-child(2n+1) {
		clear: both;
	}
}
.breakdownclass > img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}
</style>
<footer class="main-footer">
    <strong>Baseline Motion © <?php echo date('Y'); ?>.</strong> 
</footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
<script>
    var base_url = '<?php echo base_url(); ?>';
</script>
<!-- jQuery 3 -->
<script src="<?=base_url()?>public/bower_components/jquery/dist/jquery.js"></script>
<script src="<?=base_url()?>public/bower_components/validate/jquery.validate.min.js"></script>
<script src="<?=base_url()?>public/bower_components/validate/additional-methods.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Toastr -->
<script src="<?=base_url()?>public/bower_components/toastr/js/toastr.min.js"></script>
<script src="<?=base_url()?>public/bower_components/toastr/js/ui-toastr.min.js"></script>

<!-- FastClick -->
<script src="<?=base_url()?>public/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>public/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="<?=base_url()?>public/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="<?=base_url()?>public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=base_url()?>public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- DataTables -->
<script src="<?=base_url()?>public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>public/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- SlimScroll -->
<script src="<?=base_url()?>public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->

<!-- date-range-picker -->
<script src="<?=base_url()?>public/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url()?>public/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- daterange picker -->
<link rel="stylesheet" href="<?=base_url()?>public/bower_components/bootstrap-daterangepicker/daterangepicker.css">

<script>
	$('#daterange-btn').daterangepicker({
		ranges   : {
			'Today'       : [moment(), moment()],
			'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month'  : [moment().startOf('month'), moment().endOf('month')],
			'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'This Year'  : [moment().startOf('year'), moment()],
			'Last Year'  : [moment().subtract(1, 'year').startOf('month'), moment()]
		},
		startDate: '<?php echo $startdate; ?>',
		endDate  : '<?php echo $enddate; ?>'
	},
	function (start, end) {
		//$('#daterange-btn span').html('<i class="fa fa-calendar" style="padding: 0px 10px 5px 5px;"></i> ' + start.format('MM-DD-YYYY') + ' - ' + end.format('MM-DD-YYYY'));
		location.href = "<?=base_url()?>dashboard/assessments?start="+start.format('YYYY-MM-DD')+"&end="+end.format('YYYY-MM-DD');
	});
	$(function () {
		if(selectedlink!= ""){
			$(".sidebar-menu li").removeClass('active');
			$("#"+selectedlink).addClass('active');
		}
	});
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-154875438-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-154875438-1');
  
	$(document).ready(function(){
		console.log("here");
		$('img').each(function(){
			console.log("here2");
			$(this).addClass("crawled");
			var rtimg = $(this).attr('src');
			if(rtimg != ""){
				try{
					var n = rtimg.indexOf("kinetisense");
					if(n >= 0){
						var res = rtimg.replace("baselinev2.foundersapproach.org", "portal.baselinemotion.com");
						$(this).attr({ 'src' : res });
					}
				}catch(err) {}
			}
		});
	});
</script>

<?php $this->load->view('template/page_level_scripts'); ?>
</body>
</html>
