# Envio de e-mails com PHP + Laravel

#### Projeto prático utilizando PHP + Laravel para o envio de e-mails, onde é realizada toda a validação de um email e a ativação de uma conta.

# Configurações de e-mail no Laravel

-   **mail.php**

    #### Esse arquivo se encontra no caminho **_config/mail.php_** e nele fica todas as configurações de email.

    ```php
    'default' => env('MAIL_MAILER', 'smtp'),
    ```

    -   O bloco do código acima, verifica se a variável **_MAIL_MAILER_** possui algum valor definido, que se encontra no arquivo .env, e caso não tenha nenhum valor, é definido o valor default **_smtp_**.
    -   **_Simple Mail Transfer Protocol (SMTP)_** nada mais é que um servidor para receber e-mails enviados por outra pessoa.

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

    ```php
    MAIL_MAILER=smtp
    MAIL_HOST=mailhog
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

    -   MAIL_MAILER: Definir o serviço de email que será utilizado.
    -   MAIL_HOST: URL de autenticação do servidor de smtp.
    -   MAIL_PORT: Porta do servidor smtp.
    -   MAIL_USERNAME: E-mail do usuário.
    -   MAIL_PASSWORD: Senha do e-mail do usuário.
    -   MAIL_ENCRYPTION: Criptografia utilizada no servidor.
    -   MAIL_FROM_ADDRESS: Remetente dos e-mail (normalmente é definido um default, caso nenhum seja definido).
    -   MAIL_FROM_NAME: Nome da aplicação.
    -   Alguns dados são fornecidos pelo servidor de SMTP.

# Criando classe para envio de e-mail

### Criando a classe utilizando o artisan

```php
php artisan make:mail ExampleMail
```
