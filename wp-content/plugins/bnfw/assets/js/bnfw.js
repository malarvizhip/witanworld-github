jQuery(document).ready(function($) {
    function toggle_fields() {
    	var show_fields = $('#show-fields').is(":checked");

    	if ( show_fields ) {
			$('#email, #cc, #bcc, #reply').show();
    	} else {
			$('#email, #cc, #bcc, #reply').hide();
    	}

	    $( '#subject-wrapper' ).show();
    }

    function toggle_users() {
    	if ( $( '#only-post-author' ).is( ':checked' ) ) {
    		$( '#users, #current-user' ).hide();
    	} else {
    		$( '#users, #current-user' ).show();
    	}

	    if ( 'new-comment' === $( '#notification' ).val() ) {
		    $( '#current-user' ).show();
	    }
    }

	function init() {
		var notification = $('#notification').val();

		$("#notification, .bnfw-select2").select2();
		$(".user-select2").select2({
			tags: BNFW.enableTags
		} );
		$(".user-ajax-select2").select2( {
			ajax: {
				url: ajaxurl,
				dataType: 'json',
				data: function( params ) {
					return {
						action: 'bnfw_search_users',
						query: params.term,
						page: params.page
					};
				},
				processResults: function( data, page ) {
					return {
						results: data
					};
				}
			},
			minimumInputLength: 1,
			tags: BNFW.enableTags
		} );

		if ( ! $( '#notification' ).length ) {
			return;
		}

		toggle_fields();

		if ( 'reply-comment' === notification || notification.startsWith( 'commentreply-' ) ||
				'new-user' === notification || 'welcome-email' === notification || 'user-password' === notification ||
				'password-changed' === notification || 'email-changed' === notification || 'user-role' === notification ||
				'multisite-new-user-invited' === notification || 'multisite-new-user-created' === notification || 'multisite-new-user-welcome' === notification ||
				'multisite-site-registered' === notification || 'multisite-site-welcome' === notification ||
				'multisite-site-created' === notification || 'multisite-site-deleted' === notification ||
				'multisite-site-admin-email-change-attempted' === notification || 'multisite-site-admin-email-changed' === notification ||
				'multisite-network-admin-email-change-attempted' === notification || 'multisite-network-admin-email-changed' === notification) {

			$('#toggle-fields, #email, #cc, #bcc, #reply, #users, #current-user, #post-author').hide();
			$('#user-password-msg, #disable-autop, #email-formatting').show();

			$( '#subject-wrapper' ).show();
			if ( 'multisite-new-user-created' === notification || 'multisite-site-created' === notification || 'multisite-site-deleted' === notification ||
					'multisite-site-admin-email-change-attempted' === notification  || 'multisite-network-admin-email-change-attempted' === notification ) {

				$( '#subject-wrapper' ).hide();
			}
		} else if ( 'new-comment' === notification || 'new-trackback' === notification || 'new-pingback' === notification ||
				'admin-password' === notification || 'admin-user' === notification || 'admin-role' === notification ) {

			$( '#toggle-fields, #users, #email-formatting, #disable-autop, #current-user, #post-author' ).show();
			toggle_fields();
			toggle_users();
			$( '#user-password-msg' ).hide();
		} else if ( 'admin-password-changed' === notification || 'core-updated' === notification ) {
			$( '#toggle-fields, #users, #email-formatting, #disable-autop' ).show();
			toggle_fields();
			toggle_users();
			$( '#user-password-msg, #current-user, #post-author' ).hide();
		} else {
			$('#toggle-fields, #users, #email-formatting, #disable-autop, #current-user, #post-author').show();
			toggle_fields();
			toggle_users();
			$('#user-password-msg').hide();
		}
	}

	init();

	/**
	 * Show a warning message if a notification is configured for more than 200 emails.
	 */
	$( '#users-select' ).on( 'change', function () {
		var emailCount = $( '#users-select' ).find( ':selected' ).length,
			$msg = $( '#users-count-msg' );

		if ( emailCount > 200 ) {
			$msg.show();
		} else {
			$msg.hide();
		}
	} );

    $('#notification').on('change', function() {
		var $this = $(this),
			notification = $this.val();

		if ( 'reply-comment' === notification || notification.startsWith( 'commentreply-' ) ||
			'new-user' === notification || 'welcome-email' === notification || 'user-password' === notification ||
			'password-changed' === notification || 'email-changed' === notification || 'user-role' === notification ||
			'multisite-new-user-invited' === notification || 'multisite-new-user-created' === notification || 'multisite-new-user-welcome' === notification ||
			'multisite-site-registered' === notification || 'multisite-site-welcome' === notification ||
			'multisite-site-created' === notification || 'multisite-site-deleted' === notification ||
			'multisite-site-admin-email-change-attempted' === notification || 'multisite-site-admin-email-changed' === notification ||
			'multisite-network-admin-email-change-attempted' === notification || 'multisite-network-admin-email-changed' === notification) {

			$('#toggle-fields, #email, #cc, #bcc, #reply, #users, #current-user, #post-author').hide();
			$('#user-password-msg, #disable-autop, #email-formatting').show();

			$( '#subject-wrapper' ).show();
			if ( 'multisite-new-user-created' === notification || 'multisite-site-created' === notification || 'multisite-site-deleted' === notification ||
					'multisite-site-admin-email-change-attempted' === notification  || 'multisite-network-admin-email-change-attempted' === notification ) {

				$( '#subject-wrapper' ).hide();
			}
		} else if ( 'admin-password' === notification || 'admin-user' === notification || 'admin-role' === notification ) {
			$('#post-author').hide();
			$('#toggle-fields, #users, #email-formatting, #disable-autop, #current-user').show();
			$('#user-password-msg').hide();
			toggle_fields();
			toggle_users();
		} else if ( 'admin-password-changed' === notification || 'core-updated' === notification ) {
			$( '#toggle-fields, #users, #email-formatting, #disable-autop' ).show();
			toggle_fields();
			toggle_users();
			$( '#user-password-msg, #current-user, #post-author' ).hide();
		} else {
			$('#toggle-fields, #users, #email-formatting, #disable-autop, #current-user, #post-author').show();
			$('#user-password-msg').hide();
			toggle_fields();
			toggle_users();
		}
    });

    $('#show-fields').change(function() {
    	toggle_fields();
    });

    $( '#only-post-author' ).change(function() {
		toggle_users();
	} );

	// send test email
	$( '#test-email' ).click(function() {
		$( '#send-test-email' ).val( 'true' );
	});

	// Validate before saving notification
	$( '#publish' ).click(function() {
		if ( $('#users').is(':visible') ) {
			if ( null === $(BNFW.validation_element).val() ) {
				$('#bnfw_error').remove();
				$('.wrap h1').after('<div class="error" id="bnfw_error"><p>' + BNFW.empty_user + '</p></div>');
				return false;
			}
		}

		return true;
	});

	$( '#shortcode-help' ).on( 'click', function() {
		var notification = $( '#notification' ).val(),
			notification_slug = '',
			splited;

		switch( notification ) {
			case 'new-comment':
			case 'new-trackback':
			case 'new-pingback':
			case 'reply-comment':
			case 'commentreply-page':
			case 'user-password':
			case 'admin-password':
			case 'admin-password-changed':
			case 'password-changed':
			case 'email-changed':
			case 'new-user':
			case 'welcome-email':
			case 'user-role':
			case 'admin-role':
			case 'admin-user':
			case 'new-post':
			case 'core-updated':
			case 'update-post':
			case 'pending-post':
			case 'future-post':
			case 'newterm-category':
			case 'newterm-post_tag':
				notification_slug = notification;
				break;

			default:
				splited = notification.split( '-' );
				switch( splited[0] ) {
					case 'new':
					case 'update':
					case 'pending':
					case 'private':
					case 'future':
					case 'comment':
						notification_slug = splited[0] + '-post';
						break;
					case 'commentreply':
						notification_slug = splited[0] + '-post';
						break;
					case 'newterm':
						notification_slug = 'newterm-category';
						break;
					// ideally these should be in the add-ons. But hardcoding them here for now
					case 'customfield':
						notification_slug = 'customfield-post';
						break;
					case 'updatereminder':
						notification_slug = 'updatereminder-post';
						break;

					default:
						notification_slug = notification;
						break;
				}

				break;
		}

		$(this).attr( 'href', 'https://betternotificationsforwp.com/documentation/notifications/shortcodes/?notification=' + notification_slug + '&utm_source=WP%20Admin%20Notification%20Editor%20-%20"Shortcode%20Help"&utm_medium=referral' );
	});

	/**
	 * Insert Default Message for notification.
	 */
	$( '#insert-default-msg' ).on( 'click', function() {
		var notification = $( '#notification' ).val(),
			subject = '',
			body = '';

		switch ( notification ) {
			case 'new-comment':
			case 'new-trackback':
			case 'new-pingback':
			case 'reply-comment':
				subject = '[[global_site_title]] Comment: "[post_title]"';
				body = 'New comment on your post "[post_title]"<br>' +
					'Author: [comment_author] (IP address: [comment_author_IP]) <br>' +
					'Email: [comment_author_email] <br>' +
				    'URL: [comment_author_url] <br>' +
					'Comment: <br> ' +
					'[comment_content] <br>' +
					'<br>' +
					'You can see all comments on this post here: <br>' +
					'[permalink]#comments';

				break;

			case 'admin-user':
				subject = '[[global_site_title]] New User Registration';
				body = 'New user registration on your site [global_site_title]: <br>' +
					'Username: [user_login] <br>' +
					'E-mail: [user_email]';

				break;

			case 'admin-password-changed':
				subject = '[[global_site_title]] Password Changed';
				body = 'Password changed for user: [user_login]: <br>';

				break;

			case 'user-password':
				subject = '[[global_site_title]] Password Reset';
				body = 'Someone has requested a password reset for the following account: <br>' +
					'Site Name: [global_site_title] <br>' +
					'Username: [user_login] <br>' +
					'If this was a mistake, just ignore this email and nothing will happen. <br>' +
					'To reset your password, visit the following address: [password_reset_link]';

				break;

			case 'password-changed':
				subject = '[[global_site_title]] Notice of Password Change';
				body = 'Hi [user_nicename], <br>' +
					'<br>' +
					'This notice confirms that your password was changed on [global_site_title].' +
					'<br>' +
					'If you did not change your password, please contact the Site Administrator at [admin_email] <br>' +
					'<br>' +
					'This email has been sent to [global_user_email]' +
					'<br>' +
					'Regards, <br>' +
					'All at [global_site_title] <br>' +
					'[global_site_url]';
				break;

			case 'email-changed':
				subject = '[[global_site_title]] Notice of Email Change';
				body = 'Hi [user_nicename], <br>' +
					'<br>' +
					'This notice confirms that your email address was changed to [user_email].' +
					'<br>' +
					'If you did not change your email, please contact the Site Administrator at [admin_email] <br>' +
					'<br>' +
					'This email has been sent to [global_user_email]' +
					'<br>' +
					'Regards, <br>' +
					'All at [global_site_title] <br>' +
					'[global_site_url]';
				break;

			case 'new-user':
				subject = '[[global_site_title]] Your username and password info';
				body = 'Username: [user_login] <br>' +
					'To set your password, visit the following address: [password_url]';

				break;

			case 'multisite-new-user-invited':
				subject = '[[network_name] Activate [user_login]';
				body = 'To activate your user, please click the following link:' +
					'<br>' +
					'[activation_link]' +
					'<br>' +
					'After you activate, you will receive *another email* with your login.';

				break;

			default:
				alert( "This is a new notification that is not available in WordPress by default and has been added by Better Notifications for WordPress. As such, it doesn't have any default content." );
				break;
		}

		if ( subject !== '' ) {
			$( '#subject' ).val( subject );
		}

		if ( body !== '' ) {
			if ( tinyMCE && tinyMCE.editors && tinyMCE.editors['notification_message'] ) {
				tinyMCE.editors['notification_message'].selection.setContent( '<div>' + body + '</div>' );
			}
		}

		return false;
	} );
});
