<?php

namespace Test;

use Jmauerhan\TextColumns\Formatter;

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

}
