<?php

/**
 * Mailing functions
 *
 * @package bramble
 */

function mailtrap($phpmailer) {
  $phpmailer->isSMTP();
  $phpmailer->Host = 'smtp.mailtrap.io';
  $phpmailer->SMTPAuth = true;
  $phpmailer->Port = 2525;
  $phpmailer->Username = 'Your USERNAME';
  $phpmailer->Password = 'your PW';
}
add_action( 'phpmailer_init', 'mailtrap' );
