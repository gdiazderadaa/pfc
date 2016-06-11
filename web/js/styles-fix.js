/**
 * 
 */
(function($){
	$(document).ready(function(){
		fixBoxesHeight();
	});
	$( window ).resize(function(){
		fixBoxesHeight();
	});
	
	function fixBoxesHeight(){
		var boxes = $(".box-body.table-responsive").filter(function(){
			return $(this).children().is("table");
		});
		var maxHeight = 0;
		
		//Get max box height
		boxes.each(function(){
			if ($(this).height() > maxHeight){
				maxHeight = $(this).height();
			}
		});
		
		//Apply max box height to all boxes
		boxes.each(function(){
			$(this).css("min-height",maxHeight);
		});
	}
})(jQuery);
