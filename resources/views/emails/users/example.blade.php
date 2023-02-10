<h1>Olá {{ $user->name }}</h1> {{-- $user->name é capturando através da variável passada no __construct, na classe
'ExampleMail' --}}

<p>Paragráfo</p>

<img src="{{ $message->embed($imageExample) }}" alt="{{ $user->name }}">