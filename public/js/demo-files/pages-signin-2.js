/////////////////////////
// Pages Signin Type 2 //
/////////////////////////

"use strict";

$(document).ready(function(){

	/* Form Validation */
	/**
	 * DEMO CODE
	 * These lines of code below are merely demo purposes. Build upon them and create your own
	 * Check documentation for usage
	 */
	 var myheight = $( window ).height();
  	$('#signin-type-2').height(myheight);

  	
	$('.login-form')
	.bootstrapValidator({
		container: '.error-messages',
		feedbackIcons: {
			valid: 'icon icon-check',
			invalid: 'icon icon-cross',
			validating: 'icon icon-refresh'
		},
		fields: {
			email: {
				validators: {
					notEmpty: {
						message: 'The email address is required and cannot be empty'
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: 'The password is required and cannot be empty'
					}
				}
			}
		}
	})
	.on('error.field.bv', function(e, data) {
		// $(e.target)  --> The field element
		// data.bv      --> The BootstrapValidator instance
		// data.field   --> The field name
		// data.element --> The field element

		data.bv.disableSubmitButtons(false);
	})
	.on('success.field.bv', function(e, data) {
		// $(e.target)  --> The field element
		// data.bv      --> The BootstrapValidator instance
		// data.field   --> The field name
		// data.element --> The field element

		var $parent = data.element.parents('.form-group');

		// Remove the has-success class
		$parent.removeClass('has-success');

		// Hide the success icon
		$parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
		data.bv.disableSubmitButtons(false);
	})
	.on('error.form.bv', function(e) {
		// The e parameter is same as one
		// in the error.form.bv event above

		// Change background color on Error
		$("#signin-type-2").addClass("bg-color-red");

		setTimeout(function(){
			$("#signin-type-2").removeClass("bg-color-red");
		}, 6000);

	});

	
});










