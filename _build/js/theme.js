jQuery(document).ready(function(){

	//* Make all paragraphed image full-width, except when normal-width is applied
	// jQuery('#content .entry-content').find( 'p:not([class="normal-width"]) > img').parent().addClass('full-width');
	jQuery('#content > .entry .entry-content, #content .widget_black_studio_tinymce .textwidget').find( 'img, iframe' ).parent('p, div').not('[class="normal-width"]').addClass('full-width');

});