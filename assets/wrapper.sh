#!/bin/bash
script=$1
export env=$(dirname $script)
$script "${@:2}" &
