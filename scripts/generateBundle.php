#!/usr/bin/php
<?php

include __DIR__ . '/../vendor/autoload.php';

$success = My\Project\TextFormatter\BundleConfigurator::saveBundle();

die($success ? "All done.\n" : "An error occurred.\n");
