#!/bin/bash

FREE=$(free -m | grep Mem | awk '{print $4}')
TOTAL=$(free -m | grep Mem | awk '{print $2}')
PERCENT=$(($FREE * 100 / $TOTAL))
TEMP_FILE="/tmp/temp-mem-use"

if [ $PERCENT -lt 15 ]
then
  ## MEMORY LESS THAN 15% FREE
  if [ -f $TEMP_FILE ]; then
    ## TEMP FILE EXIST
    STARTED=$(date +%s -d "$(cat $TEMP_FILE)")
    CURRENT=$(date +%s -d "$(date +"%Y-%m-%d %T")")
    DIFF=$(( ($CURRENT - $STARTED) / 60 ))
    if [ $DIFF -gt 15 ]; then
      ## TIME MORE THAN 15 MINUTES
      shutdown now -r
    fi
  else
    ## TEMP FILE DOES NOT EXIST
    echo $(date +"%Y-%m-%d %T") > $TEMP_FILE
  fi
else
  ## MEMORY MORE THAT 15% FREE
  rm $TEMP_FILE
fi

exit 0

