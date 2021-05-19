<?php

define('REGEX_NUMBERS', '/[0-9]+/');
define('REGEX_FLOATS', '/[-+]?[0-9]+(\.[0-9]+)?([eE][-+]?[0-9]+)?/');
define('REGEX_BOOL', '/true|false|0|1/');
define('REGEX_CP', '/([A-Z]+[A-Z]?\-)?[0-9]{1,2} ?[0-9]{3}/');
define('REGEX_PHONE', '/(01|02|03|04|05|06|07|08|09)[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}/');
define('REGEX_EMAIL', '/[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})/');
define('REGEX_IP', '/(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/');
