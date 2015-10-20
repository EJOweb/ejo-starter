jQuery(document).ready(function($){
	var custom_uploader;
	$('body .image-upload').on('click', '.upload-button', function(e)
	{
		e.preventDefault();

		var button = $(this);

		var value_holder = button.siblings('.image-id');
		var image_container = button.siblings('.image-container');

		//* For multiple uploaders //* Why deleting, just create new object
		if (custom_uploader) {
			//* Close current uploader?
			custom_uploader.close();
		}

		// custom_uploader = wp.media.frames.file_frame = wp.media(
		custom_uploader = wp.media(
		{
			title: 'Choose Image',
			button: {
	    			text: 'Choose Image'
			},
			multiple: false
		});

		custom_uploader.open();

		custom_uploader.on('select', function()
		{
			// var attachment = custom_uploader.state().get('selection').toJSON();
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			value_holder.val(attachment.id);

			var image = $( '<img />', { src: attachment.sizes.thumbnail.url });

			//* Replace current image with selected
			image_container.html(image);
		});
	});

	$('body .image-upload').on('click', '.remove-button', function(e)
	{
		e.preventDefault();

		var button = $(this);

		var value_holder = button.siblings('.image-id');
		var image_container = button.siblings('.image-container');

		//* Remove value
		value_holder.val('');

		//* Make empty
		image_container.html('');
	});
});