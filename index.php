<?php
/**
 * Created by PhpStorm.
 * User: yijin
 * Date: 2018/7/17
 * Time: 15:19
 */
require_once './autoload.php';
$longOpts = [
    'driver::',
    'host::',
    'user::',
    'pwd::',
    'database::',
    'language::'
];
$options = getopt('d::h::u::p::D::L::', $longOpts);
$driver = $options['d'] ? : $options['driver'] ? : '';
/**
 * @var \Common\Generate $model
 */
$class = '\\'.ucfirst($driver).'\\'.ucfirst($driver).'Generate';
if (in_array($driver, ['mysql'])) {
    try {
        $model = new $class($options);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
} else {
    echo 'Only support mysql';
    exit(1);
}
$model->setLanguage($options['L'] ? : $options['language'] ? : 'en');
if ($model->generate()) {
    echo 'Generate success';
} else {
    echo 'Generate failed';
}
exit(0);