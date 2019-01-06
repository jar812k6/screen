#!/bin/bash
#
NAME=$1
TIME=$2
#
for p in $(pidof $NAME)
do
UPTIME_PR=$(ps -p "$p" -o etime | tail -n 1|sed -e 's/^[ \t]//' | awk -F: '{print $160+$2}')
PID=$(ps -p "$p" -o pid | tail -n 1 | sed -e 's/^[ \t]*//')
if [ "$UPTIME_PR" -ge "$TIME" ]
then
kill -9 $p
fi
done

