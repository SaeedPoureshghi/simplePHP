<?php

function set_token() {
    $token = hash_hmac('sha1', time(), time());
    $_SESSION['_token'] = $token;
  }
  
  function insert_token()  {
    echo '<input type="hidden" name="_token" id="_token" value="'.$_SESSION['_token'].'">';
  }
  
function hash_pass($pass){
    return hash_hmac('sha256',$pass,$pass.'ozone_pass');
  }

  function show_date() {
    $date=date_create();
    echo date_format($date,"l, F j");
  }

  function show_date_time() {
    $date=date_create();
    echo date_format($date,"M j,H:i");
  }

  function Post($url,$fields) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $fields,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
        
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response,true);
  }

  function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);

    if ($ago > $now) {
      $postfix = "remain";
    }else{
      $postfix = "ago";
    }
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' '.$postfix : 'just now';
}

 
  ?>