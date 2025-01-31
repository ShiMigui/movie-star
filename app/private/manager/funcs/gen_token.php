<?php
/**
 * Generates a token with double of the length provided.
 * @param int $midLength The length of the token.
 * @return string The generated token.
 */
function gen_token($midLength = 30): string {
    return bin2hex(random_bytes($midLength));
}