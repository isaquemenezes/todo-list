<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tela Inicial</title>


        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 text-gray-900">

        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Minha Aplicação</h1>
                <ul class="flex space-x-6">
                    <li><a href="/" class="text-gray-700 hover:text-blue-500">Início</a></li>

                        <li><a href="/usuarios" class="text-gray-700 hover:text-blue-500">Usuários</a></li>


                    <li><a href="/relatorios" class="text-gray-700 hover:text-blue-500">Relatórios</a></li>
                    <li><a href="/configuracoes" class="text-gray-700 hover:text-blue-500">Configurações</a></li>
                    <li> <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">Sair</button>
                    </form></li>
                </ul>
            </div>
        </nav>


        <main class="max-w-7xl mx-auto px-6 py-10">
            <h2 class="text-2xl font-semibold mb-6">Bem-vindo à tela inicial</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="/usuarios" class="bg-white p-6 rounded-lg shadow hover:bg-blue-50">
                    <h3 class="text-lg font-bold">Gerenciar Usuários</h3>
                    <p class="text-gray-600">Adicione, edite ou remova usuários do sistema.</p>
                </a>

                <a href="/relatorios" class="bg-white p-6 rounded-lg shadow hover:bg-blue-50">
                    <h3 class="text-lg font-bold">Visualizar Relatórios</h3>
                    <p class="text-gray-600">Acesse relatórios detalhados e exporte dados.</p>
                </a>

                <a href="/configuracoes" class="bg-white p-6 rounded-lg shadow hover:bg-blue-50">
                    <h3 class="text-lg font-bold">Configurações</h3>
                    <p class="text-gray-600">Personalize preferências e configurações do sistema.</p>
                </a>
            </div>
        </main>
    </body>
</html>
