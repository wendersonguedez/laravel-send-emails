# Envio de e-mails com PHP + Laravel

#### Projeto prático utilizando PHP + Laravel para o envio de e-mails, onde é realizada toda a validação de um email e a ativação de uma conta.

# Configurações de e-mail no Laravel

-   **mail.php**

    #### Esse arquivo se encontra no caminho **_config/mail.php_** e nele fica todas as configurações de email.

    ```php
    'default' => env('MAIL_MAILER', 'smtp'),
    ```

    -   O bloco do código acima, verifica se a variável **_MAIL_MAILER_** possui algum valor definido, que se encontra no arquivo .env, e caso não tenha nenhum valor, é definido o valor default **_smtp_**.

    ```php
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ],
    ]
    ```

    -   Caso esteja sendo utilizado o serviço **_stmp_**, as configurações acima serão setadas para este serviço.
