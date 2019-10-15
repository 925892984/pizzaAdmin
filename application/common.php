<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


//函数作用：发送邮箱
//$to:发送给谁，即收件人
//$title：发送主题
//$content:发送内容
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
use mailer\PHPMailer;
use mailer\SMTP;
use mailer\Exception;

function mailto($to,$title,$content){
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->CharSet='utf-8';
        $mail->isSMTP();
        // Set mailer to use SMTP
        $mail->SMTPAuth = true;
        $mail->Host       = 'smtp.126.com';  // Specify main and backup SMTP servers
//        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'hbzhoulei@126.com';                     // SMTP username
        $mail->Password   = 'zl199709205052';                               // SMTP password
        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('hbzhoulei@126.com', '周磊');
        $mail->addAddress($to);     // Add a recipient
//        $mail->addAddress('ellen@example.com');               // Name is optional
//        $mail->addReplyTo('info@example.com', 'Information');
//        $mail->addCC('cc@example.com');
//        $mail->addBCC('bcc@example.com');

        // Attachments
//        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $title;
        $mail->Body    = $content;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        return $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
//        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        exception($mail->ErrorInfo,1001);
    }

}
