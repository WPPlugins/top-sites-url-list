<?php


function tsul_get_config() {
    // See https://developers.google.com/identity/protocols/OAuth2InstalledApp#formingtheurl for more details about these fields.
    $config = array(
        'application_name' => 'TOP Sites URL list',
        'client_id'        => '946205211738-gdoqvbr67jtd4dtbdiiolpspju9okuta.apps.googleusercontent.com',
        'client_secret'    => 'HN4FqJ_9x0kq8Yk-L6B2qjcl',
        'redirect_uri'     => 'urn:ietf:wg:oauth:2.0:oob',
        'scopes'           => 'https://www.googleapis.com/auth/analytics.readonly'
    );

	return $config;
}


function tsul_get_option_page_url ( $echo = true ) {
	$url = 'options-general.php?page=tsul_settings_page';

	if ( $echo ) {
		echo $url;
	} else {
		return $url;
	}
}


function tsul_get_post_types () {
	$builtin_types = array('post', 'page');

	$custom_post_types_args = array(
		'public'   => true,
		'_builtin' => false
	);

	$custom_post_types = get_post_types($custom_post_types_args);

	if ( is_array($custom_post_types) ) {
		asort($custom_post_types);
		$post_types = array_merge($builtin_types, $custom_post_types);
	} else {
		$post_types = $builtin_types;
	}

	return $post_types;
}





if( !function_exists('eko') ){
	function _eko ($vInput, $level = 0, $depth = 0) {
		$tmp = _fancy_vardump ( $vInput, $level, $depth);
		echo $tmp;
	}
}



if( !function_exists('fancy_vardump') ){
	function _fancy_vardump ($vInput, $level = 0, $depth = 0) {

		$bgs = array ('#DDDDDD', '#C4F0FF', '#BDE9FF', '#FFF1CA');
		$bg = &$bgs[$depth % sizeof($bgs)];
		$font_size = "12";
		$s = "<table border='0' cellpadding='4' cellspacing='0' style='font-size: ".$font_size."px;'><tr><td style='background: none $bg;font-size: ".$font_size."px; text-align: left; ";
		if (is_int($vInput)) {
			$s .= "'>";
			$s .= sprintf('int (<b>%d</b>)', intval($vInput));
		} else if (is_float($vInput)) {
			$s .= "'>";
			$s .= sprintf('float (<b>%f</b>)', doubleval($vInput));
		} else if (is_string($vInput)) {
			$s .= "'>";
			$s .= sprintf('string[%d] (<b>"%s"</b>)', strlen($vInput),$vInput);
		} else if (is_bool($vInput)) {
			$s .= "'>";
			$s .= sprintf('bool (<b>%s</b>)', ($vInput === true ? 'true' : 'false'));
		} else if (is_resource($vInput)) {
			$s .= "'>";
			$s .= sprintf('resource (<b>%s</b>)', get_resource_type($vInput));
		} else if (is_null($vInput)) {
			$s .= "'>";
			$s .= sprintf('null');
		} else if (is_array($vInput)) {
			$s .= "'>";
			$s .= sprintf('array[%d]', count($vInput));
			$s .= "</td></tr>";
			if ($level == 0 || $depth < $level) {
				$s .= "<tr><td style='background: none $bg; text-align: left; border-top: solid 2px black;font-size: ".$font_size."px;'>";
				$s .= "<table border='0' cellpadding='4' cellspacing='0' style='font-size: ".$font_size."px;'>";
				foreach ($vInput as $vKey => $vVal) {
					$s .= '<tr>';
					$s .= "<td style='background-color: $bg; text-align: left;font-size: ".$font_size."px;'>".
					sprintf('<b>%s%s%s</b>', ((is_int($vKey)) ? '' : '"'), $vKey, ((is_int($vKey)) ? '' : '"')).
					'</td>';
					$s .= "<td style='background-color: $bg; text-align: left;font-size: ".$font_size."px;'>=></td>";
					$s .= "<td style='background-color: $bg; text-align: left;font-size: ".$font_size."px;'>" .
					fancy_vardump($vVal, $level, $depth+1) .
					'</td>';
					$s .= '</tr>';
				}
				$s .= '</table>';
			}
		} else if (is_object($vInput)) {
			$s .= "'>";
			$s .= sprintf('object (<b>%s</b>)', get_class($vInput));
			$s .= "</td></tr>";
			if ($level == 0 || $depth < $level) {
				$s .= "<tr><td style='background: none $bg; text-align: left; border-top: solid 2px black;font-size: ".$font_size."px;'>";
				$s .= "<table border='0' cellpadding='4' cellspacing='0' style='font-size: ".$font_size."px;'>";
				foreach (get_object_vars($vInput) as $vKey => $vVal) {
					$s .= '<tr>';
					$s .= "<td style='background-color: $bg; text-align: left;font-size: ".$font_size."px;'>" .
					sprintf('<b>%s%s%s</b>', ((is_int($vKey)) ? '' : '"'), $vKey, ((is_int($vKey)) ? '' : '"')) .
					'</td>';
					$s .= "<td style='background-color: $bg; text-align: left;font-size: ".$font_size."px;'>=></td>";
					$s .= "<td style='background-color: $bg; text-align: left;font-size: ".$font_size."px;'>" .
					fancy_vardump($vVal, $level, $depth+1) .
					'</td>';
					$s .= '</tr>';
				}
				$s .= '</table>';
			}
		} else {
			$s .= "'>";
			$s .= sprintf('<b>unhandled (gettype() reports "%s")', gettype($vInput));
		}
		$s .= '</td></tr></table><br>';

		return $s;
	}
}
