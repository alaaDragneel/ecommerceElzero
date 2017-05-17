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

	// start switch between login and sgin up

	$(".login-page h1 span").click(function(){

		$(this).addClass("selected").siblings().removeClass("selected");

		$(".login-page form").hide();

		$('.' + $(this).data("class")).fadeIn(100);

	});

	// end switch between login and sgin up

	//start validate the forms for sgin up form

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
	
	//start validate the forms for sgin up form

	$(".formValidation2").on("submit", function(e){
	  
	  var errorMessage  = $(".errorMessage2");
	  var hasError = false;
	  
	  $(".inputValidation2").each(function(){
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