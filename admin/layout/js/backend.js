$(document).ready(function() {

	'use strict';

	//start hide placeholder on form fouces

	$('[placeholder]').focus(function() {

		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');

	}).blur(function() {

		$(this).attr('placeholder', $(this).attr('data-text'));

	});

	//end hide placeholder on form fouces

	//start validate the forms

	$(".formValidation").on("submit", function(e){
	  
	  var errorMessage  = $(".errorMessage");
	  var hasError = false;
	  
	  $(".inputValidation").each(function(){
		var $this = $(this);
		
		if($this.val() === ""){
		  hasError = true;
		  $this.addClass("inputError");
		  errorMessage.html("<p>Error: Please correct errors above</p>");
		  $this.attr('placeholder', 'please fill this field');
		  
		  $('[placeholder]').focus(function() {
		  	$(this).attr('data-text', $(this).attr('placeholder'));
			$(this).attr('placeholder', '');

			}).blur(function() {

			$(this).attr('placeholder', $(this).attr('data-text'));

		  });

		  e.preventDefault();
		}if($this.val() !== ""){
		  $this.removeClass("inputError"); 
		}else{
		  return true; 
		}
	  }); //Input
	  
	  errorMessage.slideDown(1000);
	}); //Form .submit

	//end validate the forms

	//start dash board

	$('.toggle-info').click(function(){

		$(this).toggleClass("selected").parent().next('.panel-body').fadeToggle(300);

		if($(this).hasClass("selected")) {

			$(this).html('<i class="fa fa-minus"></i>');

		}else{
			$(this).html('<i class="fa fa-plus"></i>');
		}

	});
	
	//end dash board
	
	// start convert the password field to text field on hover

	var passField = $('.password');

	$('.show-pass').hover(function () {

		passField.attr('type', 'text');

	}, function () {

		passField.attr('type', 'password');

	});

	// end convert the password field to text field on hover

	// start delete btn confirm

	$('.confirm').click(function () {
		return confirm('are you sure from delete ?');
	});

	// end delete btn confirm

	// start trigger the select box it
	$("select").selectBoxIt({
		// Uses the jQuery 'fadeIn' effect when opening the drop down
	    showEffect: "fadeIn",

	    // Sets the jQuery 'fadeIn' effect speed to 400 milleseconds
	    showEffectSpeed: 400,

	    // Uses the jQuery 'fadeOut' effect when closing the drop down
	    hideEffect: "fadeOut",

	    // Sets the jQuery 'fadeOut' effect speed to 400 milleseconds
	    hideEffectSpeed: 400, 
		autoWidth: false
	});
	//end trigger the select box it

});