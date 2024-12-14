<?php

wp_logout();
$redirect_url = site_url('my-account');
wp_safe_redirect($redirect_url);
