///////////////////
// Pages Mailbox //
///////////////////

"use strict";

$(document).ready(function(){

	/**
	 * circloidMailboxInbox handles the inbox features
	 */
	function circloidMailboxInbox(){

		/* Select All Feature */
		$(".mailbox-controls .email-select-all input").iCheck({
			checkboxClass: 'icheckbox_square-blue checkbox-actual'
		});

		// First clear checkbox when page is refreshed
		$(".mailbox-controls .email-select-all input").iCheck("uncheck");
		
		$(".mailbox-controls .email-select-all input").on("ifChecked", function(){
			$(".mailbox-email-list tr .email-item-checkbox").iCheck("check");
		});
		$(".mailbox-controls .email-select-all input").on("ifUnchecked", function(){
			$(".mailbox-email-list tr .email-item-checkbox").iCheck("uncheck");
		});

		/* Email Controls */
		// Enable/Disable Controls
		$(".mailbox-email-list tr").find(".email-checkbox").on("ifChecked", function(e){
			$(".email-mark-read, .email-mark-junk, .email-delete, .email-move-inbox").removeAttr("disabled", false);
		});
		$(".mailbox-email-list tr").find(".email-checkbox").on("ifUnchecked", function(e){
			var totalChecked = $(this).closest("tr").siblings().find(".checkbox-actual.checked").length;

			if(totalChecked <= 0){
				$(".email-mark-read, .email-mark-junk, .email-delete").attr("disabled", "disabled");
			}
		});

		/* Control Actions - You will have to connect your Server and Database to these code chunks - Start */

		// Refresh Email
		$(".email-refresh").on("click", function(e){
			// ADD YOUR AJAX CODE HERE. On success, call the code below or write a one that suits your needs
			location.reload();
			e.preventDefault();
		});

		// Mark Read
		$(".email-mark-read").on("click", function(e){
			// ADD YOUR AJAX CODE HERE. On success, call the code below or write a one that suits your needs
			$(".mailbox-email-list tr.email-status-unread").each(function(){
				$(this).find(".checkbox-actual.checked").closest("tr").removeClass("email-status-unread");
			});
			e.preventDefault();
		});

		// Delete Email
		$(".email-delete").on("click", function(e){
			// ADD YOUR AJAX CODE HERE. On success, call the code below or write a one that suits your needs
			$(".mailbox-email-list tr .checkbox-actual.checked").each(function(){
				$(this).closest("tr").fadeOut(300, function(){
					$(this).remove();
				});
			});

			$(".alert").remove();

			var messageDelete = '<div class="alert alert-success alert-dismissable" style="opacity:0;"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><strong>Deleted!</strong> Email(s) deleted.</div>';

			$(".mailbox-controls").after(messageDelete);
			$(".alert").animate({"opacity":1}, 300);
			$(".email-mark-read, .email-mark-junk, .email-delete").attr("disabled", "disabled");

			e.preventDefault();
		});

		// Mark as Junk
		$(".email-mark-junk").on("click", function(e){
			// ADD YOUR AJAX CODE HERE. On success, call the code below or write a one that suits your needs
			$(".mailbox-email-list tr .checkbox-actual.checked").each(function(){
				$(this).closest("tr").fadeOut(300, function(){
					$(this).remove();
				});
			});

			$(".alert").remove();
			
			var messageDelete = '<div class="alert alert-success alert-dismissable" style="opacity:0;"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><strong>Moved!</strong> Email(s) have been moved to the Junk Folder.</div>';

			$(".mailbox-controls").after(messageDelete);
			$(".alert").animate({"opacity":1}, 300);
			$(".email-mark-read, .email-mark-junk, .email-delete").attr("disabled", "disabled");

			e.preventDefault();
		});

		/* Control Actions - You will have to connect your Server and Database to these code chunks - End */

		/* Individual Email Features */
		$(".mailbox-email-list tr").each(function(){

			/* Star Email Feature */
			$(this).find(".email-star").on("click", function(){
				$(this).find(".email-star-status").toggleClass("checked");
			});

			/* Checkboxes - Individual */
			$(this).find(".email-checkbox").iCheck({
				checkboxClass: 'icheckbox_square-blue checkbox-actual'
			});

			$(this).find(".email-checkbox").on("click", function(){
				$(this).find(".email-item-checkbox").iCheck("toggle");
			});

			// First clear all checkboxes when page is refreshed
			$(this).find(".checkbox-actual.checked .email-item-checkbox").iCheck("uncheck");

			// Highlight Row when checkbox is clicked
			$(this).find(".email-checkbox").on('ifChecked', function(e){
				$(this).closest("tr").addClass("highlighted");
			});
			$(this).find(".email-checkbox").on('ifUnchecked', function(e){
				$(this).closest("tr").removeClass("highlighted");
			});
			

			/* Get and Set Email URL */
			var emailURL = $(this).data("email-url");

			$(this).find(".email-sender, .email-subject, .email-datetime").on("click", function(){
				window.location.href = emailURL;
			});
		});
	}

	/**
	 * circloidMailboxMessageView handles features on the message view of each email
	 */
	function circloidMailboxMessageView(){
		$("#show-others").on("click", function(e){
			$(".message-recepient-others").slideToggle(300);
			e.preventDefault();
		});
	}
	

	
	/* Call Functions */
	circloidMailboxInbox();

	circloidMailboxMessageView();
	

});