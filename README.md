# Yourls bundle

Yourls integration for Mautic.

Yourls Homepage: https://yourls.org/

Note: this plugin require Mautic 5.0.0 

## Installation

By composer 

```
composer require vinzent/mautic-yourls-bundle
php ./bin/console mautic:plugins:reload
php ./bin/console cache:clear
```

## Setup

1. Get secret access token from https://yourlsite/admin/tools.php
2. Verify your API URL: https://yourlssite/yourls-api.php (should get you a "Please login" message)
3. Enable plugin on https://yourmauticsite/s/plugins

## Usage

At the moment If you enable shortener service, automatically all links in sms are shortened by Yourls. 
