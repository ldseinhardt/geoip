#!/bin/bash

DIR=$(dirname $0)

FILENAME="GeoLite2-City"

wget "http://geolite.maxmind.com/download/geoip/database/$FILENAME.tar.gz" -P $DIR

tar -zxvf "$DIR/$FILENAME.tar.gz" --no-anchored "$FILENAME.mmdb" -O > "$DIR/$FILENAME.mmdb"
