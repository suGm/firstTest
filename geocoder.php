<?php

include '/usr/local/software/MFFC/vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$geocoder = new \Geocoder\ProviderAggregator();

$geocoder->registerProviders([
    new \Geocoder\Provider\GoogleMaps(
        $adapter, $locale, $region, $useSsl
    ),
    new \Geocoder\Provider\GoogleMapsBusiness(
        $adapter, '<CLIENT_ID>', '<PRIVATE_KEY>', $locale, $region, $useSsl
    ),
    new \Geocoder\Provider\Yandex(
        $adapter, $locale, $toponym
    ),
    new \Geocoder\Provider\MaxMind(
        $adapter, '<MAXMIND_API_KEY>', $service, $useSsl
    ),
    new \Geocoder\Provider\ArcGISOnline(
        $adapter, $sourceCountry, $useSsl
    ),
]);

// $geocoder->registerProvider(
//     new \Geocoder\Provider\Nominatim(
//         $adapter, 'http://your.nominatim.server', $locale
//     )
// );

// $geocoder
//     ->using('google_maps')
//     ->geocode('...');

// $geocoder
//     ->limit(10)
//     ->reverse($lat, $lng);