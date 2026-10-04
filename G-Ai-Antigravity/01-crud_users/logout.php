<?php
/**
 * User Logout Handler
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/auth.php';

logout_user();

set_flash('info', 'You have been logged out successfully.');
redirect('login.php');
