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

#### Criando a classe utilizando o artisan

```php
php artisan make:mail ExampleMail
```

> A classe criada se encontra dentro de **_app/Mail/ExampleMail.php_**

#### Estrutura da classe criada:

```php
class ExampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {

    }

    public function envelope()
    {
        return new Envelope(
            # remetente do e-mail (quem está enviando).
            from: new Address('wenderson@gmail.com', 'Wenderson'),
            # assunto do e-mail.
            subject: 'Apenas teste',
        );
    }

    public function content()
    {
        return new Content(
            # path da view.
            view: 'emails.users.example',
        );
    }

    public function attachments()
    {
        return [];
    }
}
```

-   public function \_\_construct() : Dentro do método **_\_\_construct_**, podemos definir os dados que serão passados para essa class, sempre que receber e-mails.

-   public function envelope() : Nesse método, é realizada a configuração do remetente do e-mail, ou seja, quem está enviando o e-mail.

-   public function content() : Nesse método, é definida a view que será renderizada no corpo do e-mail. Seguindo um padrão, é definida uma pasta **_emails_** dentro do diretório **_views_**, onde terá as views com seus respectivos nomes.

# Criação da view que será renderizada dentro do corpo do e-mail

#### Após a criação da pasta emails dentro do diretório views, é necessário criar um arquivo **_.blade_** dentro da pasta emails.

> -   path: views/emails/users/example.blade.php

#### Arquivo blade somente para teste:

```html
<h1>H1 do email</h1>

<p>Paragráfo</p>
```

# Utilizando Mailtrap como serviço de SMTP

#### Após realizar o cadastro na plataforma, é necessário atualizar o arquivo .env com as credencias fornecidas pela plataforma.

-   **.env**

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=*****
MAIL_USERNAME=****************
MAIL_PASSWORD=****************
MAIL_ENCRYPTION=tls
```

#### Após atualizar o arquivo .env com as credenciais do servidor SMTP, podemos realizar um envio de e-mail como teste.

# Enviando um e-mail de fato

#### Como teste, podemos realizar o envio do e-mail através de uma rota.

```php
Route::get('/test-email', function () {
    Mail::to('wendersonguedes6@gmail.com')->send(new ExampleMail());

    return 'email enviado';
});
```

-   Ao acessar a rota **_/test-email_** o e-mail será enviado e exibirá uma mensagem caso seja enviado com sucesso.

-   **_Mail::to('wendersonguedes6@gmail.com')->send(new ExampleMail())_** fica responsável por realizar o envio da mensagem para o e-mail passado como parâmetro.
