<?php

namespace Jmauerhan\TextColumns;

class Formatter
{
    /** @var array */
    private $originalData;

    /** @var int */
    private $numColumns;

    /** @var int[] */
    private $columnWidths;

    public function __construct(array $originalData)
    {
        $this->originalData = $originalData;
        $this->numColumns = max(array_map('count', $this->originalData));
        $this->columnWidths = [];
        for ($i = 0; $i < $this->numColumns; $i++) {
            $column = array_column($this->originalData, $i);
            $maxLen = max(array_map('strlen', $column));
            $this->columnWidths[$i] = $maxLen;
        }
    }

    /**
     * @return array
     */
    public function format()
    {
        $formattedValues = [];
        foreach ($this->originalData AS $row) {
            $paddedRow = [];
            foreach ($this->columnWidths AS $col => $width) {
                if (empty($row[$col])) {
                    $row[$col] = ' ';
                }
                $paddedRow[$col] = str_pad($row[$col], $width);
            }
            ksort($paddedRow);
            $formattedValues[] = $paddedRow;
        }
        return $formattedValues;
    }
}
