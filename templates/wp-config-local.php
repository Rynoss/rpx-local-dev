<?php
/**
 * Local-only WordPress constants. Edit freely.
 *
 * Loaded by wp-config.php on every request. Lives at .ddev/wp-config-local.php
 * on host (gitignored). Constants set here win because PHP define() is no-op
 * if the constant is already set.
 *
 * Survives `ddev restart` and `ddev rpx-init`.
 */

// Debug
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
define('SAVEQUERIES', false);

// Add custom constants below
