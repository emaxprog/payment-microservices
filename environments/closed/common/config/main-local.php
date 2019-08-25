<?php
return [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'messageConfig' => [
                'charset' => 'UTF-8',
                // 'from' => 'noreply@mydomain.com',
                // 'bcc' => 'developer@mydomain.com',
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => getenv('mail_host'),          //@common/config/serv.env -> mail_host=smtp.gmail.com,
                'username' => getenv('mail_username'),  //@common/config/serv.env -> mail_username=my@gmail.com,
                'password' => getenv('mail_password'),  //@common/config/serv.env -> mail_password=pass,
                'encryption' => getenv('mail_encryption'),
                'port' => getenv('mail_port'),
            ],
        ],
    ],
    'params' => [],
];
