/*
 * Script Plugins
 */

/* SuperFish*/
jQuery(document).ready(function($) { 
	$('ul.sf-menu').superfish({
		animation:   {opacity:'show',height:'show'},
		speed:       300,
		dropShadows: false 
	}); 
});
/* Mobile Menu */
jQuery(document).ready(function($){
	$('ul.sf-menu').mobileMenu({switchWidth: 767, topOptionText: 'Menu', prependTo: '.main-navigation'});
});
/* Fix placeholder for old browser */
jQuery(document).ready(function($){

	if(!Modernizr.input.placeholder){

		$('[placeholder]').focus(function() {
		  var input = $(this);
		  if (input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		  }
		}).blur(function() {
		  var input = $(this);
		  if (input.val() == '' || input.val() == input.attr('placeholder')) {
			input.addClass('placeholder');
			input.val(input.attr('placeholder'));
		  }
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
		  $(this).find('[placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
			  input.val('');
			}
		  })
		});

	}
});