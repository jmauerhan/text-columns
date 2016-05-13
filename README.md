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
```

You can now print the array however you like. The examples in this file are using a pipe separator to demonstrate the padding added by the formatter.
```
$sep = '|';
foreach($output AS $row){
  $output = implode(" {$sep} ", $row);
  echo "{$sep} {$output} {$sep}".PHP_EOL;
}
```

Output:
```
| aaa   | bbbbbbb |
| ccccc | dd      |
```


### Wrapping
The formatter handles wrapping cells that have multi-line data, or exceed a set width.

#### Line Breaks
```
$input = [
  ['command', 'This is a description '.PHP_EOL.'which spans multiple lines.'],
  ['data', 'This is a short line']
];

$formatter = new Formatter($input);
$output = $formatter->format();
```

Output:
```
| command | This is a description       |
|         | which spans multiple lines. |
| data    | This is a short line        |
```

#### Maximum Width - set to 20
```
$input = [
  ['command', 'This is a description '.PHP_EOL.'which spans multiple lines.'],
  ['data', 'This is a shorter line'],
  ['random', 'Some data: 1293847y3hwedfjsoidf87e3y6t2wusjdhhf']
];

$formatter = new Formatter($input);
$formatter->setMaxColumnWidth(20)
$output = $formatter->format();
```

Output: (The column wraps at the max width, using word boundaries to prevent breaking a word if possible, and also at the pre-existing line breaks.)
```
| command | This is a           |
|         | description which   |
|         | spans multiple      |
|         | lines.              |
| data    | This is a shorter   |
|         | line                |
| random  | Some data:          |
|         | 1293847y3hwedfjsoid |
|         | f87e3y6t2wusjdhhf   |
```
