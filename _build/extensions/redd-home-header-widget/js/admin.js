jQuery(document).ready(function($){

	var custom_uploader;
	$('body').on('click', '.redd-hhi-upload-button', function(e)
	{
		e.preventDefault();

		var button = $(this);
		var container = button.parent();
		var value_holder = container.find('.redd-hhi-image-id');

		if (custom_uploader) {
			custom_uploader.open();
			return;
		}

		custom_uploader = wp.media.frames.file_frame = wp.media(
		{
			title: 'Choose Image',
			button: {
	    			text: 'Choose Image'
			},
			multiple: false
		});
		custom_uploader.on('select', function()
		{
			// var attachment = custom_uploader.state().get('selection').toJSON();
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			value_holder.val(attachment.id);

			var image = $( '<img />', { src: attachment.sizes.thumbnail.url });

			//* Replace current image with selected
			container.find('img').remove();
			container.prepend(image);

		});

		custom_uploader.open();
	});

	$('body').on('click', '.redd-hhi-remove-button', function(e)
	{
		e.preventDefault();

		var button = $(this);
		var container = button.parent();
		var value_holder = container.find('.redd-hhi-image-id');

		container.find('img').remove();
		value_holder.val('');
	});
});