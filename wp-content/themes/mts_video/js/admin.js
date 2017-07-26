(function( $ ) {
	'use strict';

	$(function() {
		
		// Select which shows/hides options based on its value
		function mtsVideoShowHideChildOptions( el ) {
			var $this = $(el),
				tempValue = $this.val(),
				targetSelector = '[data-parent-select-id="'+$this.attr('id')+'"]',
				activeSelector = '[data-parent-select-value*="'+tempValue+'"]';

			$( targetSelector ).hide();

			if ( tempValue && activeSelector ) {

				$( targetSelector+activeSelector ).show();
			}
		}

		$('select#video-service').each(function() {
			mtsVideoShowHideChildOptions( $(this) );
		});

		$(document).on('change', 'select#video-service', function(e) {
			mtsVideoShowHideChildOptions( $(this) );
		});

		$('#post-formats-select').append('<p id="video-help" class="description" style="display: none;">Use the Video Options metabox to set up the video player.</p>');
		if ( $('input#post-format-video:checked').length > 0 ) {
			$('#video-help').show();
			$('#mts_meta').show();
		} else {
			$('#video-help').hide();
			$('#mts_meta').hide();
		}
		
		$('#post-formats-select').find('.post-format').change(function() {
			if ($(this).val() == 'video') {
				$('#video-help').show();
				$('#mts_meta').show();
			} else {
				$('#video-help').hide();
				$('#mts_meta').hide();
			}
		});
	});

})( jQuery );