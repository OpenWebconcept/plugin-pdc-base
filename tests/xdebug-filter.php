<?php

declare(strict_types=1);
if (! \function_exists('xdebug_set_filter')) {
    return;
}

\xdebug_set_filter(
    \XDEBUG_FILTER_CODE_COVERAGE,
    \XDEBUG_PATH_WHITELIST,
    [
        '/app/htdocs/wp-content/plugins/pdc-base/src/Base/'
    ]
);
