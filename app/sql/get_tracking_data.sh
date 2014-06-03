#!/bin/sh -x

FILE="tracking_data-$(date +%Y-%m-%d).sql";

mysqldump -u harmony_main -h 67.59.151.236 -p harmony_main tracking_requests > $FILE
