# CRUD de Jogadores em PHP + MySQL

Este projeto implementa um CRUD (Create, Read, Update, Delete) para a tabela **jogadores** em PHP, utilizando o servidor local do **XAMPP**.

---

## Pré-requisitos

- [XAMPP](https://www.apachefriends.org/pt_br/download.html) instalado (versão com PHP e MySQL).
- Editor de código (VS Code, Sublime, etc).
- Navegador atualizado.

---

## Configuração do Ambiente

1. **Instalar e iniciar o XAMPP**  
- Abra o **XAMPP Control Panel**.  
- Inicie os serviços **Apache** e **MySQL**.

2. **Configurar o projeto no htdocs**  
- Copie a pasta do projeto para o diretório:
```
    C:\xampp\htdocs\
    ```
  - Renomeie a pasta, se desejar, para algo como `crud_jogadores`.

3. **Criar o banco de dados**  
  - Acesse o phpMyAdmin no navegador:
    ```
    http://localhost/phpmyadmin
    ```
  - Crie o banco com o nome:
    ```sql
    CREATE DATABASE futebol_db;
    ```
  - Selecione o banco `futebol_db` e execute os scripts SQL do arquivo fornecido (`banco.sql` ou conforme documentação), por exemplo:
    ```sql
    USE futebol_db;

    CREATE TABLE times (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        cidade VARCHAR(100) NOT NULL
    );

    CREATE TABLE jogadores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        posicao VARCHAR(30) NOT NULL,
        numero_camisa INT NOT NULL,
        time_id INT,
        FOREIGN KEY (time_id) REFERENCES times(id)
    );
    ```

---

## Configuração da Conexão

Edite o arquivo **`config.php`** (ou equivalente no projeto) e configure com os dados do seu MySQL local:

```php
//```php
<?php
$host = "localhost";
$user = "root";  
$pass = "root";   
$db   = "futebol_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
   die("Falha na conexão: " . $conn->connect_error);
}
?>
?>