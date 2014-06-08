jQuery( document )
	.ready( function ( $ ) {
		"use strict";

		// media uploader
		jQuery( 'a.multi-images-upload' )
			.on( 'click', function ( evt ) {
				evt.preventDefault();
				var file_frame, thumbnails;
				var button = jQuery( this );
				var inputId = jQuery( this )
					.data( 'store' );
				// file frame already created, return
				if ( file_frame ) {
					file_frame.open();
					return;
				}
				// create the file frame
				file_frame = wp.media.frames.file_frame = wp.media( {
					title: jQuery( this )
						.data( 'uploader_title' ),
					button: jQuery( this )
						.data( 'uploader_button_text' ),
					multiple: false,
					library: {
						type: 'image'
					}
				} );
				// get the selected attachments when user confirms selection
				file_frame.on( 'select', function ( evt ) {
					var selected = file_frame.state()
						.get( 'selection' )
						.toJSON(),
						store = jQuery( inputId ),
						urls = [];
					for ( var i = selected.length - 1; i >= 0; i-- ) {
						urls.push( selected[ i ].url );
					}

					// triggering change will activate the Save & Close button
					store.val( urls )
						.trigger( 'change' );
					// update the thumbnails using the new images
					updateThumbnails( urls, store );

				} );
				// open the file frame
				file_frame.open();
			} );

		jQuery( 'a.multi-images-remove' )
			.on( 'click', function ( evt ) {
				evt.preventDefault();
				var button = $( this ),
					input = jQuery( button.data( 'store' ) ),
					store = jQuery( input );
				input.val( '' )
					.trigger( 'change' );
				updateThumbnails( '', store );
			} );

		function updateThumbnails( urls, args ) {
			var input = args,
				thumbContainer = jQuery( input.data( 'thumbs-container' ) );
			var urls = urls;
			// remove old images
			thumbContainer.empty();
			// for each image url in the value create and append an image element to the list
			for ( var i = urls.length - 1; i >= 0; i-- ) {
				var li = $( '<li/>' );
				li.attr( 'style', 'background-image:url(' + urls[ i ] + ');' );
				li.attr( 'class', 'thumbnail' );
				li.attr( 'data-src', urls[ i ] );
				thumbContainer.append( li );
			}
		}

	} );
