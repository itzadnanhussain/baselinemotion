jQuery(document).ready(function(){
    jQuery("#signup-form").validate({
        rules: {
            'name': {
                required:true
            },
			 'email': {
                required:true,
				email:true
            }
        },
        messages: {
            'name': {
                required: "Please enter name"
            },
            'email':{
                required:"Please enter email",
                email:"Please enter a valid email!"
            }
        }
    });
	
	jQuery("#resetpw-form").validate({
        rules: {
            'reset_password_code': {
                required:true
            },
			'password': {
                required:true
            },
			'conf_password': {
                required:true,
				equalTo : "#password"
            }
        },
        messages: {
            'reset_password_code': {
                required: "Please enter password code"
            },
            'password':{
                required:"Please enter new password"
            },
            'conf_password':{
                required:"Please enter confirm password",
				equalTo : "Confirm password is not match"
            }
        }
    });
   /* jQuery(document).on('submit','#signup-form',function(e){
        e.preventDefault();
        if(!jQuery(this).valid()) return false;
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'login/validatesignup',
            data: data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#form-category')[0].reset();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    });*/
	
	jQuery("#forgetpw-form").validate({
        rules: {
			 'email': {
                required:true,
				email:true
            }
        },
        messages: {
            'email':{
                required : "Please enter email",
                email : "Please enter a valid email!"
            }
        }
    });
	
  /*  jQuery(document).on('submit','#forgetpw-form',function(e){
        e.preventDefault();
        // if(!jQuery(this).valid()) return false;
        var data = new FormData(this);
        jQuery.ajax({
            type: 'post',
            url: base_url+'login/add_edit_category',
            data: data,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.flag){
                    toastr.success(data.msg, "");
                    jQuery('#form-category')[0].reset();
                }else{
                    toastr.error(data.msg, "");
                }
            }
        });
    }); */
});

