<?php

namespace TestParser\db;

use mysqli;
use TestParser\config\DB;

class ClientMysql
{
    protected mysqli|null $conn = null;

    public function init(): void
    {
        if (is_null($this->conn)) {
            $this->conn = mysqli_connect(
                DB::HOST,
                DB::USERNAME,
                DB::PASSWORD,
                DB::DBNAME,
            );
        }
    }

    public function close(): void
    {
        if (!is_null($this->conn)) {
            mysqli_close($this->conn);
            $this->conn = null;
        }
    }
}
