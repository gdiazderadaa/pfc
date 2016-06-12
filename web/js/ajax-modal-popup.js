(function($){
    $(document).on('click', '.show-modal', function (e) {
        e.preventDefault();
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content. 
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('.modal-body')
                    .load($(this).attr('#modalContent'));
        } else {
            //if modal isn't open; open it and load content
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('href'));           
        }
        //dynamiclly set the header for the modal
        document.getElementById('modalHeaderTitle').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        
        //prepend submit button
        if ($(this).attr('data-submit')){
        	var dataReloadContainerId = $(this).attr('data-reload-container') ? "#" + $(this).attr('data-reload-container') : false;
        	$('.modal-footer').find("button[type='submit']").html($(this).attr('data-submit'))
        	$('.modal-footer').find("button[type='submit']").show();
        	
        	//Handle submission
        	$('.modal-footer').find("button[type='submit']").on("click", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                var form = $(this).closest(".modal-content").find("form");
    			
    			if(form.find('div.has-error').length) {
                            return false;
                }	
    		
    			 $.ajax({
                        url: form.attr('action')+"&submit=true",
                        type: 'post',
                        data: form.serialize(),
                        success: function(data) {
                        	if (dataReloadContainerId)
                                $.pjax.reload({container:dataReloadContainerId});
                        }
                    });		
                return false;
            });
        }
        else{
        	$('.modal-footer').find("button[type='submit']").hide();
        }
    });
 })(jQuery);