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
<script src="<?= base_url() ?>public/bower_components/jquery/dist/jquery.js"></script>
<script src="<?= base_url() ?>public/bower_components/validate/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>public/bower_components/validate/additional-methods.min.js"></script>

<script src="<?= base_url() ?>public/bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url() ?>public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Toastr -->
<script src="<?= base_url() ?>public/bower_components/toastr/js/toastr.min.js"></script>
<script src="<?= base_url() ?>public/bower_components/toastr/js/ui-toastr.min.js"></script>

<!-- FastClick -->
<script src="<?= base_url() ?>public/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>public/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url() ?>public/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="<?= base_url() ?>public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url() ?>public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- DataTables -->
<script src="<?= base_url() ?>public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- SlimScroll -->
<script src="<?= base_url() ?>public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script>
	$(document).ready(function() {
		console.log("here");
		$('img').each(function() {
			console.log("here2");
			$(this).addClass("crawled");
			var rtimg = $(this).attr('src');
			if (rtimg != "") {
				try {
					var n = rtimg.indexOf("kinetisense");
					if (n >= 0) {
						var res = rtimg.replace("baselinev2.foundersapproach.org", "portal.baselinemotion.com");
						$(this).attr({
							'src': res
						});
					}
				} catch (err) {}
			}
		});
	});

	function load_data22() {
		$.ajax({
			url: "<?php echo base_url(); ?>combine_scores/load_data",
			method: "POST",
			success: function(data) {
				$('#imported_combine_data').html(data);
				$('#orig_videos_data').DataTable();
			}
		});
	}

	function load_data2() {
		$.ajax({
			url: "<?php echo base_url(); ?>workout_videos/load_data",
			method: "POST",
			success: function(data) {
				$('#imported_videos_data').html(data);
				$('#orig_videos_data').DataTable();
			}
		});
	}

	function load_data3() {
		$.ajax({
			url: "<?php echo base_url(); ?>workouts/load_data",
			method: "POST",
			success: function(data) {
				$('#imported_workouts_data').html(data);
				$('#orig_videos_data').DataTable();
			}
		});
	}

	function load_data4() {
		$.ajax({
			url: "<?php echo base_url(); ?>rules/load_kams",
			method: "POST",
			success: function(data) {
				$('#imported_rules_kams_data').html(data);
				$('#orig_videos_data').DataTable();
				$('.switchstatus').on('change', function() {
					//console.log("call");
					var formid = jQuery(this).attr('frmid');
					var status = 0;
					if (this.checked) {
						status = 1;
					}
					$.ajax({
						url: "<?php echo base_url(); ?>rules/updaterules",
						method: "POST",
						data: {
							status: status,
							id: formid
						},
						success: function(data) {
							//alert(data);
							location.href = "<?php echo base_url(); ?>rules/kams";
						}
					});
				});
			}
		});
	}


	function load_data8() {
		$.ajax({
			url: "<?php echo base_url(); ?>rules/load_functional",
			method: "POST",
			success: function(data) {
				$('#imported_rules_functional_data').html(data);
				$('#orig_videos_data').DataTable();
				$('.switchstatus').on('change', function() {
					//console.log("call");
					var formid = jQuery(this).attr('frmid');
					var status = 0;
					if (this.checked) {
						status = 1;
					}
					$.ajax({
						url: "<?php echo base_url(); ?>rules/updaterules",
						method: "POST",
						data: {
							status: status,
							id: formid
						},
						success: function(data) {
							//alert(data);
							location.href = "<?php echo base_url(); ?>rules/functional";
						}
					});
				});
			}
		});
	}

	function load_data9() {
		$.ajax({
			url: "<?php echo base_url(); ?>rules/load_overhead",
			method: "POST",
			success: function(data) {
				$('#imported_rules_overhead_data').html(data);
				$('#orig_videos_data').DataTable();
				$('.switchstatus').on('change', function() {
					//console.log("call");
					var formid = jQuery(this).attr('frmid');
					var status = 0;
					if (this.checked) {
						status = 1;
					}
					$.ajax({
						url: "<?php echo base_url(); ?>rules/updaterules",
						method: "POST",
						data: {
							status: status,
							id: formid
						},
						success: function(data) {
							//alert(data);
							location.href = "<?php echo base_url(); ?>rules/overhead";
						}
					});
				});
			}
		});
	}

	function load_data10() {
		$.ajax({
			url: "<?php echo base_url(); ?>rules/load_wallangel",
			method: "POST",
			success: function(data) {
				$('#imported_rules_wallangel_data').html(data);
				$('#orig_videos_data').DataTable();
				$('.switchstatus').on('change', function() {
					//console.log("call");
					var formid = jQuery(this).attr('frmid');
					var status = 0;
					if (this.checked) {
						status = 1;
					}
					$.ajax({
						url: "<?php echo base_url(); ?>rules/updaterules",
						method: "POST",
						data: {
							status: status,
							id: formid
						},
						success: function(data) {
							//alert(data);
							location.href = "<?php echo base_url(); ?>rules/wallangel";
						}
					});
				});
			}
		});
	}

	function load_data5() {
		$.ajax({
			url: "<?php echo base_url(); ?>rules/load_posture",
			method: "POST",
			success: function(data) {
				$('#imported_rules_posture_data').html(data);
				$('#orig_videos_data').DataTable();
				$('.switchstatus').on('change', function() {
					//console.log("call");
					var formid = jQuery(this).attr('frmid');
					var status = 0;
					if (this.checked) {
						status = 1;
					}
					$.ajax({
						url: "<?php echo base_url(); ?>rules/updaterules",
						method: "POST",
						data: {
							status: status,
							id: formid
						},
						success: function(data) {
							//alert(data);
							location.href = "<?php echo base_url(); ?>rules/posture";
						}
					});
				});
			}
		});
	}

	function load_data11() {
		$.ajax({
			url: "<?php echo base_url(); ?>rules/load_reverselunge",
			method: "POST",
			success: function(data) {
				$('#imported_rules_reverselunge_data').html(data);
				$('#orig_videos_data').DataTable();
				$('.switchstatus').on('change', function() {
					//console.log("call");
					var formid = jQuery(this).attr('frmid');
					var status = 0;
					if (this.checked) {
						status = 1;
					}
					$.ajax({
						url: "<?php echo base_url(); ?>rules/updaterules",
						method: "POST",
						data: {
							status: status,
							id: formid
						},
						success: function(data) {
							//alert(data);
							location.href = "<?php echo base_url(); ?>rules/reverselunge";
						}
					});
				});
			}
		});
	}

	function load_data6() {
		$.ajax({
			url: "<?php echo base_url(); ?>rules/load_rom",
			method: "POST",
			success: function(data) {
				$('#imported_rules_rom_data').html(data);
				$('#orig_videos_data').DataTable();
				$('.switchstatus').on('change', function() {
					//console.log("call");
					var formid = jQuery(this).attr('frmid');
					var status = 0;
					if (this.checked) {
						status = 1;
					}
					$.ajax({
						url: "<?php echo base_url(); ?>rules/updaterules",
						method: "POST",
						data: {
							status: status,
							id: formid
						},
						success: function(data) {
							//alert(data);
							location.href = "<?php echo base_url(); ?>rules/rom";
						}
					});
				});
			}
		});
	}

	function deletereverselunge(id) {
		var r = confirm("Are you sure you want to delete this workouts?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>workouts/deletevideo?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data11();
				}
			});
		}
	}

	function deleteDataWorkout(id) {
		var r = confirm("Are you sure you want to delete this workouts?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>workouts/deletevideo?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data3();
				}
			});
		}
	}

	function deletekams(id) {
		var r = confirm("Are you sure you want to delete this rules?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>rules/deleterules?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data4();
				}
			});
		}
	}

	function deleterom(id) {
		var r = confirm("Are you sure you want to delete this rules?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>rules/deleterules?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data6();
				}
			});
		}
	}


	function deletefunctional(id) {
		var r = confirm("Are you sure you want to delete this rules?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>rules/deleterules?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data8();
				}
			});
		}
	}

	function deleteposture(id) {
		var r = confirm("Are you sure you want to delete this rules?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>rules/deleterules?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data5();
				}
			});
		}
	}

	function deleteoverhead(id) {
		var r = confirm("Are you sure you want to delete this rules?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>rules/deleterules?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data9();
				}
			});
		}
	}

	function deletewallangel(id) {
		var r = confirm("Are you sure you want to delete this rules?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>rules/deleterules?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data10();
				}
			});
		}
	}

	function deleteCombineData(id) {
		var r = confirm("Are you sure you want to delete this Combine Data?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>combine_scores/deletevideo?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data22();
				}
			});
		}
	}

	function deleteData(id) {
		var r = confirm("Are you sure you want to delete this video?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url(); ?>workout_videos/deletevideo?id=" + id,
				method: "POST",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					load_data2();
				}
			});
		}
	}

	$(function() {
		if (selectedlink != "") {
			console.log("here" + selectedlink);
			$(".sidebar-menu li").removeClass('active');
			$("#" + selectedlink).addClass('active');
		}

		if ($('#add_rules_kams').length > 0) {

			load_data4();

			$('#add_rules_kams').on('submit', function(event) {
				//alert("call");
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>rules/addkamsrules",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_rules').html('Sending...');
					},
					success: function(data) {
						$('#add_rules').trigger("reset");
						$('#add_rules').attr('disabled', false);
						$('#add_rules').html('Save');
						location.href = "<?php echo base_url(); ?>rules/kams";
					}
				});
			});
		}


		if ($('#add_rules_rom').length > 0) {

			load_data6();

			$('#add_rules_rom').on('submit', function(event) {
				//alert("call");
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>rules/addkamsrules",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_rules').html('Sending...');
					},
					success: function(data) {
						$('#add_rules').trigger("reset");
						$('#add_rules').attr('disabled', false);
						$('#add_rules').html('Save');
						location.href = "<?php echo base_url(); ?>rules/rom";
					}
				});
			});
		}


		if ($('#add_rules_functional').length > 0) {

			load_data8();

			$('#add_rules_functional').on('submit', function(event) {
				//alert("call");
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>rules/addkamsrules",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_posture_rules').html('Sending...');
					},
					success: function(data) {
						$('#add_posture_rules').trigger("reset");
						$('#add_posture_rules').attr('disabled', false);
						$('#add_posture_rules').html('Save');
						location.href = "<?php echo base_url(); ?>rules/functional";
					}
				});
			});
		}

		if ($('#add_rules_posture').length > 0) {

			load_data5();

			$('#add_rules_posture').on('submit', function(event) {
				//alert("call");
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>rules/addkamsrules",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_posture_rules').html('Sending...');
					},
					success: function(data) {
						$('#add_posture_rules').trigger("reset");
						$('#add_posture_rules').attr('disabled', false);
						$('#add_posture_rules').html('Save');
						location.href = "<?php echo base_url(); ?>rules/posture";
					}
				});
			});
		}

		if ($('#add_rules_reverselunge').length > 0) {

			load_data11();

			$('#add_rules_reverselunge').on('submit', function(event) {
				//alert("call");
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>rules/addkamsrules",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_posture_rules').html('Sending...');
					},
					success: function(data) {
						$('#add_posture_rules').trigger("reset");
						$('#add_posture_rules').attr('disabled', false);
						$('#add_posture_rules').html('Save');
						location.href = "<?php echo base_url(); ?>rules/reverselunge";
					}
				});
			});
		}

		if ($('#add_rules_overhead').length > 0) {

			load_data9();

			$('#add_rules_overhead').on('submit', function(event) {
				//alert("call");
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>rules/addkamsrules",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_posture_rules').html('Sending...');
					},
					success: function(data) {
						$('#add_posture_rules').trigger("reset");
						$('#add_posture_rules').attr('disabled', false);
						$('#add_posture_rules').html('Save');
						location.href = "<?php echo base_url(); ?>rules/overhead";
					}
				});
			});
		}

		if ($('#add_rules_wallangel').length > 0) {

			load_data10();

			$('#add_rules_wallangel').on('submit', function(event) {
				//alert("call");
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>rules/addkamsrules",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_posture_rules').html('Sending...');
					},
					success: function(data) {
						$('#add_posture_rules').trigger("reset");
						$('#add_posture_rules').attr('disabled', false);
						$('#add_posture_rules').html('Save');
						location.href = "<?php echo base_url(); ?>rules/wallangel";
					}
				});
			});
		}

		if ($('#imported_csv_data').length > 0) {

			load_data();

			function load_data() {
				$.ajax({
					url: "<?php echo base_url(); ?>csv_import/load_data",
					method: "POST",
					success: function(data) {
						$('#imported_csv_data').html(data);
						$('#orig_csv_data').DataTable();
					}
				});
			}

			$('#import_csv').on('submit', function(event) {
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>csv_import/import",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#import_csv_btn').html('Importing...');
					},
					success: function(data) {
						$('#import_csv')[0].reset();
						$('#import_csv_btn').attr('disabled', false);
						$('#import_csv_btn').html('Import Done');
						load_data();
					}
				});
			});
		}

		if ($('#imported_combine_data').length > 0) {

			load_data22();

			$('#add_combines').on('submit', function(event) {
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>combine_scores/import",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_combine').html('Importing...');
					},
					success: function(data) {
						$("#userids").val('').trigger('change');
						$('#add_combines').trigger("reset");
						$('#add_combine').attr('disabled', false);
						$('#add_combine').html('Save');
						if ($('#embed_combine_id').length > 0) {
							location.href = "<?= base_url() ?>combine_scores";
						}
						load_data22();
					}
				});
			});
		}

		if ($('#imported_videos_data').length > 0) {

			load_data2();

			$('#add_videos').on('submit', function(event) {
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>workout_videos/import",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_video').html('Importing...');
					},
					success: function(data) {
						$("#userids").val('').trigger('change');
						$('#add_videos').trigger("reset");
						$('#add_video').attr('disabled', false);
						$('#add_video').html('Save');
						if ($('#embed_video_id').length > 0) {
							location.href = "<?= base_url() ?>workout_videos";
						}
						load_data2();
					}
				});
			});
		}

		if ($('#imported_workouts_data').length > 0) {

			load_data3();

			$('#add_workouts').on('submit', function(event) {
				event.preventDefault();
				$.ajax({
					url: "<?php echo base_url(); ?>workouts/addworkouts",
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#add_workout').html('Sending...');
					},
					success: function(data) {
						$('#add_workouts').trigger("reset");
						$('#add_workout').attr('disabled', false);
						$('#add_workout').html('Save');
						if ($('#embed_video_id').length > 0) {
							location.href = "<?= base_url() ?>workouts";
						}
						load_data3();
					}
				});
			});
		}

		if ($('.select2').length > 0) {
			$('.select2').select2();
		}

		if ($('#userTimeZone').length > 0) {
			$("#userTimeZone").val(Intl.DateTimeFormat().resolvedOptions().timeZone);
		}

		if ($('.videoslist').length > 0) {
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
			$('.videoslist .breakdownclass h2').click(function() {
				$(this).prev().find('a').click();
			});
			$('a.viewdet').click(function() {
				$(this).parent().prev().find('a').click();
			});
		}
	});

	////////////Event Check List /////////////////////////
	$('#add_event_checklist').submit(function(e) {
		e.preventDefault();
		e.stopPropagation(); 
		$.ajax({
			type: 'POST',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function() {
				$('#add_combine').html('Importing...');
			},
			success: function(data) {
				let res = JSON.parse(data);
				switch (res.code) {
					case 'success':

						setTimeout(function() {
							window.location.reload();
						}, 3500)
						break;
					case 'warning':

						setTimeout(function() {
							window.location.reload();
						}, 3500)

						break;

				}
			}
		})  

	});
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-154875438-1"></script>
<script>
	window.dataLayer = window.dataLayer || [];

	function gtag() {
		dataLayer.push(arguments);
	}
	gtag('js', new Date());

	gtag('config', 'UA-154875438-1');
</script>

<?php $this->load->view('template/page_level_scripts'); ?>
 
</body>

</html>