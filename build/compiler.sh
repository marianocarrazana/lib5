#!/bin/bash
js="pdf.worker.js"
js2="pdf.js"
closure="java -jar /home/mariano/closure/compiler.jar"
$closure --language_in=ECMASCRIPT5 --js_output_file=pdf_out.js $js2