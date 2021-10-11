///////////////////////////////
// Form Validation Functions //
///////////////////////////////

"use strict";

$(document).ready(function() {
	/**
	 * DEMO CODE
	 * These lines of code below are merely demo purposes. Build upon them and create your own
	 * Check documentation for usage
	 */
	
	/* Registration Form */
	$('#employee_form')
	.bootstrapValidator({
		feedbackIcons: {
			valid: 'icon icon-check',
			invalid: 'icon icon-cross',
			validating: 'icon icon-refresh'
		},
		fields: {
			first_name: {
				message: 'First name is not valid',
				validators: {
					notEmpty: {
						message: 'First Name is required and cannot be empty'
					},
					stringLength: {
						min: 4,
						max: 25,
						message: 'First Name must be more than 4 and less than 25 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z]+$/,
						message: 'First Name can only consist of alphabets'
					},
				}
			},
			last_name: {
				message: 'Last name is not valid',
				validators: {
					notEmpty: {
						message: 'Last Name is required and cannot be empty'
					},
					stringLength: {
						min: 4,
						max: 25,
						message: 'Last Name must be more than 4 and less than 25 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z]+$/,
						message: 'Last Name can only consist of alphabets'
					},
				}
			},
			email: {
				validators: {
					notEmpty: {
						message: 'The email address is required and cannot be empty'
					},
					emailAddress: {
						message: 'The email address is not a valid'
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: 'The password is required and cannot be empty'
					},
					stringLength: {
						min: 8,
						message: 'The password must have at least 8 characters'
					}
				}
			},
			birth_date: {
				validators: {
					notEmpty: {
						message: 'Birth Date is required'
					},
					date: {
						format: 'MM//DD/YYYY',
						message: 'Birth Date is not valid'
					}
				}
			},
			hire_date: {
				validators: {
					notEmpty: {
						message: 'Hiring Date is required'
					},
					date: {
						format: 'MM//DD/YYYY',
						message: 'Hiring Date is not valid'
					}
				}
			},
			release_date: {
				validators: {
					notEmpty: {
						message: 'Releasing date is required'
					},
					date: {
						format: 'MM//DD/YYYY',
						message: 'Releasing date is not valid'
					}
				}
			},
			phone: {
				message: '',
				validators: {
					notEmpty: {
						message: 'Phone Number is required and cannot be empty'
					},
					regexp: {
						regexp: /^[0-9,+]+$/,
						message: 'Phone Number can only consist of numeric values'
					},
					stringLength: {
						min: 10,
						max: 20,
						message: 'Phone Number must be more than 10 and less than 20 characters long'
					}
				}
			},
			fax: {
				message: '',
				validators: {
					notEmpty: {
						message: 'Fax is required and cannot be empty'
					},
					regexp: {
						regexp: /^[0-9,+]+$/,
						message: 'Fax can only consist of numeric values'
					},
					stringLength: {
						min: 10,
						max: 20,
						message: 'Fax must be more than 10 and less than 20 characters long'
					}
				}
			},
			mobile: {
				message: '',
				validators: {
					notEmpty: {
						message: 'Mobile Number is required and cannot be empty'
					},
					regexp: {
						regexp: /^[0-9,+]+$/,
						message: 'Mobile number can only consist of numeric values'
					},
					stringLength: {
						min: 10,
						max: 20,
						message: 'Mobile number must be more than 10 and less than 20 characters long'
					}

				}
			},
			city: {
				validators: {
					notEmpty: {
						message: 'City is required	'
					}
				}
			},
			zip: {
				validators: {
					notEmpty: {
						message: 'Zip is required	'
					}
				}
			},
			address: {
				validators: {
					notEmpty: {
						message: 'Address is required	'
					}
				}
			},
			notes: {
				validators: {
					notEmpty: {
						message: 'Notes are required	'
					}
				}
			},
			address1: {
				validators: {
					notEmpty: {
						message: 'Address1 is required	'
					}
				}
			},
			w4fed: {
				validators: {
					notEmpty: {
						message: 'w4fed field is required	'
					}
				}
			},
			w4state: {
				validators: {
					notEmpty: {
						message: 'w4state field is required	'
					}
				}
			},
			salary: {
				validators: {
					notEmpty: {
						message: 'Salary is required'
					},
					regexp: {
						regexp: /^[0-9,.]+$/,
						message: 'Salary field can only consist of numbers.'
					}
				}
			},
			ss_no: {
				validators: {
					notEmpty: {
						message: 'SS# is required'
					},
					regexp: {
						regexp: /^[0-9,+]+$/,
						message: 'SS No can only consist of numbers.'
					}
				}
			}

		}
	});


	$('#customer_form')
	.bootstrapValidator({
		feedbackIcons: {
			valid: 'icon icon-check',
			invalid: 'icon icon-cross',
			validating: 'icon icon-refresh'
		},
		fields: {
			first_name: {
				message: 'First name is not valid',
				validators: {
					notEmpty: {
						message: 'First Name is required and cannot be empty'
					},
					stringLength: {
						min: 4,
						max: 25,
						message: 'First Name must be more than 4 and less than 25 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z]+$/,
						message: 'First Name can only consist of alphabets'
					},
				}
			},
			last_name: {
				message: 'Last name is not valid',
				validators: {
					notEmpty: {
						message: 'Last Name is required and cannot be empty'
					},
					stringLength: {
						min: 4,
						max: 25,
						message: 'Last Name must be more than 4 and less than 25 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z]+$/,
						message: 'Last Name can only consist of alphabets'
					},
				}
			},
			other: {
				validators: {
					notEmpty: {
						message: 'This field is required	'
					}
				}
			},
			email: {
				validators: {
					notEmpty: {
						message: 'The email address is required and cannot be empty'
					},
					emailAddress: {
						message: 'The email address is not a valid'
					}
				}
			},
			fax: {
				message: '',
				validators: {
					notEmpty: {
						message: 'Fax is required and cannot be empty'
					},
					regexp: {
						regexp: /^[0-9,+]+$/,
						message: 'Fax can only consist of numeric values'
					},
					stringLength: {
						min: 10,
						max: 20,
						message: 'Fax must be more than 10 and less than 20 characters long'
					}
				}
			},

			password: {
				validators: {
					notEmpty: {
						message: 'The password is required and cannot be empty'
					},
					stringLength: {
						min: 8,
						message: 'The password must have at least 8 characters'
					}
				}
			},
			title: {
				validators: {
					notEmpty: {
						message: 'Title is required'
					}
				}
			},
			company: {
				validators: {
					notEmpty: {
						message: 'Company is required'
					}
				}
			},	
			phone: {
				message: '',
				validators: {
					notEmpty: {
						message: 'Phone Number is required and cannot be empty'
					},
					regexp: {
						regexp: /^[0-9,+]+$/,
						message: 'The username can only consist of numeric values'
					},
					stringLength: {
						min: 10,
						max: 20,
						message: 'The username must be more than 10 and less than 20 characters long'
					}
				}
			},
			mobile: {
				message: '',
				validators: {
					notEmpty: {
						message: 'Mobile Number is required and cannot be empty'
					},
					regexp: {
						regexp: /^[0-9,+]+$/,
						message: 'Mobile number can only consist of numeric values'
					},
					stringLength: {
						min: 10,
						max: 20,
						message: 'Mobile number must be more than 10 and less than 20 characters long'
					}

				}
			},
			city: {
				validators: {
					notEmpty: {
						message: 'City is required	'
					}
				}
			},
			zip: {
				validators: {
					notEmpty: {
						message: 'Zip is required	'
					}
				}
			},
			address: {
				validators: {
					notEmpty: {
						message: 'Address is required	'
					}
				}
			},
			billing_address: {
				validators: {
					notEmpty: {
						message: 'Billing Address is required	'
					}
				}
			},
			notes: {
				validators: {
					notEmpty: {
						message: 'Notes are required	'
					}
				}
			},
			address1: {
				validators: {
					notEmpty: {
						message: 'Address1 is required	'
					}
				}
			},
			
			salary: {
				validators: {
					notEmpty: {
						message: 'Salary is required'
					},
					regexp: {
						regexp: /^[0-9,.]+$/,
						message: 'Salary field can only consist of numbers.'
					}
				}
			},
			tax_id: {
				validators: {
					notEmpty: {
						message: 'Tax ID is required'
					},
					regexp: {
						regexp: /^[0-9,+]+$/,
						message: 'Tax ID can only consist of numbers.'
					}
				}
			},
			cc_no: {
				validators: {
					notEmpty: {
						message: 'Credit Card No is required'
					},
					regexp: {
						regexp: /^[0-9,-]+$/,
						message: 'Credit Card No can only consist of numbers and dashes.'
					}
				}
			},
			cvv_no: {
				validators: {
					notEmpty: {
						message: 'CVV is required'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'CVV can only consist of numbers.'
					},
					stringLength: {
						min: 3,
						max: 3,
						message: 'CVV must be of 3 digits'
					}
				}
			}
		}
	});

	// $('#login_form')
	// .bootstrapValidator({
	// 	feedbackIcons: {
	// 		valid: 'icon icon-check',
	// 		invalid: 'icon icon-cross',
	// 		validating: 'icon icon-refresh'
	// 	},
	// 	fields: {
	// 		email: {
	// 			validators: {
	// 				notEmpty: {
	// 					message: 'The email address is required and cannot be empty'
	// 				},
	// 				emailAddress: {
	// 					message: 'The email address is not a valid'
	// 				}
	// 			}
	// 		},
	// 		password: {
	// 			validators: {
	// 				notEmpty: {
	// 					message: 'The password is required and cannot be empty'
	// 				}
	// 			}

	// 		}
	// 	}
	// }
	


	/* More Validation Types */
	$('#reportForm')
	.bootstrapValidator({
		excluded: ':disabled',
		feedbackIcons: {
			valid: 'icon icon-check',
			invalid: 'icon icon-cross',
			validating: 'icon icon-refresh'
		},
		fields: {
			title: {
				validators: {
					notEmpty: {
						message: 'The title is required'
					}
				}
			},
			description: {
				validators: {
					notEmpty: {
						message: 'The abstract is required'
					}
				}
			},
			os: {
				validators: {
					notEmpty: {
						message: 'The operating system is required'
					}
				}
			},
			'browser[]': {
				validators: {
					notEmpty: {
						message: 'Choose at least one browser'
					}
				}
			},
			priority: {
				validators: {
					notEmpty: {
						message: 'The priority is required'
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

		// Hide the messages
		data.element
		.data('bv.messages')
		.find('.help-block[data-bv-for="' + data.field + '"]').hide();
	});

	/* Advamced Validation */
	$('#advancedForm')
	// IMPORTANT: You must declare .on('init.field.bv')
	// before calling .bootstrapValidator(options)
	.on('init.field.bv', function(e, data) {
		// data.bv      --> The BootstrapValidator instance
		// data.field   --> The field name
		// data.element --> The field element

		var $parent    = data.element.parents('.form-group'),
		$icon      = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]'),
		options    = data.bv.getOptions(),                      // Entire options
		validators = data.bv.getOptions(data.field).validators; // The field validators

		if (validators.notEmpty && options.feedbackIcons && options.feedbackIcons.required) {
			// The field uses notEmpty validator
			// Add required icon
			$icon.addClass(options.feedbackIcons.required).show();
		}
	})
	.bootstrapValidator({
		excluded: ':disabled',
		feedbackIcons: {
			required: 'glyphicon glyphicon-asterisk',
			valid: 'icon icon-check',
			invalid: 'icon icon-cross',
			validating: 'icon icon-refresh'
		},
		fields: {
			name: {
				validators: {
					notEmpty: {
						message: 'The name field is required'
					},
					stringLength: {
						min: 6,
						max: 30,
						message: 'The name field must be more than 6 and less than 30 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z ]+$/,
						message: 'The name field can only consist of letters and spaces only'
					}
				}
			},
			price: {
				validators: {
					notEmpty: {
						message: 'The price is required'
					},
					regexp: {
						regexp: /^[0-9,.]+$/,
						message: 'The price field can only consist of numbers, commas, and fullstops (dots) only'
					}
				}
			},
			quantity: {
				validators: {
					notEmpty: {
						message: 'The quantity is required'
					},
					numeric: {
						message: 'The quantity must be a number'
					}
				}
			},
			trailer: {
				validators: {
					notEmpty: {
						message: 'The Youtube trailer link is required'
					},
					uri: {
						message: 'The Youtube trailer link is not valid'
					}
				}
			},
			ckeditor1: {
				validators: {
					notEmpty: {
						message: 'The CKEditor field is required and cannot be empty'
					},
					callback: {
						message: 'The CKEditor field must be less than 200 characters long',
						callback: function(value, validator, $field) {
							// Get the plain text without HTML
							var div  = $('<div/>').html(value).get(0),
							text = div.textContent || div.innerText;

							return text.length <= 200;
						}
					}
				}
			}
		}
	})
	.find('[name="ckeditor1"]')
	.ckeditor()
	.editor
	// To use the 'change' event, use CKEditor 4.2 or later
	.on('change', function() {
		// Revalidate the ckeditor1 field
		$('#advancedForm').bootstrapValidator('revalidateField', 'ckeditor1');
	});
	
	$('#resetButton').on('click', function(e) {
		// Reset the form
		$('#advancedForm').data('bootstrapValidator').resetForm(true);
	});
});