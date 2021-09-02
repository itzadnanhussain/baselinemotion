<?php if($this->session->userdata("user_type") != 2){ ?>
<script>location.href="<?=base_url()?>";</script>
<?php } ?>
<script>selectedlink = 'videosmenulink'; </script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		  Manage Rules
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>dashboard/">Dashboard</a></li>
        <li class="active">Manage Rules</li>
      </ol>
    </section>
	
	<?php 
		
		$param_name = '';
		$param_sign = '';
		$id = '';
		$name = '';
		$param_value = '';
		$line = '';
		
		if(isset($videosembed) && $videosembed!=""){
			foreach($videosembed as $workouts){
				$param_name = $workouts['param_name'];
				$name = $workouts['name'];
				$param_sign = $workouts['param_sign'];
				$param_value = $workouts['param_value'];
				$line = $workouts['line'];
				$id = $workouts['id'];
			}
		}
	?>
	
    <!-- Main content -->
    <section class="content">
		<div class="container box">
			<form method="post" id="add_rules_posture" enctype="multipart/form-data">
				<div class="form-group"><br/>
					<label>Rules Name</label>
					<input type="text" class="form-control" id="name" value="<?php echo $name; ?>" name="name" data-placeholder="Enter Rules Name" style="width: 100%;">
				</div>
				<div class="form-group">
					<label>Parameter Name</label>	
					<select class="form-control select2" id="param_name" name="param_name" data-placeholder="Select Parameter Name" style="width: 100%;">
						<?php 
							foreach($paramname as $dat) {
								$sel = '';
								if($param_name == $dat['param_name'])
									$sel = 'selected = "selected"';
								echo "<option value='".$dat['param_name']."' ".$sel.">".$dat['param_label']."</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Parameter Sign</label>	
					<select class="form-control select2" id="param_sign" name="param_sign" data-placeholder="Select Parameter Name" style="width: 100%;">
						<?php 
							foreach($signlist as $signs) {
								$sel = '';
								if($param_sign == $signs['sign'])
									$sel = 'selected = "selected"';
								echo "<option value='".$signs['sign']."' ".$sel.">".$signs['name']."</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Compare Value</label>
					<input type="text" class="form-control" id="param_value" value="<?php echo $param_value; ?>" name="param_value" data-placeholder="Enter Compare Value" style="width: 100%;">
				</div>
				<div class="form-group">
					<label>Select Line</label>	
					<select class="form-control select2" id="line" name="line" data-placeholder="Select Line" style="width: 100%;">
						<option value="">Select Line</option>
						<option value="LL" <?php if($line == 'LL') echo 'selected=selected'; ?>>Lateral Line (LL)</option>
						<option value="SFL" <?php if($line == 'SFL') echo 'selected=selected'; ?>>Superficial Frontline (SFL)</option>
						<option value="SBL" <?php if($line == 'SBL') echo 'selected=selected'; ?>>Superficial Backline (SBL)</option>
						<option value="SPL" <?php if($line == 'SPL') echo 'selected=selected'; ?>>Spiral Line (SPL)</option>
					</select>
				</div>
				<input type="hidden" name='userTimeZone' id="userTimeZone" value=''>
				<input type="hidden" name='rules_type' id="rules_type" value='Posture'>
				<?php if($id != ""){ ?>
					<input  type="hidden" name='id' id="rules_id" value='<?php echo $id; ?>'>
					<button type="submit" name="add_posture_rules" class="btn btn-primary" id="add_posture_rules">Update</button>
				<?php }else{ ?>
					<input  type="hidden" name='status' id="status" value='1'>
					<button type="submit" name="add_posture_rules" class="btn btn-primary" id="add_posture_rules">Save</button>
				<?php } ?>
			</form>
			<br />
			<div id="imported_rules_posture_data"></div>
		</div>
		<div style="clear:both;"></div>
    </section>
    <!-- /.content -->
	<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<style>

/* The switch - the box around the slider */
#imported_rules_posture_data .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
#imported_rules_posture_data .switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
#imported_rules_posture_data .slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

#imported_rules_posture_data .slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

#imported_rules_posture_data input:checked + .slider {
  background-color: #2196F3;
}

#imported_rules_posture_data input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

#imported_rules_posture_data input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
#imported_rules_posture_data .slider.round {
  border-radius: 34px;
}

#imported_rules_posture_data .slider.round:before {
  border-radius: 50%;
}

#imported_videos_data iframe{
	max-width:200px;
	max-height:150px;
}

#add_videos textarea {
    width: 100%;
    height: 120px;
    padding: 10px;
}

.btn-primary {
    background-color: black;
    border-color: black;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc;
    border-color: #367fa9;
    padding: 1px 10px;
    color: #fff;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    margin-right: 5px;
    color: rgba(255,255,255,0.7);
}
</style>
<!-- /.content-wrapper -->