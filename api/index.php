<?php

// Vercel serverless entrypoint.
// Memetakan request ke public/index.php Laravel dengan storage di /tmp (writeable).

// Pastikan storage temporer Laravel ditulis ke /tmp (filesystem writeable di Vercel).
if (! is_dir('/tmp/views')) {
    @mkdir('/tmp/views', 0777, true);
}
if (! is_dir('/tmp/cache/data')) {
    @mkdir('/tmp/cache/data', 0777, true);
}
if (! is_dir('/tmp/sessions')) {
    @mkdir('/tmp/sessions', 0777, true);
}
if (! is_dir('/tmp/logs')) {
    @mkdir('/tmp/logs', 0777, true);
}

putenv('VIEW_COMPILED_PATH=/tmp/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';

require __DIR__ . '/../public/index.php';
