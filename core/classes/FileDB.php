<?php

namespace Core;

class FileDB
{

    private $file_name;
    private $data;

    public function __construct($file_name)
    {
        $this->file_name = $file_name;
        $this->load();
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function save()
    {
        $encoded_array = json_encode($this->data);
        $bytes_written = file_put_contents($this->file_name, $encoded_array);
        if ($bytes_written !== false) {
            return true;
        }

        return false;
    }

    public function load()
    {
        if (file_exists($this->file_name)) {
            $this->data = json_decode(file_get_contents($this->file_name), true);
        } else {
            $this->data = [];
        }
    }

    /**
     * create table
     * @param string $table_name
     * @return bool
     */
    public function createTable(string $table_name)
    {
        if (!$this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        }
        return false;
    }

    /**
     * check if table exists
     * @param string $table_name
     * @return bool
     */
    public function tableExists(string $table_name)
    {
        if (isset($this->data[$table_name])) {
            return true;
        }
        return false;
    }

    /**
     * delete table
     * @param string $table_name
     * @return bool
     */
    public function dropTable(string $table_name)
    {
        if ($this->tableExists($table_name)) {
            unset($this->data[$table_name]);
            return true;
        }
        return false;
    }

    /**
     * delete value from table, leaving the table
     * @param string $table_name
     * @return bool
     */
    public function truncateTable(string $table_name)
    {
        if (!$this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        }
        return false;
    }

    /**
     * insert row to table
     * @param string $table_name
     * @param int $row
     * @param null $row_id
     * @return bool|mixed|null
     */
    public function insertRow(string $table_name, array $row, int $row_id = null)
    {
        if ($row_id) {
            if (!($this->rowExists($table_name, $row_id))) {
                $this->data[$table_name][$row_id] = $row;
                return $row_id;
            } else {
                return false;
            }
        } else {
            $this->data[$table_name][] = $row;

//            return array_key_last($this->data[$table_name]);
            return array_keys($this->data[$table_name])[count($this->data[$table_name]) - 1];
        }
    }

    /**
     * check if row exists in table
     * @param string $table_name
     * @param int $row_id
     * @return bool
     */
    public function rowExists(string $table_name, int $row_id)
    {
        if (isset($this->data[$table_name][$row_id])) {
            return true;
        }
        return false;
    }

    /**
     * update row from table
     * @param string $table_name
     * @param int $row_id
     * @param int $row
     * @return bool
     */
    public function updateRow(string $table_name, int $row_id, array $row): bool
    {
        if ($this->rowExists($table_name, $row_id)) {
            $this->data[$table_name][$row_id] = $row;
            return true;
        }
        return false;
    }

    /**
     * delete row from table
     * @param string $table_name
     * @param int $row_id
     * @return int|null
     */
    public function deleteRow(string $table_name, int $row_id): ?int
    {

        if ($this->rowExists($table_name, $row_id)) {
            unset($this->data[$table_name][$row_id]);
            return true;
        }
        return false;
    }

    /**
     * return row from table
     * @param string $table_name
     * @param int $row_id
     * @return int|null
     */
    public function getRow(string $table_name, int $row_id)
    {


        if ($this->rowExists($table_name, $row_id)) {
            return $this->data[$table_name][$row_id];
        }

        return false;
    }

    /**
     *
     * @param string $table_name
     * @param array $conditions
     * @return array
     */
    public function getRowsWhere($table_name, array $conditions)
    {
        $results = [];
        foreach ($this->data[$table_name] as $row_id => $row) {
            $found = TRUE;

            foreach ($conditions as $condition_key => $condition_value) {
                $row_value = $row[$condition_key];
                if ($condition_value != $row_value) {
                    $found = FALSE;
                    break;
                }
            }
            if ($found) {
                $results[$row_id] = $row;
            }
        }
        return $results;
    }

    public function __destruct()
    {
        $this->save();
    }

}
