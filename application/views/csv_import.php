<?php if($this->session->userdata("user_type") != 2){ ?>
<script>location.href="<?=base_url()?>";
</script>
<?php } ?>
<script>selectedlink = 'csvimportmenu'; </script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		  Import Scores
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>dashboard/">Dashboard</a></li>
        <li class="active">Import Scores</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="container box">
			<form method="post" id="import_csv" enctype="multipart/form-data">
				<div class="form-group"><br/><br/>
					<label>Select CSV File</label>
					<input type="file" name="csv_file" id="csv_file" required accept=".csv" />
				</div>
				<br />
				<button type="submit" name="import_csv" class="btn btn-primary" id="import_csv_btn">Import CSV</button>
			</form>
			<br />
			<div id="imported_csv_data"></div>
		</div>
		<div style="clear:both;"></div>
    </section>
    <!-- /.content -->
	<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<style>
.btn-primary {
    background-color: black;
    border-color: black;
}
</style>
<!-- /.content-wrapper -->