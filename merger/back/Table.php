<?php declare(strict_types=1);

namespace projects\merger\back;

class Table
{

    private $userArray;
    private $colCount;
    private $rowCount;

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
     * Display of an unchanged table
     */
    public function getUnmodifiedTable()
    {
        $iterator = 1;
        $table = '
        <div class="container">
            <div class="row">
                <div class="col">
                    <table class="table">';
                        for ($i = 0; $i < $this->rowCount; $i++) {
                            $table .= '<tr>';
                            for ($j = 0; $j < $this->colCount; $j++, $iterator++) {
                                $table .= '<td
                                    style="
                                        width: 100px;
                                        height: 100px;
                                        text-align: center;
                                        vertical-align: middle;
                                    ">';
                                $table .= $iterator; $table .= '</td>';
                            }
                            $table .= '</tr>';
                        }
                        $table .= '</table>
                </div>
            </div>
        </div>';
        return $table;
    }

    public function getModifiedTable()
    {
        $size = $this->rowCount * $this->colCount;
        $delimiter = ',';
        $userSelectedCells = explode($delimiter, $this->userArray['cells']);
        $countOfSelectedCells = count($userSelectedCells);
        $arrayOfTableCells = [];
        $colspan = [];
        $rowspan = [];
        $width = [];
        $height = [];
        $color = [];
        $bgcolor = [];
        $text = [];
        $iterator = 1;
        $countOfSelectedLines = 0;
        $validatorResult = false;
        $table = '';

        sort($userSelectedCells);

        for ($i = 1; $i <= $size; $i++) {
            $width[] = '100';
            $height[] = '100';
            $colspan[] = '1';
            $rowspan[] = '1';
            $text[] = $i;
        }

        for ($i = 1; $i <= $size; $i++) {
            $arrayOfTableCells[$i] = "$i";
        }

        $maxOfSelectedCells = max($userSelectedCells);
        $minOfSelectedCells = min($userSelectedCells);

        for ($i = 1; $i <= $this->rowCount; $i++) {
            if ($i - 1 <= intdiv($maxOfSelectedCells - $minOfSelectedCells, $this->rowCount) && intdiv($maxOfSelectedCells - $minOfSelectedCells, $this->rowCount) <= $i) {
                $countOfSelectedLines = $i;
            }
        }
        $cellsOnEachLine = [];

        for ($i = 1; $i <= $this->rowCount; $i++) {
            for ($j = 1; $j <= $this->colCount; $j++) {
                if (in_array($arrayOfTableCells[$iterator], $userSelectedCells)) {
                    $cellsOnEachLine[$i][] = $arrayOfTableCells[$iterator];
                }
                $iterator++;
            }
        }

        try {
            $validatorResult = $this->userTableValidator($countOfSelectedLines, $cellsOnEachLine, $userSelectedCells, $arrayOfTableCells);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $minUserSelectedCells = min($userSelectedCells);

        if ($validatorResult == true) {
            for ($i = 0; $i < $countOfSelectedCells; $i++) {
                $color[$userSelectedCells[$i] - 1] = $this->userArray['color'];
                $bgcolor[$userSelectedCells[$i] - 1] = $this->userArray['bgcolor'];
                $text[$userSelectedCells[$i] - 1] = $this->userArray['text'];
                $align[$userSelectedCells[$i] - 1] = $this->userArray['align'];
                $valign[$userSelectedCells[$i] - 1] = $this->userArray['valign'];
                $colspan[$userSelectedCells[$i] - 1] = 1;
                $rowspan[$userSelectedCells[$i] - 1] = 1;

                if ($i == $minUserSelectedCells) {
                    $colspan[$i - 1] = $countOfSelectedCells / $countOfSelectedLines;
                    $rowspan[$i - 1] = $countOfSelectedLines;
                }

            }
            $table = $this->createUserTable();
            return $table;
        }
        return false;
    }

    private function createUserTable()
    {
        $table = '';
        $table .= '<div class="container" >
        <div class="row" >
            <div class="col" >
                <table class="table" >';
                    $iterator = 1;
                    for ($i = 0; $i < $this->rowCount; $i++) {
                        $table .= '<tr >';
                            for ($j = 0; $j < $this->colCount; $j++, $iterator++) {
                                if (in_array($arrAll[$iterator],
                                        $arr_cells) == false xor $arrAll[$iterator] == $arr_cells[0]) {
                                    $table .= "<td colspan = " . $colspan[$iterator - 1];
                                        rowspan = "$rowspan[$iterator - 1]"
                                        style = "
                                                width: $colspan[$iterator - 1] * $width[$iterator - 1] . 'px'; ?>;
                                                height: $rowspan[$iterator - 1] * $height[$iterator - 1] . 'px'; ?>;
                                                background: $bgcolor[$iterator - 1];
                                                color: $color[$iterator - 1];
                                                text-align: $align[$iterator - 1];
                                                vertical-align: $valign[$iterator - 1];
                                                " >
                                    $text[$iterator - 1]; </td >
                                }
                            }
                        </tr >
                    }
                </table >
            </div >
        </div >
    </div >
    }

   private function userTableValidator(int $countOfSelectedLines, array $cellsOnEachLine, array $userSelectedCells, array $arrayOfTableCells)
   {
       if ($countOfSelectedLines != 1) {
           for ($i = 1; $i < $countOfSelectedLines; $i++) {
               if (min($cellsOnEachLine[$i]) != min($cellsOnEachLine[$i + 1]) - $this->colCount && max($cellsOnEachLine[$i]) != max($cellsOnEachLine[$i + 1]) - $this->colCount) {
                   throw new Exception('These can\'t be combined!');
               }
               if ($i == $countOfSelectedLines - 1) {
                   for ($j = 1; $j < $countOfSelectedLines; $j++) {
                       if (count($cellsOnEachLine[$j]) != count($cellsOnEachLine[$j + 1])) {
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