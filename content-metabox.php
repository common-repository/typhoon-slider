<?php 
add_action( 'add_meta_boxes', 'typhoon_add_meta_box' );

function typhoon_add_meta_box() {
	add_meta_box( "typhoon_metabox", "Slides", "typhoon_slides_content", "typhoon_slider" );
}

function typhoon_slides_content($post) {
	global $typhoon_url;
	?>

	<div class='ts_all_slides'>
		<?php 
			$post_id = $post->ID;
			$slides = get_post_meta($post_id , "slides" , true);
			
			if(!is_array($slides)) {
				typohoon_print_slide("");
			}
			else {
				foreach($slides as $slide) {
					typohoon_print_slide($slide);
				} 
			}
		?>			
	</div>

	<style type="text/css">
		.ts_picker {
		  border-right: 1px solid #e8e4e4;
		  float: left;
		  height: 121px;
		  width: 7%;
		}

		.ts_slide_content {
		  float: left;
		  width: 89%;
		}

		.slide_div {
		  background: #f2f2f2 none repeat scroll 0 0;
		  box-shadow: 0 2px 1px #d0d0d0;
		  cursor: grab;
		  margin-bottom: 20px;
		  padding: 10px;
		}
		.tscontrols {
		  display: block;
		  float: left;
		  width: 31px;
		}

		.tscontrols .add, .tscontrols .remove {
		  display: inline-block;
		  height: 30px;
		  width: 30px;
		  cursor: pointer;
		}

		.tscontrols .add img, .tscontrols .remove img {
		  max-width: 100%;
		}

		.clearfix:after {
		   content: " "; /* Older browser do not support empty content */
		   visibility: hidden;
		   display: block;
		   height: 0;
		   clear: both;
		}

		.ts_content {
		  height: 140px;
		  width: 97%;
		}

		.typhoon_bye {
			animation:typhoonbye_kf 1s 1;
			overflow:hidden;
		}		

		.typhoon_hello {
			animation:typhoonhello_kf 1s 1;
			overflow:hidden;
		}

		@-moz-keyframes typhoonbye_kf {
		  0%   { opacity: 1; margin-left: 0; height: 100px; }
		  100% { opacity: 0; background-color:red; transform: rotateY(90deg); height: 40px;}
		}		

		@-moz-keyframes typhoonhello_kf {
		  0%   { opacity: 0;  height: 0px; background-color:#7DCEF9; transform: rotateY(90deg); }
		  100% { opacity: 1;  height: 100px; background-color:auto; transform: rotateY(0deg);}
		}
		
		.ts_picker > img {
		  max-width: 100%;
		}

		.tycoon_insert_img {
		  border: 0 solid;
		  margin-top: 10px;
		  width: 55%;
		  cursor: pointer;
		}

	</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery(".ts_all_slides").sortable();
		});

		var ts_slide_html = '<div class="slide_div clearfix typhoon_hello"> \
							<div class="ts_picker"> \
								<img class=\'grip\' src="<?php echo $typhoon_url."images/grip.png" ?>"> \
								<img class="tycoon_insert_img" src="<?php echo $typhoon_url."images/gallery.png" ?>" > \
							</div>\
							<div class="ts_slide_content">\
								<textarea class="ts_content" name="ts_content[]"></textarea>\
							</div>\
							<div class=\'tscontrols\'> \
								<span class="add"><img src=\'<?php echo $typhoon_url."images/add.png"?>\'></span>\
								<span class="remove"><img src=\'<?php echo $typhoon_url."images/minus.png"?>\'></span>\
							</div>\
					</div>';

		jQuery(document).on("click" , ".tscontrols .add" , function() {

			jQuery(".ts_all_slides").append(ts_slide_html);

		});	

		jQuery(document).on("click" , ".tscontrols .remove" , function() {

			var slide = jQuery(this).parent().parent();
			slide.removeClass("typhoon_hello");
			slide.addClass("typhoon_bye");
			
			window.setTimeout(function() {
				slide.remove();
			} , 1000);

		});			

		var frame , ts_this , ts_this_tb;

		jQuery(document).on("click" , ".tycoon_insert_img" , function() {

			ts_this = jQuery(this);
			ts_this_tb = ts_this.parent().parent().find(".ts_content");

			console.log(ts_this_tb);

			if ( frame ) {
		      frame.open();
		      return;
		    }
    
		    // Create a new media frame
		    frame = wp.media({
		      title: 'Select or Upload Media Of Your Chosen Persuasion',
		      button: {
		        text: 'Use this media'
		      },
		      multiple: false  // Set to true to allow multiple files to be selected
		    });

    
		    // When an image is selected in the media frame...
		    frame.on( 'select', function() {
		      
		      // Get media attachment details from the frame state
		      var attachment = frame.state().get('selection').first().toJSON();

		      console.log(ts_this_tb);
		      console.log("prmoad");
		      // Send the attachment URL to our custom image input field.
		      ts_this_tb.val( ts_this_tb.val() + '<img src="'+attachment.url+'"> ' );

		    });

		    // Finally, open the modal on click
		    frame.open();
  

		} );
	</script>
		
	<?php
}

?>