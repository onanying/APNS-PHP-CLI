<?php

/**
 * 自动载入配置
 * @author 刘健 <59208859>
 */
spl_autoload_register(function ($class) {
    include 'Library' . DIRECTORY_SEPARATOR . $class . '.class.php';
});
