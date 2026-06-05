#!/bin/zsh
# wp-cli wrapper cho site Local "nghikigai" — tự dò siteID/socket nên không vỡ khi Local cấp lại port.
SITE_NAME="nghikigai"
LOCAL_SUPPORT="$HOME/Library/Application Support/Local"
SITES_JSON="$LOCAL_SUPPORT/sites.json"
PHP="$LOCAL_SUPPORT/lightning-services/php-8.2.29+0/bin/darwin-arm64/bin/php"
WPCLI="/Applications/Local.app/Contents/Resources/extraResources/bin/wp-cli/wp-cli.phar"
SITE_PUBLIC="$HOME/Local Sites/$SITE_NAME/app/public"

SITE_ID=$(/usr/bin/python3 -c "import json,os,sys; d=json.load(open(os.path.expanduser('$SITES_JSON'))); print(next((k for k,v in d.items() if v['name']=='$SITE_NAME'),''))")
if [ -z "$SITE_ID" ]; then echo "Khong tim thay site '$SITE_NAME' trong Local"; exit 1; fi
SOCK="$LOCAL_SUPPORT/run/$SITE_ID/mysql/mysqld.sock"
if [ ! -S "$SOCK" ]; then echo "Site '$SITE_NAME' chua chay (khong co socket $SOCK). Mo Local va Start site."; exit 1; fi

"$PHP" -d mysqli.default_socket="$SOCK" -d pdo_mysql.default_socket="$SOCK" -d memory_limit=512M \
  "$WPCLI" --path="$SITE_PUBLIC" "$@"
