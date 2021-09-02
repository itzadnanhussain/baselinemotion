<?php if($this->session->userdata("user_type") != 2){ ?>
<script>location.href="<?=base_url()?>";</script>
<?php } ?>
<script>selectedlink = 'manageworkoutlinkmenu'; </script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		  Manage Workouts
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>dashboard/">Dashboard</a></li>
        <li class="active">Manage Workouts</li>
      </ol>
    </section>
	
	<?php 
		
		$line = '';
		$code = '';
		$id = '';
		$title = '';
		$description = '';
		
		if(isset($videosembed) && $videosembed!=""){
		foreach($videosembed as $workouts){
			$line = $workouts['line'];
			$code = $workouts['code'];
			$title = $workouts['title'];
			$description = $workouts['description'];
			$id = $workouts['id'];
		}
		}
	?>
	
    <!-- Main content -->
    <section class="content">
		<div class="container box">
			<form method="post" id="add_workouts" enctype="multipart/form-data">
				<br/><br/>
				<input type="hidden" name="userTimeZone" id="userTimeZone" value=""/>
				<div class="form-group">
					<label>Workout Title</label> <br/>
					<input type="text" name="title" id="title" style="width:100%; padding: 10px;" value='<?php echo $title; ?>' placeholder="Enter workout title">
				</div>
				<div class="form-group">
					<label>Workout Description</label>
					<textarea name="description" id="description" placeholder="Enter workout description"><?php echo $description; ?></textarea>
				</div>
				<div class="form-group">
					<label>Select Line</label>
					<select class="form-control select2" id="line" name="line" data-placeholder="Select Line" style="width: 100%; padding: 10px;">
						<option value=''>Select Line</option>
						<option value='LL' <?php if($line == 'LL'){ echo 'selected'; } ?>>Lateral Line (LL)</option>
						<option value='SFL' <?php if($line == 'SFL'){ echo 'selected'; } ?>>Superficial Frontline (SFL)</option>
						<option value='SBL' <?php if($line == 'SBL'){ echo 'selected'; } ?>>Superficial Backline (SBL)</option>
						<option value='SPL' <?php if($line == 'SPL'){ echo 'selected'; } ?>>Spiral Line (SPL)</option>
					</select>
				</div>
				<div class="form-group">
					<label>Embeded Code</label>
					<textarea name="code" id="code" placeholder="Please add your embeded code here"><?php echo $code; ?></textarea>
				</div>
				<?php if($id != ""){ ?>
					<input  type="hidden" name='id' id="embed_video_id" value='<?php echo $id; ?>'>
					<button type="submit" name="add_workout" class="btn btn-primary" id="add_workout">Update</button>
				<?php }else{ ?>
					<button type="submit" name="add_workout" class="btn btn-primary" id="add_workout">Save</button>
				<?php } ?>
			</form>
			<br />
			<div id="imported_workouts_data"></div>
		</div>
		<div style="clear:both;"></div>
    </section>
    <!-- /.content -->
	<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<script>
	document.title = 'Manage Workouts | Baseline Motion';
</script>
<style>
#imported_workouts_data iframe{
	max-width:200px;
	max-height:150px;
}

#add_workouts textarea {
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
    padding: 10px;
    color: #fff;
}
.select2-container .select2-selection--single{
	height: auto;
	padding: 10px 10px 5px 10px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow{
	top: 8px;
    right: 8px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    margin-right: 5px;
    color: rgba(255,255,255,0.7);
}
</style>
<!-- /.content-wrapper -->