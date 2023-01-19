# Envio de e-mails com PHP + Laravel

#### Projeto prático utilizando PHP + Laravel para o envio de e-mails, onde é realizada toda a validação de um email e a ativação de uma conta.

# Configurações de e-mail no Laravel

-   **mail.php**

    #### Esse arquivo se encontra no caminho **_config/mail.php_** e nele fica todas as configurações de email.

    ```php
    'default' => env('MAIL_MAILER', 'smtp'),
    ```

    -   Pega o valor definido na variável 'MAIL_MAILER', que se encontra no arquivo .env, e caso não tenha nenhum valor, é definido o valor default 'smtp'.