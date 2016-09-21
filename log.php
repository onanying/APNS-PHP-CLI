<?php

/**
 * 输出错误日志到文件
 * @author 刘健 <59208859>
 */
function log_err($tag, $message)
{
    $content = date('Y-m-d H:i:s') . " | ERROR | {$tag} | {$message}" . PHP_EOL;
    print $content;
    file_put_contents('Log/error.log', $content, FILE_APPEND | LOCK_EX);
}

/**
 * 输出信息日志到文件
 * @author 刘健 <59208859>
 */
function log_info($tag, $message)
{
    $content = date('Y-m-d H:i:s') . " | INFO | {$tag} | {$message}" . PHP_EOL;
    print $content;
    file_put_contents('Log/info.log', $content, FILE_APPEND | LOCK_EX);
}
