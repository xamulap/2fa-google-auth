#!/bin/bash

if [ "$#" -ne 2 ]; then
    echo "Illegal number of parameters\n ./2fatest.sh username token"
    exit 0
fi


radtest $1 $2 localhost 0 testing123

