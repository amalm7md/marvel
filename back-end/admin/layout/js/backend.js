$(function(){

	'use strict';

	// Trigger the SelectBox  
	$("select").selectBoxIt({
		autoWidth:false;
		});


	// Hide Placeholder On Form Focus

	$('[placeholder]').focus(function(){
		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	}).blur(function(){
		$(this).attr('placeholder',$(this).attr('data-text'));
	});



	// Add Asterisk On Required Fields

	$('input').each(function(){

		if ($(this).attr('required') == 'required') {

			$(this).after('<span class="asterisk">*</span>');
		}
	});


	//convert password field to  Text field  on haver

	var passField = $('.password');
	$('.show-pass') .hover(function(){
	 passField.attr('type','text');
	},function(){
    passField.attr('type','password');

	});


	// Confirmation message on button

	$('.confirm').click(function(){

		return confirm('Are You Sure?');
	});


	// Categories view options 

	$('.cat h3') .click(function (){
	     $(this).next('.full-view') .fadeToggle(200);

	}) ;



	$('.option span').click(function(){
		
    $(this).addClass('active').sibling('span').removeClass('active');
    if($(this).data('view') === 'full' ){
        $('.cat .full-view') .fadeIn(200);
    }else{
        $('.cat .full-view') .fadeOut(200);
    }
	}); 

});