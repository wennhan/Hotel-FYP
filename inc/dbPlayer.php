<?php

namespace dbPlayer;


class dbPlayer {

    private $db_host="localhost";
    private $db_name="hms";
    private $db_user="root";
    private $db_pass="";
    protected $con;

    public function open()
    {
        $this->con = new \mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        if ($this->con->connect_error) {
            return $this->con->connect_error;
        } else {
            return "true";
        }
    }
    public function close()
    {
        $this->con->close();

        return "true";
    }


    public function insertData($table, $data)
    {
        $keys = "`" . implode("`, `", array_keys($data)) . "`";
        $values = "'" . implode("', '", $data) . "'";

        $this->con->query("INSERT INTO `{$table}` ({$keys}) VALUES ({$values})");

        return $this->con->insert_id . $this->con->error;
    }
    public function registration($query, $query2)
{
    $res = $this->con->query($query);

    if ($res) {
        $res = $this->con->query($query2);

        if ($res) {
            return "true";
        } else {
            return $this->con->error;
        }
    } else {
        return $this->con->error;
    }
}
    public function getData($query)
    {
        $res = $this->con->query($query);

        if (!$res) {
            return "Can't get data " . $this->con->error;
        } else {
            return $res;
        }
    }
    public function update($query)
    {
        $res = $this->con->query($query);

        if (!$res) {
            return "Can't update data " . $this->con->error;
        } else {
            return "true";
        }
    }
    public function updateData($table, $conColumn, $conValue, $data)
    {
        $updates = array();

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $value = $this->con->real_escape_string($value);
                $value = "'$value'";
                $updates[] = "$key = $value";
            }
        }

        $implodeArray = implode(', ', $updates);
        $query = "UPDATE " . $table . " SET " . $implodeArray . " WHERE " . $conColumn . "='" . $conValue . "'";

        $res = $this->con->query($query);

        if (!$res) {
            return "Can't Update data " . $this->con->error;
        } else {
            return "true";
        }
    }


    public function delete($query)
    {
        $res = $this->con->query($query);

        if (!$res) {
            return "Can't delete data " . $this->con->error;
        } else {
            return "true";
        }
    }

    public function getAutoId($prefix)
    {
    $uId = "";
    $q = "SELECT number FROM auto_id WHERE prefix='" . $prefix . "';";
    $result = $this->getData($q);
    $userId = array();

    while ($row = $result->fetch_assoc()) {
        array_push($userId, $row['number']);
    }

    if (strlen($userId[0]) >= 1) {
        $uId = $prefix . "00" . $userId[0];
    } elseif (strlen($userId[0]) == 2) {
        $uId = $prefix . "0" . $userId[0];
    } else {
        $uId = $prefix . $userId[0];
    }

    array_push($userId, $uId);
    return $userId;
    }
    public  function  updateAutoId($value,$prefix)
    {
         $id =intval($value)+1;

        $query="UPDATE auto_id set number=".$id." where prefix='".$prefix."';";
        return $this->update($query);

    }

    public function execNonQuery($query)
    {
        $res = $this->con->query($query);

        if (!$res) {
            return "Can't Execute Query" . $this->con->error;
        } else {
            return "true";
        }
    }
    public function execDataTable($query)
    {
        if ($this->con) {
            $res = $this->con->query($query);
    
            if ($res === false) {
                return "Can't Execute Query: " . $this->con->error;
            } else {
                return $res;
            }
        } else {
            return "Database connection is not established.";
        }
    }
    
}
