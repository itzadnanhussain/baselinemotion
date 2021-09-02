<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<div class="col-md-12">
			<h1>
				<span>Dashboard</span>
			
				<?php 
					$date = DateTime::createFromFormat('m-d-Y', '01-01-2018');
					$startdate = $date->format('m-d-Y');
					$enddate = date('m-d-Y');
					
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
					<li class="active">Dashboard</li>
				</ol>
			</h1>
		</div>
    </section>

	<?php
		$startdate1 = $date->format('Y-m-d');
		$enddate1 = date('Y-m-d');
			
		$maindata = array();
		$finalchartdata = array();
		$overallscore = array();
		$balancescore = array();
		$flexibilityscore = array();
		$corestabilityscore = array();
		$dynamicposturescore = array();
		$lowerextremitypowerscore = array();
		$functionalasymmetryscore = array();
		$susceptibilitytoinjuryscore = array();
		$uniquedatearray = array();
		$sortdate = array();
		
		foreach($res->romAssessments as $romsession) {
			$data1 = array();
			$date = date_create($romsession->date);
			$t = date_format($date,"m-d-Y");
				
			$data1['date'] = $t;
			
			if($romsession->jointType == "SpineMid")
				$data1['type'] = 'Back '.$romsession->movementType;
			else
				$data1['type'] = $romsession->jointType.' '.$romsession->movementType;
			
			$data1['score'] = round($romsession->score * 100 ,2). "%";
			$data1['scoreval'] = $romsession->score * 100;
			
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
					}
					
					$maindata[$t]['romAssessments'][] = $data1;
				}
			}else{
				$t1 = date_format($date,"Y-m-d");
					$cur = $t1;
					if( $cur >= $startdate1 && $cur <= $enddate1){
						if(!in_array($t, $uniquedatearray))
						{	$uniquedatearray[] = $t;
							$t1 = date_format($date,"Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $romsession->practitionerId;
							$maindata[$t]['date'] = $t;
						}
						$maindata[$t]['romAssessments'][] = $data1;
					}
			}
		}
	
		foreach($res->overheadSquatAssessments as $overheadsession) {
			$data1 = array();
			$date = date_create($overheadsession->date);
			$t = date_format($date,"m-d-Y");
			
			$data1['date'] = $t;
			$data1['type'] = 'Overhead Squat';
			$data1['score'] = round($overheadsession->score * 100 ,2). "%";
			$data1['scoreval'] = $overheadsession->score * 100;
			
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
					}
					$maindata[$t]['overheadAssessments'][] = $data1;
				}
			}
		}
		
		foreach($res->reverseLungeAssessments as $reverselungesession){
			$data1 = array();
			$date = date_create($reverselungesession->date);
			$t = date_format($date,"m-d-Y");
			
			$data1['date'] = $t;
			$data1['type'] = 'Reverse Lunge';
			$data1['score'] = round($reverselungesession->score * 100 ,2). "%";
			$data1['scoreval'] = $reverselungesession->score * 100;
			
			
			
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
					}
					$maindata[$t]['reverselungeAssessments'][] = $data1;
				}
			}
		}
		
		foreach($res->wallAngelAssessments as $wallangelsession){	
			$data1 = array();
			$date = date_create($wallangelsession->date);
			$t = date_format($date,"m-d-Y");
			
			$data1['date'] = $t;
			$data1['type'] = 'Posture Angel';
			$data1['score'] = round($wallangelsession->score * 100 ,2). "%";
			$data1['scoreval'] = $wallangelsession->score * 100;
			
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
					}
					$maindata[$t]['wallangelAssessments'][] = $data1;
				}
			}
		}
		
		foreach($res->balanceAssessments as $balancesession){
			$data1 = array();
			$date = date_create($balancesession->date);
			$t = date_format($date,"m-d-Y");
			
			$data1['date'] = $t;
			$data1['type'] = 'Balance '.$balancesession->type;
			$data1['score'] = round($balancesession->score * 100 ,2). "%";
			$data1['scoreval'] = (1 - $balancesession->score) * 100;
			
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
					}
					$maindata[$t]['balanceAssessments'][] = $data1;
				}
			}
			
		}
		
		foreach($res->verticalJumpAssessments as $verticaljumpsession){
			$data1 = array();
			$date = date_create($verticaljumpsession->date);
			$t = date_format($date,"m-d-Y");
			
			$data1['date'] = $t;
			$data1['type'] = 'Vertical Jump';
			$data1['score'] = round($verticaljumpsession->score * 100 ,2). "%";
			$data1['scoreval'] = $verticaljumpsession->score * 100;
			
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
					}
					$maindata[$t]['jumpAssessments'][] = $data1;
				}
			}
		}
		
		/*echo '<pre>';
		print_r($maindata);
		echo '</pre>';*/
		
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
			
			$a = array();
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
			
			$a = array_filter($a);
			$average = array_sum($a)/count($a);
			$average = round($average ,0);
			
			$data5 = array();
			$yeardate = date("Y-m-d", $timestamp);
			$data5['date'] = $yeardate;
			$data5['val'] = $average;
			$overallscore[] = "{y: '".$yeardate."', item1: ".$average."}";
			$finalchartdata[] = $data5;
			
		}
		
	?>

    <!-- Main content -->
    <section class="content" style="float:left; clear: both; width: 100%;">
    <!-- Info boxes -->
		<?php 
		
			if($flaglist){
				echo '<h4 style="float: left; margin: 0 0 0 15px;"> No assessments available.</h4>';
			} else { 
			
				$flagkams = true;
				foreach($indexKAMS as $kams){
					$flagkams = false;					
					$date = DateTime::createFromFormat('m/d/Y', $kams->date);


					if(isset($_REQUEST['start']) && $_REQUEST['start'] != "" && isset($_REQUEST['end']) && $_REQUEST['end'] != ""){
				
						$t1 = $date->format('Y-m-d');
						$st = $_REQUEST['start'];
						$ed = $_REQUEST['end'];
						$cur = $t1;
						
						if( $cur >= $st && $ed >= $cur){
							$yeardate = $date->format('Y-m-d');
							$balanceaverage = $kams->balance_index;
							$flexibilityaverage = $kams->flexibility_index;
							$corestabilityaverage = $kams->core_stability_index;
							$dynamicpostureaverage = $kams->dynamic_posture_index;
							$lowerextremitypoweraverage = $kams->lower_extremity_power_score;
							$functionalasymmetryaverage = $kams->functional_asymmetry_index;
							$susceptibilityinjuryaverage = $kams->susceptibility_to_injury_index;
							
							$balancescore[] = "{y: '".$yeardate."', item1: ".$balanceaverage."}";
							$flexibilityscore[] = "{y: '".$yeardate."', item2: ".$flexibilityaverage."}";
							$corestabilityscore[] = "{y: '".$yeardate."', item3: ".$corestabilityaverage."}";
							$dynamicposturescore[] = "{y: '".$yeardate."', item4: ".$dynamicpostureaverage."}";
							$lowerextremitypowerscore[] = "{y: '".$yeardate."', item5: ".$lowerextremitypoweraverage."}";
							$functionalasymmetryscore[] = "{y: '".$yeardate."', item6: ".$functionalasymmetryaverage."}";
							$susceptibilitytoinjuryscore[] = "{y: '".$yeardate."', item7: ".$susceptibilityinjuryaverage."}";
						}
						
					}else{
						
						$t1 = date_format($date,"Y-m-d");
						$cur = $t1;
						if( $cur >= $startdate1 && $cur <= $enddate1){
							
						$yeardate = $date->format('Y-m-d');
						$balanceaverage = $kams->balance_index;
						$flexibilityaverage = $kams->flexibility_index;
						$corestabilityaverage = $kams->core_stability_index;
						$dynamicpostureaverage = $kams->dynamic_posture_index;
						$lowerextremitypoweraverage = $kams->lower_extremity_power_score;
						$functionalasymmetryaverage = $kams->functional_asymmetry_index;
						$susceptibilityinjuryaverage = $kams->susceptibility_to_injury_index;
						
						if(isset($balanceaverage) && $balanceaverage!="" && $balanceaverage!=0)
							$balancescore[] = "{y: '".$yeardate."', item1: ".$balanceaverage."}";
						
						if(isset($flexibilityaverage) && $flexibilityaverage!="" && $flexibilityaverage!=0)
							$flexibilityscore[] = "{y: '".$yeardate."', item2: ".$flexibilityaverage."}";
						
						if(isset($corestabilityaverage) && $corestabilityaverage!="" && $corestabilityaverage!=0)
							$corestabilityscore[] = "{y: '".$yeardate."', item3: ".$corestabilityaverage."}";
						
						if(isset($dynamicpostureaverage) && $dynamicpostureaverage!="" && $dynamicpostureaverage!=0)
							$dynamicposturescore[] = "{y: '".$yeardate."', item4: ".$dynamicpostureaverage."}";
						
						if(isset($lowerextremitypoweraverage) && $lowerextremitypoweraverage!="" && $lowerextremitypoweraverage!=0)
							$lowerextremitypowerscore[] = "{y: '".$yeardate."', item5: ".$lowerextremitypoweraverage."}";
						
						if(isset($functionalasymmetryaverage) && $functionalasymmetryaverage!="" && $functionalasymmetryaverage!=0)
							$functionalasymmetryscore[] = "{y: '".$yeardate."', item6: ".$functionalasymmetryaverage."}";
						
						if(isset($susceptibilityinjuryaverage) && $susceptibilityinjuryaverage!="" && $susceptibilityinjuryaverage!=0)
							$susceptibilitytoinjuryscore[] = "{y: '".$yeardate."', item7: ".$susceptibilityinjuryaverage."}";
						}
						
					}
					
					
				}
				
		?>
		<div class="col-md-12 mobhide">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false" class="text-center">Overall <br/> Score</a></li>
				<li class="active tab_2"><a href="#tab_2" onclick="viewtab2()" data-toggle="tab" aria-expanded="false" class="text-center">Balance <br/> Score</a></li>
				<li class="active tab_2 tab_3"><a href="#tab_3" onclick="viewtab3()" data-toggle="tab" aria-expanded="false" class="text-center">Flexibility <br/> Scores</a></li>
				<li class="active tab_2 tab_4"><a href="#tab_4" onclick="viewtab4()" data-toggle="tab" aria-expanded="false" class="text-center">Core Stability <br/> Scores</a></li>
				<li class="active tab_2 tab_5"><a href="#tab_5" onclick="viewtab5()" data-toggle="tab" aria-expanded="false" class="text-center">Dynamic Posture <br/> Scores</a></li>
				<li class="active tab_2 tab_6"><a href="#tab_6" onclick="viewtab6()" data-toggle="tab" aria-expanded="false" class="text-center">Lower Extremity <br/> Power Scores</a></li>
				<li class="active tab_2 tab_7"><a href="#tab_7" onclick="viewtab7()" data-toggle="tab" aria-expanded="false" class="text-center">Functional Assymmetry <br/> Scores</a></li>
				<li class="active tab_2 tab_8"><a href="#tab_8" onclick="viewtab8()" data-toggle="tab" aria-expanded="false" class="text-center">Susceptibility to <br/> Injury Scores</a></li>
            </ul>
            <div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<div class="box-body chart-responsive">
						<div class="chart" id="line-chart" style="height: 300px;"></div>
					</div>
				</div>
				<!-- /.tab-pane -->
				
				<div class="tab-pane active tab_2" id="tab_2">
					<div class="box-body chart-responsive">
						<div class="chart" id="line-chart2" style="height: 300px;"></div>
					</div>
				</div>
				<!-- /.tab-pane -->
				
				<div class="tab-pane active tab_2 tab_3" id="tab_3">
					<div class="box-body chart-responsive">
						<div class="chart" id="line-chart3" style="height: 300px;"></div>
					</div>
				</div>
				<!-- /.tab-pane -->
				
				<div class="tab-pane active tab_2 tab_4" id="tab_4">
					<div class="box-body chart-responsive">
						<div class="chart" id="line-chart4" style="height: 300px;"></div>
					</div>
				</div>
				<!-- /.tab-pane -->
				
				<div class="tab-pane active tab_2 tab_5" id="tab_5">
					<div class="box-body chart-responsive">
						<div class="chart" id="line-chart5" style="height: 300px;"></div>
					</div>
				</div>
				<!-- /.tab-pane -->
				
				<div class="tab-pane active tab_2 tab_6" id="tab_6">
					<div class="box-body chart-responsive">
						<div class="chart" id="line-chart6" style="height: 300px;"></div>
					</div>
				</div>
				<!-- /.tab-pane -->
				
				<div class="tab-pane active tab_2 tab_7" id="tab_7">
					<div class="box-body chart-responsive">
						<div class="chart" id="line-chart7" style="height: 300px;"></div>
					</div>
				</div>
				<!-- /.tab-pane -->
				
				<div class="tab-pane active tab_2 tab_8" id="tab_8">
					<div class="box-body chart-responsive">
						<div class="chart" id="line-chart8" style="height: 300px;"></div>
					</div>
				</div>
				<!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
		<div class="col-md-12 deskhide">
          <div class="box box-solid">
            <div class="box-body">
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
						Overall Score
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
						<div class="tab-pane active">
							<div class="box-body chart-responsive">
								<div class="chart" id="mobile-chart" style="height: 300px;"></div>
							</div>
						</div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-danger">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
						Balance Score
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse collapse2 in">
                    <div class="box-body">
						<div class="tab-pane active">
							<div class="box-body chart-responsive">
								<div class="chart" id="mobile-chart2" style="height: 300px;"></div>
							</div>
						</div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
							Flexibility Scores
						</a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse collapse2 in">
                    <div class="box-body">
						<div class="tab-pane active">
							<div class="box-body chart-responsive">
								<div class="chart" id="mobile-chart3" style="height: 300px;"></div>
							</div>
						</div>
                    </div>
                  </div>
                </div>
				 <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                        Core Stability Scores
                      </a>
                    </h4>
                  </div>
                  <div id="collapseFour" class="panel-collapse collapse collapse2 in">
                    <div class="box-body">
						<div class="tab-pane active">
							<div class="box-body chart-responsive">
								<div class="chart" id="mobile-chart4" style="height: 300px;"></div>
							</div>
						</div>
                    </div>
                  </div>
                </div>
				 <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                        Dynamic Posture Scores
                      </a>
                    </h4>
                  </div>
                  <div id="collapseFive" class="panel-collapse collapse collapse2 in">
						<div class="box-body">
							<div class="tab-pane active">
								<div class="box-body chart-responsive">
									<div class="chart" id="mobile-chart5" style="height: 300px;"></div>
								</div>
							</div>
						</div>
					</div>
                </div>
				 <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                        Lower Extremity Scores
                      </a>
                    </h4>
                  </div>
                  <div id="collapseSix" class="panel-collapse collapse collapse2 in">
                    <div class="box-body">
						<div class="tab-pane active">
								<div class="box-body chart-responsive">
									<div class="chart" id="mobile-chart6" style="height: 300px;"></div>
								</div>
							</div>
                    </div>
                  </div>
                </div>
				 <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                        Functional Assymmetry Scores
                      </a>
                    </h4>
                  </div>
                  <div id="collapseSeven" class="panel-collapse collapse collapse2 in">
                    <div class="box-body">
						<div class="tab-pane active">
								<div class="box-body chart-responsive">
									<div class="chart" id="mobile-chart7" style="height: 300px;"></div>
								</div>
							</div>
                    </div>
                  </div>
                </div>
				<div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
						 Susceptibility to Injury Scores
                      </a>
                    </h4>
                  </div>
                  <div id="collapseEight" class="panel-collapse collapse collapse2 in">
                    <div class="box-body">
						<div class="tab-pane active">
							<div class="box-body chart-responsive">
								<div class="chart" id="mobile-chart8" style="height: 300px;"></div>
							</div>
						</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
		
			<?php } ?>
    </section>
	<style>
		.range_inputs .btn-success {
			background-color: #00ABEE!important;
			border-color: #00ABEE;
			opacity: 1;
		}
		.nav-stacked>li>a{
			width:100%;
		}
		.nav-stacked>li>a:hover, .nav-stacked>li>a.active{
			background: #03a9f4;
			color: white;
		}
		.posdatecal{
			position: relative;
		}
		.posdatecal i{
			position: absolute;
			right: 10px;
			top: 35px;
		}
		.nav-tabs-custom>.nav-tabs>li.active {
			border-top-color: #000;
		}
		.nav-tabs-custom>.nav-tabs>li.active a{
			font-weight: bold;
		}
		.morris-hover.morris-default-style {
			background: rgba(255, 255, 255, 1) !important;
			font-weight: 700 !important;
			text-align: left !important;
		}
		.nav-tabs-custom>.nav-tabs>li.active>a {
			border-top-color: transparent;
			border-left-color: transparent;
			border-right-color: transparent;
		}
		.nav-tabs-custom>.nav-tabs {
			border-bottom-color: transparent;
		}
		
		div#accordion .panel.box {
			border-top-color: black;
		}

		div#accordion .panel.box h4 a{
			color: black!important;
		}
		
	/***	.nav-tabs-custom>.nav-tabs>li.tab_2.active {
			border-top-color: #88aa11;
		}
		.nav-tabs-custom>.nav-tabs>li.tab_2.active>a {
			color: #88aa11;
		}
		
		.nav-tabs-custom>.nav-tabs>li.tab_3.active {
			border-top-color: #FF00FF;
		}
		.nav-tabs-custom>.nav-tabs>li.tab_3.active>a {
			color: #FF00FF;
		}
		
		.nav-tabs-custom>.nav-tabs>li.tab_4.active {
			border-top-color: #008000;
		}
		.nav-tabs-custom>.nav-tabs>li.tab_4.active>a {
			color: #008000;
		}
		
		.nav-tabs-custom>.nav-tabs>li.tab_5.active {
			border-top-color: #008080;
		}
		.nav-tabs-custom>.nav-tabs>li.tab_5.active>a {
			color: #008080;
		}
		
		.nav-tabs-custom>.nav-tabs>li.tab_6.active {
			border-top-color: #2F4F4F;
		}
		.nav-tabs-custom>.nav-tabs>li.tab_6.active>a {
			color: #2F4F4F;
		}
		
		.nav-tabs-custom>.nav-tabs>li.tab_7.active {
			border-top-color: #4B0082;
		}
		.nav-tabs-custom>.nav-tabs>li.tab_7.active>a {
			color: #4B0082;
		}
		
		.nav-tabs-custom>.nav-tabs>li.tab_8.active {
			border-top-color: #800000;
		}
		.nav-tabs-custom>.nav-tabs>li.tab_8.active>a {
			color: #800000;
		}
******/
		@media only screen and (min-width: 768px) {
			.deskhide{
				display: none;
			}
		}
		
		@media only screen and (max-width: 768px) {
			.mobhide{
				display: none;
			}
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
	</style>
    <!-- /.content -->
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<!-- /.content-wrapper -->

<footer class="main-footer">
    <!-- <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div> -->
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
<script src="<?=base_url()?>public/bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=base_url()?>public/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url()?>public/dist/js/demo.js"></script>
<script src="<?=base_url()?>public/bower_components/raphael/raphael.min.js"></script>
<script src="<?=base_url()?>public/bower_components/morris.js/morris.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>public/bower_components/morris.js/morris.css">

<!-- date-range-picker -->
<script src="<?=base_url()?>public/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url()?>public/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- daterange picker -->
<link rel="stylesheet" href="<?=base_url()?>public/bower_components/bootstrap-daterangepicker/daterangepicker.css">

<script>
	$(function () {
		"use strict";
		
		<?php if(!$flaglist){ ?>
		// LINE CHART
		if($('#line-chart').length > 0) {
			var line = new Morris.Area({
				element: 'line-chart',
				resize: true,
				data: [<?php echo join(", ",$overallscore); ?>],
				xkey: 'y',
				ykeys: ['item1'],
				ymax: 100,
				labels: ['OVERALL SCORE'],
				lineColors: ['#00ABEE'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear();},
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear();}
			});
			
			var line = new Morris.Area({
				element: 'mobile-chart',
				resize: true,
				data: [<?php echo join(", ",$overallscore); ?>],
				xkey: 'y',
				ykeys: ['item1'],
				ymax: 100,
				labels: ['OVERALL SCORE'],
				lineColors: ['#00ABEE'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
			
			$('.tab_2').removeClass('active');
			$('.collapse2').removeClass('in');
			
		}
		
		<?php } ?>
	});
	
	function viewtab2(){
		setTimeout(function(){
			var line = new Morris.Area({
				element: 'line-chart2',
				resize: true,
				data: [<?php echo join(", ",$balancescore); ?>],
				xkey: 'y',
				ykeys: ['item1'],
				ymax: 100,
				labels: ['BALANCE SCORE'],
				lineColors: ['#88AA11'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
			
			var line = new Morris.Area({
				element: 'mobile-chart2',
				resize: true,
				data: [<?php echo join(", ",$balancescore); ?>],
				xkey: 'y',
				ykeys: ['item1'],
				ymax: 100,
				labels: ['BALANCE SCORE'],
				lineColors: ['#88AA11'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
		}, 200);
	}
	
	function viewtab3(){
		setTimeout(function(){
			var line = new Morris.Area({
				element: 'line-chart3',
				resize: true,
				data: [<?php echo join(", ", $flexibilityscore); ?>],
				xkey: 'y',
				ykeys: ['item2'],
				ymax: 100,
				labels: ['FLEXIBILITY SCORE'],
				lineColors: ['#FF00FF'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
			
			var line = new Morris.Area({
				element: 'mobile-chart3',
				resize: true,
				data: [<?php echo join(", ", $flexibilityscore); ?>],
				xkey: 'y',
				ykeys: ['item2'],
				ymax: 100,
				labels: ['FLEXIBILITY SCORE'],
				lineColors: ['#FF00FF'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
		}, 200);
	}
	
	function viewtab4(){
		setTimeout(function(){
			var line = new Morris.Area({
				element: 'line-chart4',
				resize: true,
				data: [<?php echo join(", ", $corestabilityscore); ?>],
				xkey: 'y',
				ykeys: ['item3'],
				ymax: 100,
				labels: ['CORE STABILITY SCORE'],
				lineColors: ['#008000'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
			
			var line = new Morris.Area({
				element: 'mobile-chart4',
				resize: true,
				data: [<?php echo join(", ", $corestabilityscore); ?>],
				xkey: 'y',
				ykeys: ['item3'],
				ymax: 100,
				labels: ['CORE STABILITY SCORE'],
				lineColors: ['#008000'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
		}, 200);
	}
	
	function viewtab5(){
		setTimeout(function(){
			var line = new Morris.Area({
				element: 'line-chart5',
				resize: true,
				data: [<?php echo join(", ", $dynamicposturescore); ?>],
				xkey: 'y',
				ykeys: ['item4'],
				ymax: 100,
				labels: ['DYNAMIC POSTURE SCORE'],
				lineColors: ['#008080'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
			
			var line = new Morris.Area({
				element: 'mobile-chart5',
				resize: true,
				data: [<?php echo join(", ", $dynamicposturescore); ?>],
				xkey: 'y',
				ykeys: ['item4'],
				ymax: 100,
				labels: ['DYNAMIC POSTURE SCORE'],
				lineColors: ['#008080'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
		}, 200);
	}
	
	function viewtab6(){
		setTimeout(function(){
			var line = new Morris.Area({
				element: 'line-chart6',
				resize: true,
				data: [<?php echo join(", ", $lowerextremitypowerscore); ?>],
				xkey: 'y',
				ykeys: ['item5'],
				ymax: 100,
				labels: ['LOWER EXTREMITY POWER SCORE'],
				lineColors: ['#2F4F4F'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
			
			var line = new Morris.Area({
				element: 'mobile-chart6',
				resize: true,
				data: [<?php echo join(", ", $lowerextremitypowerscore); ?>],
				xkey: 'y',
				ykeys: ['item5'],
				ymax: 100,
				labels: ['LOWER EXTREMITY POWER SCORE'],
				lineColors: ['#2F4F4F'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
		}, 200);
	}
	
	function viewtab7(){
		setTimeout(function(){
			var line = new Morris.Area({
				element: 'line-chart7',
				resize: true,
				data: [<?php echo join(", ", $functionalasymmetryscore); ?>],
				xkey: 'y',
				ykeys: ['item6'],
				ymax: 100,
				labels: ['FUNCTIONAL ASSYMMETRY SCORE'],
				lineColors: ['#4B0082'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
			
			var line = new Morris.Area({
				element: 'mobile-chart7',
				resize: true,
				data: [<?php echo join(", ", $functionalasymmetryscore); ?>],
				xkey: 'y',
				ykeys: ['item6'],
				ymax: 100,
				labels: ['FUNCTIONAL ASSYMMETRY SCORE'],
				lineColors: ['#4B0082'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
		}, 200);
	}
	
	function viewtab8(){
		setTimeout(function(){
			var line = new Morris.Area({
				element: 'line-chart8',
				resize: true,
				data: [<?php echo join(", ", $susceptibilitytoinjuryscore); ?>],
				xkey: 'y',
				ykeys: ['item7'],
				ymax: 100,
				labels: ['SUSCEPTIBILITY TO INJURY SCORE'],
				lineColors: [ '#800000'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			});
			
			var line = new Morris.Area({
				element: 'mobile-chart8',
				resize: true,
				data: [<?php echo join(", ", $susceptibilitytoinjuryscore); ?>],
				xkey: 'y',
				ykeys: ['item7'],
				ymax: 100,
				labels: ['SUSCEPTIBILITY TO INJURY SCORE'],
				lineColors: [ '#800000'],
				hideHover: 'auto',
				xLabelFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
				xLabels:'day',
				dateFormat: function (ts) { var d = new Date(ts); return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); }
			}); 
		}, 200);
	}
	
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
			location.href = "<?=base_url()?>dashboard/?start="+start.format('YYYY-MM-DD')+"&end="+end.format('YYYY-MM-DD');
		});
</script>
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
