#!/bin/bash
mysqlcheck -h daxmark.railyatri.in -u railstager -pOmlL0G --all-databases
#mysqlcheck -h daxmark.railyatri.in -u railstager -pOmlL0G --all-databases -o
#mysqlcheck -h daxmark.railyatri.in -u railstager -pOmlL0G --all-databases --auto-repair
mysqlcheck -h daxmark.railyatri.in -u railstager -pOmlL0G --all-databases --analyze
