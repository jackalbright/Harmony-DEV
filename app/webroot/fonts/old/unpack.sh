#!/bin/sh -x

Z=$1
D=${Z%%-fontfacekit.zip}

mkdir $D;
cd $D;
unzip ../$Z
