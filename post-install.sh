#!/bin/bash

mkdir bill

if [!-d $PWD/bob]; then
    mkdir -p $PWD/bob;
fi;