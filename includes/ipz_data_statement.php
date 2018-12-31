<?php
/*
 * Copyright (C) 2016 David Blanchard
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
 
namespace Puzzle\Data;

use PDOStatement;

include_once 'ipz_data_driver.php';

use Puzzle\Data\Driver;

/**
 * Description of adatareader
 *
 * @author david
 */
class Statement
{
    private $_statement;
    private $_values;
    private $_fieldCount;
    private $_rowCount;
    private $_meta = [];
    private $_colNames = [];
    private $_config = null;
    private $_sql = '';
    private $_result = null;
    private $_driver = '';

    public function __construct($statement, $config, $sql)
    {
        $this->_statement = $statement;
        $this->_config = (object) $config;
        $this->_sql = $sql;
        $this->_driver = $this->_config->driver;
    }

    public function fetch($mode = \PDO::FETCH_NUM)
    {
        $this->_values = $this->_statement->fetch($mode);
        return $this->_values;
    }
    
    public function fetchAll($mode = \PDO::FETCH_NUM)
    {
        $this->_values = $this->_statement->fetchAll($mode);
        return $this->_values;
    }

    public function fetchObject()
    {
        return $this->_statement->fetchObject();
    }
    
    public function columnCount()
    {
        if (!isset($this->_fieldCount)) {
            try {
                $this->_fieldCount = $this->_statement->columnCount();
            } catch (\PDOException $ex) {
                if (isset($this->_values[0])) {
                    $this->_fieldCount = count($this->_values[0]);
                } else {
                    throw new \Exception("Cannot count fields of a row before the resource is fetched", -1, $ex);
                }
            }
        }
        return $this->_fieldCount;
    }

    public function rowCount()
    {
        if (!isset($this->_rowCount)) {
            try {
                $this->_rowCount = $this->_statement->rowCount();
            } catch (\PDOException $ex) {
                if (is_array($this->_values)) {
                    $this->_rowCount = count($this->_values);
                } else {
                    throw new \Exception("Cannot count rows of a result set before the resource is fetched", -1, $ex);
                }
            }
        }
        return $this->_rowCount;
    }

    public function getColumnMeta($i)
    {
        return $this->_statement->getColumnMeta($i);
    }

    public function getFieldName($i)
    {
        $name = '';

        if ($this->_driver === Driver::MYSQL && $this->getMySQLiResult()) {
            $field_info = $this->_result->fetch_field_direct($i);
            $name = $field_info->name;
        } else {
            if (!isset($this->_meta[$i])) {
                $this->_meta[$i] = $this->_statement->getColumnMeta($i);
            }
            $name = $this->_meta[$i]['name'];
        }

        return $name;
    }

    public function getFieldType($i)
    {
        $type = '';

        if ($this->_driver === Driver::MYSQL && $this->getMySQLiResult()) {
            $field_info = $this->_result->fetch_field_direct($i);
            $type = $field_info->type;
        } else {
            if (!isset($this->_meta[$i])) {
                $this->_meta[$i] = $this->_statement->getColumnMeta($i);
            }
            $type = $this->_meta[$i]['native_type'];
        }

        return $type;
    }

    public function getFieldLen($i)
    {
        $len = 0;

        if ($this->_driver === Driver::MYSQL && $this->getMySQLiResult()) {
            $field_info = $this->_result->fetch_field_direct($i);
            $len = $field_info->length;
        } else {
            if (!isset($this->_meta[$i])) {
                $this->_meta[$i] = $this->_statement->getColumnMeta($i);
            }
            $len = $this->_meta[$i]['len'];
        }

        return $len;
    }

    private function getMySQLiResult()
    {
        if ($this->_result === null) {
            try {
                $cs = new \mysqli(
                    $this->_config->host,
                    $this->_config->user,
                    $this->_config->password,
                    $this->_config->database,
                    ($this->_config->port !== '') ? $this->_config->port : null
                );

                $this->_result = $cs->query($this->_sql);
            } catch (\Exception $ex) {
                \debugLog(__FILE__ . ':' . __LINE__ . ':' . __METHOD__ . ':', $ex);
                return false;
            }
        }

        return true;
    }
}
