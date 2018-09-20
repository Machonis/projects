<?php declare(strict_types=1);

namespace projects\merger\back;

use Exception;

class Table
{

    private $userArray;
    private $colCount;
    private $rowCount;
    private $size;

    /**
     * Table constructor
     * @param array $userArray
     * @param int $rowCount
     * @param int $colCount
     */
    public function __construct(array $userArray, int $rowCount, int $colCount)
    {
        $this->setRowCount($rowCount);
        $this->setColCount($colCount);
        $this->setUserArray($userArray);
        $this->setSize();
    }

    /**
     * @param $userArray
     */
    private function setUserArray($userArray)
    {
        $this->userArray = $userArray;
    }

    /**
     * @param $colCount
     */
    private function setColCount($colCount)
    {
        $this->colCount = $colCount;
    }

    /**
     * @param $rowCount
     */
    private function setRowCount($rowCount)
    {
        $this->rowCount = $rowCount;
    }

    /**
     * Set count of cells
     */
    private function setSize()
    {
        $this->size = $this->rowCount*$this->colCount;
    }

    /**
     * @return array
     */
    private function getUserSelectedCells()
    {
        $tmp = [];
        $userSelectedCells = explode(',', $this->userArray['cells']);
        sort($userSelectedCells);

        foreach ($userSelectedCells as $key => $value) {
            $tmp[$key+1] = $userSelectedCells[$key];
        }
        $userSelectedCells = $tmp;

        return $userSelectedCells;
    }

     /**
     * Return of an unchanged table
     */
    public function getUnmodifiedTable()
    {
        $iterator = 1;
        $table = '
        <div id ="unmodified_table">
                    <table class="table">';
                        for ($i = 0; $i < $this->rowCount; $i++) {
                            $table .= '<tr>';
                            for ($j = 0; $j < $this->colCount; $j++, $iterator++) {
                                $table .= '<td
                                    style="
                                        width:' . 100 / $this->colCount . '%;
                                        height:' . 100 / $this->rowCount . '%;
                                        text-align: center;
                                        vertical-align: middle;
                                    ">';
                                $table .= $iterator; $table .= '</td>';
                            }
                            $table .= '</tr>';
                        }
                        $table .= '</table>
        </div>';

        return $table;
    }

    private function getArrayOfTableCells()
    {
        $arrayOfTableCells = [];

        for ($i = 1; $i <= $this->size; $i++) {
            $arrayOfTableCells[$i] = $i;
        }
        return $arrayOfTableCells;
    }

    private function getCountOfSelectedRows()
    {
        $countOfSelectedRows = [];
        $userSelectedCells = $this->getUserSelectedCells();
        $maxOfSelectedCells = max($userSelectedCells);
        $minOfSelectedCells = min($userSelectedCells);

        for ($i = 1; $i <= $this->rowCount; $i++) {
            if ($i - 1 <= intdiv($maxOfSelectedCells - $minOfSelectedCells, $this->rowCount) &&
                intdiv($maxOfSelectedCells - $minOfSelectedCells, $this->rowCount) <= $i) {
                $countOfSelectedRows = $i;
            }
        }
        return $countOfSelectedRows;
    }

    private function getCellsOnEachRow()
    {
        $arrayOfTableCells = $this->getArrayOfTableCells();
        $userSelectedCells = $this->getUserSelectedCells();
        $cellsOnEachRow = [];
        $iterator = 1;
        $tmp = [];
        for ($i = 1; $i <= $this->rowCount; $i++) {
            for ($j = 1; $j <= $this->colCount; $j++) {
                if (in_array($arrayOfTableCells[$iterator], $userSelectedCells)) {
                    $tmp[$i][] = $arrayOfTableCells[$iterator];
                }
                $iterator++;
            }
        }

        $i = 1;
        $j = 1;

        foreach ($tmp as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                $cellsOnEachRow[$i][$j] = $tmp[$key1][$key2];
                $j++;
            }
            $j = 1;
            $i++;
        }
        return $cellsOnEachRow;
    }

    public function getModifiedTable()
    {
        $countOfSelectedRows = $this->getCountOfSelectedRows();
        $userSelectedCells = $this->getUserSelectedCells();
        $countOfSelectedCells = count($userSelectedCells);
        $arrayOfTableCells = $this->getArrayOfTableCells();
        $validatorResult = false;
        $colspan = [];
        $rowspan = [];
        $width = [];
        $height = [];
        $color = [];
        $bgcolor = [];
        $text = [];
        $align = [];
        $valign = [];

        for ($i = 1; $i <= $this->size; $i++) {
            $width[$i] = 100 / $this->colCount;
            $height[$i] = 100 / $this->rowCount;
            $colspan[$i] = '1';
            $rowspan[$i] = '1';
            $text[$i] = $i;
            $align[$i] = 'center';
        }

        try {
            $validatorResult = $this->userTableValidator();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $minUserSelectedCells = min($userSelectedCells);

        if ($validatorResult == true) {
            foreach ($arrayOfTableCells as $value) {
                if (in_array($value, $userSelectedCells)) {
                    $color[$value] = $this->userArray['color'];
                    $bgcolor[$value] = $this->userArray['bgcolor'];
                    $text[$value] = $this->userArray['text'];
                    $align[$value] = $this->userArray['align'];
                    $valign[$value] = $this->userArray['valign'];
                    $colspan[$value] = 1;
                    $rowspan[$value] = 1;

                    if ($value == $minUserSelectedCells) {
                        $colspan[$value] = $countOfSelectedCells / $countOfSelectedRows;
                        $rowspan[$value] = $countOfSelectedRows;
                    }

                }
            }
                $table = $this->createUserTable($arrayOfTableCells, $userSelectedCells, $colspan, $rowspan, $width,
                    $height, $color, $bgcolor, $text, $align, $valign);
                return $table;
        }
        return false;
    }

    private function createUserTable(array $arrayOfTableCells, array $userSelectedCells, array $colspan, array $rowspan, array $width, array $height, array $color, array $bgcolor, array $text, array $align, array $valign)
    {
        $table = '';
        $table .= '<div id ="modified_table" >
                <table class="table" >';
                    $iterator = 1;
                    for ($i = 0; $i < $this->rowCount; $i++) {
                        $table .= '<tr >';
                            for ($j = 0; $j < $this->colCount; $j++, $iterator++) {
                                if (in_array($arrayOfTableCells[$iterator],
                                        $userSelectedCells) == false xor $arrayOfTableCells[$iterator] == $userSelectedCells[1]) {
                                    $table .= '<td colspan = ' . $colspan[$iterator] . ' ';
                                    $table .= 'rowspan = ' . $rowspan[$iterator];
                                    $table .= ' style = " '. PHP_EOL;
                                        $table .= 'width: ' . $colspan[$iterator] * $width[$iterator] . '% ; '. PHP_EOL;
                                        $table .= 'height: ' . $rowspan[$iterator] * $height[$iterator] . '% ; '. PHP_EOL;
                                        $table .= 'background: ' . $bgcolor[$iterator] . '; '. PHP_EOL;
                                        $table .= 'color: ' . $color[$iterator]. '; ' . PHP_EOL;
                                        $table .= 'text-align: ' . $align[$iterator]. '; '. PHP_EOL;
                                        $table .= 'vertical-align: ' . $valign[$iterator]. '; '. PHP_EOL;
                                    $table .= '">' .
                                    $text[$iterator] . '</td >';
                                }
                            }
                        $table .= '</tr >';
                    }
                $table .= '</table >
    </div >';
    return $table;
    }

    /**
     * Check the possibility of merging cells
     * @return bool
     * @throws Exception
     */
   private function userTableValidator()
   {
       $cellsOnEachRow = $this->getCellsOnEachRow();
       $countOfSelectedRows = $this->getCountOfSelectedRows();
       $userSelectedCells = $this->getUserSelectedCells();
       $arrayOfTableCells = $this->getArrayOfTableCells();
       if ($countOfSelectedRows != 1) {
           for ($i = 1; $i < $countOfSelectedRows; $i++) {
               if (min($cellsOnEachRow[$i]) != min($cellsOnEachRow[$i + 1]) - $this->colCount && max($cellsOnEachRow[$i]) != max($cellsOnEachRow[$i + 1]) - $this->colCount) {
                   throw new Exception('These can\'t be combined!');
               }
               if ($i == $countOfSelectedRows - 1) {
                   for ($j = 1; $j < $countOfSelectedRows; $j++) {
                       if (count($cellsOnEachRow[$j]) != count($cellsOnEachRow[$j + 1])) {
                           throw new Exception('These can\'t be combined!');
                       }
                   }
               }
           }
       } else {
           for ($j = min($userSelectedCells); $j <= max($userSelectedCells); $j++) {
               if (in_array($arrayOfTableCells[$j], $userSelectedCells) == false) {
                   throw new Exception('These can\'t be combined!');
               }
           }
       }
       return true;
   }
}