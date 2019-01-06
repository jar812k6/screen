#!/bin/bash

## Process name to be killed
proc_name=phantomjs

[ -n "$1" ] && proc_name=$1

## Max execution time before process is considered stuck and eligible to be killed
max_time=300

[ -n "$2" ] && max_time=$2

pids=$(pgrep $proc_name)

for pid in $pids
do

# elapsed=$(ps -p $pid -o etime | tail -1 | tr ':' ' ')

elapsed=$(ps -p $pid -o etime= | tr '-' ':' | awk -F: '{ total=0; m=1; }
{ for (i=0; i < NF; i++) {total += $(NF-i)*m; m *= i >= 2 ? 24 : 60 }}
{print total}' )

if (( $elapsed > $max_time ))
then
kill $pid >/dev/null 2>&1 # Attempt softkill first
sleep 0.1 # Give 0.1 seconds to quit gracefully.
kill -9 $pid >/dev/null 2>&1
fi

done


