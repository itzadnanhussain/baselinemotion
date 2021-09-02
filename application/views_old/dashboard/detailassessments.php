<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<div class="col-md-12">
			<h1>
				<b><span id="datetitle"></span></b>&nbsp;<font style="font-size:70%; position: relative; top: -4px; left: 5px;">Detailed Assessments</font>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?=base_url()?>dashboard/">Dashboard</a></li>
				<li><a href="<?=base_url()?>dashboard/assessments">Assessments</a></li>
				<li class="active">Detailed Assessments</li>
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
			
			if(isset($_REQUEST['date']))
				$selecteddate = $_REQUEST['date'];
			
			foreach($res->romAssessments as $romsession){
				$data1 = array();
				$date=date_create($romsession->date);
				$tdate=date_format($date,"Y-m-d");	
				$t = date_format($date,"m-d-Y");
				
				$data1['date'] = $t;
				$data1['score'] = round($romsession->score * 100 ,2). " %";
				$data1['scoreval'] = $romsession->score * 100;
				
				if($romsession->jointType == "SpineMid")
					$data1['type'] = 'Back '.$romsession->movementType;
				else
					$data1['type'] = $romsession->jointType.' '.$romsession->movementType;
				
				if(isset($romsession->assessmentFrames[0]->imagePath) && $romsession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $romsession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['imagePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}else
					$data1['imagePath'] = '';
				
				if(isset($romsession->videoFilePath) && $romsession->videoFilePath!=""){
					$imgpath = $romsession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['videoFilePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				} else
					$data1['videoFilePath'] = '';
				
				if($selecteddate!=""){
					$timestamp = strtotime($tdate);
					if($timestamp == $selecteddate){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$sortdate[] = date_format($date,"Y-m-d");
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['romAssessments'][] = $data1;
					}
				}else{
					if(!in_array($t, $uniquedatearray))
					{	$uniquedatearray[] = $t;
						$sortdate[] = date_format($date,"Y-m-d");
						$maindata[$t]['date'] = $t;
						$maindata[$t]['title'] = 'KAMS';
					}
					$maindata[$t]['romAssessments'][] = $data1;
				}
			} 
		
			foreach($res->overheadSquatAssessments as $overheadsession){
				$data1 = array();
				$date=date_create($overheadsession->date);
				$tdate=date_format($date,"Y-m-d");
				$t = date_format($date,"m-d-Y");
				
				$data1['date'] = $t;
				$data1['type'] = 'Overhead Squat';
				$data1['score'] = round($overheadsession->score * 100 ,2). " %";
				$data1['scoreval'] = $overheadsession->score * 100;
				
				if(isset($overheadsession->assessmentFrames[0]->imagePath) && $overheadsession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $overheadsession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['imagePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}else
					$data1['imagePath'] = '';
				
				if(isset($overheadsession->videoFilePath) && $overheadsession->videoFilePath!=""){
					$imgpath = $overheadsession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['videoFilePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				} else
					$data1['videoFilePath'] = '';
				
				
				if($selecteddate!=""){
					$timestamp = strtotime($tdate);
					if($timestamp == $selecteddate){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$sortdate[] = date_format($date,"Y-m-d");
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['overheadAssessments'][] = $data1;
					}
				}else{
					if(!in_array($t, $uniquedatearray))
					{	$uniquedatearray[] = $t;
						$sortdate[] = date_format($date,"Y-m-d");
						$maindata[$t]['date'] = $t;
						$maindata[$t]['title'] = 'KAMS';
					}
					$maindata[$t]['overheadAssessments'][] = $data1;
				}
			} 
		
			foreach($res->reverseLungeAssessments as $reverselungesession){
				$data1 = array();
				$date=date_create($reverselungesession->date);
				$tdate=date_format($date,"Y-m-d");
				$t = date_format($date,"m-d-Y");
				
				$data1['date'] = $t;
				$data1['type'] = 'Reverse Lunge';
				$data1['score'] = round($reverselungesession->score * 100 ,2). " %";
				$data1['scoreval'] = $reverselungesession->score * 100;
				
				if(isset($reverselungesession->assessmentFrames[0]->imagePath) && $reverselungesession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $reverselungesession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['imagePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}else
					$data1['imagePath'] = '';
				
				if(isset($reverselungesession->videoFilePath) && $reverselungesession->videoFilePath!=""){
					$imgpath = $reverselungesession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['videoFilePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				} else
					$data1['videoFilePath'] = '';
				
				
				if($selecteddate!=""){
					$timestamp = strtotime($tdate);
					if($timestamp == $selecteddate){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$sortdate[] = date_format($date,"Y-m-d");
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['reverselungeAssessments'][] = $data1;
					}
				}else{
					if(!in_array($t, $uniquedatearray))
					{	$uniquedatearray[] = $t;
						$sortdate[] = date_format($date,"Y-m-d");
						$maindata[$t]['date'] = $t;
						$maindata[$t]['title'] = 'KAMS';
					}
					$maindata[$t]['reverselungeAssessments'][] = $data1;
				}
			} 
		
			foreach($res->wallAngelAssessments as $wallangelsession){	
				$data1 = array();
				$date=date_create($wallangelsession->date);
				$tdate=date_format($date,"Y-m-d");
				$t = date_format($date,"m-d-Y");
				
				$data1['date'] = $t;
				$data1['type'] = 'Posture Angel';
				$data1['score'] = round($wallangelsession->score * 100 ,2). " %";
				$data1['scoreval'] = $wallangelsession->score * 100;
				
				if(isset($wallangelsession->assessmentFrames[0]->imagePath) && $wallangelsession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $wallangelsession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['imagePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}else
					$data1['imagePath'] = '';
				
				if(isset($wallangelsession->videoFilePath) && $wallangelsession->videoFilePath!=""){
					$imgpath = $wallangelsession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['videoFilePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				} else
					$data1['videoFilePath'] = '';
				
				
				if($selecteddate!=""){
					$timestamp = strtotime($tdate);
					if($timestamp == $selecteddate){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$sortdate[] = date_format($date,"Y-m-d");
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['wallangelAssessments'][] = $data1;
					}
				}else{
					if(!in_array($t, $uniquedatearray))
					{	$uniquedatearray[] = $t;
						$sortdate[] = date_format($date,"Y-m-d");
						$maindata[$t]['date'] = $t;
						$maindata[$t]['title'] = 'KAMS';
					}
					$maindata[$t]['wallangelAssessments'][] = $data1;
				}
			} 
		
			foreach($res->balanceAssessments as $balancesession){
				$data1 = array();
				$date=date_create($balancesession->date);
				$tdate=date_format($date,"Y-m-d");
				$t = date_format($date,"m-d-Y");
				
				$data1['date'] = $t;
				$data1['type'] = 'Balance '.$balancesession->type;
				$data1['score'] = round($balancesession->score * 100 ,2). " %";
				$data1['scoreval'] = (1 - $balancesession->score) * 100;
				
				if(isset($balancesession->assessmentFrames[0]->imagePath) && $balancesession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $balancesession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['imagePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}else
					$data1['imagePath'] = '';
				
				if(isset($balancesession->videoFilePath) && $balancesession->videoFilePath!=""){
					$imgpath = $balancesession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['videoFilePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				} else
					$data1['videoFilePath'] = '';
				
				
				if($selecteddate!=""){
					$timestamp = strtotime($tdate);
					if($timestamp == $selecteddate){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$sortdate[] = date_format($date,"Y-m-d");
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['balanceAssessments'][] = $data1;
					}
				}else{
					if(!in_array($t, $uniquedatearray))
					{	$uniquedatearray[] = $t;
						$sortdate[] = date_format($date,"Y-m-d");
						$maindata[$t]['date'] = $t;
						$maindata[$t]['title'] = 'KAMS';
					}
					$maindata[$t]['balanceAssessments'][] = $data1;
				}
			} 
		
			foreach($res->verticalJumpAssessments as $verticaljumpsession){
				$data1 = array();
				$date=date_create($verticaljumpsession->date);
				$tdate=date_format($date,"Y-m-d");
				$t = date_format($date,"m-d-Y");
				
				$data1['date'] = $t;
				$data1['type'] = 'Vertical Jump';
				$data1['score'] = round($verticaljumpsession->score * 100 ,2). " %";
				$data1['scoreval'] = $verticaljumpsession->score * 100;
				
				if(isset($verticaljumpsession->assessmentFrames[0]->imagePath) && $verticaljumpsession->assessmentFrames[0]->imagePath!=""){
					$imgpath = $verticaljumpsession->assessmentFrames[0]->imagePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['imagePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				}else
					$data1['imagePath'] = '';
				
				if(isset($verticaljumpsession->videoFilePath) && $verticaljumpsession->videoFilePath!=""){
					$imgpath = $verticaljumpsession->videoFilePath;
					$startstr = strrpos($imgpath,"\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath,$startstr,$endstr);
					
					$data1['videoFilePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
				} else
					$data1['videoFilePath'] = '';
				
				if($selecteddate!=""){
					$timestamp = strtotime($tdate);
					if($timestamp == $selecteddate){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$sortdate[] = date_format($date,"Y-m-d");
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['jumpAssessments'][] = $data1;
					}
				}else{
					if(!in_array($t, $uniquedatearray))
					{	$uniquedatearray[] = $t;
						$sortdate[] = date_format($date,"Y-m-d");
						$maindata[$t]['date'] = $t;
						$maindata[$t]['title'] = 'KAMS';
					}
					$maindata[$t]['jumpAssessments'][] = $data1;
				}
			}
			
			$flagkams = true;
			$kamsscore = array();
			foreach($indexKAMS as $kams){
				$flagkams = false;				
				$date = DateTime::createFromFormat('m/d/Y', $kams->date);

				if($selecteddate!=""){
					$tdate = $date->format("Y-m-d");
					$timestamp = strtotime($tdate);
					if($timestamp == $selecteddate){
						$t = $date->format("m-d-Y");
						$yeardate = $date->format('Y-m-d');
						$kamsscore[$t]['balancescore'] = $kams->balance_index;
						$kamsscore[$t]['flexibilityscore'] = $kams->flexibility_index;
						$kamsscore[$t]['corestabilityscore'] = $kams->core_stability_index;
						$kamsscore[$t]['dynamicposturescore'] = $kams->dynamic_posture_index;
						$kamsscore[$t]['lowerextremitypowerscore'] = $kams->lower_extremity_power_score;
						$kamsscore[$t]['functionalasymmetryscore'] = $kams->functional_asymmetry_index;
						$kamsscore[$t]['susceptibilitytoinjuryscore'] = $kams->susceptibility_to_injury_index;
					}
				}else{
					$t = $date->format("m-d-Y");
					$yeardate = $date->format('Y-m-d');
					$kamsscore[$t]['balancescore'] = $kams->balance_index;
					$kamsscore[$t]['flexibilityscore'] = $kams->flexibility_index;
					$kamsscore[$t]['corestabilityscore'] = $kams->core_stability_index;
					$kamsscore[$t]['dynamicposturescore'] = $kams->dynamic_posture_index;
					$kamsscore[$t]['lowerextremitypowerscore'] = $kams->lower_extremity_power_score;
					$kamsscore[$t]['functionalasymmetryscore'] = $kams->functional_asymmetry_index;
					$kamsscore[$t]['susceptibilitytoinjuryscore'] = $kams->susceptibility_to_injury_index;
				}
			}
		?>
		
		<div class="row" style="">
			<?php
				foreach($res->functionalAssessments as $funassesssession)
				{
					
					$data1 = array();
					$date = date_create($funassesssession->date);
					$tdate = date_format($date,"Y-m-d");
					$t = date_format($date,"m-d-Y");
					
					$frame = $funassesssession->assessmentFrames[0];
					//print_r($frame);
					
					$funframe = $frame->jointCoordsBLOB;
					if($funframe!=""){
					$fr1 = json_decode($funframe);
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Head carriage';
					$data2['score'] = round($fr1->AngleHead ,2);
					$data1[] = $data2;
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Eyes';
					$data2['score'] = round($fr1->AngleEyes ,2);
					$data1[] = $data2;
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Spinal';
					$data2['score'] = round($fr1->AngleSpine ,2);
					$data1[] = $data2;
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Hip';
					$data2['score'] = round($fr1->AngleHips ,2);
					$data1[] = $data2;
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Knee';
					$data2['score'] = round($fr1->AngleKnees ,2);
					$data1[] = $data2;
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Shoulder Plane Rotation';
					$data2['score'] = round($fr1->ShoulderPlaneRotation ,2);
					$data1[] = $data2;
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Hip Plane Rotation';
					$data2['score'] = round($fr1->HipPlaneRotation ,2);
					$data1[] = $data2;
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Knee Plane Rotation';
					$data2['score'] = round($fr1->KneePlaneRotation ,2);
					$data1[] = $data2;
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Ankle Plane Rotation';
					$data2['score'] = round($fr1->AnklePlaneRotation ,2);
					$data1[] = $data2;
					
					$data2 = array();
					$data2['date'] = $t;
					$data2['type'] = 'Notes';
					$data2['score'] = $frame->notesAssessment;
					
					
					if(isset($frame->imagePath) && $frame->imagePath!="")
					{	
						$imgpath = $frame->imagePath;
						$startstr = strrpos($imgpath,"\\");
						$startstr++;
						$endstr = strlen($imgpath);
						$profile_pic = substr($imgpath,$startstr,$endstr);
						
						$data2['imagePath'] = base_url()."public/images/kinetisense/".$this->session->userdata("patientid")."/".$profile_pic;
					} else
						$data2['imagePath'] = '';
					
					if(isset($funassesssession->videoFilePath) && $funassesssession->videoFilePath!="")
						$data2['videoFilePath'] = $funassesssession->videoFilePath;
					else
						$data2['videoFilePath'] = '';
					
					$data1[] = $data2;
					$data1['title'] = $funassesssession->tag;
					
					//print_r($data1);	
					if($selecteddate!=""){
						$timestamp = strtotime($tdate);
						if($timestamp == $selecteddate){
							if(!in_array($t, $uniquedatearray))
							{	$uniquedatearray[] = $t;
								$sortdate[] = date_format($date,"Y-m-d");
								$maindata[$t]['date'] = $t;
							}
							$maindata[$t]['functionalAssessments'][] = $data1;
						}
					}else{
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$sortdate[] = date_format($date,"Y-m-d");
							$maindata[$t]['date'] = $t;
						}
						$maindata[$t]['functionalAssessments'][] = $data1;
					}
				}
				}
			?>
		</div>
		
		<?php
		
		/*
			echo "<pre>";
			print_r($maindata);
			echo "</pre>";
		*/
		
			$additionalscript = '';
			$galcount = 1;
			function sortFunction( $a, $b ) {
				return strtotime($b) - strtotime($a);
			}
				
			if(sizeof($sortdate) > 1)
				usort($sortdate, "sortFunction");
			
			
			foreach($sortdate as $d1){
				$timestamp = strtotime($d1);
				$a = array();
				$new_date = date("m-d-Y", $timestamp);
				if($selecteddate!=""){
					if($timestamp == $selecteddate){
						//print_r('<h1 style="padding-left: 20px;border-bottom: 2px solid;padding-bottom: 20px; margin-left: 15px; margin-right: 15px;">'.$new_date.'</h1>');
						
						echo "<h2 class='hidekamssection' style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>OVERALL SCORE</font><span id='overallscore".$timestamp."' style='float: right;background: black;color: white;padding: 10px;font-size: 125%;font-weight: 700;'></span></h2><div class='whitebgcontent hidekamssection'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='slider'></div></div><div style='float:left; width:100%; height:45px;'></div></div><div class='breakdownclass hidekamssection' style='width: calc(100% - 25px);'>";
						print_r('<h2>KAMS Assessment</h2>');
						echo '<script> document.getElementById("datetitle").innerHTML = "'.$new_date.'"; </script>';
						
						$d = $maindata[$new_date];
						if(isset($d['romAssessments'])){
							foreach($d['romAssessments'] as $rom){
								$videoimagepath = '';
								$foldername = str_replace(".zip","/",$rom['videoFilePath']);
								$fdname = str_replace(base_url(),"/var/www/html/",$foldername);
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
													$vc .= '<a data-fancybox="gallery'.$galcount.'" href="'.$videoimagepath.'?'.time().'"><img style="width:180px; margin:5px;" src="'.$videoimagepath.'?'.time().'"></a>';
													$c++;
													if($c > 6)
														break;
												}
											}
										}
									}
								}
								
								if($vc != ""){
									if(@is_array(getimagesize($rom['imagePath'])))
										print_r('<p><b>'.$rom['type'].'</b> <span>'.$rom['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;"><a data-fancybox="gallery'.$galcount.'" href="'.$rom['imagePath'].'"><img style="width:180px; margin:5px;" src="'.$rom['imagePath'].'?'.time().'"  ></a>'.$vc.'</span></p>');
									else
										print_r('<p><b>'.$rom['type'].'</b> <span>'.$rom['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;">'.$vc.'</span></p>');
									
								} else {
									if(@is_array(getimagesize($rom['imagePath'])))
										print_r('<p><b>'.$rom['type'].'</b> <span>'.$rom['score'].'</span><a data-fancybox="gallery'.$galcount.'" href="'.$rom['imagePath'].'?'.time().'" ><img style="width:180px; margin:5px;" src="'.$rom['imagePath'].'?'.time().'"></a></p>');
									else
										print_r('<p><b>'.$rom['type'].'</b> <span>'.$rom['score'].'</span></p>');
								}
								
								$a[] = $rom['scoreval'];
								$galcount++;
								
							}
						}
						
						if(isset($d['overheadAssessments'])){
							foreach($d['overheadAssessments'] as $overhead){
								
								$videoimagepath = '';
								$foldername = str_replace(".zip","/",$overhead['videoFilePath']);
								$fdname = str_replace(base_url(),"/var/www/html/",$foldername);
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
													$vc .= '<a data-fancybox="gallery'.$galcount.'" href="'.$videoimagepath.'?'.time().'"><img style="width:180px; margin:5px;" src="'.$videoimagepath.'?'.time().'"></a>';
													$c++;
													if($c > 6)
														break;
												}
											}
										}
									}
								}
								
								
								if($vc != ""){
									if(@is_array(getimagesize($overhead['imagePath'])))
										print_r('<p><b>'.$overhead['type'].'</b> <span>'.$overhead['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;"><a data-fancybox="gallery'.$galcount.'" href="'.$overhead['imagePath'].'?'.time().'"><img style="width:180px; margin:5px;" src="'.$overhead['imagePath'].'" ></a>'.$vc.'</span></p>');
									else
										print_r('<p><b>'.$overhead['type'].'</b> <span>'.$overhead['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;">'.$vc.'</span></p>');
								} else {
									if(@is_array(getimagesize($overhead['imagePath'])))
										print_r('<p><b>'.$overhead['type'].'</b> <span>'.$overhead['score'].'</span><a data-fancybox="gallery'.$galcount.'" href="'.$overhead['imagePath'].'" ><img style="width:180px; margin:5px;" src="'.$overhead['imagePath'].'?'.time().'"></a></p>');
									else
										print_r('<p><b>'.$overhead['type'].'</b> <span>'.$overhead['score'].'</span></p>');
								}
								
								$a[] = $overhead['scoreval'];
								$galcount++;
							}
						}
						
						if(isset($d['reverselungeAssessments'])){
							foreach($d['reverselungeAssessments'] as $reverselunge){
								
								$videoimagepath = '';
								$foldername = str_replace(".zip","/",$reverselunge['videoFilePath']);
								$fdname = str_replace(base_url(),"/var/www/html/",$foldername);
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
													$vc .= '<a data-fancybox="gallery'.$galcount.'" href="'.$videoimagepath.'"><img style="width:180px; margin:5px;" src="'.$videoimagepath.'?'.time().'"></a>';
													$c++;
													if($c > 6)
														break;
												}
											}
										}
									}
								}
								
								if($vc != ""){
									if(@is_array(getimagesize($reverselunge['imagePath'])))
										print_r('<p><b>'.$reverselunge['type'].'</b> <span>'.$reverselunge['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;"><a data-fancybox="gallery'.$galcount.'"  href="'.$reverselunge['imagePath'].'"><img style="width:180px; margin:5px;" src="'.$reverselunge['imagePath'].'?'.time().'"></a>'.$vc.'</span></p>');
									else
										print_r('<p><b>'.$reverselunge['type'].'</b> <span>'.$reverselunge['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;">'.$vc.'</span></p>');
								} else {
									if(@is_array(getimagesize($reverselunge['imagePath'])))
										print_r('<p><b>'.$reverselunge['type'].'</b> <span>'.$reverselunge['score'].'</span><a  data-fancybox="gallery'.$galcount.'" href="'.$reverselunge['imagePath'].'"><img style="width:180px; margin:5px;" src="'.$reverselunge['imagePath'].'?'.time().'"></a></p>');
									else
										print_r('<p><b>'.$reverselunge['type'].'</b> <span>'.$reverselunge['score'].'</span></p>');
								}
								$a[] = $reverselunge['scoreval'];
								$galcount++;
							}
						}
						
						if(isset($d['wallangelAssessments'])){
							foreach($d['wallangelAssessments'] as $wallangel){
								$videoimagepath = '';
								$foldername = str_replace(".zip","/",$wallangel['videoFilePath']);
								$fdname = str_replace(base_url(),"/var/www/html/",$foldername);
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
													$vc .= '<a data-fancybox="gallery'.$galcount.'" href="'.$videoimagepath.'"><img style="width:180px; margin:5px;" src="'.$videoimagepath.'?'.time().'"></a>';
													$c++;
													if($c > 6)
														break;
												}
											}
										}
									}
								}
								
								if($vc != ""){
									if(@is_array(getimagesize($wallangel['imagePath'])))
										print_r('<p><b>'.$wallangel['type'].'</b> <span>'.$wallangel['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;"><a data-fancybox="gallery'.$galcount.'"  href="'.$wallangel['imagePath'].'"><img style="width:180px; margin:5px;" src="'.$wallangel['imagePath'].'?'.time().'"></a>'.$vc.'</span></p>');
									else
										print_r('<p><b>'.$wallangel['type'].'</b> <span>'.$wallangel['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;">'.$vc.'</span></p>');
								} else {
									if(@is_array(getimagesize($wallangel['imagePath'])))
										print_r('<p><b>'.$wallangel['type'].'</b> <span>'.$wallangel['score'].'</span><a  data-fancybox="gallery'.$galcount.'" href="'.$wallangel['imagePath'].'"><img style="width:180px; margin:5px;" src="'.$wallangel['imagePath'].'?'.time().'"></a></p>');
									else
										print_r('<p><b>'.$wallangel['type'].'</b> <span>'.$wallangel['score'].'</span></p>');
								}
								$a[] = $wallangel['scoreval'];
								$galcount++;
							}
						}
						
						if(isset($d['balanceAssessments'])){
							foreach($d['balanceAssessments'] as $balance){
								$videoimagepath = '';
								$foldername = str_replace(".zip","/",$balance['videoFilePath']);
								$fdname = str_replace(base_url(),"/var/www/html/",$foldername);
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
													$vc .= '<a data-fancybox="gallery'.$galcount.'" href="'.$videoimagepath.'"><img style="width:180px; margin:5px;" src="'.$videoimagepath.'?'.time().'"></a>';
													$c++;
													if($c > 6)
														break;
												}
											}
										}
									}
								}
								
								if($vc != ""){
									if(@is_array(getimagesize($balance['imagePath'])))
										print_r('<p><b>'.$balance['type'].'</b> <span>'.$balance['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;"><a data-fancybox="gallery'.$galcount.'"  href="'.$balance['imagePath'].'"><img style="width:180px; margin:5px;" src="'.$balance['imagePath'].'?'.time().'"></a>'.$vc.'</span></p>');
									else
										print_r('<p><b>'.$balance['type'].'</b> <span>'.$balance['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;">'.$vc.'</span></p>');
								} else {
									if(@is_array(getimagesize($balance['imagePath'])))
										print_r('<p><b>'.$balance['type'].'</b> <span>'.$balance['score'].'</span><a  data-fancybox="gallery'.$galcount.'" href="'.$balance['imagePath'].'"><img style="width:180px; margin:5px;" src="'.$balance['imagePath'].'?'.time().'"></a></p>');
									else
										print_r('<p><b>'.$balance['type'].'</b> <span>'.$balance['score'].'</span></p>');
								}
								
								$a[] = $balance['scoreval'];
								$galcount++;
							}
						}
						
						if(isset($d['jumpAssessments'])){
							foreach($d['jumpAssessments'] as $jump){
								$videoimagepath = '';
								$foldername = str_replace(".zip","/",$jump['videoFilePath']);
								$fdname = str_replace(base_url(),"/var/www/html/",$foldername);
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
													$vc .= '<a data-fancybox="gallery'.$galcount.'" href="'.$videoimagepath.'"><img style="width:180px; margin:5px;" src="'.$videoimagepath.'?'.time().'"></a>';
													$c++;
													if($c > 6)
														break;
												}
											}
										}
									}
								}
								
								if($vc != ""){
									if(@is_array(getimagesize($jump['imagePath'])))
										print_r('<p><b>'.$jump['type'].'</b> <span>'.$jump['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;"><a data-fancybox="gallery'.$galcount.'"  href="'.$jump['imagePath'].'"><img style="width:180px; margin:5px;" src="'.$jump['imagePath'].'?'.time().'"></a>'.$vc.'</span></p>');
									else
										print_r('<p><b>'.$jump['type'].'</b> <span>'.$jump['score'].'</span><span style="float: left;padding:10px 0;clear:both;width: 100%;display: flex; flex-wrap: wrap;">'.$vc.'</span></p>');
								} else {
									if(@is_array(getimagesize($jump['imagePath'])))
										print_r('<p><b>'.$jump['type'].'</b> <span>'.$jump['score'].'</span><a data-fancybox="gallery'.$galcount.'"  href="'.$jump['imagePath'].'"><img style="width:180px; margin:5px;" src="'.$jump['imagePath'].'?'.time().'"></a></p>');
									else
										print_r('<p><b>'.$jump['type'].'</b> <span>'.$jump['score'].'</span></p>');
								}
								$a[] = $jump['scoreval'];
								$galcount++;
							}
						}
						print_r('</div>');
						
						
						if(sizeof($a)>0)
						{	$a = array_filter($a);
							$average = array_sum($a)/count($a);
							$average = round($average ,0);
						}else{
							$average = 0;
							$additionalscript .= '<script>jQuery(document).ready(function(){ jQuery(".hidekamssection").hide();});</script>';
						}
						echo '<script> /*document.getElementById("kams'.$timestamp.'").innerHTML = "'.$average.'%";*/ document.getElementById("overallscore'.$timestamp.'").innerHTML = "'.$average.'%"; </script>';
						
						
					}
				}else{
					echo "<h2 class='hidekamssection' style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0; float: left;'>OVERALL SCORE</font> <span id='overallscore".$timestamp."' style='float: right; background: black; color: white; padding: 10px; font-size: 125%; font-weight: 700;'></span></h2><div class='whitebgcontent hidekamssection'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='slider'></div></div><div style='float:left; width:100%; height:45px;'></div></div><div class='breakdownclass hidekamssection' style='width: calc(100% - 25px);'>";
					print_r('<h2>KAMS Assessment</h2>');
					echo '<script> document.getElementById("datetitle").innerHTML = "'.$new_date.'"; </script>';
					
					$a = array();
					$d = $maindata[$new_date];
					if(isset($d['romAssessments'])){
						foreach($d['romAssessments'] as $rom){
							print_r('<p><b>'.$rom['type'].'</b> <span>'.$rom['score'].'</span></p>');
							$a[] = $rom['scoreval'];
						}
					}
					
					if(isset($d['overheadAssessments'])){
						foreach($d['overheadAssessments'] as $overhead){
							print_r('<p><b>'.$overhead['type'].'</b> <span>'.$overhead['score'].'</span></p>');
							$a[] = $overhead['scoreval'];
						}
					}

					if(isset($d['reverselungeAssessments'])){
						foreach($d['reverselungeAssessments'] as $reverselunge){
							print_r('<p><b>'.$reverselunge['type'].'</b> <span>'.$reverselunge['score'].'</span></p>');
							$a[] = $reverselunge['scoreval'];
						}
					}
					
					if(isset($d['wallangelAssessments'])){
						foreach($d['wallangelAssessments'] as $wallangel){
							print_r('<p><b>'.$wallangel['type'].'</b> <span>'.$wallangel['score'].'</span></p>');
							$a[] = $wallangel['scoreval'];
						}
					}
					
					if(isset($d['balanceAssessments'])){
						foreach($d['balanceAssessments'] as $balance){
							print_r('<p><b>'.$balance['type'].'</b> <span>'.$balance['score'].'</span></p>');
							$a[] = $balance['scoreval'];
						}
					}
					
					if(isset($d['jumpAssessments'])){
						foreach($d['jumpAssessments'] as $jump){
							print_r('<p><b>'.$jump['type'].'</b> <span>'.$jump['score'].'</span></p>');
							$a[] = $jump['scoreval'];
						}
					}
					print_r('</div>');
					
					if(sizeof($a)>0)
					{	$a = array_filter($a);
						$average = array_sum($a)/count($a);
						$average = round($average ,0);
					}else{
						$average = 0;
						$additionalscript .= '<script>jQuery(document).ready(function(){ jQuery(".hidekamssection").hide();});</script>';
					}
					echo '<script> /*document.getElementById("kams'.$timestamp.'").innerHTML = "'.$average.'%";*/ document.getElementById("overallscore'.$timestamp.'").innerHTML = "'.$average.'%"; </script>';
				}
			}
		?>
			<!-- <div class="row" style='clear:both; margin:30px 0;'>
				<h2>Functional Assessments</h2>
			</div> -->
		<?php
			
			foreach($sortdate as $d1){					
				$timestamp = strtotime($d1);
				$new_date = date("m-d-Y", $timestamp);
				
				if($selecteddate!=""){
					if($timestamp == $selecteddate){
						echo '<script> document.getElementById("datetitle").innerHTML = "'.$new_date.'"; </script><script></script>';
						$d = $maindata[$new_date];
						if(isset($d['functionalAssessments'])){
							foreach($d['functionalAssessments'] as $jump){
								echo "<div class='breakdownclass' style='width:calc(100% - 25px);'>";
								print_r('<h2>'.$jump['title'].' Assessment</h2>');
								for($t = 0; $t < sizeof($jump) - 1; $t++){
									$vc = '';
									if(isset($jump[$t]['videoFilePath']) && $jump[$t]['videoFilePath']!=""){
										$foldername = str_replace(".zip","/",$jump[$t]['videoFilePath']);
										$fdname = str_replace(base_url(),"/var/www/html/",$foldername);
										// print_r("1:::".$foldername."::".$fdname);
										$c = 1;
										
										if(is_dir($fdname)) {
											// print_r("1.1:::");
											if ($handle = opendir($fdname)) {
												// print_r("1.2:::");
												while (false !== ($entry = readdir($handle))) {
													if ($entry != "." && $entry != "..") {
														if (strpos($entry, '.jpg') !== false)
														{
															$videoimagepath = $foldername.$entry;
															$vc .= '<a data-fancybox="gallery'.$galcount.'" href="'.$videoimagepath.'"><img style="width:180px; margin:5px;" src="'.$videoimagepath.'?'.time().'"></a>';
															$c++;
															if($c > 6)
																break;
														}
													}
												}
											}
										}
									}
									
									
									$ic = '';
									if(isset($jump[$t]['imagePath']) && $jump[$t]['imagePath']!="")
									{
										$iPath = str_replace(base_url(),"/var/www/html/",$jump[$t]['imagePath']);
										if(file_exists($iPath))
											$ic = '<a data-fancybox="gallery'.$galcount.'" href="'.$jump[$t]['imagePath'].'"><img style="width:100%;" src="'.$jump[$t]['imagePath'].'?'.time().'"></a>';
									}
									
									$galcount++;
									if($jump[$t]['type'] == "Notes")
										print_r('<p><b>'.$jump[$t]['type'].'</b> <span class="splfullwidth">'.$jump[$t]['score'].'</span><i>'.$ic.$vc.'</i></p>');
									else
										print_r('<p><b>'.$jump[$t]['type'].'</b> <span>'.$jump[$t]['score'].'</span></p>');
									
									//print_r($jump[$t]);
								}
								print_r('</div>');
							}
						}
					}
				}else{
					echo '<script> document.getElementById("datetitle").innerHTML = "'.$new_date.'"; </script><script></script>';
					$d = $maindata[$new_date];
					if(isset($d['functionalAssessments'])){
						foreach($d['functionalAssessments'] as $jump){
							echo "<div class='breakdownclass' style='width:calc(100% - 25px);'>";
							print_r('<h2>'.$jump['title'].' Assessment</h2>');
							for($t = 0; $t < sizeof($jump) - 1; $t++){
								$vc = '';
								if(isset($jump[$t]['videoFilePath']) && $jump[$t]['videoFilePath']!=""){
									$foldername = str_replace(".zip","/",$jump[$t]['videoFilePath']);
									$fdname = str_replace(base_url(),"/var/www/html/",$foldername);
									// print_r("1:::".$foldername."::".$fdname);
									$c = 1;
									
									if(is_dir($fdname)) {
										// print_r("1.1:::");
										if ($handle = opendir($fdname)) {
											// print_r("1.2:::");
											while (false !== ($entry = readdir($handle))) {
												if ($entry != "." && $entry != "..") {
													if (strpos($entry, '.jpg') !== false)
													{
														$videoimagepath = $foldername.$entry;
														$vc .= '<a data-fancybox="gallery'.$galcount.'" href="'.$videoimagepath.'"><img style="width:180px; margin:5px;" src="'.$videoimagepath.'?'.time().'"></a>';
														$c++;
														if($c > 6)
															break;
													}
												}
											}
										}
									}
								}
								
								
								$ic = '';
								if(isset($jump[$t]['imagePath']) && $jump[$t]['imagePath']!="")
								{
									$iPath = str_replace(base_url(),"/var/www/html/",$jump[$t]['imagePath']);
									if(file_exists($iPath))
										$ic = '<a data-fancybox="gallery'.$galcount.'" href="'.$jump[$t]['imagePath'].'"><img style="width:100%;" src="'.$jump[$t]['imagePath'].'?'.time().'"></a>';
								}
									
								$galcount++;
								
								if($jump[$t]['type'] == "Notes")
									print_r('<p><b>'.$jump[$t]['type'].'</b> <span class="splfullwidth">'.$jump[$t]['score'].'</span><i>'.$ic.$vc.'</i></p>');
								else
									print_r('<p><b>'.$jump[$t]['type'].'</b> <span>'.$jump[$t]['score'].'</span></p>');
							}
							print_r('</div>');
						}
					}
				}
			}
			
			$balanceavg = 0;
			$flexibilityavg = 0;
			$corestabilityavg = 0;
			$dynamicpostureavg = 0;
			$functionalasymmetryavg = 0;
			$lowerextremitypoweravg = 0;
			$susceptibilitytoinjuryavg = 0;
			
			foreach($sortdate as $d1){								
				$timestamp = strtotime($d1);
				$a = array();
				$new_date = date("m-d-Y", $timestamp);
				if($selecteddate!=""){
					if($timestamp == $selecteddate){
						if(isset($kamsscore[$new_date])){
						$d = $kamsscore[$new_date];
						if(isset($d['balancescore']) && $d['balancescore']!=""){
							$balanceavg = $d['balancescore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0; float: left;'>BALANCE SCORE</font> <span id='balancescore".$timestamp."' style='float: right;background: black; color: white;padding: 10px;font-size: 125%;font-weight: 700;'>".$d['balancescore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderbalance'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['flexibilityscore']) && $d['flexibilityscore']!=""){
							$flexibilityavg = $d['flexibilityscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>FLEXIBILITY SCORE</font> <span id='flexibilityscore".$timestamp."' style='float: right;background: black;color: white;padding: 10px;font-size: 125%;font-weight: 700;'>".$d['flexibilityscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderflexibility'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['corestabilityscore']) && $d['corestabilityscore']!=""){
							$corestabilityavg = $d['corestabilityscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>CORE STABILITY SCORE</font> <span id='corestabilityscore".$timestamp."' style='float: right;background: black;color: white;padding: 10px;font-size: 125%;font-weight: 700;'>".$d['corestabilityscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='slidercorestability'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['dynamicposturescore']) && $d['dynamicposturescore']!=""){
							$dynamicpostureavg = $d['dynamicposturescore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>DYNAMIC POSTURE SCORE</font> <span id='dynamicposturescore".$timestamp."' style='float: right;background: black;color: white;padding: 10px;font-size: 125%;font-weight: 700;'>".$d['dynamicposturescore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderdynamicposture'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['lowerextremitypowerscore']) && $d['lowerextremitypowerscore']!=""){
							$lowerextremitypoweravg = $d['lowerextremitypowerscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>LOWER EXTREMITY POWER SCORE</font> <span id='lowerextremitypowerscore".$timestamp."' style='float: right;background: black;color: white;padding: 10px;font-size: 125%;font-weight: 700;'>".$d['lowerextremitypowerscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderlowerextremitypower'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['functionalasymmetryscore']) && $d['functionalasymmetryscore']!=""){
							$functionalasymmetryavg = $d['functionalasymmetryscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>FUNCTIONAL ASSYMMETRY SCORE</font> <span id='functionalasymmetryscore".$timestamp."' style='float: right;background: black;color: white;padding: 10px;font-size: 125%;font-weight: 700;'>".$d['functionalasymmetryscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderfunctionalasymmetry'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['susceptibilitytoinjuryscore']) && $d['susceptibilitytoinjuryscore']!=""){
							$susceptibilitytoinjuryavg = $d['susceptibilitytoinjuryscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>SUSCEPTIBILITY TO INJURY SCORE</font> <span id='susceptibilitytoinjuryscore".$timestamp."' style='float: right;background: black;color: white;padding: 10px;font-size: 125%;font-weight: 700;'>".$d['susceptibilitytoinjuryscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='slidersusceptibilitytoinjury'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						}
					}
				}else{
					
					if(isset($kamsscore[$new_date])){
						$d = $kamsscore[$new_date];
						if(isset($d['balancescore']) && $d['balancescore']!=""){
							$balanceavg = $d['balancescore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>BALANCE SCORE</font> <span id='balancescore".$timestamp."' style='float: right; background: black;color: white; padding: 10px; font-size: 125%; font-weight: 700;'>".$d['balancescore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderbalance'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['flexibilityscore']) && $d['flexibilityscore']!=""){
							$flexibilityavg = $d['flexibilityscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>FLEXIBILITY SCORE</font> <span id='flexibilityscore".$timestamp."' style='float: right; background: black;color: white;padding: 10px; font-size: 125%; font-weight: 700;'>".$d['flexibilityscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderflexibility'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['corestabilityscore']) && $d['corestabilityscore']!=""){
							$corestabilityavg = $d['corestabilityscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>CORE STABILITY SCORE</font> <span id='corestabilityscore".$timestamp."' style='float: right; background: black; color: white; padding: 10px; font-size: 125%; font-weight: 700;'>".$d['corestabilityscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='slidercorestability'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['dynamicposturescore']) && $d['dynamicposturescore']!=""){
							$dynamicpostureavg = $d['dynamicposturescore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>DYNAMIC POSTURE SCORE</font> <span id='dynamicposturescore".$timestamp."' style='float: right; background: black; color: white; padding: 10px; font-size: 125%; font-weight: 700;'>".$d['dynamicposturescore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderdynamicposture'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['lowerextremitypowerscore']) && $d['lowerextremitypowerscore']!=""){
							$lowerextremitypoweravg = $d['lowerextremitypowerscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>LOWER EXTREMITY POWER SCORE</font> <span id='lowerextremitypowerscore".$timestamp."' style='float: right; background: black;color: white; padding: 10px; font-size: 125%; font-weight: 700;'>".$d['lowerextremitypowerscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderlowerextremitypower'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['functionalasymmetryscore']) && $d['functionalasymmetryscore']!=""){
							$functionalasymmetryavg = $d['functionalasymmetryscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>FUNCTIONAL ASSYMMETRY SCORE</font> <span id='functionalasymmetryscore".$timestamp."' style='float: right; background: black; color: white; padding: 10px; font-size: 125%; font-weight: 700;'>".$d['functionalasymmetryscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='sliderfunctionalasymmetry'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
						
						if(isset($d['susceptibilitytoinjuryscore']) && $d['susceptibilitytoinjuryscore']!=""){
							$susceptibilitytoinjuryavg = $d['susceptibilitytoinjuryscore'];
							echo "<h2 style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>SUSCEPTIBILITY TO INJURY SCORE</font> <span id='susceptibilitytoinjuryscore".$timestamp."' style='float: right; background: black; color: white; padding: 10px; font-size: 125%; font-weight: 700;'>".$d['susceptibilitytoinjuryscore']."</span></h2><div class='whitebgcontent'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='slidersusceptibilitytoinjury'></div></div><div style='float:left; width:100%; height:45px;'></div></div>";
						}
					}
				}
			}
		?>		
	  <div style="clear:both;"></div>
    </section>
    <!-- /.content -->
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>

<style>
/*.fancybox-image{
	transform: rotate(180deg);
}*/
/*
background: #FF0000; 
background: -moz-linear-gradient(left,  #FF0000 0%, #FF7100 40%, #BCE62C 60%, #7DD856 80%, #7DD856 100%);
background: -webkit-linear-gradient(left,  #FF0000 0%,#FF7100 40%,#BCE62C 60%,#7DD856 80%,#7DD856 100%);
background: linear-gradient(to right,  #FF0000 0%,#FF7100 40%,#BCE62C 60%,#7DD856 80%,#7DD856 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#FF0000', endColorstr='#7DD856',GradientType=1 );
*/

.ui-widget-header {
	background: #03a9f4!important;
}

.ui-widget-content {
    border: 1px solid black!important;
	background: #e1e1e1;
	color: #222222;
	margin-top: 4px;
}

.whitebgcontent{
	float: left;
    width: calc(100% - 30px);
    clear: both;
    background: white;
    margin: -15px 15px 30px;
    padding: 20px 20px 20px 10px;
}

.ui-slider .ui-slider-handle {
	position: absolute !important;
	z-index: 2 !important;
	width: 3.2em !important;
	height: 2.2em !important;
	cursor: default !important;
	margin: 0 -20px auto !important;
	text-align: center !important;	
	line-height: 30px !important;
	color: #FFFFFF !important;
	font-size: 15px !important;
}

.ui-corner-all {
	/*border-radius: 20px;*/
}

.ui-slider-horizontal .ui-slider-handle {
	top: -3em !important;
}

.ui-state-default,
.ui-widget-content .ui-state-default {
	background: #808080 !important;
    border: 2px solid #808080!important;
}

.ui-slider-horizontal .ui-slider-handle {
    margin-left: -24px !important;
}

.ui-slider .ui-slider-handle {
	cursor: pointer;
}

.ui-slider a,
.ui-slider a:focus {
	cursor: pointer;
	outline: none;
}

.ui-slider-range-min {
	background: #2980b9;
}

.ui-slider-label-inner {
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-top: 10px solid #808080;
    display: block;
    left: 50%;
    margin-left: -10px;
    position: absolute;
    top: 100%;
    z-index: 99;
}

.ui-state-disabled{
	opacity:1!important;
}
.ui-slider .level1 {
    float: left;
    width: calc(40% + 9px);
    /*background: #FF0000;*/
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
	border-top: 18px solid #FF0000;
    border-right: 18px solid #FF7100;
}
.ui-slider .level2 {
    float: left;
    width: calc(21% - 9px);
    /*background: #FF7100;*/
    position: absolute;
    left: calc(40% + 9px);
    top: 0;
    bottom: 0;
	border-top: 18px solid #FF7100;
    border-right: 18px solid yellow;
}
.ui-slider .level3 {
    float: left;
    width: calc(14% + 9px);
    /*background: yellow;*/
    position: absolute;
    left: 61%;
    top: 0;
    bottom: 0;
	border-top: 18px solid yellow;
    border-right: 18px solid #BCE62C;
}
.ui-slider .level4 {
    float: left;
    width: calc(11% - 9px);
    /*background: #BCE62C;*/
    position: absolute;
    left: calc(75% + 9px);
    top: 0;
    bottom: 0;
	border-top: 18px solid #BCE62C;
    border-right: 18px solid #7ED957;
}
.ui-slider .level5 {
    float: left;
    width: 14%;
    /* background: #7ED957; */
    position: absolute;
    left: 86%;
    top: 0;
    bottom: 0;
	border-top: 18px solid #7ED957;
    border-right: 18px solid #7ED957;
}
.ui-slider-horizontal .ui-slider-range{
	background: transparent!important;
}
div#slider {
    height: 20px;
}
.ui-slider .ui-slider-range:after {
    content: '';
    height: 32px;
    width: 10px;
    float: right;
    position: relative;
    left: 5px;
    top: -7px;
    background: #808080;
    z-index: 99999999999999;
}
.ui-slider .level1:after {
    content: 'Needs Attention';
    position: absolute;
	width: 100%;
    top: 5px;
    text-align: center;
	opacity:0;
}
.ui-slider .level2:after {
    content: 'Poor';
    position: absolute;
	width: 100%;
    top: 5px;
    text-align: center;
	opacity:0;
}
.ui-slider .level3:after {
    content: 'Moderate';
    position: absolute;
	width: 100%;
    top: 5px;
    text-align: center;
	opacity:0;
}
.ui-slider .level4:after {
    content: 'Good';
    position: absolute;
	width: 100%;
    top: 5px;
    text-align: center;
	opacity:0;
}
.ui-slider .level5:after {
    content: 'Great';
    position: absolute;
	width: 100%;
    top: 5px;
    text-align: center;
	opacity:0;
}
div.ui-slider .hideafter:after {
    display: none;
}
.breakdownclass p img {
    max-width: 400px;
    float: left;
    clear: both;
    padding: 10px;
}
.ui-slider-range.ui-widget-header.ui-corner-all.ui-slider-range-min:before {
    content: attr(status);
    position: absolute;
    right: 0;
    top: 26px;
    transform: translateX(50%);
	text-align: center;
}

</style>
<!-- /.content-wrapper -->
<script>
	document.title = 'Detailed Assessments | Baseline Motion';
</script>

<footer class="main-footer">
    <strong>Baseline Motion © <?php echo date('Y'); ?>.</strong> 
</footer>

<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
<script>
    var base_url = '<?php echo base_url(); ?>';
</script>
<!-- jQuery 3 -->
<script src="<?=base_url()?>public/bower_components/jquery/dist/jquery.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
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

<!-- AdminLTE for demo purposes -->
<script src="<?=base_url()?>public/dist/js/demo.js"></script>

<script>
	function hidethelabel(sliderid, val){
		console.log("call"+sliderid+"---"+val);
		$('#'+sliderid+' .level1,#'+sliderid+' .level2,#'+sliderid+' .level3,#'+sliderid+' .level4,#'+sliderid+' .level5').addClass('hideafter');
		if(val > 85) {
			$('#'+sliderid+' div.ui-slider-range').attr({'status':'Great'});
			//$('#'+sliderid+" .level5").removeClass('hideafter');
		} else if(val > 74) {
			$('#'+sliderid+' div.ui-slider-range').attr({'status':'Good'});
			//$('#'+sliderid+" .level4").removeClass('hideafter');
		} else if(val > 60) {
			$('#'+sliderid+' div.ui-slider-range').attr({'status':'Moderate'});
			//$('#'+sliderid+" .level3").removeClass('hideafter');
		} else if(val > 40) {
			$('#'+sliderid+' div.ui-slider-range').attr({'status':'Poor'});
			//$('#'+sliderid+" .level2").removeClass('hideafter');
		} else {
			$('#'+sliderid+' div.ui-slider-range').attr({'status':'Needs Attention'});
			//$('#'+sliderid+" .level1").removeClass('hideafter');
		}	
	}
	
	$(document).ready(function(){ 
		 $("#slider").slider({
			range: "min",
			animate: true,
			value: <?php if(isset($average) && $average != "" && $average != "-"){ echo $average; } else { echo "0"; } ?>,
			min: 0,
			max: 100,
			step: 1,
			disabled: true,
			slide: function (event, ui) {
				$('#slider a').html('<label>' + ui.value + '%</label><div class="ui-slider-label-inner"></div>');
				setTimeout(function(){ hidethelabel('slider',ui.value); }, 500);
			}
		});
		
		$('#slider a').html('<label><?php if(isset($average) && $average != "" && $average != "-"){ echo $average."%"; } else { echo "0"; } ?></label><div class="ui-slider-label-inner"></div>');
		
		<?php if(isset($average) && $average != "" && $average != "-"){ ?>
		setTimeout(function(){ hidethelabel('slider','<?php echo $average; ?>'); }, 1500);
		<?php }else{ ?>
		setTimeout(function(){ hidethelabel('slider',0); }, 1500);
		<?php } ?>
		
		$("#sliderbalance").slider({
			range: "min",
			animate: true,
			value: <?php if(isset($balanceavg) && $balanceavg != "" && $balanceavg != "-"){ echo $balanceavg; } else { echo "0"; } ?>,
			min: 0,
			max: 100,
			step: 1,
			disabled: true,
			slide: function (event, ui) {
				$('#sliderbalance a').html('<label>' + ui.value + '</label><div class="ui-slider-label-inner"></div>');
				setTimeout(function(){ hidethelabel('sliderbalance',ui.value); }, 500);
			}
		});
		
		$('#sliderbalance a').html('<label><?php if(isset($balanceavg) && $balanceavg != "" && $balanceavg != "-"){ echo $balanceavg; } else { echo "0"; } ?></label><div class="ui-slider-label-inner"></div>');
		
		<?php if(isset($balanceavg) && $balanceavg != "" && $balanceavg != "-"){ ?>
		setTimeout(function(){ hidethelabel('sliderbalance','<?php echo $balanceavg; ?>'); }, 1500);
		<?php }else{ ?>
		setTimeout(function(){ hidethelabel('sliderbalance',0); }, 1500);
		<?php } ?>
		
		$("#sliderflexibility").slider({
			range: "min",
			animate: true,
			value: <?php if(isset($flexibilityavg) && $flexibilityavg != "" && $flexibilityavg != "-"){ echo $flexibilityavg; } else { echo "0"; } ?>,
			min: 0,
			max: 100,
			step: 1,
			disabled: true,
			slide: function (event, ui) {
				$('#sliderflexibility a').html('<label>' + ui.value + '</label><div class="ui-slider-label-inner"></div>');
				setTimeout(function(){ hidethelabel('sliderflexibility',ui.value); }, 500);
			}
		});
		
		$('#sliderflexibility a').html('<label><?php if(isset($flexibilityavg) && $flexibilityavg != "" && $flexibilityavg != "-"){ echo $flexibilityavg; } else { echo "0"; } ?></label><div class="ui-slider-label-inner"></div>');
		
		<?php if(isset($flexibilityavg) && $flexibilityavg != "" && $flexibilityavg != "-"){ ?>
		setTimeout(function(){ hidethelabel('sliderflexibility','<?php echo $flexibilityavg; ?>'); }, 1500);
		<?php }else{ ?>
		setTimeout(function(){ hidethelabel('sliderflexibility',0); }, 1500);
		<?php } ?>
		
		$("#slidercorestability").slider({
			range: "min",
			animate: true,
			value: <?php if(isset($corestabilityavg) && $corestabilityavg != "" && $corestabilityavg != "-"){ echo $corestabilityavg; } else { echo "0"; } ?>,
			min: 0,
			max: 100,
			step: 1,
			disabled: true,
			slide: function (event, ui) {
				$('#slidercorestability a').html('<label>' + ui.value + '</label><div class="ui-slider-label-inner"></div>');
				setTimeout(function(){ hidethelabel('slidercorestability',ui.value); }, 500);
			}
		});
		
		$('#slidercorestability a').html('<label><?php if(isset($corestabilityavg) && $corestabilityavg != "" && $corestabilityavg != "-"){ echo $corestabilityavg; } else { echo "0"; } ?></label><div class="ui-slider-label-inner"></div>');
		
		<?php if(isset($corestabilityavg) && $corestabilityavg != "" && $corestabilityavg != "-"){ ?>
		setTimeout(function(){ hidethelabel('slidercorestability','<?php echo $corestabilityavg; ?>'); }, 1500);
		<?php }else{ ?>
		setTimeout(function(){ hidethelabel('slidercorestability',0); }, 1500);
		<?php } ?>
		
		$("#sliderdynamicposture").slider({
			range: "min",
			animate: true,
			value: <?php if(isset($dynamicpostureavg) && $dynamicpostureavg != "" && $dynamicpostureavg != "-"){ echo $dynamicpostureavg; } else { echo "0"; } ?>,
			min: 0,
			max: 100,
			step: 1,
			disabled: true,
			slide: function (event, ui) {
				$('#sliderdynamicposture a').html('<label>' + ui.value + '</label><div class="ui-slider-label-inner"></div>');
				setTimeout(function(){ hidethelabel('sliderdynamicposture',ui.value); }, 500);
			}
		});
		
		$('#sliderdynamicposture a').html('<label><?php if(isset($dynamicpostureavg) && $dynamicpostureavg != "" && $dynamicpostureavg != "-"){ echo $dynamicpostureavg; } else { echo "0"; } ?></label><div class="ui-slider-label-inner"></div>');
		
		<?php if(isset($dynamicpostureavg) && $dynamicpostureavg != "" && $dynamicpostureavg != "-"){ ?>
		setTimeout(function(){ hidethelabel('sliderdynamicposture','<?php echo $dynamicpostureavg; ?>'); }, 1500);
		<?php }else{ ?>
		setTimeout(function(){ hidethelabel('sliderdynamicposture',0); }, 1500);
		<?php } ?>
		
		$("#sliderlowerextremitypower").slider({
			range: "min",
			animate: true,
			value: <?php if(isset($lowerextremitypoweravg) && $lowerextremitypoweravg != "" && $lowerextremitypoweravg != "-"){ echo $lowerextremitypoweravg; } else { echo "0"; } ?>,
			min: 0,
			max: 100,
			step: 1,
			disabled: true,
			slide: function (event, ui) {
				$('#sliderlowerextremitypower a').html('<label>' + ui.value + '</label><div class="ui-slider-label-inner"></div>');
				setTimeout(function(){ hidethelabel('sliderlowerextremitypower',ui.value); }, 500);
			}
		});
		
		$('#sliderlowerextremitypower a').html('<label><?php if(isset($lowerextremitypoweravg) && $lowerextremitypoweravg != "" && $lowerextremitypoweravg != "-"){ echo $lowerextremitypoweravg; } else { echo "0"; } ?></label><div class="ui-slider-label-inner"></div>');
		
		<?php if(isset($lowerextremitypoweravg) && $lowerextremitypoweravg != "" && $lowerextremitypoweravg != "-"){ ?>
		setTimeout(function(){ hidethelabel('sliderlowerextremitypower','<?php echo $lowerextremitypoweravg; ?>'); }, 1500);
		<?php }else{ ?>
		setTimeout(function(){ hidethelabel('sliderlowerextremitypower',0); }, 1500);
		<?php } ?>
		
		$("#sliderfunctionalasymmetry").slider({
			range: "min",
			animate: true,
			value: <?php if(isset($functionalasymmetryavg) && $functionalasymmetryavg != "" && $functionalasymmetryavg != "-"){ echo $functionalasymmetryavg; } else { echo "0"; } ?>,
			min: 0,
			max: 100,
			step: 1,
			disabled: true,
			slide: function (event, ui) {
				$('#sliderfunctionalasymmetry a').html('<label>' + ui.value + '</label><div class="ui-slider-label-inner"></div>');
				setTimeout(function(){ hidethelabel('sliderfunctionalasymmetry',ui.value); }, 500);
			}
		});
		
		$('#sliderfunctionalasymmetry a').html('<label><?php if(isset($functionalasymmetryavg) && $functionalasymmetryavg != "" && $functionalasymmetryavg != "-"){ echo $functionalasymmetryavg; } else { echo "0"; } ?></label><div class="ui-slider-label-inner"></div>');
		
		<?php if(isset($functionalasymmetryavg) && $functionalasymmetryavg != "" && $functionalasymmetryavg != "-"){ ?>
		setTimeout(function(){ hidethelabel('sliderfunctionalasymmetry','<?php echo $functionalasymmetryavg; ?>'); }, 1500);
		<?php }else{ ?>
		setTimeout(function(){ hidethelabel('sliderfunctionalasymmetry',0); }, 1500);
		<?php } ?>
		
		$("#slidersusceptibilitytoinjury").slider({
			range: "min",
			animate: true,
			value: <?php if(isset($susceptibilitytoinjuryavg) && $susceptibilitytoinjuryavg != "" && $susceptibilitytoinjuryavg != "-"){ echo $susceptibilitytoinjuryavg; } else { echo "0"; } ?>,
			min: 0,
			max: 100,
			step: 1,
			disabled: true,
			slide: function (event, ui) {
				$('#slidersusceptibilitytoinjury a').html('<label>' + ui.value + '</label><div class="ui-slider-label-inner"></div>');
				setTimeout(function(){ hidethelabel('slidersusceptibilitytoinjury',ui.value); }, 500);
			}
		});
		
		$('#slidersusceptibilitytoinjury a').html('<label><?php if(isset($susceptibilitytoinjuryavg) && $susceptibilitytoinjuryavg != "" && $susceptibilitytoinjuryavg != "-"){ echo $susceptibilitytoinjuryavg; } else { echo "0"; } ?></label><div class="ui-slider-label-inner"></div>');
		
		<?php if(isset($susceptibilitytoinjuryavg) && $susceptibilitytoinjuryavg != "" && $susceptibilitytoinjuryavg != "-"){ ?>
		setTimeout(function(){ hidethelabel('slidersusceptibilitytoinjury','<?php echo $susceptibilitytoinjuryavg; ?>'); }, 1500);
		<?php }else{ ?>
		setTimeout(function(){ hidethelabel('slidersusceptibilitytoinjury',0); }, 1500);
		<?php } ?>
		$('#slider, #sliderbalance, #sliderflexibility, #slidercorestability, #sliderdynamicposture, #sliderlowerextremitypower, #sliderfunctionalasymmetry, #slidersusceptibilitytoinjury').append('<div class="level1"></div><div class="level2"></div><div class="level3"></div><div class="level4"></div><div class="level5"></div>');
	});
	selectedlink = "assesslinkmenu";
	$(function () {
		if(selectedlink!= ""){
			$(".sidebar-menu li").removeClass('active');
			$("#"+selectedlink).addClass('active');
		}
	});
</script>
<?php echo $additionalscript; ?>

<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-154875438-1"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-154875438-1');
</script>

<?php $this->load->view('template/page_level_scripts'); ?>
</body>
</html>