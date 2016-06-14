<?php

/*  Copyright (C) 2012 Drew Phillips  (http://phpcaptcha.org/download/securimage-wp.zip)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once dirname(__FILE__) . '/securimage.php';

$captchaId = (isset($_GET['id']) && strlen($_GET['id']) == 40) ?
             $_GET['id'] :
             sha1(uniqid($_SERVER['REMOTE_ADDR'] . $_SERVER['REMOTE_PORT']));

$options = array(
    'captchaId' => $captchaId,
    'no_session' => true,
    'use_database' => false,
    'send_headers' => false,
    'no_exit'      => true,
);

$img = new Securimage($options);

set_error_handler(array(&$img, 'errorHandler')); // set this early, WP omits a lot of warnings and errors

require_once dirname(__FILE__) . '/../../../../wp-load.php'; // backwards "lib/securimage-wp/plugins/wp-content/"

if (get_option('siwp_disable_audio', 0) == 1) {
    exit;
}

$audio_lang = get_option('siwp_audio_lang', 'en');

$result = siwp_get_code_from_database($captchaId);
$audio  = null;

if ($result == null) {
    $code = siwp_generate_code($captchaId, $img);

    $code_display = $code['display'];
} else {
    $code_display = $result->code_display;
    $audio        = siwp_get_audio_from_database($captchaId);
}

$img->display_value = $code_display;

$img->audio_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'audio' . DIRECTORY_SEPARATOR . $audio_lang;

// mp3 or wav format
$format   = (isset($_GET['format']) && strtolower($_GET['format']) == 'mp3') ? 'mp3' : null;
$lame_bin = get_option('siwp_lame_binary_path', siwp_find_lame_binary());

if ($format == 'mp3' && (empty($lame_bin) || !is_executable($lame_bin))) {
    $format = 'wav';
}

if ($audio === null) {
    ob_start();
    $img->outputAudioFile($format);
    $audio = ob_get_contents();
    ob_end_clean();
    siwp_save_audio_to_database($captchaId, $audio);
}

$type = (substr($audio, 0, 4) == 'RIFF') ? 'audio/wav' : 'audio/mpeg';

header('Accept-Ranges: bytes');
header("Content-Disposition: attachment; filename=\"securimage_audio-{$captchaId}.{$format}\"");
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Expires: Sun, 1 Jan 2000 12:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Content-type: ' . $type);

$img->rangeDownload($audio);
