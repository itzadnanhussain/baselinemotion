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
			
					
			function checkresult($score, $sign, $val){
				//echo "here:::".$score."::::".$sign."::::".$val."<br/>";
				$result = false;
				switch($sign){
					case "<":
						if($score < $val)
							$result = true;
						break;
					case ">":
						if($score > $val)
							$result = true;
						break;
					case ">=":
						if($score >= $val)
							$result = true;
						break;
					case "<=":
						if($score <= $val)
							$result = true;
						break;
					case "==":
						if($score == $val)
							$result = true;
						break;
					case "!=":
						if($score != $val)
							$result = true;
						break;
					default:
						$result = false;
				}
				
				return $result;
			}
			
			
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
								if(isset($rulesdata['BackLateralFlexionRight']['line']) && $rulesdata['BackLateralFlexionRight']['line']!=""){
									if(checkresult($score, $rulesdata['BackLateralFlexionRight']['param_sign'], $rulesdata['BackLateralFlexionRight']['param_value'])) {
										//echo "694<br/>";
										switch($rulesdata['BackLateralFlexionRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Back Lateral Flexion Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Back Lateral Flexion Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Back Lateral Flexion Right </b> <i>(SPL - Spiral Line)</i> <span>'.$score.' %</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Back Lateral Flexion Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
										}
										//echo "695<br/>";
									}else{
										switch($rulesdata['BackLateralFlexionRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Back Lateral Flexion Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Back Lateral Flexion Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Back Lateral Flexion Right </b> <i>(SPL - Spiral Line)</i> <span>'.$score.' %</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Back Lateral Flexion Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
										}
									}										
								}
								
									
							}else if($rom['type'] == "Back Extension"){
								$score = $rom['scoreval'];
								
								if(isset($rulesdata['BackExtension']['line']) && $rulesdata['BackExtension']['line']!=""){
									if(checkresult($score, $rulesdata['BackExtension']['param_sign'], $rulesdata['BackExtension']['param_value'])) {
										switch($rulesdata['BackExtension']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Extension </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Extension </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Extension </b> <i>(SPL - Spiral Line)</i> <span>'.$score.' %</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Extension </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
										}
									}else{
										switch($rulesdata['BackExtension']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Extension </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Extension </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Extension </b> <i>(SPL - Spiral Line)</i> <span>'.$score.' %</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Extension </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
										}
									}
								}
							}else if($rom['type'] == "Back Flexion"){
								$score = $rom['scoreval'];
								if(isset($rulesdata['BackFlexion']['line']) && $rulesdata['BackFlexion']['line']!=""){
									if(checkresult($score, $rulesdata['BackFlexion']['param_sign'], $rulesdata['BackFlexion']['param_value'])) {
										switch($rulesdata['BackFlexion']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Flexion </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Flexion </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Flexion </b> <i>(SPL - Spiral Line)</i> <span>'.$score.' %</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Flexion </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
										}
									}else{
										switch($rulesdata['BackFlexion']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Flexion </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Flexion </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Flexion </b> <i>(SPL - Spiral Line)</i> <span>'.$score.' %</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Flexion </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
										}
									}
								}
							}else if($rom['type'] == "Back LateralFlexionLeft"){
								$score = $rom['scoreval'];
								if(isset($rulesdata['BackLateralFlexionLeft']['line']) && $rulesdata['BackLateralFlexionLeft']['line']!=""){
									if(checkresult($score, $rulesdata['BackLateralFlexionLeft']['param_sign'], $rulesdata['BackLateralFlexionLeft']['param_value'])) {
										switch($rulesdata['BackLateralFlexionLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Back Lateral Flexion Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Back Lateral Flexion Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Back Lateral Flexion Left </b> <i>(SPL - Spiral Line)</i> <span>'.$score.' %</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Back Lateral Flexion Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
										}
									}else{
										switch($rulesdata['BackLateralFlexionLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Back Lateral Flexion Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Back Lateral Flexion Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.' %</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Back Lateral Flexion Left </b> <i>(SPL - Spiral Line)</i> <span>'.$score.' %</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Back Lateral Flexion Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.' %</span></div>');
										}
									}
								}
							}
						}
					}
					
					if(isset($d['overheadAssessments'])){
						foreach($d['overheadAssessments'] as $overhead){
							//print_r('<p><b>'.$overhead['type'].'</b> <span>'.$overhead['score'].'</span></p>');
							$a[] = $overhead['scoreval'];
							$evaluations = json_decode($overhead['evaluationsBlob']);
							
							if(isset($evaluations->ThighsReachHorizontal)){
								$score = round($evaluations->ThighsReachHorizontal ,2);
								
								if(isset($rulesdata['OverheadThighsReachHorizontal']['line']) && $rulesdata['OverheadThighsReachHorizontal']['line']!=""){
									if(checkresult($score, $rulesdata['OverheadThighsReachHorizontal']['param_sign'], $rulesdata['OverheadThighsReachHorizontal']['param_value'])) {
										switch($rulesdata['OverheadThighsReachHorizontal']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Thighs Reach Horizontal </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Thighs Reach Horizontal </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Thighs Reach Horizontal </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Thighs Reach Horizontal </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['OverheadThighsReachHorizontal']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Thighs Reach Horizontal </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Thighs Reach Horizontal </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Thighs Reach Horizontal </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Thighs Reach Horizontal </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							
							
							
							if(isset($evaluations->ValgusLeft)){
								$score = round($evaluations->ValgusLeft ,2);
								
								if(isset($rulesdata['OverheadValgusLeft']['line']) && $rulesdata['OverheadValgusLeft']['line']!=""){
									if(checkresult($score, $rulesdata['OverheadValgusLeft']['param_sign'], $rulesdata['OverheadValgusLeft']['param_value'])) {
										switch($rulesdata['OverheadValgusLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Valgus Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Valgus Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Valgus Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Valgus Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['OverheadValgusLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Valgus Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Valgus Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Valgus Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Valgus Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							
							if(isset($evaluations->ValgusRight)){
								$score = round($evaluations->ValgusRight ,2);
								
								if(isset($rulesdata['OverheadValgusRight']['line']) && $rulesdata['OverheadValgusRight']['line']!=""){
									if(checkresult($score, $rulesdata['OverheadValgusRight']['param_sign'], $rulesdata['OverheadValgusRight']['param_value'])) {
										switch($rulesdata['OverheadValgusRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Valgus Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Valgus Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Valgus Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Valgus Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['OverheadValgusRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Valgus Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Valgus Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Valgus Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Valgus Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ShoulderLateralTilt)){
								$score = round($evaluations->ShoulderLateralTilt ,2);
								
								if(isset($rulesdata['OverheadShoulderLateralTilt']['line']) && $rulesdata['OverheadShoulderLateralTilt']['line']!=""){
									if(checkresult($score, $rulesdata['OverheadShoulderLateralTilt']['param_sign'], $rulesdata['OverheadShoulderLateralTilt']['param_value'])) {
										switch($rulesdata['OverheadShoulderLateralTilt']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Shoulder Lateral Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Shoulder Lateral Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Lateral Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Lateral Tilt </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['OverheadShoulderLateralTilt']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Shoulder Lateral Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Shoulder Lateral Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Lateral Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Lateral Tilt </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ShoulderAxisRotation)){
								$score = round($evaluations->ShoulderAxisRotation ,2);
								
								if(isset($rulesdata['OverheadShoulderAxisRotation']['line']) && $rulesdata['OverheadShoulderAxisRotation']['line']!=""){
									if(checkresult($score, $rulesdata['OverheadShoulderAxisRotation']['param_sign'], $rulesdata['OverheadShoulderAxisRotation']['param_value'])) {
										switch($rulesdata['OverheadShoulderAxisRotation']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Shoulder Axis Rotation </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Shoulder Axis Rotation </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Axis Rotation </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Axis Rotation </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['OverheadShoulderAxisRotation']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Shoulder Axis Rotation </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Shoulder Axis Rotation </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Axis Rotation </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Axis Rotation </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
						}
					}

					if(isset($d['reverselungeAssessments'])){
						foreach($d['reverselungeAssessments'] as $reverselunge){
							//print_r('<p><b>'.$reverselunge['type'].'</b> <span>'.$reverselunge['score'].'</span></p>');
							
							$a[] = $reverselunge['scoreval'];
							$evaluations = json_decode($reverselunge['evaluationsBlob']);
							
							
							if(isset($evaluations->ReachedKneelingPositionLeft)){
								$score = round($evaluations->ReachedKneelingPositionLeft ,2);
								
								if(isset($rulesdata['ReverseLungeReachedKneelingPositionLeft']['line']) && $rulesdata['ReverseLungeReachedKneelingPositionLeft']['line']!=""){
									if(checkresult($score, $rulesdata['ReverseLungeReachedKneelingPositionLeft']['param_sign'], $rulesdata['ReverseLungeReachedKneelingPositionLeft']['param_value'])) {
										switch($rulesdata['ReverseLungeReachedKneelingPositionLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Reached kneeling position Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Reached kneeling position Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Reached kneeling position Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Reached kneeling position Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['ReverseLungeReachedKneelingPositionLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Reached kneeling position Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Reached kneeling position Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Reached kneeling position Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Reached kneeling position Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ValgusLeft)){
								$score = round($evaluations->ValgusLeft ,2);
								
								if(isset($rulesdata['ReverseValgusLeft']['line']) && $rulesdata['ReverseValgusLeft']['line']!=""){
									if(checkresult($score, $rulesdata['ReverseValgusLeft']['param_sign'], $rulesdata['ReverseValgusLeft']['param_value'])) {
										switch($rulesdata['ReverseValgusLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Valgus Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Valgus Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Valgus Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Valgus Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['ReverseValgusLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Valgus Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Valgus Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Valgus Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Valgus Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							
							if(isset($evaluations->ShoulderLateralTiltLeft)){
								$score = round($evaluations->ShoulderLateralTiltLeft ,2);
								
								if(isset($rulesdata['ReverseShoulderLateralTiltLeft']['line']) && $rulesdata['ReverseShoulderLateralTiltLeft']['line']!=""){
									if(checkresult($score, $rulesdata['ReverseShoulderLateralTiltLeft']['param_sign'], $rulesdata['ReverseShoulderLateralTiltLeft']['param_value'])) {
										switch($rulesdata['ReverseShoulderLateralTiltLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Shoulder Lateral Tilt Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Shoulder Lateral Tilt Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Lateral Tilt Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Lateral Tilt Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['ReverseShoulderLateralTiltLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Shoulder Lateral Tilt Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Shoulder Lateral Tilt Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Lateral Tilt Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Lateral Tilt Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ShoulderAxisRotationLeft)){
								$score = round($evaluations->ShoulderAxisRotationLeft ,2);
								
								if(isset($rulesdata['ReverseShoulderAxisRotationLeft']['line']) && $rulesdata['ReverseShoulderAxisRotationLeft']['line']!=""){
									if(checkresult($score, $rulesdata['ReverseShoulderAxisRotationLeft']['param_sign'], $rulesdata['ReverseShoulderAxisRotationLeft']['param_value'])) {
										switch($rulesdata['ReverseShoulderAxisRotationLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Shoulder Axis Rotation Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Shoulder Axis Rotation Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Axis Rotation Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Axis Rotation Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['ReverseShoulderAxisRotationLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Shoulder Axis Rotation Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Shoulder Axis Rotation Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Axis Rotation Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Axis Rotation Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ReachedKneelingPositionRight)){
								$score = round($evaluations->ReachedKneelingPositionRight ,2);
								
								if(isset($rulesdata['ReverseShoulderAxisRotationLeft']['line']) && $rulesdata['ReverseShoulderAxisRotationLeft']['line']!=""){
									if(checkresult($score, $rulesdata['ReverseShoulderAxisRotationLeft']['param_sign'], $rulesdata['ReverseShoulderAxisRotationLeft']['param_value'])) {
										switch($rulesdata['ReverseShoulderAxisRotationLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Shoulder Axis Rotation Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Shoulder Axis Rotation Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Axis Rotation Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Axis Rotation Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['ReverseShoulderAxisRotationLeft']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Shoulder Axis Rotation Left </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Shoulder Axis Rotation Left </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Axis Rotation Left </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Axis Rotation Left </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ReachedKneelingPositionRight)){
								$score = round($evaluations->ReachedKneelingPositionRight ,2);
								
								if(isset($rulesdata['ReverseReachedKneelingPositionRight']['line']) && $rulesdata['ReverseReachedKneelingPositionRight']['line']!=""){
									if(checkresult($score, $rulesdata['ReverseReachedKneelingPositionRight']['param_sign'], $rulesdata['ReverseReachedKneelingPositionRight']['param_value'])) {
										switch($rulesdata['ReverseReachedKneelingPositionRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Reached kneeling position Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Reached kneeling position Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Reached kneeling position Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Reached kneeling position Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['ReverseReachedKneelingPositionRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Reached kneeling position Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Reached kneeling position Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Reached kneeling position Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Reached kneeling position Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ValgusRight)){
								$score = round($evaluations->ValgusRight ,2);
								
								if(isset($rulesdata['ReverseValgusRight']['line']) && $rulesdata['ReverseValgusRight']['line']!=""){
									if(checkresult($score, $rulesdata['ReverseValgusRight']['param_sign'], $rulesdata['ReverseValgusRight']['param_value'])) {
										switch($rulesdata['ReverseValgusRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Valgus Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Valgus Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Valgus Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Valgus Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['ReverseValgusRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Valgus Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Valgus Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Valgus Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Valgus Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ShoulderLateralTiltRight)){
								$score = round($evaluations->ShoulderLateralTiltRight ,2);
								
								if(isset($rulesdata['ReverseShoulderLateralTiltRight']['line']) && $rulesdata['ReverseShoulderLateralTiltRight']['line']!=""){
									if(checkresult($score, $rulesdata['ReverseShoulderLateralTiltRight']['param_sign'], $rulesdata['ReverseShoulderLateralTiltRight']['param_value'])) {
										switch($rulesdata['ReverseShoulderLateralTiltRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Shoulder Lateral Tilt Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Shoulder Lateral Tilt Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Lateral Tilt Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Lateral Tilt Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['ReverseShoulderLateralTiltRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Shoulder Lateral Tilt Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Shoulder Lateral Tilt Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Lateral Tilt Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Lateral Tilt Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ShoulderAxisRotationRight)){
								$score = round($evaluations->ShoulderAxisRotationRight ,2);
								
								if(isset($rulesdata['ShoulderAxisRotationRight']['line']) && $rulesdata['ShoulderAxisRotationRight']['line']!=""){
									if(checkresult($score, $rulesdata['ShoulderAxisRotationRight']['param_sign'], $rulesdata['ShoulderAxisRotationRight']['param_value'])) {
										switch($rulesdata['ShoulderAxisRotationRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Shoulder Axis Rotation Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Shoulder Axis Rotation Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Axis Rotation Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Axis Rotation Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['ShoulderAxisRotationRight']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Shoulder Axis Rotation Right </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Shoulder Axis Rotation Right </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Axis Rotation Right </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Axis Rotation Right </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
						}
					}
					
					if(isset($d['wallangelAssessments'])){
						foreach($d['wallangelAssessments'] as $wallangel){
							//print_r('<p><b>'.$wallangel['type'].'</b> <span>'.$wallangel['score'].'</span></p>');
							$a[] = $wallangel['scoreval'];
							$evaluations = json_decode($wallangel['evaluationsBlob']);
							//print_r(json_decode($evaluations));
							
							
							if(isset($evaluations->HeadCarriage)){
								$score = round($evaluations->HeadCarriage ,2);
								
								if(isset($rulesdata['WallAngelHeadCarriage']['line']) && $rulesdata['WallAngelHeadCarriage']['line']!=""){
									if(checkresult($score, $rulesdata['WallAngelHeadCarriage']['param_sign'], $rulesdata['WallAngelHeadCarriage']['param_value'])) {
										switch($rulesdata['WallAngelHeadCarriage']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Head Carraige </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Head Carraige </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Head Carraige </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Head Carraige </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['WallAngelHeadCarriage']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Head Carraige </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Head Carraige </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Head Carraige </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Head Carraige </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->ShoulderLateralTilt)){
								$score = round($evaluations->ShoulderLateralTilt ,2);
								
								if(isset($rulesdata['WallAngelShoulderLateralTilt']['line']) && $rulesdata['WallAngelShoulderLateralTilt']['line']!=""){
									if(checkresult($score, $rulesdata['WallAngelShoulderLateralTilt']['param_sign'], $rulesdata['WallAngelShoulderLateralTilt']['param_value'])) {
										switch($rulesdata['WallAngelShoulderLateralTilt']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Shoulder Lateral Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Shoulder Lateral Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Shoulder Lateral Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Shoulder Lateral Tilt </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['WallAngelShoulderLateralTilt']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Shoulder Lateral Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Shoulder Lateral Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Shoulder Lateral Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Shoulder Lateral Tilt </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
							if(isset($evaluations->HipLateralTilt)){
								$score = round($evaluations->HipLateralTilt ,2);
								
								if(isset($rulesdata['WallAngelHipLateralTilt']['line']) && $rulesdata['WallAngelHipLateralTilt']['line']!=""){
									if(checkresult($score, $rulesdata['WallAngelHipLateralTilt']['param_sign'], $rulesdata['WallAngelHipLateralTilt']['param_value'])) {
										switch($rulesdata['WallAngelHipLateralTilt']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-danger"><b>Hip Lateral Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-danger"><b>Hip Lateral Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-danger"><b>Hip Lateral Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-danger"><b>Hip Lateral Tilt </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}else{
										switch($rulesdata['WallAngelHipLateralTilt']['line']){
											case "SBL":
												print_r('<div class="callout KAMS SBL callout-success"><b>Hip Lateral Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
												break;
											case "SFL":
												print_r('<div class="callout KAMS SFL callout-success"><b>Hip Lateral Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
												break;
											case "SPL":
												print_r('<div class="callout KAMS SPL callout-success"><b>Hip Lateral Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
												break;
											default:
												print_r('<div class="callout KAMS LL callout-success"><b>Hip Lateral Tilt </b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
										}
									}
								}
							}
							
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
									
										$score = abs($jump[$t]['score']);
										
										if(isset($rulesdata['FunctionalHeadTilt']['line']) && $rulesdata['FunctionalHeadTilt']['line']!=""){
											if(checkresult($score, $rulesdata['FunctionalHeadTilt']['param_sign'], $rulesdata['FunctionalHeadTilt']['param_value'])) {
												switch($rulesdata['FunctionalHeadTilt']['line']){
													case "SBL":
														print_r('<div class="callout Posture SBL callout-danger"><b>Head Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
														break;
													case "SFL":
														print_r('<div class="callout Posture SFL callout-danger"><b>Head Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
														break;
													case "SPL":
														print_r('<div class="callout Posture SPL callout-danger"><b>Head Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
														break;
													default:
														print_r('<div class="callout Posture LL callout-danger"><b>Head Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
												}
											}else{
												switch($rulesdata['FunctionalHeadTilt']['line']){
													case "SBL":
														print_r('<div class="callout Posture SBL callout-success"><b>Head Tilt</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
														break;
													case "SFL":
														print_r('<div class="callout Posture SFL callout-success"><b>Head Tilt</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
														break;
													case "SPL":
														print_r('<div class="callout Posture SPL callout-success"><b>Head Tilt</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
														break;
													default:
														print_r('<div class="callout Posture LL callout-success"><b>Head Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
												}
											}
										}
										
								} else if($jump[$t]['type'] == 'Eye Tilt'){
									$score = abs($jump[$t]['score']);
									
									if(isset($rulesdata['FunctionalEyeTilt']['line']) && $rulesdata['FunctionalEyeTilt']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalEyeTilt']['param_sign'], $rulesdata['FunctionalEyeTilt']['param_value'])) {
											switch($rulesdata['FunctionalEyeTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Eye Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Eye Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Eye Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Eye Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalEyeTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Eye Tilt</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Eye Tilt</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Eye Tilt</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Eye Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Shoulder Tilt'){
									
									$score = abs($jump[$t]['score']);
									
									if(isset($rulesdata['FunctionalShoulderTilt']['line']) && $rulesdata['FunctionalShoulderTilt']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalShoulderTilt']['param_sign'], $rulesdata['FunctionalShoulderTilt']['param_value'])) {
											switch($rulesdata['FunctionalShoulderTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Shoulder Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Shoulder Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Shoulder Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Shoulder Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalShoulderTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Shoulder Tilt</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Shoulder Tilt</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Shoulder Tilt</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Shoulder Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Spine Tilt'){
									$score = abs($jump[$t]['score']);
									if(isset($rulesdata['FunctionalSpineTilt']['line']) && $rulesdata['FunctionalSpineTilt']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalSpineTilt']['param_sign'], $rulesdata['FunctionalSpineTilt']['param_value'])) {
											switch($rulesdata['FunctionalSpineTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Spine Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Spine Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Spine Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Spine Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalSpineTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Spine Tilt</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Spine Tilt</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Spine Tilt</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Spine Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
								} else if($jump[$t]['type'] == 'Hip Tilt'){
									$score = abs($jump[$t]['score']);
									
									if(isset($rulesdata['FunctionalHipTilt']['line']) && $rulesdata['FunctionalHipTilt']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalHipTilt']['param_sign'], $rulesdata['FunctionalHipTilt']['param_value'])) {
											switch($rulesdata['FunctionalHipTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Hip Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Hip Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Hip Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Hip Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalHipTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Hip Tilt</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Hip Tilt</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Hip Tilt</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Hip Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
									
									
								} else if($jump[$t]['type'] == 'Knee Tilt'){
									$score = abs($jump[$t]['score']);
									
									if(isset($rulesdata['FunctionalKneeTilt']['line']) && $rulesdata['FunctionalKneeTilt']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalKneeTilt']['param_sign'], $rulesdata['FunctionalKneeTilt']['param_value'])) {
											switch($rulesdata['FunctionalKneeTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Knee Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Knee Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Knee Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Knee Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalKneeTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Knee Tilt</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Knee Tilt</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Knee Tilt</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Knee Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
								} else if($jump[$t]['type'] == 'Ankle Tilt'){
									$score = abs($jump[$t]['score']);
									if(isset($rulesdata['FunctionalAnkleTilt']['line']) && $rulesdata['FunctionalAnkleTilt']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalAnkleTilt']['param_sign'], $rulesdata['FunctionalAnkleTilt']['param_value'])) {
											switch($rulesdata['FunctionalAnkleTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Ankle Tilt </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Ankle Tilt </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Ankle Tilt </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Ankle Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalAnkleTilt']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Ankle Tilt</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Ankle Tilt</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Ankle Tilt</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Ankle Tilt</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
								} else if($jump[$t]['type'] == 'Head Position'){
									
									$HeadPosition = $jump[$t]['score'];
									$score = abs($HeadPosition) * 100;
									
									if(isset($rulesdata['FunctionalHeadPosition']['line']) && $rulesdata['FunctionalHeadPosition']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalHeadPosition']['param_sign'], $rulesdata['FunctionalHeadPosition']['param_value'])) {
											switch($rulesdata['FunctionalHeadPosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-danger"><b>Head Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$HeadPosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-danger"><b>Head Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$HeadPosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Head Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$HeadPosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Head Position</b> <i>(LL - Lateral Line)</i> <span>'.$HeadPosition.'</span></div>');
											}
										} else {
											switch($rulesdata['FunctionalHeadPosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-success"><b>Head Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$HeadPosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-success"><b>Head Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$HeadPosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Head Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$HeadPosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Head Position</b> <i>(LL - Lateral Line)</i> <span>'.$HeadPosition.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Shoulder Position'){
									$ShoulderPosition = $jump[$t]['score'];
									$score = abs($ShoulderPosition) * 100;
									
									if(isset($rulesdata['FunctionalShoulderPosition']['line']) && $rulesdata['FunctionalShoulderPosition']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalShoulderPosition']['param_sign'], $rulesdata['FunctionalShoulderPosition']['param_value'])) {
											switch($rulesdata['FunctionalShoulderPosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-danger"><b>Shoulder Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$ShoulderPosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-danger"><b>Shoulder Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$ShoulderPosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Shoulder Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$ShoulderPosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Shoulder Position</b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderPosition.'</span></div>');
											}
										} else {
											switch($rulesdata['FunctionalShoulderPosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-success"><b>Shoulder Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$ShoulderPosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-success"><b>Shoulder Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$ShoulderPosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Shoulder Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$ShoulderPosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Shoulder Position</b> <i>(LL - Lateral Line)</i> <span>'.$ShoulderPosition.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Spine Position'){
									$SpinePosition = $jump[$t]['score'];
									$score = abs($SpinePosition) * 100;
									
									if(isset($rulesdata['FunctionalSpinePosition']['line']) && $rulesdata['FunctionalSpinePosition']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalSpinePosition']['param_sign'], $rulesdata['FunctionalSpinePosition']['param_value'])) {
											switch($rulesdata['FunctionalSpinePosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-danger"><b>Spine Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$SpinePosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-danger"><b>Spine Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Spine Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Spine Position</b> <i>(LL - Lateral Line)</i> <span>'.$SpinePosition.'</span></div>');
											}
										} else {
											switch($rulesdata['FunctionalSpinePosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-success"><b>Spine Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$SpinePosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-success"><b>Spine Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Spine Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Spine Position</b> <i>(LL - Lateral Line)</i> <span>'.$SpinePosition.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Hip Position'){
									$HipPosition = $jump[$t]['score'];
									$score = abs($HipPosition) * 100;
									
									if(isset($rulesdata['FunctionalHipPosition']['line']) && $rulesdata['FunctionalHipPosition']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalHipPosition']['param_sign'], $rulesdata['FunctionalHipPosition']['param_value'])) {
											switch($rulesdata['FunctionalHipPosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-danger"><b>Hip Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$SpinePosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-danger"><b>Hip Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Hip Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Hip Position</b> <i>(LL - Lateral Line)</i> <span>'.$SpinePosition.'</span></div>');
											}
										} else {
											switch($rulesdata['FunctionalHipPosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-success"><b>Hip Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$SpinePosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-success"><b>Hip Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Hip Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Hip Position</b> <i>(LL - Lateral Line)</i> <span>'.$SpinePosition.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Knee Position'){
									$KneePosition = $jump[$t]['score'];
									$KneePosition = abs($KneePosition) * 100;
									
									if(isset($rulesdata['FunctionalKneePosition']['line']) && $rulesdata['FunctionalKneePosition']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalKneePosition']['param_sign'], $rulesdata['FunctionalKneePosition']['param_value'])) {
											switch($rulesdata['FunctionalKneePosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-danger"><b>Knee Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$SpinePosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-danger"><b>Knee Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Knee Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Knee Position</b> <i>(LL - Lateral Line)</i> <span>'.$SpinePosition.'</span></div>');
											}
										} else {
											switch($rulesdata['FunctionalKneePosition']['line']){
												case "SFL":
												case "SBL":
													if($score < 0)
														print_r('<div class="callout Posture SFL callout-success"><b>Knee Position</b> <i>(SFL - Superficial Frontline)</i> <span>'.$SpinePosition.'</span></div>');
													else
														print_r('<div class="callout Posture SBL callout-success"><b>Knee Position</b> <i>(SBL - Superficial Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Knee Position</b> <i>(SPL - Spiral Backline)</i> <span>'.$SpinePosition.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Knee Position</b> <i>(LL - Lateral Line)</i> <span>'.$SpinePosition.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Shoulder Plane Rotation'){
									$score = abs($jump[$t]['score']);
									if(isset($rulesdata['FunctionalShoulderPlaneRotation']['line']) && $rulesdata['FunctionalShoulderPlaneRotation']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalShoulderPlaneRotation']['param_sign'], $rulesdata['FunctionalShoulderPlaneRotation']['param_value'])) {
											switch($rulesdata['FunctionalShoulderPlaneRotation']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Shoulder Plane Rotation </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Shoulder Plane Rotation </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Shoulder Plane Rotation </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Shoulder Plane Rotation</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalShoulderPlaneRotation']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Shoulder Plane Rotation</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Shoulder Plane Rotation</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Shoulder Plane Rotation</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Shoulder Plane Rotation</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Hip Plane Rotation'){
									$score = abs($jump[$t]['score']);
									
									if(isset($rulesdata['FunctionalHipPlaneRotation']['line']) && $rulesdata['FunctionalHipPlaneRotation']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalHipPlaneRotation']['param_sign'], $rulesdata['FunctionalHipPlaneRotation']['param_value'])) {
											switch($rulesdata['FunctionalHipPlaneRotation']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Hip Plane Rotation </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Hip Plane Rotation </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Hip Plane Rotation </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Hip Plane Rotation</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalHipPlaneRotation']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Hip Plane Rotation</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Hip Plane Rotation</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Hip Plane Rotation</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Hip Plane Rotation</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Knee Plane Rotation'){
									$score = abs($jump[$t]['score']);
									
									if(isset($rulesdata['FunctionalKneePlaneRotation']['line']) && $rulesdata['FunctionalKneePlaneRotation']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalKneePlaneRotation']['param_sign'], $rulesdata['FunctionalKneePlaneRotation']['param_value'])) {
											switch($rulesdata['FunctionalKneePlaneRotation']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Knee Plane Rotation </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Knee Plane Rotation </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Knee Plane Rotation </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Knee Plane Rotation</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalKneePlaneRotation']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Knee Plane Rotation</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Knee Plane Rotation</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Knee Plane Rotation</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Knee Plane Rotation</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
									
								} else if($jump[$t]['type'] == 'Ankle Plane Rotation'){
									$score = abs($jump[$t]['score']);
									if(isset($rulesdata['FunctionalAnklePlaneRotation']['line']) && $rulesdata['FunctionalAnklePlaneRotation']['line']!=""){
										if(checkresult($score, $rulesdata['FunctionalAnklePlaneRotation']['param_sign'], $rulesdata['FunctionalAnklePlaneRotation']['param_value'])) {
											switch($rulesdata['FunctionalAnklePlaneRotation']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-danger"><b>Ankle Plane Rotation </b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-danger"><b>Ankle Plane Rotation </b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-danger"><b>Ankle Plane Rotation </b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-danger"><b>Ankle Plane Rotation</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}else{
											switch($rulesdata['FunctionalAnklePlaneRotation']['line']){
												case "SBL":
													print_r('<div class="callout Posture SBL callout-success"><b>Ankle Plane Rotation</b> <i>(SBL - Superficial Backline)</i> <span>'.$score.'</span></div>');
													break;
												case "SFL":
													print_r('<div class="callout Posture SFL callout-success"><b>Ankle Plane Rotation</b> <i>(SFL - Superficial Frontline)</i> <span>'.$score.'</span></div>');
													break;
												case "SPL":
													print_r('<div class="callout Posture SPL callout-success"><b>Ankle Plane Rotation</b> <i>(SPL - Spiral Backline)</i> <span>'.$score.'</span></div>');
													break;
												default:
													print_r('<div class="callout Posture LL callout-success"><b>Ankle Plane Rotation</b> <i>(LL - Lateral Line)</i> <span>'.$score.'</span></div>');
											}
										}
									}
									
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
					<div class="summaryclsbody"><b>LL</b><span id="totalll">0</span><i id="totalllper">0</i></div>
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
	document.title = 'Detailed Workouts | Baseline Motion';
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