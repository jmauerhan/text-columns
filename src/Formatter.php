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
        $pattern = '/.{1,' . $this->maxColumnWidth . '}(?=\b)\W*/';
        $rows = [];
        foreach ($this->originalData AS $row) {
            $extraRows = [];
            foreach ($row AS $col => $cellData) {
                $cellData = trim($cellData);
                preg_match_all($pattern, $cellData, $splitValue);
                foreach ($splitValue[0] AS $rowNum => $subRow) {
                    $extraRows[$rowNum][$col] = trim($subRow);
                }
            }
            ksort($extraRows);
            $rows = array_merge($rows, $extraRows);
        }
        $this->indexedData = $rows;

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
