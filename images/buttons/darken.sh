#!/bin/sh

F=$1
echo $F
#exit;

convert $F -modulate 90,150,98 $F
