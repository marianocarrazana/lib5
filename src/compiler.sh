#!/bin/bash
js="pdf.worker.js"
js2="moment.js"
closure="java -jar /home/mariano/closure/compiler.jar"
$closure --language_in=ECMASCRIPT5 --js_output_file=moment.min.js $js2