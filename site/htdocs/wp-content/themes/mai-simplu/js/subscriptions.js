(function($){
	$(document).on('click', '.govithub-follow-trigger', function(event){
        event.preventDefault();

        $.ajax({
            url: GovItHubMaiSimpluData.ajax_url,
            data: {
                'action':'follow_request',
                'id' : $(this).data('postid'),
                'state' : $(this).data('follow')
            },
            success:function(data) {
                location.reload();
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });  

    });

})(jQuery);