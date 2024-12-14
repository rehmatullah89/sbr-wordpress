<?php
/**
 * BuddyPress Avatars main template.
 *
 * This template is used to inject the BuddyPress Backbone views
 * dealing with avatars.
 *
 * It's also used to create the common Backbone views.
 *
 * @since 2.3.0
 * @version 3.1.0
 */

/**
 * This action is for internal use, please do not use it
 */
do_action( 'bp_attachments_avatar_check_template' );

    

?>

<div class="messageDisplayOnAvatarage">
	<div class="manage-and-update-profile-photos">Manage and update your profile photo</div>
	<div class="bp-avatar-nav"></div>
</div>
<div class="bp-avatar"></div>
<div class="bp-avatar-status"></div>

<script type="text/html" id="tmpl-bp-avatar-nav">
	<a href="{{data.href}}" class="bp-avatar-nav-item" data-nav="{{data.id}}">{{data.name}}</a>
</script>

<?php bp_attachments_get_template_part( 'uploader' ); ?>

<?php bp_attachments_get_template_part( 'avatars/crop' ); ?>

<?php bp_attachments_get_template_part( 'avatars/camera' ); ?>

<?php bp_attachments_get_template_part( 'avatars/recycle' ); ?>

<script id="tmpl-bp-avatar-delete" type="text/html">
	<# if ( 'user' === data.object ) { #>
		<p><?php esc_html_e( "If you'd like to delete your current profile photo, use the delete profile photo button.", 'buddypress' ); ?></p>
		<button type="button" class="button edit" id="bp-delete-avatar"><?php esc_html_e( 'Delete My Profile Photo', 'buddypress' ); ?></button>
	<# } else if ( 'group' === data.object ) { #>
		<?php bp_nouveau_user_feedback( 'group-avatar-delete-info' ); ?>
		<button type="button" class="button edit" id="bp-delete-avatar"><?php esc_html_e( 'Delete Group Profile Photo', 'buddypress' ); ?></button>
	<# } else { #>
		<?php
			/**
			 * Fires inside the avatar delete frontend template markup if no other data.object condition is met.
			 *
			 * @since 3.0.0
			 */
			do_action( 'bp_attachments_avatar_delete_template' ); ?>
	<# } #>
</script>
<script>
		setTimeout(function() {
			jQuery("#bp-delete-avatar").on("click", function (e) { 
				setTimeout(function() {
					location.reload();
				}, 2000);
			});
		}, 3000);
		</script>
<?php
	/**
	 * Fires after the avatar main frontend template markup.
	 *
	 * @since 3.0.0
	 */
	if (function_exists('w3tc_flush_url')) {
        $user_idd = bp_core_get_userid(bp_core_get_username(get_current_user_id()));
                if (!$user_idd || $user_idd == '') {
                    $linkslug = $wpdb->get_var( "SELECT user_login FROM wp_users WHERE user_nicename = '".bp_core_get_username(get_current_user_id())."'" );
                  
                }
                else{
                    $linkslug = bp_core_get_username(get_current_user_id());
                }
        w3tc_flush_url(home_url()."/rdh/profile/".$linkslug."/");
        w3tc_flush_url(home_url()."/rdh/products/".$linkslug."/");
        w3tc_flush_url(home_url()."/rdh/contact/".$linkslug."/");
    }
	do_action( 'bp_attachments_avatar_main_template' ); ?>
