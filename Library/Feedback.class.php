<?php

/**
 * APNS Feedback 类
 * @author 刘健 <59208859>
 */
class Feedback extends Base
{

    protected $services = array(
        'tls://feedback.push.apple.com:2196', // 开发状态服务器地址
        'tls://feedback.sandbox.push.apple.com:2196', // 产品状态服务器地址
    );

    const TIME_BINARY_SIZE = 4;
    const TOKEN_LENGTH_BINARY_SIZE = 2;
    const DEVICE_BINARY_SIZE = 32;

    protected $data = array();

    public function __construct($params = array())
    {
        empty($params) or $this->connect($params);
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    // 接收消息
    public function receive()
    {
        $feedbackLen = self::TIME_BINARY_SIZE + self::TOKEN_LENGTH_BINARY_SIZE + self::DEVICE_BINARY_SIZE;
        $this->data = array();
        $buffer = '';
        while (!@feof($this->socket)) {
            // 读取数据
            $tmpBuffer = @fread($this->socket, 8192);
            if ($tmpBuffer === false) {
                throw new Exception('Failed to fread');
            }
            $buffer .= $tmpBuffer;
            // 显示状态
            $tmpBufferLen = strlen($tmpBuffer);
            if ($tmpBufferLen > 0) {
                // 打印日志
                log_info('feedback', "{$tmpBufferLen} bytes read");
            }
            unset($tmpBuffer, $tmpBufferLen);
            // 解包
            $bufferLen = strlen($buffer);
            if ($bufferLen >= $feedbackLen) {
                $counts = floor($bufferLen / $feedbackLen);
                for ($i = 0; $i < $counts; $i++) {
                    // 取一条数据
                    $feedbackBuffer = substr($buffer, 0, $feedbackLen);
                    $buffer = substr($buffer, $feedbackLen);
                    // 解包
                    $this->data[] = $feedback = $this->binaryParse($feedbackBuffer);
                    // 打印日志
                    $msg = sprintf(
                        "timestamp=%d (%s), tokenLength=%d, deviceToken=%s",
                        $feedback['timestamp'],
                        date('Y-m-d H:i:s', $feedback['timestamp']),
                        $feedback['tokenLength'],
                        $feedback['deviceToken']
                    );
                    log_info('feedback', $msg);
                    unset($feedback, $msg);
                }
            }
        }
        return $this->data;
    }

    // 二进制解包
    protected function binaryParse($binaryBuffer)
    {
        return unpack('Ntimestamp/ntokenLength/H*deviceToken', $binaryBuffer);
    }

}
