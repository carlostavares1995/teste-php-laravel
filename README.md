![Logo AI Solutions](http://aisolutions.tec.br/wp-content/uploads/sites/2/2019/04/logo.png)

# AI Solutions

## Teste para novos candidatos (PHP/Laravel)

### Introdução

Este teste utiliza PHP 8.1, Laravel 10 e um banco de dados SQLite simples.

1. Faça o clone desse repositório;
1. Execute o `composer install`;
1. Crie e ajuste o `.env` conforme necessário
1. Execute as migrations e os seeders;

### Primeira Tarefa:

Crítica das Migrations e Seeders: Aponte problemas, se houver, e solucione; Implemente melhorias;

### Segunda Tarefa:

Crie a estrutura completa de uma tela que permita adicionar a importação do arquivo `storage/data/2023-03-28.json`, para a tabela `documents`. onde cada registro representado neste arquivo seja adicionado a uma fila para importação.

Feito isso crie uma tela com um botão simples que dispara o processamento desta fila.

Utilize os padrões que preferir para as tarefas.

### Terceira Tarefa:

Crie um test unitário que valide o tamanho máximo do campo conteúdo.

Crie um test unitário que valide a seguinte regra:

Se a categoria for "Remessa" o título do registro deve conter a palavra "semestre", caso contrário deve emitir um erro de registro inválido.
Se a caterogia for "Remessa Parcial", o titulo deve conter o nome de um mês(Janeiro, Fevereiro, etc), caso contrário deve emitir um erro de registro inválido.

Boa sorte!

### Instruções para o setup docker do projeto:

Copie o arquivo .env.example para .env

```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env

```dosini
APP_NAME="Upload JSON"
APP_URL=http://localhost:8181

DB_CONNECTION=pgsql
DB_HOST=database
DB_PORT=5432
DB_DATABASE=document_db
DB_USERNAME=root
DB_PASSWORD=123456

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Crie os containers do projeto

```sh
docker-compose up -d
```

Entre no container app

```sh
docker-compose exec app bash
```

Instale as dependências do projeto

```sh
composer install
```

Gere a key do Laravel

```sh
php artisan key:generate
```

Execute as migrations e as seeds

```sh
php artisan migrate --seed
```

Acesse o projeto
[http://localhost:8181](http://localhost:8181)

### Observações e pensamentos:

1. Esquema SQLite: Não é necessário manter o arquivo 'sqlite-schema.sql', pois o Laravel já gerencia a criação e o histórico das tabelas através das migrations. Vou manter apenas as tabelas essenciais para o desafio e considerar melhorias adicionais posteriormente.

2. Organização das migrations: As migrations foram organizadas de forma mais lógica.

3. Alteração no 'bigInteger': A correção seria utilizar 'unsignedBigInteger', mas optei por uma abordagem mais direta com foreignId.

4. Unique para o nome da categoria: Adicionei unique na coluna name da tabela categories para evitar categorias repetidas.

5. Tabela 'failed_jobs': Criei a tabela 'failed_jobs' para salvar as jobs que deram erro durante sua execução.

6. Uso de enum para categorias: A coluna name na tabela categories foi alterada para enum, o que é apropriado para campos com um conjunto fixo de valores (como "Remessa" e "Remessa Parcial") que não mudam frequentemente. No entanto, se essas categorias mudam com frequência ou se novos valores forem adicionados, essa abordagem pode não ser a melhor.

7. Possível adição de código para categorias: Considerei adicionar uma coluna de código para usar como referência nas categorias, permitindo a alteração do nome no futuro, sem afetar a integridade dos dados. No entanto, como o nome da categoria já está definida como um enum e a estrutura do arquivo .json já está mapeada, decidi manter o modelo atual do tópico 6.

8. Seeders e factories: Atualizei o seeder para utilizar 'updateOrCreate', garantindo que as categorias não sejam duplicadas caso a seeder seja executada múltiplas vezes. Além disso, criei uma factory para o modelo 'Category', que poderá ser utilizada para testes futuros. Adicionei a chamada da seed em 'DatabaseSeeder'.

9. Relação com usuários: Considerei adicionar uma relação entre documentos e usuários do sistema, o que permitiria notificar os usuários quando o processo fosse concluído. No entanto optei por não implementar isso por agora.

10. Tratamento de exclusão de categorias: Se a exclusão de categorias for uma possibilidade, poderia ser interessante definir 'category_id' como 'nullable' em vez de usar 'cascade'. No entanto, isso depende das regras de negócio da aplicação. Portanto, mantive a exclusão em 'cascade'.

---

11. Acredito que o desafio seja mais focado no back-end, então deixei o front-end o mais simples possível, e optei por utilizar Blade ao invés do vue.js.

12. Estou trabalhando com o arquivo routes/web.php por simplificação, mas se fosse uma API isolada, criaria no arquivo routes/api.php com uma arquitetura de pastas mais robusta, separando a API por versões e utilizando os retornos do controller como response json.

13. Em uma situação real, não seria necessário criar um botão para processar a fila, pois o correto seria configurar o worker do job no Supervisor. No entanto, criei o botão utilizando Artisan::call, conforme solicitado.

14. Percebi que o desafio está mais relacionado ao Laravel, então estou utilizando o padrão de queue e job junto com o Redis. No entanto, se fosse necessário isolar as filas, podemos utilizar um bucket do SQS. E em casos onde um evento necessite de múltiplas interações, podemos criar um tópico no SNS antes do SQS para distribuir essas ações.

15. Seria interessante configurar um ambiente de observabilidade para monitorar a aplicação e suas jobs, como por exemplo o New Relic ou o OpenTelemetry, porém neste caso seria necessário mais configurações, e posteriormente definir alguns alertas de monitoramento. No entanto, deixarei isso para um próximo desafio.

16. Se necessário, poderíamos implementar a internacionalização nas mensagens do sistema.

17. Decidi não utilizar uma estratégia de reprocessamento para as jobs com falhas, apenas coletando-as na tabela ‘failed_jobs’, pois nesta aplicação provavelmente a retentativa iria falhar novamente mas para alguns casos faria sentido.

18. Decidi rodar os testes unitários em um banco SQLite em memória, mantendo o banco oficial isolado.

19. Fiz uma configuração padrão para o Nginx, mas podemos fazer ajustes mais detalhados, se necessário.

20. Caso a aplicação necessite de mais performance podemos configurar o OPcache, mas decidi deixar mais simples por enquanto.

21. Existem duas formas de validar os dados do json antes de salvar na fila ou durante a execução. Decidi deixar as validações para a execução da fila, mas isso depende de quanto a aplicação está disposta a processar os dados antes de enviá-los para a fila.

22. Enviei os documentos um a um para a fila para aumentar a capacidade de escala e deixar os dados mais granulados. Em alguns casos, podemos optar por enviar o array inteiro, melhorando um pouco a performance, mas com menos controle sobre sua execução.
