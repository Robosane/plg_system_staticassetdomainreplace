#!/bin/bash
# Zip the package

FNAME="plg_system_staticassetdomainreplace.zip"

rm $FNAME
zip -r $FNAME index.html staticassetdomainreplace.php staticassetdomainreplace.xml en-GB.plg_system_staticassetdomainreplace.sys.ini

packagesize=$(ls -lh $FNAME)
echo "Created: $packagesize"
