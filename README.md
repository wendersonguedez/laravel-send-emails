# Envio de e-mails utilizando Laravel 9

#### Projeto prático utilizando PHP + Laravel para o envio de e-mails, onde é realizada toda a validação de um email e a ativação de uma conta.

# Configurações do arquivo de e-mail no Laravel

-   **mail.php**

    #### Esse arquivo se encontra no caminho **_config/mail.php_** e nele fica todas as configurações de email.

    ```php
    'default' => env('MAIL_MAILER', 'smtp'),
    ```

    -   O bloco do código acima, verifica se a variável **_MAIL_MAILER_** possui algum valor definido, que se encontra no arquivo .env, e caso não tenha nenhum valor, é definido o valor default **_smtp_**.
    -   **_Simple Mail Transfer Protocol (SMTP)_** nada mais é que um servidor para receber e-mails enviados por outra pessoa.

    #

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

    -   Caso esteja sendo utilizado o serviço **_smtp_**, as configurações acima serão setadas para este serviço.

    # Configuração das variáveis de ambiente para o envio de um e-mail

    ```js
    MAIL_MAILER = smtp;
    MAIL_HOST = mailhog;
    MAIL_PORT = 1025;
    MAIL_USERNAME = null;
    MAIL_PASSWORD = null;
    MAIL_ENCRYPTION = null;
    MAIL_FROM_ADDRESS = "hello@example.com";
    MAIL_FROM_NAME = "${APP_NAME}";
    ```

    -   MAIL_MAILER: Define o serviço de email que será utilizado.
    -   MAIL_HOST: URL de autenticação do servidor smtp.
    -   MAIL_PORT: Porta do servidor.
    -   MAIL_USERNAME: E-mail concedido pelo servidor SMTP.
    -   MAIL_PASSWORD: Senha concedida pelo servidor SMTP.
    -   MAIL_ENCRYPTION: Criptografia utilizada no servidor.
    -   MAIL_FROM_ADDRESS: Quem está enviando o e-mail (normalmente é definido um default, caso nenhum seja definido).
    -   MAIL_FROM_NAME: Nome da aplicação/Nome de quem está enviando o e-mail.
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

# Utilizando Mailtrap como serviço SMTP

#### Após realizar o cadastro na plataforma, é necessário atualizar o arquivo .env com as credenciais fornecidas pela plataforma.

-   Arquivo .env atualizado:

```js
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=*****
MAIL_USERNAME=****************
MAIL_PASSWORD=****************
MAIL_ENCRYPTION=tls
```

#### Após atualizar o arquivo .env com as credenciais do servidor SMTP, podemos realizar um envio de um e-mail como teste.

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

# Visualizar o corpo do e-mail no browser

#### É possível visualizar no próprio browser como está o corpo do e-mail enviado.

```php
Route::get('/test-email', function () {
    return (new ExampleMail())->render();
    Mail::to('wendersonguedes6@gmail.com')->send(new ExampleMail());

    return 'email enviado';
});
```

-   É necessário criar um objeto da class **_ExampleMail_** e utilizar o método render no momento da instância do objeto.

-   Após isso, o corpo do e-mail será renderizado no browser, facilitando a visualização de como está ficando.

# Passar dados para view de e-mail

#### Primeiramente é necessário criar a tabela de usuários e posteriormente criar um usuário, para que possamos utilizar seus dados na view de e-mail.

-   Rodar a migrate para que a tabela seja criada:

```php
php artisan migrate
```

#

#### Para cenário de teste, vamos realizar a criação de um usuário fictício utilizando o método **_factory_**.

```php
Route::get('/test-email', function () {
    $user = User::factory()->create();
    Mail::to('wendersonguedez4@gmail.com')
        ->send(new ExampleMail($user));

    return 'email enviado';
});
```

-   Todos os dados do usuário criado são passados como argumentos para a classe **_ExampleMail_**, onde são recebidos no método **_\_\_construct_**.

#

```php
public function __construct(private User $user)
{
    #
}
```

-   O método **_\_\_construct_** está esperando um objeto da model **_User_**, que será armazenado na variável **_$user_**. Essa variável é privada, garantindo que somente a própria classe poderá acessá-la.

#

```php
public function content()
{
    return new Content(
        view: 'emails.users.example',
        with: [
            'user' => $this->user
        ],
    );
}
```

-   Para que os dados do usuário possam ser acessados na view, é necessário utilizar o parâmetro **_with_**, onde podemos passar um só valor ou um array com vários valores. No código acima, estamos passando um array, onde o índice **_'user'_** possui os dados obtidos do método **_\_\_construct_**.

#

#### Acessando os dados do usuário na view:

```php
<h1>Olá {{ $user->name }}</h1>

<p>Paragráfo</p>
```

# Enviar e-mails com anexo

#### Fornecendo o caminho do anexo:

```php
public function attachments()
{
    return [
        // Attachment::fromPath('/path/to/file'),
        Attachment::fromPath(storage_path('app/test.txt')),
    ];
}
```

-   A primeira forma que temos para enviar um e-mail com anexo, é fornecendo o caminho do arquivo para o método **_fromPath_**.
-   No exemplo acima, estou enviando como anexo o arquivo **_test.txt_**, que se encontra no path **_storage/app/test.txt_**. **_storage_path_** é um método que aponta para as pastas dentro do diretório **_storage_**.

#

#### Especificar o nome e o tipo MIME do anexo:

```php
public function attachments()
{
    return [
        Attachment::fromPath('/path/to/file')
                ->as('name.pdf')
                ->withMime('application/pdf'),
    ];
}
```

-   É possível também especificar o nome de exibição e tipo MIME do anexo enviado, utilizando os métodos **_as_** e **_withMime_**.

-   **MIME** é uma norma utilizada para indicar o tipo de dado que um arquivo (anexo) contém, nesse caso, se trata de um arquivo **PDF**.

# Renderizar imagens no corpo de um e-mail

#### Para fins de teste, um arquivo de imagem foi salvo em **_storage/app_**, para que ela possa ser enviada junto com a mensagem de e-mail.

```php
public function content()
{
    return new Content(
        view: 'emails.users.example',
        with: [
            'user' => $this->user,
            'imageExample' => storage_path('app/image-test.png')
        ],
    );
}
```

-   A imagem está sendo recuperada através do método **_storage_path_**, que busca o arquivo através do path passada como parâmetro, e logo em seguida sendo armazenada em **_'imageExample'_**.

#

```php
<img src="{{ $message->embed($imageExample) }}" alt="">
```

-   Para renderizar a imagem no corpo do e-mail, é necessário utilizar o método **_embed_**, que é possível acessa-ló através da variável **_$message_**. Como parâmetro, utilizamos a variável $imageExample, que foi passada através do parâmetro **_with_** (código anterior).

# Renderizar estilo markdown no corpo de um e-mail.

#### Para fins de teste, vamos gerar uma nova class de e-mail através do artisan:

```php
php artisan make:mail UserWelcome --markdown=emails.users.welcome
```

-   O comando acima, além de gerar uma classe para envio de emails, também declara que nela será utilizada uma view markdown. **_--markdown=emails.users.welcome_** indica o path que essa view será armazenada.

#

```php
<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

```

-   Código acima foi gerado através do comando anterior utilizando o artisan. Ele utiliza uma combinação de componentes Blade e sintaxe Markdown.

#

```php
public function content()
{
    return new Content(
        markdown: 'emails.users.welcome',
    );
}
```

-   A diferença significativa está que agora ao invés de retornar uma view do tipo **_blade_**, estará retornando uma view do tipo **_markdown_**.

#

```php
Route::get('/test-email-markdown', function () {
    return (new UserWelcome())->render();
    return 'email markdown enviado';
});
```

> -   Inicialmente, ao acessar a rota definida, foi retornada uma exception: **_Call to undefined function mb_strcut()_**, que foi resolvida ao instalar a extensão mbstring, de acordo com a versão do **_PHP_** utilizada no projeto.

-   Para fins de teste, criaremos uma nova rota para realizar o envio de e-mails utilizando markdown.

-   Ao acessar a rota definida, será exibido no browser a estrutura do nosso arquivo markdown que é gerado por default, como foi mostrado mais acima.

# Personalizar e-mails markdown

#### O próprio laravel disponibiliza uma estrutura markdown bem legal, no entanto, toda essa estrutura pode ser personalizada. Para isso, é necessário publicar as **_assets/tags_** da view markdown através do artisan.

```php
php artisan vendor:publish --tag=laravel-mail
```

-   O comando acima irá copiar o diretório das assets que iremos personalizar, para o diretório **_resources_**. Com isso, podemos personalizar as views.

> -   Path das views: **_resources/views/vendor/mail_**

```php
'markdown' => [
    'theme' => 'default',

    'paths' => [
        resource_path('views/vendor/mail'),
    ],
],
```

-   O código acima se encontra dentro de **_config/mail.php_**, e se trata das configurações das views de markdown.

    -   'theme' => 'default' : Indica qual o tema CSS utilizado nas views markdown, que se encontra em **_resources/views/vendor/mail/html/themes/default.css_**. E através desse arquivo, podemos personalizar
        a aparência dos e-mails;

    -   'paths' => [] : Caminho do diretório onde se encontra as assets dos e-mails;

    -   Todas as informações podes acima podem ser alteradas. Caso deseja alterar o nome do tema CSS ou até mesmo o nome do diretório, basta apenas no bloco de código acina, dentro de **_config/mail.php_**;
