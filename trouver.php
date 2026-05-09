<?php

function RequeteAPI(string $url)
{
  $curl = curl_init();
  curl_setopt_array($curl, [
    CURLOPT_URL => "$url",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",]);
  $response = curl_exec($curl);
  $err = curl_error($curl);

  if ($err) 
  {
    echo "cURL Error #:" . $err;
  } 
  else 
  {
    $tableau = json_decode($response, true);
    return $tableau;
  }
}

$urlPoke = "https://pokeapi.co/api/v2/pokemon/123";
$tabPoke = RequeteAPI($urlPoke);

$urlAbility = $tabPoke['abilities'][0]['ability']['url'];
$tabAbility = RequeteAPI($urlAbility);

var_dump($tabAbility);

foreach ($tabPoke['abilities'] as $key => $value) {
  echo $value['ability'] . "<br>";
}

?>
