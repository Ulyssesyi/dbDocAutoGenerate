<?php
/**
 * Created by PhpStorm.
 * User: 18810
 * Date: 2018/7/17
 * Time: 15:41
 */

namespace common;

interface iGenerate {
    public function generate();
    public function setLanguage($language);
    public function getLanguage();
    public function setRequestData($data);
    public function getRequestData($key = null);
    public function getHeader();
}