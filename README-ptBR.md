Docs available in [en-US](README.md)

# Modelo inicial de API PHP 💻

## Pré-requisitos 🛠️

- PHP instalado em sua máquina. 🐘
- Composer instalado em sua máquina. 📦
- Banco de dados MySQL configurado. 🗄️
- Entendimento básico de programação em PHP. 🧠

## Instalação de Dependências 🚀

1. Clone o projeto ou baixe o template para o seu diretório local. 📂

2. Navegue até o diretório do projeto e execute o seguinte comando para instalar as dependências:

    ```bash
    composer install
    ```

3. Isso irá instalar todas as dependências listadas no arquivo `composer.json` e garantir que você trabalhe com as versões exatas especificadas em `composer.lock`. 🔒

## Configuração de Variáveis de Ambiente ⚙️

1. Localize o arquivo [.env.example](.env.example) no diretório do projeto. 🗂️

2. Renomeie o arquivo para `.env`:

    Prompt de Comando:
    ```cmd
    rename .env.example .env
    ```
    
    PowerShell:
    ```powershell
    mv .env.example .env
    ```

3. Abra o arquivo `.env` em um editor de texto e configure as variáveis de ambiente conforme necessário: 📝

    - **API Configuration:**
        - `API_HOST`: O endereço onde a API será executada (por exemplo, `localhost`). 🌐
        - `API_PORT`: A porta em que a API será executada (por exemplo, `8000`). 🔌
        - `TIMEZONE`: O fuso horário da aplicação (por exemplo, `America/Sao_Paulo`). 🕰️

    - **Database Configuration:**
        - `DB_HOST`: O endereço do servidor de banco de dados. 🏠
        - `DB_PORT`: A porta do servidor de banco de dados. 🔌
        - `DB_USER`: O nome de usuário para acessar o banco de dados. 👤
        - `DB_PASS`: A senha para acessar o banco de dados. 🔑
        - `DB_NAME`: O nome do banco de dados. 🏷️

4. Salve as alterações no arquivo `.env`. 💾

## Configurando DAO, Model e Controller 🛠️

### DAO (Data Access Object) 🗃️

1. Crie uma classe DAO para cada entidade do banco de dados (por exemplo, `UserDAO` para a tabela `users`). 👥

2. Implemente métodos para operações específicas, como `selectAll()`. 💼

3. Use a conexão com o banco de dados para executar consultas SQL. 💻

#### Aqui está um exemplo de UserDAO:

```php
<?php

namespace App\DAO;

class UserDAO extends DAO
{
    // Construtor para inicializar o objeto UserDAO
    public function __construct()
    {
        // Chama o construtor da classe pai (DAO) para inicializar a conexão com o banco de dados
        parent::__construct();
    }

    // Método para selecionar todos os registros da tabela "User"
    public function selectAll()
    {
        // Definição da consulta SQL para selecionar todos os registros da tabela "User"
        $sql = "SELECT * FROM User";

        // Prepara a consulta SQL usando a conexão com o banco de dados
        $stmt = $this->conn->prepare($sql);

        // Executa a consulta preparada
        $stmt->execute();

        // Retorna todos os resultados da consulta como objetos de classe (baseado na classe DAO)
        return $stmt->fetchAll(DAO::FETCH_CLASS);
    }
}
```

### Model 🧩

1. Crie uma classe Model para cada entidade do banco de dados (por exemplo, `UserModel`). 👤

2. Defina atributos para representar as colunas da tabela de banco de dados. 📊

3. Implemente métodos para interagir com o DAO, como `getAll()`. 🛠️

#### Aqui está um exemplo de UserModel:

```php
<?php

namespace App\Model;

use App\DAO\UserDAO;
use Exception;

class UserModel extends Model
{
    // Atributos públicos para representar as colunas da tabela User
    public $id, $name;

    // Método para obter todos os registros da tabela User
    public function getAll()
    {
        try {
            // Cria uma instância de UserDAO para acessar a camada de dados
            $dao = new UserDAO();
            // Chama o método selectAll() de UserDAO para obter todos os registros
            // Os resultados são armazenados na propriedade $rows
            $this->rows = $dao->selectAll();
        } catch (Exception $e) {
            // Lança uma exceção em caso de erro durante a execução
            throw $e;
        }
    }
}
```

### Controller ⚙️

1. Crie uma classe Controller para cada recurso ou conjunto de funcionalidades da sua API (por exemplo, `UserController`). 💡

2. No Controller, crie métodos para responder a solicitações HTTP específicas, como `GET`, `POST`, `PUT`, e `DELETE`. 📝

3. Chame os métodos do Model para processar os dados recebidos das solicitações e envie respostas apropriadas ao cliente. 📨

#### Aqui está um exemplo de UserController:

```php
<?php

namespace App\Controller;

use App\Model\UserModel;

class UserController extends Controller
{
    // Método estático que será executado quando a rota correspondente for acessada
    public static function index(): void
    {
        // Cria uma nova instância de UserModel para acessar a camada de modelo
        $model = new UserModel;
        
        // Chama o método getAll() de UserModel para obter todos os registros
        $model->getAll();
        
        // Envia a resposta em formato JSON contendo os registros obtidos
        parent::sendJSONResponse($model->rows);
    }
}
```

## Registrando as rotas da api ↪️

1. Adicione as rotas necessárias no arquivo [routes.php](App/routes.php):

```php
<?php
use App\Controller\UserController;
use App\Modules\HttpMethod;
use App\Modules\Router;

Router::request(HttpMethod::GET, "/users", [UserController::class, "index"]);
```

## Iniciando a Aplicação 🏁

1. Para iniciar a aplicação, execute o seguinte comando no diretório raíz do projeto:

    ```bash
    php api start
    ```

2. Isso iniciará o servidor no endereço e porta definidos em `.env`.

## Testando a API 🧪

1. Faça chamadas HTTP aos endpoints da sua API para verificar se tudo está funcionando conforme esperado. ✅

2. Use ferramentas como Insomnia para enviar solicitações `GET`, `POST`, `PUT`, e `DELETE`. 📮

3. Verifique as respostas para garantir que os dados sejam processados corretamente. ✔️