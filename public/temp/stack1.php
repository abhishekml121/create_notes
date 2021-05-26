<?php
/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

echo '<h2>monsterid</h2>';
echo get_gravatar('bbcarljohnson2@gmail.com23',$s = 80, $d = 'monsterid', $r = 'g', $img = true);


echo '<h2>identicon</h2>';
echo get_gravatar('bbcarljohnson2@gmail.com23',$s = 80, $d = 'identicon', $r = 'g', $img = true);


echo '<h2>wavatar</h2>';
echo get_gravatar('bbcarljohnson2@gmail.com23',$s = 80, $d = 'wavatar', $r = 'g', $img = true);


echo '<h2>mp</h2>';
echo get_gravatar('abhishek',$s = 80, $d = 'mp', $r = 'g', $img = true);
echo get_gravatar('abhishek1',$s = 80, $d = 'mp', $r = 'g', $img = true);
echo get_gravatar('abhishek2',$s = 80, $d = 'mp', $r = 'g', $img = true);
echo get_gravatar('abhisheK3',$s = 80, $d = 'mp', $r = 'g', $img = true);

echo '<h2>404</h2>';
echo get_gravatar('abhishek',$s = 80, $d = '404', $r = 'g', $img = true);
echo get_gravatar('abhishek1',$s = 80, $d = '404', $r = 'g', $img = true);
echo get_gravatar('abhishek2',$s = 80, $d = '404', $r = 'g', $img = true);
echo get_gravatar('abhisheK3',$s = 80, $d = '404', $r = 'g', $img = true);

?>