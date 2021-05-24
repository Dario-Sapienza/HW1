<?php

$queryString = http_build_query([
'key' => '21218063-0071ff8a98ffb5ef1f88d9110',
'q' => 'workout',
'per_page' => '100',
]);

$curl = curl_init(sprintf('%s?%s','https://pixabay.com/api/', $queryString));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($curl);
curl_close($curl);
echo($json);


?>