<?php
//////////////////////////////////////////////////////////////////////////
//
//  Note: This demo is being hosted on Hostgator
//  Hostgator uses Central Standard Time (CST), except where the United States
//  recognizes Daylight savings time. Consequently, the 'e' (the timezone identifier)
//  used in the format string below will output as America/Chicago. It will output
//  differently depending on the server used. However, it will remain consistent relative to GMT.
//
//////////////////////////////////////////////////////////////////////////


/* =============================================================================
                              create_lists()
============================================================================= */


function create_lists($data){
  $area_is_1_list      = '<ul class="area_is_1_list">';
  $area_is_not_1_list  = '<ul class="area_is_not_1_list">';
  $area_is_not_1_array = [];


  /* ================================
       Append to $area_is_1_list
  ================================ */


  foreach ($data as $unit){
    if ($unit->area == 1){
      $area_is_1_list .= '<li>' .
                         '<span><strong>Unit #:</strong> ' . $unit->unit_number . '</span>' .
                         '<span><strong>Area:</strong> '        . $unit->area        . '</span>' .
                         '<span><strong>Updated at:</strong> '  . date('l F d, Y \a\t h:i a e', strtotime($unit->updated_at)) . '</span></li>';
    } elseif ($unit->area > 1) {
      array_push($area_is_not_1_array, $unit);
    }
  }
  $area_is_1_list .= '</ul>';


  /* ================================
     Append to $area_is_not_1_list
  ================================ */


  foreach ($area_is_not_1_array as $unit){
    $area_is_not_1_list .= '<li>' .
                           '<span><strong>Unit #:</strong> ' . $unit->unit_number . '</span>' .
                           '<span><strong>Area:</strong> '   . $unit->area        . '</span>' .
                           '<span><strong>Updated at:</strong> '  . date('l F d, Y \a\t h:i a e', strtotime($unit->updated_at)) . '</span></li>';
  }
  $area_is_not_1_list .= '</ul>';


  /* ================================
        Return an array of lists
  ================================ */


  $lists_array = array(
    "area_is_1_list"     => $area_is_1_list,
    "area_is_not_1_list" => $area_is_not_1_list
  );

  return $lists_array;
}


/* =============================================================================
                              cURL session
============================================================================= */


$api_end_point_url = 'https://api.sightmap.com/v1/assets/1273/multifamily/units?per-page=100';
$api_key           = '7d64ca3869544c469c3e7a586921ba37';
$ch                = curl_init();


curl_setopt($ch, CURLOPT_URL, $api_end_point_url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //???
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //???
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $api_key));
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);


$data = curl_exec($ch);


/* ================================
Check that curl_exec($ch) was successful
================================ */


if( curl_errno($ch) ){
  //No connection results in: Request Error:Couldn't resolve host 'api.sightmap.com'
  $curl_err = '<span>Request Error: ' . curl_error($ch) . '</span>';
} else {
  $data = json_decode($data);


  /* ================================
    Verify that $data is type object
  ================================ */


  //////////////////////////////////////////////////////////////////////////////
  //
  //  A very basic check to verify that $data references an object.
  //  If it doesn't reference an object, then we know SOMETHING went wrong,
  //  and should not proceed with create_list().
  //  We can sneak in error messages by using the $lists array identifier
  //  (and corresponding list element identifiers), which the UI expects.
  //
  //  Rather than populating the array with actual lists, we can create error messages.
  //
  //////////////////////////////////////////////////////////////////////////////


  if ( gettype($data) != 'object'){
    $lists = array(
      "area_is_1_list"     => '<p class="data_err">Whoops! Something went wrong!<span>Unable to Access the List</span></p>',
      "area_is_not_1_list" => '<p class="data_err">Whoops! Something went wrong!<span>Unable to Access the List</span></p>'
    );
  } else {
    $data = $data->data;
    //Pass $data to create_lists
    $lists = create_lists($data);
  }
}

curl_close($ch);
?>
