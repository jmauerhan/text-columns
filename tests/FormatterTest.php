<?php

namespace Test;

use Jmauerhan\TextColumns\Formatter;

/**
 * Class FormatterTest
 * @package Test
 * @covers Jmauerhan\TextColumns\Formatter
 */
class FormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::format
     */
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

    /**
     * @covers ::format
     */
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

    public function getNewLines()
    {
        return [
            ["\n"],
            ["\r\n"]
        ];
    }

    /**
     * @dataProvider getNewLines
     * @covers ::format
     */
    public function testFormatReturnsExtraRowsWhenValuesAreMultiline($newLineValue)
    {
        $input = [
            ['aaa', 'first line' . $newLineValue . 'second line'],
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

}
