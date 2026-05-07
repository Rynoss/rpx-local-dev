<?php
/**
 * Fix WordPress port 443 redirect in GitHub Codespaces.
 * Reads the correct host from the Codespaces proxy headers.
 * Has no effect when running locally (header is not present).
 */
if (isset($_SERVER["HTTP_X_FORWARDED_HOST"])) {
    $_SERVER["HTTP_HOST"] = $_SERVER["HTTP_X_FORWARDED_HOST"];
}
