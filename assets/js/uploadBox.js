jQuery(document).ready(function($) {
	$.fn.LCUploadBox = function(destination, title) {
		$(this).click(function(event) {
			event.preventDefault();
			tb_show(title,'media-upload.php?type=image&TB_iframe=true&post_id=0' , false)
		});
		window.send_to_editor = function(html) { 
            var image_url = $( 'img',html).attr( 'src'); 
            $(destination).val(image_url); 
            tb_remove(); 
        } ;

	};
});