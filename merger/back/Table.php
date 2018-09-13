<?php declare(strict_types=1);

namespace projects\merger\back;

class Table
{

    private $userArray;
    private $colCount;
    private $rowCount;

    /**
     * Table constructor.
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
    public function displayTable()
    {
        $iterator = 1;
    ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <table class="table-first">
                        <?php for ($i = 0; $i < $this->rowCount; $i++)
                    {?>
                    <tr>
                        <?php for ($j = 0; $j < $this->colCount; $j++, $iterator++) {?>
                            <td
                                style="
                                    width: 100px;
                                    height: 100px;
                                    text-align: center;
                                    vertical-align: middle;
                                ">
                                <?php echo $iterator;?></td>
                                <?php }?>
                            </tr>
                        <?php  }?>
                    </table>
                </div>
            </div>
        </div>
    }
}