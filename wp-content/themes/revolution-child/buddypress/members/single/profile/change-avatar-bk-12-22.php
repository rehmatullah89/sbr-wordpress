<?php
/**
 * BuddyPress - Members Profile Change Avatar
 *
 * @since 3.0.0
 * @version 3.2.0
 */
?>
<link rel="stylesheet" href="https://stable.smilebrilliant.com/wp-content/themes/revolution-child/assets/css/dashboardStyles.css?ver=1666181554">
<style>
	#item-header.users-header.single-headers,  nav#object-nav, nav#subnav {
    display: none !important;
}
</style>
<script>
	$( document ).ajaxComplete(function( event, xhr, settings ) {
  console.log(settings.data);
  if(settings.data.includes("action=bp_avatar_set")) {
	window.location.href = '/my-account/edit-account/';
  }
});
</script>
<div class="row sidebarNavigationBuddyPress">
				<div class="small-12 columns">
					<div class="post-content no-vc">
<div class="flexDesktop">
<div class="sideBarNavigationList ">
<?php

require_once(get_stylesheet_directory().'/woocommerce/myaccount/navigation.php'); ?>
			     </div>
			<div class="myAccountContainerMbtInner">
<h2 class="screen-heading change-avatar-screen"><?php esc_html_e( 'Change Profile Photo', 'buddypress' ); ?></h2>

<?php //bp_nouveau_member_hook( 'before', 'avatar_upload_content' ); ?>

<?php if ( ! (int) bp_get_option( 'bp-disable-avatar-uploads' ) ) : ?>

	<p class="bp-feedback info">
		<span class="bp-icon" aria-hidden="true"></span>
		<span class="bp-help-text">
			<?php
			/* Translators: %s is used to output the link to the Gravatar site */
			printf( esc_html__( 'Your profile photo will be used on your profile and throughout the site. If there is a %s associated with your account email we will use that, or you can upload an image from your computer.', 'buddypress' ),
				/* Translators: Url to the Gravatar site, you can use the one for your country eg: https://fr.gravatar.com for French translation */
				'<a href="' . esc_url( __( 'https://gravatar.com', 'buddypress' ) ) . '">Gravatar</a>'
			); ?>
		</span>
	</p>


	<div class="custom-added-tabs hidden-mobile">
		<ul class="nav nav-tabs  mt-3 customTabs tabsDesktop">
			<li class="nav-item">
				<a class="uppercase  nav-link  ripple-button rippleSlowAnimate" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Contact</a>
			</li>
			<li class="nav-item">
				<a class="uppercase nav-link ripple-button rippleSlowAnimate" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Social</a>
			</li>
			<!-- <li class="nav-item">
				<a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Oral</a>
			</li> -->
			<li class="nav-item">
				<a class="nav-link uppercase ripple-button rippleSlowAnimate" id="pills-password-tab" data-toggle="pill" href="#pills-password" role="tab" aria-controls="pills-password" aria-selected="false">Change password</a>
			</li>
			<li class="nav-item">
				<a class="nav-link uppercase ripple-button rippleSlowAnimate active" id="pills-uploadPhoto-tab"  href="/members/<?php echo bp_core_get_username(get_current_user_id());?>/profile/change-avatar" role="tab" aria-controls="" >Upload Photo</a>
			</li>
		

		</ul>
	</div>

<div class="uploadPhotoSec">
		<div class="uploadProfileTopSec">
			<div class="profilePhoto">

            <div class="profile-image-avatar">
                <img src="<?php echo esc_url( get_avatar_url(get_current_user_id()) ); ?>" class="avatar img-circle img-thumbnail" alt="avatar">

            </div>

			</div>


			<form action="" method="post" id="avatar-upload-form" class="standard-form" enctype="multipart/form-data">

				<?php if ( 'upload-image' === bp_get_avatar_admin_step() ) : ?>

					<?php wp_nonce_field( 'bp_avatar_upload' ); ?>
					<p class="bp-help-text"><?php esc_html_e( "Click below to select a JPG, GIF or PNG format photo from your computer and then click 'Upload Image' to proceed.", 'buddypress' ); ?></p>

					<p id="avatar-upload">
						<label for="file" class="bp-screen-reader-text"><?php esc_html_e( 'Select an image', 'buddypress' ); ?></label>
						<input type="file" name="file" id="file" />
						<input type="submit" name="upload" id="upload" value="<?php esc_attr_e( 'Upload Image', 'buddypress' ); ?>" />
						<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
					</p>

					<?php if ( bp_get_user_has_avatar() ) : ?>
						<p class="bp-help-text"><?php esc_html_e( "If you'd like to delete your current profile photo, use the delete profile photo button.", 'buddypress' ); ?></p>
						<p><a class="button edit" href="<?php bp_avatar_delete_link(); ?>"><?php esc_html_e( 'Delete My Profile Photo', 'buddypress' ); ?></a></p>
					<?php endif; ?>

				<?php endif; ?>

				<?php if ( 'crop-image' === bp_get_avatar_admin_step() ) : ?>

					<p class="bp-help-text screen-header"><?php esc_html_e( 'Crop Your New Profile Photo', 'buddypress' ); ?></p>

					<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e( 'Profile photo to crop', 'buddypress' ); ?>" />

					<div id="avatar-crop-pane" class="kkk">
						<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e( 'Profile photo preview', 'buddypress' ); ?>" />
					</div>

					<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e( 'Crop Image', 'buddypress' ); ?>" />

					<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />

					<?php wp_nonce_field( 'bp_avatar_cropstore' ); ?>

				<?php endif; ?>

			</form>

			</div>

	<?php
	/**
	 * Load the Avatar UI templates
	 *
	 * @since 2.3.0
	 */
	bp_avatar_get_templates();
	?>

<?php else : ?>

	<p class="bp-help-text">
		<?php
		/* Translators: %s is used to output the link to the Gravatar site */
		printf( esc_html__( 'Your profile photo will be used on your profile and throughout the site. To change your profile photo, create an account with %s using the same email address as you used to register with this site.', 'buddypress' ),
			/* Translators: Url to the Gravatar site, you can use the one for your country eg: https://fr.gravatar.com for French translation */
			'<a href="' . esc_url( __( 'https://gravatar.com', 'buddypress' ) ) . '">Gravatar</a>'
		); ?>
	</p>

<?php endif; ?>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
<?php
//bp_nouveau_member_hook( 'after', 'avatar_upload_content' );
