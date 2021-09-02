<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<div class="col-md-12">
			<h1>
				<b><span id="datetitle"></span></b>&nbsp;<font style="font-size:70%; position: relative; top: -4px; left: 5px;">My Workout</font>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?=base_url()?>dashboard/">Dashboard</a></li>
				<li><a href="<?=base_url()?>dashboard/assessments">Assessments</a></li>
				<li class="active">My Workout</li>
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
				$data1['evaluationsBlob'] = $overheadsession->evaluationsBlob;
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
				$data1['evaluationsBlob'] = $reverselungesession->evaluationsBlob;
				
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
				$data1['evaluationsBlob'] = $wallangelsession->evaluationsBlob;
				
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
						$data2['type'] = 'Head Tilt';
						$data2['score'] = round($fr1->AngleHead ,2);
						$data1[] = $data2;
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Eye Tilt';
						$data2['score'] = round($fr1->AngleEyes ,2);
						$data1[] = $data2;
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Shoulder Tilt';
						$data2['score'] = round($fr1->AngleShoulders ,2);
						$data1[] = $data2;

						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Spine Tilt';
						$data2['score'] = round($fr1->AngleSpine ,2);
						$data1[] = $data2;
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Hip Tilt';
						$data2['score'] = round($fr1->AngleHips ,2);
						$data1[] = $data2;
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Knee Tilt';
						$data2['score'] = round($fr1->AngleKnees ,2);
						$data1[] = $data2;
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Ankle Tilt';
						$data2['score'] = round($fr1->AngleAnkles ,2);
						$data1[] = $data2;
						
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Head Position';
						$data2['score'] = round($fr1->DistanceHead ,2);
						$data1[] = $data2;
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Shoulder Position';
						$data2['score'] = round($fr1->DistanceShoulder ,2);
						$data1[] = $data2;
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Spine Position';
						$data2['score'] = round($fr1->DistanceSpine ,2);
						$data1[] = $data2;
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Hip Position';
						$data2['score'] = round($fr1->DistanceHip ,2);
						$data1[] = $data2;
						
						$data2 = array();
						$data2['date'] = $t;
						$data2['type'] = 'Knee Position';
						$data2['score'] = round($fr1->DistanceKnee ,2);
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
						
						$data1[] = $data2;
						$data1['title'] = $funassesssession->tag;
						
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
			$additionalscript = '';
			
			function sortFunction( $a, $b ) {
				return strtotime($b) - strtotime($a);
			}
				
			if(sizeof($sortdate) > 1)
				usort($sortdate, "sortFunction");
			
			foreach($sortdate as $d1){
				$timestamp = strtotime($d1);
				$a = array();
				$new_date = date("m-d-Y", $timestamp);
				
					echo "<h2 class='hidekamssection' style='background: black!important; color: white; padding: 20px; width: calc(100% - 30px); float: left; margin: 15px;'><font style='padding: 10px 0;float: left;'>OVERALL SCORE</font><span id='overallscore".$timestamp."' style='float: right;background: black;color: white;padding: 10px;font-size: 125%;font-weight: 700;'></span></h2><div class='whitebgcontent hidekamssection'><div style='float:left; width:100%; height:45px;'></div><div class='col-sm-12'><div id='slider'></div></div><div style='float:left; width:100%; height:45px;'></div></div><div class='breakdownclass hidekamssection' style='width: calc(100% - 25px);'>";
					print_r('<h2>KAMS Assessment</h2>');
					echo '<script> document.getElementById("datetitle").innerHTML = "'.$new_date.'"; </script>';
					
					
					if($timestamp == $selecteddate){
						
						$d = $maindata[$new_date];
						if(isset($d['romAssessments'])){
							foreach($d['romAssessments'] as $rom){
								$a[] = $rom['scoreval'];
							}
						}
						
						if(isset($d['overheadAssessments'])){
							foreach($d['overheadAssessments'] as $overhead){
								$a[] = $overhead['scoreval'];
							}
						}
						
						if(isset($d['reverselungeAssessments'])){
							foreach($d['reverselungeAssessments'] as $reverselunge){
								$a[] = $reverselunge['scoreval'];
							}
						}
						
						if(isset($d['wallangelAssessments'])){
							foreach($d['wallangelAssessments'] as $wallangel){
								$a[] = $wallangel['scoreval'];
							}
						}
						
						if(isset($d['balanceAssessments'])){
							foreach($d['balanceAssessments'] as $balance){
								$a[] = $balance['scoreval'];
							}
						}
						
						if(isset($d['jumpAssessments'])){
							foreach($d['jumpAssessments'] as $jump){
								$a[] = $jump['scoreval'];
							}
						}
						//print_r('</div>');
						
						
						if(sizeof($a)>0)
						{	$a = array_filter($a);
							$average = array_sum($a)/count($a);
							$average = round($average ,0);
						}else{
							$average = 0;
							$additionalscript .= '<script>jQuery(document).ready(function(){ jQuery(".hidekamssection").hide();});</script>';
						}
						echo '<script> document.getElementById("overallscore'.$timestamp.'").innerHTML = "'.$average.'%"; </script>';
						
						
					}
					
					
					$a = array();
					$d = $maindata[$new_date];
					if(isset($d['romAssessments'])){
						foreach($d['romAssessments'] as $rom){
							
							$a[] = $rom['scoreval'];
							if($rom['type'] == "Back LateralFlexionRight"){
								$score = $rom['scoreval'];
								if($score < 100)
									print_r('<div class="callout KAMS LL callout-danger"><b>Back Lateral Flexion Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
								else
									print_r('<div class="callout KAMS LL callout-success"><b>Back Lateral Flexion Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
							}else if($rom['type'] == "Back Extension"){
								$score = $rom['scoreval'];
								if($score < 100)
									print_r('<div class="callout KAMS SBL callout-danger"><b>Extension </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
								else
									print_r('<div class="callout KAMS SBL callout-success"><b>Extension </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
							}else if($rom['type'] == "Back Flexion"){
								$score = $rom['scoreval'];
								if($score < 100)
									print_r('<div class="callout KAMS SFL callout-danger"><b>Flexion </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
								else
									print_r('<div class="callout KAMS SFL callout-success"><b>Flexion </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
							}else if($rom['type'] == "Back LateralFlexionLeft"){
								$score = $rom['scoreval'];
								if($score < 100)
									print_r('<div class="callout KAMS LL callout-danger"><b>Back Lateral Flexion Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
								else
									print_r('<div class="callout KAMS LL callout-success"><b>Back Lateral Flexion Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
							}
						}
					}
					
					if(isset($d['overheadAssessments'])){
						foreach($d['overheadAssessments'] as $overhead){
							//print_r('<p><b>'.$overhead['type'].'</b> <span>'.$overhead['score'].'</span></p>');
							$a[] = $overhead['scoreval'];
							$evaluations = json_decode($overhead['evaluationsBlob']);
							
							$ThighsReachHorizontal = round($evaluations->ThighsReachHorizontal ,2);
							if($ThighsReachHorizontal < 1)
								print_r('<div class="callout KAMS SBL callout-danger"><b>Thighs Reach Horizontal </b> <i>(SBL - Superficial Backline)</i> <span>'.$ThighsReachHorizontal.'</span></div>');
							else
								print_r('<div class="callout KAMS SBL callout-success"><b>Thighs Reach Horizontal </b> <i>(SBL - Superficial Backline)</i> <span>'.$ThighsReachHorizontal.'</span></div>');
							
							$ValgusLeft = round($evaluations->ValgusLeft * 100 ,2);
							if($ValgusLeft < 95)
								print_r('<div class="callout KAMS LL callout-danger"><b>Valgus Left </b> <i>(LL - Lateral Line)</i> <span>'.$ValgusLeft.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Valgus Left </b> <i>(LL - Lateral Line)</i> <span>'.$ValgusLeft.' %</span></div>');
							
							$ValgusRight = round($evaluations->ValgusRight * 100 ,2);
							if($ValgusRight < 95)
								print_r('<div class="callout KAMS LL callout-danger"><b>Valgus Right </b> <i>(LL - Lateral Line)</i> <span>'.$ValgusRight.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Valgus Right </b> <i>(LL - Lateral Line)</i> <span>'.$ValgusRight.' %</span></div>');
							
							$ShoulderLateralTilt = round($evaluations->ShoulderLateralTilt * 100 ,2);
							if($ShoulderLateralTilt < 90)
								print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Lateral Tilt </b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderLateralTilt.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Lateral Tilt </b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderLateralTilt.' %</span></div>');
							
							$ShoulderAxisRotation = round($evaluations->ShoulderAxisRotation * 100 ,2);
							if($ShoulderAxisRotation < 85) 
								print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Axis Rotation </b> <i>(SPL - Spiral Line)</i> <span>'.$ShoulderAxisRotation.' %</span></div>');
							else
								print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Axis Rotation </b> <i>(SPL - Spiral Line)</i> <span>'.$ShoulderAxisRotation.' %</span></div>');
						}
					}

					if(isset($d['reverselungeAssessments'])){
						foreach($d['reverselungeAssessments'] as $reverselunge){
							//print_r('<p><b>'.$reverselunge['type'].'</b> <span>'.$reverselunge['score'].'</span></p>');
							$a[] = $reverselunge['scoreval'];
							$evaluations = json_decode($reverselunge['evaluationsBlob']);
							
							$ReachedKneelingPositionLeft = round($evaluations->ReachedKneelingPositionLeft ,2);
							if($ReachedKneelingPositionLeft < 1)
								print_r('<div class="callout KAMS SFL callout-danger"><b>Reached kneeling position Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$ReachedKneelingPositionLeft.'</span></div>');
							else
								print_r('<div class="callout KAMS SFL callout-success"><b>Reached kneeling position Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$ReachedKneelingPositionLeft.'</span></div>');
							
							$ValgusLeft = round($evaluations->ValgusLeft * 100 ,2);
							if($ValgusLeft < 95)
								print_r('<div class="callout KAMS LL callout-danger"><b>Valgus Left </b> <i>(LL - Lateral Line)</i> <span>'.$ValgusLeft.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Valgus Left </b> <i>(LL - Lateral Line)</i> <span>'.$ValgusLeft.' %</span></div>');
							
							$ShoulderLateralTiltLeft = round($evaluations->ShoulderLateralTiltLeft * 100 ,2);
							if($ShoulderLateralTiltLeft < 90)
								print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Lateral Tilt Left </b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderLateralTiltLeft.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Lateral Tilt Left </b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderLateralTiltLeft.' %</span></div>');
							
							$ShoulderAxisRotationLeft = round($evaluations->ShoulderAxisRotationLeft * 100 ,2);
							if($ShoulderAxisRotationLeft < 85)
								print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Axis Rotation Left </b> <i>(SPL - Spiral Line)</i> <span>'.$ShoulderAxisRotationLeft.' %</span></div>');
							else
								print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Axis Rotation Left </b> <i>(SPL - Spiral Line)</i> <span>'.$ShoulderAxisRotationLeft.' %</span></div>');
							
							
							
							
							$ReachedKneelingPositionRight = round($evaluations->ReachedKneelingPositionRight ,2);
							if($ReachedKneelingPositionRight < 1)
								print_r('<div class="callout KAMS SFL callout-danger"><b>Reached kneeling position Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$ReachedKneelingPositionRight.'</span></div>');
							else
								print_r('<div class="callout KAMS SFL callout-success"><b>Reached kneeling position Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$ReachedKneelingPositionRight.'</span></div>');
							
							$ValgusRight = round($evaluations->ValgusRight * 100 ,2);
							if($ValgusRight < 95)
								print_r('<div class="callout KAMS LL callout-danger"><b>Valgus Right </b> <i>(LL - Lateral Line)</i> <span>'.$ValgusRight.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Valgus Right </b> <i>(LL - Lateral Line)</i> <span>'.$ValgusRight.' %</span></div>');
							
							$ShoulderLateralTiltRight = round($evaluations->ShoulderLateralTiltRight * 100 ,2);
							if($ShoulderLateralTiltRight < 90)
								print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Lateral Tilt Right </b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderLateralTiltRight.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Lateral Tilt Right </b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderLateralTiltRight.' %</span></div>');
							
							$ShoulderAxisRotationRight = round($evaluations->ShoulderAxisRotationRight * 100 ,2);
							if($ShoulderAxisRotationRight < 85)
								print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Axis Rotation Right </b> <i>(SPL - Spiral Line)</i> <span>'.$ShoulderAxisRotationRight.' %</span></div>');
							else
								print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Axis Rotation Right </b> <i>(SPL - Spiral Line)</i> <span>'.$ShoulderAxisRotationRight.' %</span></div>');
						}
					}
					
					if(isset($d['wallangelAssessments'])){
						foreach($d['wallangelAssessments'] as $wallangel){
							//print_r('<p><b>'.$wallangel['type'].'</b> <span>'.$wallangel['score'].'</span></p>');
							$a[] = $wallangel['scoreval'];
							$evaluations = json_decode($wallangel['evaluationsBlob']);
							//print_r(json_decode($evaluations));
							$HeadCarriage = round($evaluations->HeadCarriage * 100 ,2);
							if($HeadCarriage < 80)
								print_r('<div class="callout KAMS LL callout-danger"><b>Head Carraige</b> <i>(LL - Lateral Line)</i> <span>'.$HeadCarriage.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Head Carraige</b> <i>(LL - Lateral Line)</i> <span>'.$HeadCarriage.' %</span></div>');
							
							$ShoulderLateralTilt = round($evaluations->ShoulderLateralTilt * 100 ,2);
							if($ShoulderLateralTilt < 90)
								print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Lateral Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderLateralTilt.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Lateral Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderLateralTilt.' %</span></div>');
							
							$HipLateralTilt = round($evaluations->HipLateralTilt * 100 ,2);
							if($HipLateralTilt < 90)
								print_r('<div class="callout KAMS LL callout-danger"><b>Hip Lateral Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$HipLateralTilt.' %</span></div>');
							else
								print_r('<div class="callout KAMS LL callout-success"><b>Hip Lateral Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$HipLateralTilt.' %</span></div>');
						}
					}
					
				/*	if(isset($d['balanceAssessments'])){
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
				*/
					print_r('</div>');
				break;
			}
			
			foreach($sortdate as $d1){					
				$timestamp = strtotime($d1);
				$new_date = date("m-d-Y", $timestamp);
				
					echo '<script> document.getElementById("datetitle").innerHTML = "'.$new_date.'"; </script><script></script>';
					$d = $maindata[$new_date];
					if(isset($d['functionalAssessments'])) {
						foreach($d['functionalAssessments'] as $jump) {
							echo "<div class='breakdownclass' style='width:calc(100% - 25px);'>";
							print_r('<h2>'.$jump['title'].' Assessment</h2>');
							for($t = 0; $t < sizeof($jump) - 2; $t++) {
								if($jump[$t]['type'] == 'Head Tilt'){
									$HeadTilt = abs($jump[$t]['score']);
									if($HeadTilt > 6)
										print_r('<div class="callout Posture LL callout-danger"><b>Head Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$HeadTilt.'</span></div>');
									else
										print_r('<div class="callout Posture LL callout-success"><b>Head Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$HeadTilt.'</span></div>');
								} else if($jump[$t]['type'] == 'Eye Tilt'){
									$EyeTilt = abs($jump[$t]['score']);
									if($EyeTilt > 5)
										print_r('<div class="callout Posture LL callout-danger"><b>Eye Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$EyeTilt.'</span></div>');
									else
										print_r('<div class="callout Posture LL callout-success"><b>Eye Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$EyeTilt.'</span></div>');
								} else if($jump[$t]['type'] == 'Shoulder Tilt'){
									$ShoulderTilt = abs($jump[$t]['score']);
									if($ShoulderTilt > 1)
										print_r('<div class="callout Posture LL callout-danger"><b>Shoulder Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderTilt.'</span></div>');
									else
										print_r('<div class="callout Posture LL callout-success"><b>Shoulder Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderTilt.'</span></div>');
								} else if($jump[$t]['type'] == 'Spine Tilt'){
									$SpineTilt = abs($jump[$t]['score']);
									if($SpineTilt > 1)
										print_r('<div class="callout Posture LL callout-danger"><b>Spine Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$SpineTilt.'</span></div>');
									else
										print_r('<div class="callout Posture LL callout-success"><b>Spine Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$SpineTilt.'</span></div>');
								} else if($jump[$t]['type'] == 'Hip Tilt'){
									$HipTilt = abs($jump[$t]['score']);
									if($HipTilt > 1.3)
										print_r('<div class="callout Posture LL callout-danger"><b>Hip Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$HipTilt.'</span></div>');
									else
										print_r('<div class="callout Posture LL callout-success"><b>Hip Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$HipTilt.'</span></div>');
								} else if($jump[$t]['type'] == 'Knee Tilt'){
									$KneeTilt = abs($jump[$t]['score']);
									if($KneeTilt > 1.5)
										print_r('<div class="callout Posture LL callout-danger"><b>Knee Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$KneeTilt.'</span></div>');
									else
										print_r('<div class="callout Posture LL callout-success"><b>Knee Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$KneeTilt.'</span></div>');
								} else if($jump[$t]['type'] == 'Ankle Tilt'){
									$AnkleTilt = abs($jump[$t]['score']);
									if($AnkleTilt > 0.75)
										print_r('<div class="callout Posture LL callout-danger"><b>Ankle Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$AnkleTilt.'</span></div>');
									else
										print_r('<div class="callout Posture LL callout-success"><b>Ankle Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$AnkleTilt.'</span></div>');
								} else if($jump[$t]['type'] == 'Head Position'){
									$HeadPosition = $jump[$t]['score'];
									
									$x = 'SBL - Superficial Backline';
									$y = 'SBL';
									if($HeadPosition < 0){
										$x = 'SFL - Superficial Frontline';
										$y = 'SFL';
									}
									$HeadPosition = abs($HeadPosition) * 100;
									if($HeadPosition > 6)
										print_r('<div class="callout Posture '.$y.' callout-danger"><b>Head Position</b> <i>('.$x.')</i> <span>'.$HeadPosition.'</span></div>');
									else
										print_r('<div class="callout Posture '.$y.' callout-success"><b>Head Position</b> <i>('.$x.')</i> <span>'.$HeadPosition.'</span></div>');
								} else if($jump[$t]['type'] == 'Shoulder Position'){
									$ShoulderPosition = $jump[$t]['score'];
									
									$x = 'SFL - Superficial Frontline';
									$y = 'SFL';
									if($ShoulderPosition < 0) {
										$x = 'SBL - Superficial Backline';
										$y = 'SBL';
									}
									$ShoulderPosition = abs($ShoulderPosition) * 100;
									if($ShoulderPosition > 5)
										print_r('<div class="callout Posture '.$y.' callout-danger"><b>Shoulder Position</b> <i>('.$x.')</i> <span>'.$ShoulderPosition.'</span></div>');
									else
										print_r('<div class="callout Posture '.$y.' callout-success"><b>Shoulder Position</b> <i>('.$x.')</i> <span>'.$ShoulderPosition.'</span></div>');
								} else if($jump[$t]['type'] == 'Spine Position'){
									$SpinePosition = $jump[$t]['score'];
									$x = 'SFL - Superficial Frontline';
									$y = 'SFL';
									if($SpinePosition < 0){
										$x = 'SBL - Superficial Backline';
										$y = 'SBL';
									}
									$SpinePosition = abs($SpinePosition) * 100;
									if($SpinePosition > 5)
										print_r('<div class="callout Posture '.$y.' callout-danger"><b>Spine Position</b> <i>('.$x.')</i> <span>'.$SpinePosition.'</span></div>');
									else
										print_r('<div class="callout Posture '.$y.' callout-success"><b>Spine Position</b> <i>('.$x.')</i> <span>'.$SpinePosition.'</span></div>');
								} else if($jump[$t]['type'] == 'Hip Position'){
									$HipPosition = $jump[$t]['score'];
									$x = 'SBL - Superficial Backline';
									$y = 'SBL';
									if($HipPosition < 0){
										$x = 'SFL - Superficial Frontline';
										$y = 'SFL';
									}
									$HipPosition = abs($HipPosition) * 100;
									if($HipPosition > 4)
										print_r('<div class="callout Posture '.$y.' callout-danger"><b>Hip Position</b> <i>('.$x.')</i> <span>'.$HipPosition.'</span></div>');
									else
										print_r('<div class="callout Posture '.$y.' callout-success"><b>Hip Position</b> <i>('.$x.')</i> <span>'.$HipPosition.'</span></div>');
								} else if($jump[$t]['type'] == 'Knee Position'){
									$KneePosition = $jump[$t]['score'];
									$x = 'SBL - Superficial Backline';
									$y = 'SBL';
									if($KneePosition < 0) {
										$x = 'SFL - Superficial Frontline';
										$y = 'SFL';
									}
									$KneePosition = abs($KneePosition) * 100;
									if($KneePosition > 2)
										print_r('<div class="callout Posture '.$y.' callout-danger"><b>Knee Position</b> <i>('.$x.')</i> <span>'.$KneePosition.'</span></div>');
									else
										print_r('<div class="callout Posture '.$y.' callout-success"><b>Knee Position</b> <i>('.$x.')</i> <span>'.$KneePosition.'</span></div>');
								} else if($jump[$t]['type'] == 'Shoulder Plane Rotation'){
									$ShoulderPlaneRotation = abs($jump[$t]['score']);
									if($ShoulderPlaneRotation > 5)
										print_r('<div class="callout Posture SPL callout-danger"><b>Shoulder Plane Rotation</b> <i>(SPL - Spiral Line)</i> <span>'.$ShoulderPlaneRotation.'</span></div>');
									else
										print_r('<div class="callout Posture SPL callout-success"><b>Shoulder Plane Rotation</b> <i>(SPL - Spiral Line)</i> <span>'.$ShoulderPlaneRotation.'</span></div>');
								} else if($jump[$t]['type'] == 'Hip Plane Rotation'){
									$HipPlaneRotation = abs($jump[$t]['score']);
									if($HipPlaneRotation > 4)
										print_r('<div class="callout Posture SPL callout-danger"><b>Hip Plane Rotation</b> <i>(SPL - Spiral Line)</i> <span>'.$HipPlaneRotation.'</span></div>');
									else
										print_r('<div class="callout Posture SPL callout-success"><b>Hip Plane Rotation</b> <i>(SPL - Spiral Line)</i> <span>'.$HipPlaneRotation.'</span></div>');
								} else if($jump[$t]['type'] == 'Knee Plane Rotation'){
									$KneePlaneRotation = abs($jump[$t]['score']);
									if($KneePlaneRotation > 2)
										print_r('<div class="callout Posture SPL callout-danger"><b>Knee Plane Rotation</b> <i>(SPL - Spiral Line)</i> <span>'.$KneePlaneRotation.'</span></div>');
									else
										print_r('<div class="callout Posture SPL callout-success"><b>Knee Plane Rotation</b> <i>(SPL - Spiral Line)</i> <span>'.$KneePlaneRotation.'</span></div>');
								} else if($jump[$t]['type'] == 'Ankle Plane Rotation'){
									$AnklePlaneRotation = abs($jump[$t]['score']);
									if($AnklePlaneRotation > 1)
										print_r('<div class="callout Posture SPL callout-danger"><b>Ankle Plane Rotation</b> <i>(SPL - Spiral Line)</i> <span>'.$AnklePlaneRotation.'</span></div>');
									else
										print_r('<div class="callout Posture SPL callout-success"><b>Ankle Plane Rotation</b> <i>(SPL - Spiral Line)</i> <span>'.$AnklePlaneRotation.'</span></div>');
								} else {
									print_r('<p><b>'.$jump[$t]['type'].'</b> <span>'.$jump[$t]['score'].'</span></p>');
								}
							}
							print_r('</div>');
						}
					}
				break;
			}
		?>	


		<div class="breakdownclass" style="width:calc(100% - 25px); display: none;">
			<h2>Red Flag Summary</h2>
			<div class="summarydiv">
				<div class="summarycls">
					<div class="summaryclshead"><b>Posture</b></div>
					<div class="summaryclsbody"><b>LL</b><span id="posturell">0</span></div>
					<div class="summaryclsbody"><b>SFL/SBL</b><span id="posturesflsbl">0</span></div>
					<div class="summaryclsbody"><b>SPL</b><span id="posturesflspl">0</span></div>
				</div>
				<div class="summarycls">
					<div class="summaryclshead"><b>KAMS</b></div>
					<div class="summaryclsbody"><b>LL</b><span id="kamsll">0</span></div>
					<div class="summaryclsbody"><b>SFL/SBL</b><span id="kamssflsbl">0</span></div>
					<div class="summaryclsbody"><b>SPL</b><span id="kamsspl">0</span></div>
				</div>
				<div class="summarycls">
					<div class="summaryclshead"><b>Total Count</b></div>
					<div class="summaryclsbod	y"><b>LL</b><span id="totalll">0</span><i id="totalllper">0</i></div>
					<div class="summaryclsbody"><b>SFL/SBL</b><span id="totalsflsbl">0</span><i id="totalsflsblper">0</i></div>
					<div class="summaryclsbody"><b>SPL</b><span id="totalspl">0</span><i id="totalsplper">0</i></div>
				</div>
			</div>
		</div>
		<div style="clear:both;"></div>
		
	<!--	<div class="breakdownclass" style="width:calc(100% - 25px);">
			<h2>Recommended Workouts</h2>
			<?php
				//print_r($workouts);
			/*	foreach($workouts as $works){
					if($works->assessment_date == date("m-d-Y", $_REQUEST['date'])){
						//echo '<h2>'.$works->assessment_date.'</h2>';
						echo '<div class="videoslist">';
						if(isset($works->llvideos) && $works->llvideos!=""){
							foreach($works->llvideos as $ll){
								echo '<div class="individualvideo"><div>'.$ll->title.'</div><div>'.$ll->code.'</div></div>';
							}
						}
						
						if(isset($works->sflsblvideos) && $works->sflsblvideos!=""){
							foreach($works->sflsblvideos as $ll){
								echo '<div class="individualvideo"><div>'.$ll->title.'</div><div>'.$ll->code.'</div></div>';
							}
						}
						
						if(isset($works->splvideos) && $works->splvideos!=""){
							foreach($works->splvideos as $ll){
								echo '<div class="individualvideo"><div>'.$ll->title.'</div><div>'.$ll->code.'</div></div>';
							}
						}
						echo '</div><br/><br/></hr>';
					}
				}*/
			?>
			
		</div> -->
	  
    </section>
    <!-- /.content -->
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<style>
.videoslist{
	display: flex;
    clear: both;
    width: 100%;
   /* justify-content: center; */
    align-items: center;
	flex-direction: row;
	flex-wrap: wrap;
}
.videoslist .individualvideo{
	display: flex;
	flex-direction: column;
	padding: 10px;
}
.videoslist .individualvideo iframe {
    max-width: 270px;
    height: auto!important;
    width: 100%!important;
}
.summarydiv{
	display: flex;
    clear: both;
    width: 100%;
    justify-content: center;
    align-items: center;
	flex-wrap: wrap;
}
.summarydiv .summarycls {
    min-width: 250px;
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
    padding: 5px;
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
    font-size: 20px;
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
@media only screen and (max-width: 768px) {
	.callout * {
		width: 100%; 
		text-align: center!important; 
		clear: both;
	}
	.summarydiv {
		flex-direction: column;
	}
	.summarydiv .summarycls {
		width: 100%!important;
	}
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

<?php echo $additionalscript; ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-154875438-1"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-154875438-1');
	
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
	
	jQuery(document).ready(function(){		
		/****** Posture count ******/
		var posturell = 0;
		posturell = jQuery('.Posture.LL.callout-danger').length;
		jQuery('#posturell').html(posturell);
		
		var posturesfl = 0;
		var posturesbl = 0;
		var posturesflsbl = 0;
		posturesfl = jQuery('.Posture.SFL.callout-danger').length;
		posturesbl = jQuery('.Posture.SBL.callout-danger').length;
		posturesflsbl = posturesfl + posturesbl;
		jQuery('#posturesflsbl').html(posturesflsbl);
		
		var posturesflspl = 0;
		posturesflspl = jQuery('.Posture.SPL.callout-danger').length;
		jQuery('#posturesflspl').html(posturesflspl);
		
		/****** KAMS count ******/
		var kamsll = 0;
		kamsll = jQuery('.KAMS.LL.callout-danger').length;
		jQuery('#kamsll').html(kamsll);
		
		var kamssfl = 0;
		var kamssbl = 0;
		var kamssflsbl = 0;
		kamssfl = jQuery('.KAMS.SFL.callout-danger').length;
		kamssbl = jQuery('.KAMS.SBL.callout-danger').length;
		kamssflsbl = kamssfl + kamssbl;
		jQuery('#kamssflsbl').html(kamssflsbl);
		
		var kamsspl = 0;
		kamsspl = jQuery('.KAMS.SPL.callout-danger').length;
		jQuery('#kamsspl').html(kamsspl);
		
		/****** Total count ******/
		jQuery('#totalll').html(posturell + kamsll);
		jQuery('#totalsflsbl').html(posturesflsbl + kamssflsbl);
		jQuery('#totalspl').html(posturesflspl + kamsspl);
		
		/******** Percentage *********/
		var totalcount = posturell + kamsll + posturesflsbl + kamssflsbl + posturesflspl + kamsspl;
		var totalllper = (posturell + kamsll) * 100 / totalcount;
		jQuery('#totalllper').html(totalllper.toFixed(2)+" %");
		
		var totalsflsblper = (posturesflsbl + kamssflsbl) * 100 / totalcount;
		jQuery('#totalsflsblper').html(totalsflsblper.toFixed(2)+" %");
		
		var totalsplper = (posturesflspl + kamsspl) * 100 / totalcount;
		jQuery('#totalsplper').html(totalsplper.toFixed(2)+" %");
		
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
		$('#slider').append('<div class="level1"></div><div class="level2"></div><div class="level3"></div><div class="level4"></div><div class="level5"></div>');
	});
	
</script>
<?php $this->load->view('template/page_level_scripts'); ?>

</body>
</html>