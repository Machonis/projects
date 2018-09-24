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
     * return array of cells witch user want to merge
     * @return array
     */
    private function getUserSelectedCells()
    {
        $count = count($this->userArray);
        $userSelectedCells = [];

        for ($i = 0; $i < $count; $i++)
        {
            $userSelectedCells[$i] = explode(',', $this->userArray[$i]['cells']);
            sort($userSelectedCells[$i]);
        }
        return $userSelectedCells;
    }

     /**
     * return an unchanged table
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

    /**
     * return array of all cells
     * @return array
     */
    private function getArrayOfTableCells()
    {
        $arrayOfTableCells = [];

        for ($i = 0; $i <= $this->size; $i++) {
            $arrayOfTableCells[$i] = $i;
        }
        return $arrayOfTableCells;
    }

    /**
     * return how many rows were selected
     * @return array|int
     */
    private function getCountOfSelectedRows()
    {
        $countOfSelectedRows = [];
        $count = count($this->userArray);
        $userSelectedCells = $this->getUserSelectedCells();

        for ($i = 0; $i < $count; $i++) {
            $maxOfSelectedCells = max($userSelectedCells[$i]);
            $minOfSelectedCells = min($userSelectedCells[$i]);

            for ($j = 0; $j <= $this->rowCount; $j++) {
                if ($j - 1 <= intdiv($maxOfSelectedCells - $minOfSelectedCells, $this->rowCount) &&
                    intdiv($maxOfSelectedCells - $minOfSelectedCells, $this->rowCount) <= $j) {
                    $countOfSelectedRows[$i] = $j;
                }
            }
        }
        return $countOfSelectedRows;
    }

    /**
     * separate selected cells by rows
     * @return array
     */
    private function getCellsOnEachRow()
    {
        $count = count($this->userArray);
        $arrayOfTableCells = $this->getArrayOfTableCells();
        $userSelectedCells = $this->getUserSelectedCells();
        $cellsOnEachRow = [];

        for ($k = 0; $k < $count; $k++) {
            $tmp = [];
            $iterator = 0;
            for ($i = 0; $i < $this->rowCount; $i++) {
                for ($j = 0; $j < $this->colCount; $j++) {
                    if (in_array($arrayOfTableCells[$iterator], $userSelectedCells[$k])) {
                        $tmp[$i][] = $arrayOfTableCells[$iterator];
                    }
                    $iterator++;
                }
            }

            $i = 0;
            $j = 0;

            foreach ($tmp as $key1 => $value1) {
                foreach ($value1 as $key2 => $value2) {
                    $cellsOnEachRow[$k][$i][$j] = $tmp[$key1][$key2];
                    $j++;
                }
                $j = 1;
                $i++;
            }
        }
        return $cellsOnEachRow;
    }

    /**
     * return modified table
     * @return bool|string
     */
    public function getModifiedTable()
    {
        $countOfSelectedRows = $this->getCountOfSelectedRows();
        $userSelectedCells = $this->getUserSelectedCells();
        $countOfSelectedCells = count($userSelectedCells);
        $arrayOfTableCells = $this->getArrayOfTableCells();
        $validatorResult = false;
        $options = [
            'colspan' => [],
            'rowspan' => [],
            'width' => [],
            'height' => [],
            'color' => [],
            'bgcolor' => [],
            'text' => [],
            'align' => [],
            'valign' => [],
        ];

        for ($i = 1; $i <= $this->size; $i++) {
            $options['width'][$i] = 100 / $this->colCount;
            $options['height'][$i] = 100 / $this->rowCount;
            $options['colspan'][$i] = '1';
            $options['rowspan'][$i] = '1';
            $options['text'][$i] = $i;
            $options['align'][$i] = 'center';
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
                    $options['color'][$value] = $this->userArray['color'];
                    $options['bgcolor'][$value] = $this->userArray['bgcolor'];
                    $options['text'][$value] = $this->userArray['text'];
                    $options['align'][$value] = $this->userArray['align'];
                    $options['valign'][$value] = $this->userArray['valign'];
                    $options['colspan'][$value] = 1;
                    $options['rowspan'][$value] = 1;

                    if ($value == $minUserSelectedCells) {
                        $options['colspan'][$value] = $countOfSelectedCells / $countOfSelectedRows;
                        $options['rowspan'][$value] = $countOfSelectedRows;
                    }

                }
            }
                $table = $this->createUserTable($options);
                return $table;
        }
        return false;
    }

    /**
     * create modified table
     * @param array $options
     * @return string
     */
    private function createUserTable(array $options)
    {
        $arrayOfTableCells = $this->getArrayOfTableCells();
        $userSelectedCells = $this->getUserSelectedCells();
        $table = '';
        $table .= '<div id ="modified_table" >
                <table class="table" >';
                    $iterator = 1;
                    for ($i = 0; $i < $this->rowCount; $i++) {
                        $table .= '<tr >';
                            for ($j = 0; $j < $this->colCount; $j++, $iterator++) {
                                if (in_array($arrayOfTableCells[$iterator],
                                        $userSelectedCells) == false xor $arrayOfTableCells[$iterator] == $userSelectedCells[1]) {
                                    $table .= '<td colspan = ' . $options['colspan'][$iterator] . ' ';
                                    $table .= 'rowspan = ' . $options['rowspan'][$iterator];
                                    $table .= ' style = " '. PHP_EOL;
                                        $table .= 'width: ' . $options['colspan'][$iterator] * $options['width'][$iterator] . '% ; '. PHP_EOL;
                                        $table .= 'height: ' . $options['rowspan'][$iterator] * $options['height'][$iterator] . '% ; '. PHP_EOL;
                                        $table .= 'background: ' . $options['bgcolor'][$iterator] . '; '. PHP_EOL;
                                        $table .= 'color: ' . $options['color'][$iterator]. '; ' . PHP_EOL;
                                        $table .= 'text-align: ' . $options['align'][$iterator]. '; '. PHP_EOL;
                                        $table .= 'vertical-align: ' . $options['valign'][$iterator]. '; '. PHP_EOL;
                                    $table .= '">' .
                                        $options['text'][$iterator] . '</td >';
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
       $count = count($this->userArray);
       $countOfSelectedRows = $this->getCountOfSelectedRows();
       $cellsOnEachRow = $this->getCellsOnEachRow();
       $userSelectedCells = $this->getUserSelectedCells();
       $arrayOfTableCells = $this->getArrayOfTableCells();
       for ($i = 0; $i < $count; $i++) {
           if ($countOfSelectedRows[$i] != 1) {
               for ($j = 0; $j < $countOfSelectedRows - 1; $j++) {
                   if (min($cellsOnEachRow[$i][$j]) != min($cellsOnEachRow[$i][$j + 1]) - $this->colCount && max($cellsOnEachRow[$j]) != max($cellsOnEachRow[$j + 1]) - $this->colCount) {
                       throw new Exception('These can\'t be combined!');
                   }
                   if ($i == $countOfSelectedRows - 1) {
                       for ($j = 0; $j < $countOfSelectedRows -1; $j++) {
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
       }
       return true;
   }
}