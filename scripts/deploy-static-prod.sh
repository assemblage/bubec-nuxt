#!/bin/bash

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
PARENT_DIR="$PWD"

cd "$SCRIPT_DIR"

. ./script.config

# rsync upload & sync between the local folder and the server
rsync -avr --progress --include-from="$SCRIPT_DIR/${include_file_path}" --exclude-from="$SCRIPT_DIR/${exclude_file_path}"  --rsh=ssh "$PARENT_DIR/dist/" user@ssh.wellnessfood.savana-hosting.cz:"${prod_server_domain_path}/${prod_domain}"


