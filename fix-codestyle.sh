#!/bin/bash

php-cs-fixer fix src/ --level=symfony --fixers=-multiline_array_trailing_comma,single_array_no_trailing_comma,concat_with_spaces,ordered_use,short_array_syntax
