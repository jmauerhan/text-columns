<?php

namespace Jmauerhan\TextColumns;

class Formatter
{
    /** @var array */
    private $originalData;

    /** @var array */
    private $indexedData;

    /** @var int */
    private $numColumns;

    /** @var int[] */
    private $columnWidths;

    public function __construct(array $originalData)
    {
        $newLinePattern = '/\n/';
        $rows = [];
        foreach ($originalData AS $rowNum => $row) {
            $newRows = [];
            foreach ($row AS $col => $val) {
                $valToRows = preg_split($newLinePattern, $val);

                foreach ($valToRows AS $numNewRows => $subRow) {
                    $newRows[$numNewRows][$col] = trim($subRow);
                }
            }
            $rows = array_merge($rows, $newRows);
        }

        $this->indexedData = $rows;

        $this->numColumns = max(array_map('count', $this->getData()));
        $this->columnWidths = [];
        for ($i = 0; $i < $this->numColumns; $i++) {
            $column = array_column($this->getData(), $i);
            $maxLen = max(array_map('strlen', $column));
            $this->columnWidths[$i] = $maxLen;
        }

        $this->originalData = $originalData;
    }

    public function getData()
    {
        return $this->indexedData;
    }

    /**
     * @return array
     */
    public function format()
    {
        $formattedValues = [];
        foreach ($this->getData() AS $row) {
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
