<?php
/**
 * Created by PhpStorm.
 * User: 18810
 * Date: 2018/7/17
 * Time: 18:23
 * 类自动载入
 */
spl_autoload_register(function ($class) {
    // 具体项目名称空间前缀
    $prefix='';

    // 名称空间前缀的基目录
    $base_dir=__DIR__.'/';

    // 这个类使用名称空间前缀吗?
    $len=strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // 不是，转到下一个注册的autoloader
        return;
    }
    // get the relative class name
    $relative_class=substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file=$base_dir . str_replace('\\', '/', $relative_class) . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});