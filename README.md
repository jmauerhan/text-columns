# text-columns
Converts an array of strings into a padded table suitable for monospaced output

[![Build Status](https://travis-ci.org/jmauerhan/text-columns.svg?branch=master)](https://travis-ci.org/jmauerhan/text-columns) [![Coverage Status](https://coveralls.io/repos/github/jmauerhan/text-columns/badge.svg?branch=master)](https://coveralls.io/github/jmauerhan/text-columns?branch=master) 

Given an array of strings, this class will return an array with the strings padded and broken into multiple rows for any multi-line value. The resulting array can be output in a monospaced font (such as the classic terminal) and will be nicely formatted in evenly spaced columns.

## Usage

Create a `Formatter` with an array, then call `format` to convert it to a padded array.
 
```
$input = [
            ['aaa', 'bbbbbbb'],
            ['ccccc', 'dd']
        ];

$formatter = new Formatter($input);
$output = $formatter->format();

foreach($output AS $row){
  echo '| ';
  echo implode(' | ', $row);
  echo ' |'.PHP_EOL;_
}
```

Output:
```
| aaa   | bbbbbbb |
| ccccc | dd      |
```

