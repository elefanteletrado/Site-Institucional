<?php
function cupid_custom_css() {
    $cupid_data = of_get_options();
    $custom_css = '';

    /* body tag style*/
    $background_image = '';
    if ($cupid_data['use-bg-image'] == '1' && $cupid_data['layout-style'] == 'boxed')
    {
        $background_image_url = '';
        if (isset($cupid_data['bg-pattern-upload']) && $cupid_data['bg-pattern-upload'] != '')
        {
            $background_image_url = $cupid_data['bg-pattern-upload'];
        }
        else if (isset($cupid_data['bg-pattern']) && $cupid_data['bg-pattern'] != '')
        {
            $background_image_url = $cupid_data['bg-pattern'];
        }
        if ($background_image_url != '')
        {
            $background_image .= 'background-image: url("'. $background_image_url .'");';
            $background_image .= 'background-repeat: '. $cupid_data['bg-repeat'] .';';
            $background_image .= 'background-position: '. $cupid_data['bg-position'] .';';
            $background_image .= 'background-attachment: '. $cupid_data['bg-attachment'] .';';
            $background_image .= 'background-size: '. $cupid_data['bg-size'] .';';
        }
    }
    /*end body tag style*/


    $custom_css .='body{font-family:' . $cupid_data['body-font']['face'] . '; font-size: ' . $cupid_data['body-font']['size'] . ';font-weight:' .$cupid_data['body-font']['weight'] . ';'. $background_image . '}';


    if (!empty($cupid_data['heading-font']['face']) &&  $cupid_data['heading-font']['face'] != 'none')
    {
        $custom_css .= 'h1,h2,h3,h4,h5,h6{font-family: '. $cupid_data['heading-font']['face'] .';}';
    }

    if (!empty($cupid_data['h1-font']['face']) && $cupid_data['h1-font']['face'] != 'none')
    {
        $custom_css .= 'h1{font-family: '. $cupid_data['h1-font']['face'] .';font-size: '. $cupid_data['h1-font']['size'] .';font-style: '. $cupid_data['h1-font']['style'] .';font-weight: '. $cupid_data['h1-font']['weight'] .';text-transform: '. $cupid_data['h1-font']['text-transform'] .';}';
    }
    else
    {
        $custom_css .= 'h1{font-size: '. $cupid_data['h1-font']['size'] .';font-style: '. $cupid_data['h1-font']['style'] .';font-weight: '. $cupid_data['h1-font']['weight'] .';text-transform: '. $cupid_data['h1-font']['text-transform'] .';}';
    }

    if (!empty($cupid_data['h2-font']['face']) && $cupid_data['h2-font']['face'] != 'none')
    {
        $custom_css .= 'h2{font-family: '. $cupid_data['h2-font']['face'] .';font-size: '. $cupid_data['h2-font']['size'] .';font-style: '. $cupid_data['h2-font']['style'] .';font-weight: '. $cupid_data['h2-font']['weight'] .';text-transform: '. $cupid_data['h2-font']['text-transform'] .';}';
    }
    else
    {
        $custom_css .= 'h2{font-size: '. $cupid_data['h2-font']['size'] .';font-style: '. $cupid_data['h2-font']['style'] .';font-weight: '. $cupid_data['h2-font']['weight'] .';text-transform: '. $cupid_data['h2-font']['text-transform'] .';}';
    }

    if (!empty($cupid_data['h3-font']['face']) && $cupid_data['h3-font']['face'] != 'none')
    {
        $custom_css .= 'h3{font-family: '. $cupid_data['h3-font']['face'] .';font-size: '. $cupid_data['h3-font']['size'] .';font-style: '. $cupid_data['h3-font']['style'] .';font-weight: '. $cupid_data['h3-font']['weight'] .';text-transform: '. $cupid_data['h3-font']['text-transform'] .';}';
    }
    else
    {
        $custom_css .= 'h3{font-size: '. $cupid_data['h3-font']['size'] .';font-style: '. $cupid_data['h3-font']['style'] .';font-weight: '. $cupid_data['h3-font']['weight'] .';text-transform: '. $cupid_data['h3-font']['text-transform'] .';}';
    }

    if (!empty($cupid_data['h4-font']['face']) && $cupid_data['h4-font']['face'] != 'none')
    {
        $custom_css .= 'h4{font-family: '. $cupid_data['h4-font']['face'] .';font-size: '. $cupid_data['h4-font']['size'] .';font-style: '. $cupid_data['h4-font']['style'] .';font-weight: '. $cupid_data['h4-font']['weight'] .';text-transform: '. $cupid_data['h4-font']['text-transform'] .';}';
    }
    else
    {
        $custom_css .= 'h4{font-size: '. $cupid_data['h4-font']['size'] .';font-style: '. $cupid_data['h4-font']['style'] .';font-weight: '. $cupid_data['h4-font']['weight'] .';text-transform: '. $cupid_data['h4-font']['text-transform'] .';}';
    }

    if (!empty($cupid_data['h5-font']['face']) && $cupid_data['h5-font']['face'] != 'none')
    {
        $custom_css .= 'h5{font-family: '. $cupid_data['h5-font']['face'] .';font-size: '. $cupid_data['h5-font']['size'] .';font-style: '. $cupid_data['h5-font']['style'] .';font-weight: '. $cupid_data['h5-font']['weight'] .';text-transform: '. $cupid_data['h5-font']['text-transform'] .';}';
    }
    else
    {
        $custom_css .= 'h5{font-size: '. $cupid_data['h5-font']['size'] .';font-style: '. $cupid_data['h5-font']['style'] .';font-weight: '. $cupid_data['h5-font']['weight'] .';text-transform: '. $cupid_data['h5-font']['text-transform'] .';}';
    }

    if (!empty($cupid_data['h6-font']['face']) && $cupid_data['h6-font']['face'] != 'none')
    {
        $custom_css .= 'h6{font-family: '. $cupid_data['h6-font']['face'] .';font-size: '. $cupid_data['h6-font']['size'] .';font-style: '. $cupid_data['h6-font']['style'] .';font-weight: '. $cupid_data['h6-font']['weight'] .';text-transform: '. $cupid_data['h6-font']['text-transform'] .';}';
    }
    else
    {
        $custom_css .= 'h6{font-size: '. $cupid_data['h6-font']['size'] .';font-style: '. $cupid_data['h6-font']['style'] .';font-weight: '. $cupid_data['h6-font']['weight'] .';text-transform: '. $cupid_data['h6-font']['text-transform'] .';}';
    }




	$custom_css .=  $cupid_data['css-custom'] ;
	// Remove all newline & tab characters
	$custom_css = str_replace( "\r\n", '', $custom_css );
	$custom_css = str_replace( "\n", '', $custom_css );
	$custom_css = str_replace( "\t", '', $custom_css );
	return $custom_css;
}