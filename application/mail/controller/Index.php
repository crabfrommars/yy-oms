<?php


namespace app\mail\controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Index
{
    public function sendMail($to,$title,$content)
    {
        $mail=new PHPMailer();  // 实例化PHPMail核心类
        $mail->SMTPDebug=1;  // 是否启用smtp的debug进行调试，开发环境开启，生产环境注释
        $mail->isSMTP();  // 使用smtp鉴权方式发送邮件
        $mail->SMTPAuth=true;  // smtp鉴权，必须为true

    }
}