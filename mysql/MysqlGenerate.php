<?php
/**
 * Created by PhpStorm.
 * User: 18810
 * Date: 2018/7/17
 * Time: 15:27
 */

namespace Mysql;

use Common\Generate;

class MysqlGenerate extends Generate
{
    public function __construct($data)
    {
        $this->setRequestData($data);
        $address = $this->getRequestData('h') ? : $this->getRequestData('host') ? : '';
        $username = $this->getRequestData('u') ? : $this->getRequestData('user') ? : '';
        $password = $this->getRequestData('p') ? : $this->getRequestData('pwd') ? : '';
        $db = $this->getRequestData('D') ? : $this->getRequestData('database') ? :'';
        $port = $this->getRequestData('P') ? : $this->getRequestData('port') ? : 3306;
        $dsn = 'mysql:host='. $address .';dbname='. $db .';port='.$port;
        $this->conn = new \PDO($dsn, $username, $password);
        $this->db = $db;
        return parent::__construct();
    }

    public function generate($prefix = null)
    {
        if ($prefix) {
            $tables = $this->conn->query('show tables like "'.$prefix.'%"')->fetchAll();
        } else {
            $tables = $this->conn->query('show tables')->fetchAll();
        }
        $_tables = [];
        foreach ($tables as $table) {
            $_tables[]['TABLE_NAME'] = $table[0];
        }

        //循环取得所有表的备注及表中列消息
        foreach ($_tables as $k => $v) {

            $sql = 'SELECT * FROM ';
            $sql .= 'INFORMATION_SCHEMA.TABLES ';
            $sql .= 'WHERE ';
            $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$this->db}'";
            $tr = $this->conn->query($sql)->fetch(\PDO::FETCH_ASSOC);
            $_tables[$k]['TABLE_COMMENT'] = $tr['TABLE_COMMENT'];

            $sql = 'SELECT * FROM ';
            $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
            $sql .= 'WHERE ';
            $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$this->db}'";
            $fields = [];
            $field_result = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($field_result as $fr)
            {
                $fields[] = $fr;
            }
            $_tables[$k]['COLUMN'] = $fields;
        }
        $str = '';
        foreach ($_tables as $k => $v) {
            $str .= '### '.$v['TABLE_NAME'] . '  ' . $v['TABLE_COMMENT']. PHP_EOL;
            $str .= $this->getHeader();
            $columns = $this->conn->query('show full columns from '.$v['TABLE_NAME']);
            foreach ($columns as $column) {
                if ($column['Key'] === 'PRI') {
                    $default = $column['Default'] ? $column['Default'] : $column['Extra'];
                } else {
                    $default = $column['Default'];
                }
                $str .= '|' . $column['Field'] . '|' . $column['Type'] . '|' . $this->getKeyType($column['Key']) . '|' . $default . '|' . $column['Comment']. '|' .PHP_EOL;
            }
            $str .= PHP_EOL;
        }
        $path = './doc/'.$this->db.'.md';
        if ($str) {
            return file_put_contents($path, $str);
        }
        return true;
    }

    private function getKeyType($type)
    {
        if ($type === 'PRI') {
            if ($this->getLanguage() === 'zh-CN') {
                return '主键';
            } else {
                return 'Primary Key';
            }
        } elseif ($type) {
            if ($this->getLanguage() === 'zh-CN') {
                return '索引';
            } else {
                return 'Index';
            }
        } else {
            return '';
        }
    }
}