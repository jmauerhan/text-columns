<?php

namespace JMauerhan\TextColumns;

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

    private $maxColumnWidth;

    public function __construct(array $originalData)
    {
        $this->originalData = $originalData;
    }

    private function indexData()
    {
        $callback = function ($cell) {
            if (!empty($this->maxColumnWidth)) {
                return wordwrap($cell, $this->maxColumnWidth, PHP_EOL, true);
            }
            return $cell;
        };
        $wrappedRows = [];
        foreach ($this->originalData AS $row) {
            $wrappedRows[] = array_map($callback, $row);
        }

        $expandedRows = [];
        foreach ($wrappedRows AS $row) {
            $rows = [];
            foreach ($row AS $columnIndex => $cell) {
                $cellData = preg_split('/\n/', $cell);
                foreach ($cellData AS $rowIndex => $cellValue) {
                    $rows[$rowIndex][$columnIndex] = trim($cellValue);
                }
            }
            ksort($rows);
            $expandedRows = array_merge($expandedRows, $rows);
        }

        $this->indexedData = $expandedRows;

        $this->numColumns = max(array_map('count', $this->getData()));
        $this->columnWidths = [];
        for ($i = 0; $i < $this->numColumns; $i++) {
            $column = array_column($this->getData(), $i);
            $maxLen = max(array_map('strlen', $column));
            $this->columnWidths[$i] = $maxLen;
        }

    }

    public function setMaxColumnWidth($maxWidth)
    {
        $this->maxColumnWidth = $maxWidth;
    }

    public function getData()
    {
        if (empty($this->indexedData)) {
            $this->indexData();
        }
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
