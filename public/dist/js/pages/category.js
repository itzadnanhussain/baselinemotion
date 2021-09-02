jQuery(document).ready(function(){
	// jQuery('#example1').DataTable();
	var category_table = jQuery('#category-table').DataTable({
        "info": true,
        "bSort": true,
        "paging": true,
        "searching": true,
        "iDisplayLength": 5,
        "bProcessing": true,
        "aoColumns": [{
                        "mDataProp": "categoryName"
                    }, {
                        "mDataProp": "image"
                    }, {
                        "mDataProp": "action"
                    }],
        "serverSide": true,
        "sAjaxSource": base_url+'category/get_category_data',
        "deferRender": true,
        "oLanguage": {
            "sEmptyTable": "No Category in the system.",
            "sZeroRecords": "No Category to display",
            "sProcessing": "Loading..."
        },
        "fnPreDrawCallback": function (oSettings) {
            //logged_in_or_not();
			//$('#filterrwdCard').trigger('click');
        },
        "fnServerParams": function (aoData) {
        	console.log(aoData);
            aoData.push({"name": "get_giftcard_plan", "value": true});
        },

	});
    jQuery(document).on('click','.add-category',function(){
        jQuery('#form-category')[0].reset();
        jQuery('#form-category #blah_div').hide();
        jQuery('#modal-category .modal-title').text('Add Category');
        jQuery('#modal-category #form-category #form-action').val('add');
        jQuery('#modal-category #form-category #category-name').val('');
        jQuery('#modal-category').modal('show');
    });
    jQuery("#form-category").validate({
        rules: {
            'category-name': {
                required:true
            },
            'category-image':{
                required:true,
                accept:'image/*',
            }
        },
        messages: {
            'category-name': {
                required: "Please Enter Category Name"
            },
            'category-image':{
                required:"Please Upload Category Image",
                accept:"Please Upload only Image file",
            }
        }
    });
    jQuery(document).on('submit','#form-category',function(e){
        e.preventDefault();
        // if(!jQuery(this).valid()) return false;
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'category/add_edit_category',
            data: data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#modal-category').modal('hide');
                    jQuery('#form-category')[0].reset();
                    category_table.draw();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });
    jQuery(document).on('click','.edit-category',function(){
        var cat_id = jQuery(this).data('id');
        jQuery.ajax({
            type: 'post',
            url: base_url+'category/get_category',
            data:'cat_id='+cat_id,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    jQuery('#modal-category .modal-title').text('Edit Category');
                    jQuery('#modal-category #form-category #form-action').val('edit');
                    jQuery('#modal-category #form-category #cat-id').val(cat_id);
                    jQuery('#form-category')[0].reset();
                    jQuery('#modal-category #form-category #category-name').val(data.data.categoryName);
                    jQuery('#modal-category').modal('show');
                }else{
                    toastr.error(data.msg, "");
                }
            }
         });
    });

    jQuery(document).on('click','.delete-category',function(){
        var cat_id = jQuery(this).data('id');
        if(confirm('Are you Sure?')){
            jQuery.ajax({
                type: 'post',
                url: base_url+'category/delete_category',
                data:'cat_id='+cat_id,
                dataType: 'JSON',
                success: function (data) {
                    if(data.flag){
                        category_table.draw();
                        toastr.success(data.msg, "");
                    }else{
                        toastr.error(data.msg, "");
                    }
                }
            });
        }
    });
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          jQuery('#blah').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        jQuery('#blah_div').show();
      }else{
        jQuery('#blah_div').hide();
      }
    }
    jQuery("#category-image").change(function() {
      readURL(this);
    });	
});

