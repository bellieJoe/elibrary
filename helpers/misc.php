<?php

class Misc 
{
    public function test()
    {
        return "Hello";
    }

    public static function sanitizeInput($input) {
        return htmlspecialchars(strip_tags($input));
    }

    public static function logError($message, $file = null, $line = null) {
        $timestamp = date("Y-m-d H:i:s"); 
        $logMessage = "[$timestamp] ERROR: $message";
        $logFile = ROOT_PATH . "/logs/error_log.txt";

        if ($file && $line) {
            $logMessage .= " in $file on line $line";
        }

        file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);
    }

    public static function toObject(array $array) {
        array_map(fn($arr) => (object) $arr, $array);
    }

    public static function renderTdActions($actions, $row, $urls) {
        $edit = in_array("edit", $actions) ? "<a href='".$urls['edit'].$row->id."' class='btn btn-sm btn-primary'>Edit</a>" : "";
        $delete = in_array("delete", $actions) ? "<a href='".$urls['delete'].$row->id."' class='btn btn-sm btn-primary'>Delete</a>" : "";
        $actionElement = 
        "
        <div class='dropdown'>
            <button class='btn btn-sm btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
                Actions
            </button>
            <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
                <li><a class='dropdown-item' href='#'>Action</a></li>
                <li><a class='dropdown-item' href='#'>Action</a></li>
            </ul>
        </div> 
        ";

        return $actionElement;
        
    }

    public static function renderTable($headers, $data){
        ?>
        <table class="table table-striped table-bordered " id="datatable" >
            <thead>
                <tr>
                    <?php foreach ($headers as $key => $title) { ?>
                        <th><?=$title?></th>
                    <?php } ?>
                    <th class="text-center" width="50px">Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <?php foreach ($headers as $key => $title) { ?>
                        <th><?=$title?></th>
                    <?php } ?>
                    <th class="text-center" width="50px">Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                if(empty($data)){
                    echo "<tr><td colspan='" . count($headers) + 1 . "' class='text-center'>No Data Found</td></tr>";
                }

                foreach ($data as $value) {
                ?>
                    <tr>
                        <?php foreach ($headers as $key => $title) { ?>
                            <td><?=$value->$key?></td>
                        <?php } ?>
                        <td class="text-center"><?= self::renderTdActions([], $value) ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }
}

?>