#!/bin/sh -e
exec /usr/bin/ssh -o PasswordAuthentication=no -o StrictHostKeyChecking=no "$@"
