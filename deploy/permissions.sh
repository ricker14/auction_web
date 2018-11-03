#!/bin/bash

cd /data/sites
chown apache.ituser instruction_service-v2
chmod a+X instruction_service-v2
cd /data/sites/instruction_service-v2
chown apache.ituser * -R
chmod 664 * -R
