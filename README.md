# 🚀 Projeto Laravel - Gerenciamento de Tarefas 📝

# Construa e Execute
1. Clone o Repositório
```
git clone https://github.com/isaquemenezes/laravel-api-usuario.git
cd api  && cd frontend-vuejs
```
2. Instalar Dependências
```
composer install

```

3. Configure seu Banco favorito(aqui estamos com Postgres):
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
``` 
4. Rode as Migrates e Levante o servidor :
 ```
 php artisan migrate && php artisan serve
``` 


4. Testar a Aplicação | navegador| Postman
```
http://127.0.0.1:8000
```

## Testes Unitários com PHPUnit
```
php artisan test

```



## ✅ Requisitos Técnicos Alcançados (Todos)

## ✨ Requisitos Funcionais

### 👤 1. Autenticação de Usuários

* O usuário deve ser capaz de usar o login e senha informados durante o cadastro para se autenticar na aplicação.
* A aplicação deverá verificar se o usuário está ativo durante a etapa de login.
* O usuário deve ser capaz de alterar ou recuperar a senha 🔑, em caso de esquecimento.

### ➕ 2. Cadastro de Usuários

* O sistema deve possuir um usuário administrador que será responsável por criar usuários através de um cadastro exclusivo para esse perfil.
* O administrador deve ser capaz de cadastrar novos usuários informando:
    * **Nome:** (obrigatório, mínimo de 3 caracteres, máximo de 200)
    * **E-mail:** (obrigatório, único por usuário, e-mail válido, máximo de 200 caracteres)
    * **Senha:** (obrigatório, mínimo de 8 caracteres, com letras, números e símbolos)
    * **Status:** (obrigatório, booleano)
* A senha deve ser criptografada 🔒 antes de inserir o registro no banco de dados.

### 📄 3. Listagem de Usuários

* Mostrar uma lista com os usuários cadastrados, incluindo:
    * Nome, e-mail e status.
    * Ações para editar ✏️ e excluir 🗑️ a tarefa.

### 🔄 4. Atualização de Usuários

* O administrador poderá atualizar o nome, e-mail, status e senha do usuário seguindo os mesmos critérios do cadastro.

### ❌ 5. Exclusão de Usuários

* O administrador poderá excluir um usuário. Antes da exclusão deve aparecer um modal de confirmação. A exclusão somente poderá ser efetivada se o usuário não estiver relacionado a nenhuma tarefa.

### ✅ 6. Cadastro de Tarefas

* Todos os usuários do sistema devem ser capazes de cadastrar uma nova tarefa informando:
    * **Título:** (obrigatório, mínimo de 3 caracteres, máximo de 255).
    * **Descrição:** (opcional, máximo de 500 caracteres).
    * **Status:** (pendente ou concluída).
* Ao realizar o cadastro, a tarefa deve ser automaticamente vinculada ao usuário que criou a tarefa.

### 📑 7. Listagem de Tarefas

* Mostrar uma lista com as tarefas cadastradas, incluindo:
    * Título, descrição e status.
    * Ações para editar ✏️ e excluir 🗑️ a tarefa.
* A listagem deve trazer, por padrão, apenas as tarefas vinculadas ao usuário logado. Entretanto, o filtro pode ser alterado para mostrar tarefas vinculadas a outras pessoas.

### 🧑‍🤝‍🧑 8. Gerenciar Usuários das Tarefas

* Todos os usuários do sistema devem ser capazes de gerenciar as pessoas envolvidas na tarefa, adicionando ou removendo pessoas, inclusive a si mesmo.

### 👍 9. Marcar Tarefa como Concluída

* Todos os usuários do sistema devem ser capazes de marcar a tarefa como concluída através de um clique.

### ✍️ 10. Atualização de Tarefas

* O usuário deve poder atualizar o título, descrição ou status de uma tarefa seguindo os mesmos critérios do cadastro.

### 💣 11. Exclusão de Tarefas

* O usuário deve poder excluir uma tarefa. Antes da exclusão, deve aparecer um modal de confirmação.

### 🔍 12. Pesquisa e Filtro de Tarefas

* Permitir a pesquisa de tarefas pelo título.
* Filtrar as tarefas pelo status (pendente ou concluída).
* Filtrar as tarefas por pessoas.

## ⚙️ Requisitos Técnicos

### 🧱 1. Backend

* Utilizar Laravel 10 para gerenciar o backend.
* As rotas devem ser organizadas em um Resource Controller.
* As validações devem ser feitas usando Form Requests.
* A aplicação deve utilizar Eloquent ORM para acessar o banco de dados.
* Utilizar middlewares, policies ou gates para verificação de permissões de acesso quando aplicável.
* Criar Migrations para as tabelas do banco de dados.
* Utilizar transações de banco de dados durante cadastros, edições e exclusão dos registros das tabelas.
* Criar mensagens de feedback para ações do CRUD (ex.: "Tarefa criada com sucesso!").


### Tecnologias
- [Postman](https://www.postman.com/)
- [Visual Studio Code](https://code.visualstudio.com/)
- [Git](https://git-scm.com/)
- [GiHub](https://github.com/)
- [PHP | 8.1.27 ](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Bootstrap 5.3](https://getbootstrap.com/)
- [Vue: 3.2 ](https://vuejs.org/)
- [DBeaver ](https://dbeaver.io/download/)
- [PostgreSQL](https://www.postgresql.org/)

