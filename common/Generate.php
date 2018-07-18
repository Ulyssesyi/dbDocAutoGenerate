<?php
/**
 * Created by PhpStorm.
 * User: 18810
 * Date: 2018/7/17
 * Time: 15:46
 */

namespace Common;


class Generate implements iGenerate
{
    public $conn;
    public $db;
    private $_requestData;
    private $_headerZHCN = '| 字段名 | 类型 | 索引 | 默认值 | 备注 |'.PHP_EOL;
    private $_headerEN = '| Field | Type | Key | Default | Comment |'.PHP_EOL;
    private $_language = 'zh-CN';

    /**
     * Generate constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        if ($this->conn instanceof \PDO || $this->conn instanceof \mysqli) {
            return '';
        } else {
            throw new \Exception('database isn\'t connected', 500);
        }
    }

    public function generate($prefix = null)
    {
        return true;
    }

    public function setLanguage($language)
    {
        $this->_language = $language;
    }

    public function getLanguage()
    {
        return $this->_language;
    }

    public function getHeader()
    {
        if ($this->_language === 'zh-CN') {
            return $this->_headerZHCN.'|--- | --- | --- | --- | --- |'.PHP_EOL;
        } else {
            return $this->_headerEN.'|--- | --- | --- | --- | --- |'.PHP_EOL;
        }
    }

    public function setRequestData($data) {
        $this->_requestData = $data;
    }

    public function getRequestData($key = null)
    {
        if ($key) {
            return isset($this->_requestData[$key]) ? $this->_requestData[$key] : null;
        } else {
            return $this->_requestData;
        }
    }
}