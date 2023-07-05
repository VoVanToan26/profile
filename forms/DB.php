<?php
class mysql
{
    private $sname = 'localhost';
    private $unmae = 'root';
    private $password = '';
    private $db_name = 'contact_db';

    public $conn;

    function __construct()
    {
        // do anything...
    }
    public function connect()
    {
        $this->conn = mysqli_connect($this->sname, $this->unmae, $this->password, $this->db_name);
        mysqli_set_charset($this->conn, 'UTF8');
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
            return false;
        }
        return true;
    }
    public function disconn()
    {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }

    public function query_data($sql)
    {
        $dtb = array();
        $result = -1;
        if ($this->connect()) {
            $rawdata = mysqli_query($this->conn, $sql); //fix loi ky tu dac biet
            while ($row = mysqli_fetch_assoc($rawdata)) {
                $dtb[] = $row;
            }
            $result = 1;
        }
        return [$dtb, $result];
    }
    public function query_data_distinct($sql, $key)
    {
        $dtb = array();
        $result = -1;
        if ($this->connect()) {
            $rawdata = mysqli_query($this->conn, $sql); //fix loi ky tu dac biet
            while ($row = mysqli_fetch_assoc($rawdata)) {
                $dtb[] = $row[$key];
            }
            $result = 1;
        }
        return [$dtb, $result];
    }
    public function query_change($sql)
    {
        if ($this->connect()) {
            $result = mysqli_query($this->conn, $sql); //fix loi ky tu dac biet
            if ($result) {
                return 1;
            }
            return 0;
        }
        return -1;
    }

    public function query_change_multi($sql)
    {
        if ($this->connect()) {
            $result = mysqli_multi_query($this->conn, $sql); //fix loi ky tu dac biet
            if ($result) {
                return 1;
            }
            return 0;
        }
        return -1;
    }
    //function query_insert==> return result === fail/succed/errconn
    //function queyr_select==> json data or row data ===> rowdata,resutl(fail/succed/errconn)

    public function get_result_query_change_multi($sql_command, $not_use_fetch_assoc = true) // if $get_result= false it get error
    {
        if ($sql_command == "") {
            return [0, []];
        }
        $connect = $GLOBALS['connect'];

        try {
            if ($connect->multi_query($sql_command) === TRUE) {
                $i = 0;
                $data_result = [false];
                do {
                    /* store the result set in PHP */
                    $data_result[$i] = [];
                    if ($result = mysqli_store_result($connect)) {
                        if ($not_use_fetch_assoc == false) {
                            while ($row = $result->fetch_assoc()) {
                                array_push($data_result[$i], $row);
                            }
                        } else {
                            while ($row = $result->fetch_row()) {
                                array_push($data_result[$i], $row);
                            }
                        }
                    }
                    if ($connect->more_results()) $i++;
                    if ($i > 5000) break;
                } while ($connect->next_result());
                if (count($data_result) < 1) {
                    $connect->close();
                    return [0, []];
                }
            }
        } catch (Exception $e) {
            return [0, "error: " . $e];
        }
        return [1, $data_result];
    }
}