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

<script src="<?=base_url()?>public/bower_components/select2/dist/js/select2.full.min.js"></script>

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

<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script>
	function load_data2()
	{
		$.ajax({
			url:"<?php echo base_url(); ?>workout_videos/load_data",
			method:"POST",
			success:function(data)
			{
				$('#imported_videos_data').html(data);
				$('#orig_videos_data').DataTable();
			}
		});
	}
	
	function load_data3()
	{
		$.ajax({
			url:"<?php echo base_url(); ?>workouts/load_data",
			method:"POST",
			success:function(data)
			{
				$('#imported_workouts_data').html(data);
				$('#orig_videos_data').DataTable();
			}
		});
	}
	
	
	function deleteDataWorkout(id)
	{
		var r=confirm("Are you sure you want to delete this workouts?");
		if (r==true)
		{
			$.ajax({
				url:"<?php echo base_url(); ?>workouts/deletevideo?id="+id,
				method:"POST",
				contentType:false,
				cache:false,
				processData:false,
				success:function(data)
				{
					load_data3();
				}
			});
		}
	}
	
	function deleteData(id)
	{
		var r=confirm("Are you sure you want to delete this video?");
		if (r==true)
		{
			$.ajax({
				url:"<?php echo base_url(); ?>workout_videos/deletevideo?id="+id,
				method:"POST",
				contentType:false,
				cache:false,
				processData:false,
				success:function(data)
				{
					load_data2();
				}
			});
		}
	}
			
	$(function () {
		if(selectedlink!= ""){
			console.log("here"+selectedlink);
			$(".sidebar-menu li").removeClass('active');
			$("#"+selectedlink).addClass('active');
		}
		
		if($('#imported_csv_data').length > 0) {
			
			load_data();

			function load_data()
			{
				$.ajax({
					url:"<?php echo base_url(); ?>csv_import/load_data",
					method:"POST",
					success:function(data)
					{
						$('#imported_csv_data').html(data);
						$('#orig_csv_data').DataTable();
					}
				});
			}

			$('#import_csv').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url:"<?php echo base_url(); ?>csv_import/import",
					method:"POST",
					data:new FormData(this),
					contentType:false,
					cache:false,
					processData:false,
					beforeSend:function(){
						$('#import_csv_btn').html('Importing...');
					},
					success:function(data)
					{
						$('#import_csv')[0].reset();
						$('#import_csv_btn').attr('disabled', false);
						$('#import_csv_btn').html('Import Done');
						load_data();
					}
				});
			});
		}
		
		if($('#imported_videos_data').length > 0) {
			
			load_data2();

			$('#add_videos').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url:"<?php echo base_url(); ?>workout_videos/import",
					method:"POST",
					data:new FormData(this),
					contentType:false,
					cache:false,
					processData:false,
					beforeSend:function(){
						$('#add_video').html('Importing...');
					},
					success:function(data)
					{
						$("#userids").val('').trigger('change');
						$('#add_videos').trigger("reset");
						$('#add_video').attr('disabled', false);
						$('#add_video').html('Save');
						if($('#embed_video_id').length>0){
							location.href = "<?=base_url()?>workout_videos";
						}
						load_data2();
					}
				});
			});
		}
		
		if($('#imported_workouts_data').length > 0) {
			
			load_data3();

			$('#add_workouts').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url:"<?php echo base_url(); ?>workouts/addworkouts",
					method:"POST",
					data:new FormData(this),
					contentType:false,
					cache:false,
					processData:false,
					beforeSend:function(){
						$('#add_workout').html('Sending...');
					},
					success:function(data)
					{
						$('#add_workouts').trigger("reset");
						$('#add_workout').attr('disabled', false);
						$('#add_workout').html('Save');
						if($('#embed_video_id').length>0){
							location.href = "<?=base_url()?>workouts";
						}
						load_data3();
					}
				});
			});
		}
		
		if($('.select2').length > 0) {
			$('.select2').select2();
		}
		
		if($('#userTimeZone').length > 0) {
			$("#userTimeZone").val(Intl.DateTimeFormat().resolvedOptions().timeZone);
		}
		
		if($('.videoslist').length > 0) {
			/*$('.videoslist .breakdownclass h2 span').each(function(){
				var s55 = $(this);
				s55.addClass('active');
				var h = s55.height();
				s55.removeClass('active');
				if(h <= 65){
					s55.parent().find('a.viewdet').hide();
				}
				//console.log(h);
			});*/
			$('.videoslist .breakdownclass h2').click(function(){
				$(this).prev().find('a').click();
			});
			$('a.viewdet').click(function(){
				$(this).parent().prev().find('a').click();
			});
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
</script>

<?php $this->load->view('template/page_level_scripts'); ?>
</body>
</html>