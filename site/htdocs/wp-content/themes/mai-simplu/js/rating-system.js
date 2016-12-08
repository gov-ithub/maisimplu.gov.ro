(function($){
	var GovItHubMaiSimplu = {};

	GovItHubMaiSimplu.voteState = {
		isVoting: false
	}

	GovItHubMaiSimplu.init = function(){

		// Follow vote bar
		this.showFollowVoteBar();
		// Vote buttons functionality
		this.addVoteFunctionality();
		// Image pop-up
		this.initImagePopUp();

	}

	/**
	 * Will allow the user to open blog images in pop-ups
	 */
	GovItHubMaiSimplu.initImagePopUp = function(){

		$('.govithub-image-popup').magnificPopup({
			type:'image',
			mainClass: 'mfp-zoom-in',
		});

	}

	/**
	 * Will show the voting bar at the bottom of the page while the user is scrolling
	 */
	GovItHubMaiSimplu.showFollowVoteBar = function(){

		// Only allow on single proposal pages
		if( ! $('body').hasClass('single-post') ){
			return false;
		}

		// Put the voing bar at bottom
		var bar = $('.govithub-vote-share-bar'),
			clone = bar.clone();

		$(window).on('scroll', function( e ){
			var top = bar.offset().top,
				scrollPos = $(window).scrollTop();

			if( scrollPos > top ){
				clone.appendTo('body').addClass( 'govithub-fix-bar' ).show();
			}
			else{
				clone.hide();
			}

		});
	}


	/**
	 * Will allow the user to click on the voting buttons
	 */
	GovItHubMaiSimplu.addVoteFunctionality = function(){

		var that = this,
			buttons = $('.govithub-rating-trigger');

		$(document).on('click', '.govithub-rating-trigger', function(event){

			event.preventDefault();

			var postId = $( this ).data('postid'),
				voteType = $( this ).data('rating'),
				isUserLoggedIn = GovItHubMaiSimpluData.isUserLoggedIn,
				iconHolder = $(this).children('.fa'),
				voteCountHolder =  $( this ).closest('.govithub-proposal-rating-wrapper').find('.govithub-proposal-rating-status-holder');

			// Don't allow the user to spam the voting buttons
			if( that.voteState.isVoting ) {
				return false;
			}

			// Display a popup to ask the user to login
			if( ! isUserLoggedIn ){
				that.showLoginModal();
				return false;
			}

			// Show loading icon
			that.voteState.isVoting = true;
			iconHolder.addClass( 'fa-spinner fa-spin' );

			// The user is authentificated... let him vote
			GovItHubMaiSimplu.vote( postId, voteType, function( success, response ){

				if( success ){
					voteCountHolder.html( response.data.voteCount ).addClass( 'pulsate' );
				}

				that.voteState.isVoting = false;
				iconHolder.removeClass( 'fa-spinner fa-spin' );
			});
		});
	}

	/**
	 * Will display a modal window asking the user to register/login
	 */
	GovItHubMaiSimplu.showLoginModal = function(){

		var template = '<div class="govithub-need-login-popup">';
		template += 'Trebuie sa fi inregistrat pentru a putea vota.';
		template += '<a href="http://maisimplu.gov.ro/inregistrare/" class="btn btn-primary govithub-login-button green-btn">Creează cont !</a>';
		template += '<a href="http://maisimplu.gov.ro/autentificare/" class="btn btn-danger govithub-login-button">Autentificare</a>';
		template += '</div>';

		this.showMessage( template );
	}

	/**
	 * Will perform the voting action
	 * Will send an Ajax call to the server
	 */
	GovItHubMaiSimplu.vote = function( postId, voteType, callback ){

		// Prepare the data
		var data = {
			action: 'govithub_vote',
			voteType: voteType,
			postId: postId
		};

		// Make the ajax call
		$.post( GovItHubMaiSimpluData.ajax_url, data, function( response ) {
			if( response.success ){
				console.log( response );
			}
			else{
				alert(response.data.message);
			}
			callback( true, response );
		})
		.fail(function() {
			callback();
			alert( "Something went wrong. Please try again later." );
		});
	}

	GovItHubMaiSimplu.showMessage = function( message, openCallback, closeCallback ){
		$.magnificPopup.open({
			items: {
				src: '<div class="white-popup mfp-with-anim">'+ message +'</div>', // can be a HTML string, jQuery object, or CSS selector
				type: 'inline'
			},
			mainClass: 'mfp-zoom-in',
			callbacks: {
				open: function() {
					if( typeof openCallback === 'function' ){
						openCallback();
					}
				},
				close: function() {
					if( typeof closeCallback === 'function' ){
						closeCallback();
					}
				}
			}
		});
	}

	GovItHubMaiSimplu.init();
})(jQuery);