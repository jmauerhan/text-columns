<?php

namespace Test;

use JMauerhan\TextColumns\Formatter;

/**
 * Class FormatterTest
 * @package Test
 */
class FormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testFormatReturnsPaddedValues()
    {
        $input = [
            ['aaa', 'bbbbbbb'],
            ['ccccc', 'dd']
        ];
        $expectedOutput = [
            ['aaa  ', 'bbbbbbb'],
            ['ccccc', 'dd     ']
        ];

        $formatter = new Formatter($input);
        $this->assertEquals($expectedOutput, $formatter->format());
    }

    public function testFormatPadsWhenRowsHaveDifferentColumnCount()
    {
        $input = [
            ['aaa', 'bbbbbbb'],
            ['ccccc', 'dd', 'eee']
        ];
        $expectedOutput = [
            ['aaa  ', 'bbbbbbb', '   '],
            ['ccccc', 'dd     ', 'eee']
        ];

        $formatter = new Formatter($input);
        $this->assertEquals($expectedOutput, $formatter->format());
    }

    public function testFormatReturnsExtraRowsWhenValuesAreMultiline()
    {
        $input = [
            ['aaa', 'first line' . PHP_EOL . 'second line'],
            ['ccccc', 'dd']
        ];
        $expectedOutput = [
            ['aaa  ', 'first line '],
            ['     ', 'second line'],
            ['ccccc', 'dd         ']
        ];

        $formatter = new Formatter($input);
        $actualResult = $formatter->format();
        $this->assertEquals($expectedOutput, $actualResult);
    }

    public function testFormatWithMaxColumnWidthWrapsLongCellsInColumn()
    {
        $width = 60;

        $longStr = 'This is a very long line. It has a lot of text. It will need to wrap. ';
        $longStr .= 'If the very long line of text wraps and is not padded to the right column, ';
        $longStr .= 'then the columns won\'t line up correctly.';
        $input = [
            ['-long', $longStr],
            ['-short', 'short text']
        ];
        $expectedOutput = [
            ['-long ', 'This is a very long line. It has a lot of text. It will need'],
            ['      ', 'to wrap. If the very long line of text wraps and is not     '],
            ['      ', "padded to the right column, then the columns won't line up  "],
            ['      ', 'correctly.                                                  '],
            ['-short', 'short text                                                  ']
        ];

        $formatter = new Formatter($input);
        $formatter->setMaxColumnWidth($width);
        $actualResult = $formatter->format();
        $this->assertEquals($expectedOutput, $actualResult);
    }

    public function testMaxColumnWidthWrapsEveryColumn()
    {
        $width = 40;

        $longStr = 'This is a very long line. It has a lot of text. ' . PHP_EOL;
        $longStr .= 'It also has a line break.';

        $input = [
            ['long', $longStr],
            ['short', 'short string']
        ];
        $expectedOutput = [
            ['long ', 'This is a very long line. It has a lot'],
            ['     ', 'of text.                              '],
            ['     ', 'It also has a line break.             '],
            ['short', 'short string                          ']
        ];

        $formatter = new Formatter($input);
        $formatter->setMaxColumnWidth($width);
        $actualResult = $formatter->format();
        $this->assertEquals($expectedOutput, $actualResult);
    }

    public function testMaxColumnWidthWithNewLineBreak()
    {
        $width = 10;

        $input = [
            ['A string, a string, a string', 'Some other string of text']
        ];
        $expectedOutput = [
            ['A string,', 'Some other'],
            ['a string,', 'string of '],
            ['a string ', 'text      ']
        ];

        $formatter = new Formatter($input);
        $formatter->setMaxColumnWidth($width);
        $actualResult = $formatter->format();
        $this->assertEquals($expectedOutput, $actualResult);
    }

    public function testMaxColumnWidthWithForcedBreak()
    {
        $width = 5;

        $input = [
            ['123456789']
        ];
        $expectedOutput = [
            ['12345'],
            ['6789 '],
        ];

        $formatter = new Formatter($input);
        $formatter->setMaxColumnWidth($width);
        $actualResult = $formatter->format();
        $this->assertEquals($expectedOutput, $actualResult);
    }

    public function testMaxTotalWidth()
    {

    }

}
