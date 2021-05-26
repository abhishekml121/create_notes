<?php
function fibo_post( $atts = array(), $content = null ) {

    // set up default parameters
    extract(shortcode_atts(array(
        'length' => '0'
       ), $atts));
    
    return "
        <form id='foo'>
            <label for='bar'>" + Fibonacci($length); + "</label>
            <input id='bar' name='bar' type='number' value='2' />
            <input type='submit' value='Send' />
        </form>";
}

// PHP code to get the Fibonacci series 
function Fibonacci($n){ 
  
    $num1 = 0; 
    $num2 = 1;
    $arr = array();
  
    $counter = 0; 
    while ($counter < $n){ 
        echo ' '.$num1;
        $num3 = $num2 + $num1; 
        $num1 = $num2; 
        $num2 = $num3; 
        $counter = $counter + 1;
    }
} 
?>