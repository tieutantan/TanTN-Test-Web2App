#!/bin/bash

# Commands
service cron start

# Start Apache In The Foreground
exec apache2-foreground