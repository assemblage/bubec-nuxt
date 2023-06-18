#!/bin/bash

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
PARENT_DIR="$PWD"

cd "$SCRIPT_DIR"

. ./wp-theme.config

# rsync upload & sync between the local folder and the server
rsync -avr --progress --include-from="$SCRIPT_DIR/${include_file_path}" --exclude-from="$SCRIPT_DIR/${exclude_file_path}"  --rsh=ssh "$PARENT_DIR/$theme_folder_path/" user@ssh.wellnessfood.savana-hosting.cz:"${stage_server_domain_path}/${project_folder_stage}/www/wp-content/themes/$wp_theme_folder_path"


