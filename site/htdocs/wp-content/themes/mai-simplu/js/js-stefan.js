(function($){
	var GovItHubMaiSimplu = {};

	GovItHubMaiSimplu.init = function(){
		var that = this;
		jQuery(document).on('click', '.govithub-rating-trigger', function(){
			var voteType = $( this ).data('rating'),
				isUserLoggedIn = GovItHubMaiSimpluData.isUserLoggedIn;

			// Display a popup to ask the user to login
			if( ! isUserLoggedIn ){
				that.showLoginModal();
				return false;
			}

			// The user is authentificated... let him vote
			GovItHubMaiSimplu.vote( ratingType );
		});
	}

	/**
	 * Will display a modal window asking the user to register/login
	 */
	GovItHubMaiSimplu.showLoginModal = function(){
		alert( 'please login' );
	}

	/**
	 * Will perform the voting action
	 * Will send an Ajax call to the server
	 */
	GovItHubMaiSimplu.vote = function(){
		alert( 'please login' );

	}


	GovItHubMaiSimplu.init();
})(jQuery)