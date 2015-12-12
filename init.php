<?php

namespace Bolt\Extension\OnlineSid\UIBoostrapCarousel;

if (isset($app)) {
    $app['extensions']->register(new Extension($app));
}

