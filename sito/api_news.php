<?php

$queryString = http_build_query([
'access_key' => '447038df7003d21b79e110e925a8568d',
'keywords' => 'palestra-palestre-Catania-Covid',
'languages' => 'it',
'limit' => '21',
]);

$curl = curl_init(sprintf('%s?%s','http://api.mediastack.com/v1/news', $queryString));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($curl);
curl_close($curl);
echo($json);


?>