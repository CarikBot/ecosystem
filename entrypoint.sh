#!/usr/bin/env bash

set -eu

NC='\033[0m' # No Color
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'

CHECK_MODIFIED_FILES="$6"

echo "modified file: "$CHECK_MODIFIED_FILES
git config --global --add safe.directory /github/workspace
git config --global --add safe.directory $(pwd)
