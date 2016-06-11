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
        	$('.modal-footer').find("button[type='submit']").html($(this).attr('data-submit'))
        	$('.modal-footer').find("button[type='submit']").show();
        }
        else{
        	$('.modal-footer').find("button[type='submit']").hide();
        }
    });
 })(jQuery);