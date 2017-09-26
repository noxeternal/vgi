#!/bin/bash
cd public
START='\/\* START GENERATED IMPORTS \*\/'
END='\/\* END GENERATED IMPORTS \*\/'

TWOSPACE='  '
REPL=''
for F in classes/**/index.css forms/**/index.css directives/**/index.css
do
	[[ -f $F ]] || continue
	REPL=$REPL"\n@import \'../"$F"\';"
done
REPL=$(echo $REPL | sed -e 's/ui\///g' -e 's_\/_\\/_g')
pattern='/'$START'/,/'$END'/c'$START$REPL"\n"$END
sed -i "$pattern" css/main.css

START='<!-- START GENERATED SCRIPT TAGS -->'
END='<!-- END GENERATED SCRIPT TAGS -->'

REPL=''
for F in classes/**/index.js forms/**/index.js directives/**/index.js
do
	[[ -f $F ]] || continue
	REPL=$REPL"\n"$TWOSPACE"<script src=\""$F"\"></script>"
done
REPL=$(echo $REPL | sed -e 's_\/_\\/_g')
pattern='/'$START'/,/'$END'/c  '$START$REPL"\n"$END
sed -i "$pattern" index.html

pushd forms
FORMS=(*)
function joinby { local IFS="$1"; shift; echo "$*"; }
FORMS=$(joinby , ${FORMS[@]})
FORMS=${FORMS//,/"','"}
popd
echo "angular.module('forms',['"$FORMS"'])" > js/forms.js

# pushd elements
# ELEMENTS=(*)
# function joinby { local IFS="$1"; shift; echo "$*"; }
# ELEMENTS=$(joinby , ${ELEMENTS[@]})
# ELEMENTS=${ELEMENTS//,/"','"}
# popd
# echo "angular.module('elements',['"$ELEMENTS"'])" > js/elements.js

pushd directives
DIRECTIVES=(*)
function joinby { local IFS="$1"; shift; echo "$*"; }
DIRECTIVES=$(joinby , ${DIRECTIVES[@]})
DIRECTIVES=${DIRECTIVES//,/"','"}
popd
echo "angular.module('directives',['"$DIRECTIVES"'])" > js/directives.js
