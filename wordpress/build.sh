#!/usr/bin/env bash
# Package the theme and plugin as WordPress-uploadable zips in release/.
set -euo pipefail
cd "$(dirname "$0")"
mkdir -p release
rm -f release/elite-carpentry.zip release/elite-carpentry-core.zip
zip -rq release/elite-carpentry.zip elite-carpentry -x '*.DS_Store'
zip -rq release/elite-carpentry-core.zip elite-carpentry-core -x '*.DS_Store'
ls -lh release
