# Transfer
#### Descrição
Serviço REST API para cadastro de usuários - clientes e lojas, onde clientes possam realizar transações de valores entre conta e lojas apenas receber estes valores.

#### Tecnologias e serviços
Abaixo as tecnologias utilizadas no projeto.
- Laravel (PHP)
- Banco de dados (MySQL)
- Banco de dados chave/valor (Redis)

#### Instruções instalação
```php
git clone
composer install
php artisan migrate
php artisan db:seed
```

#### Métodos
Abaixo o padrão de requisições para consumir serviços.

###### Registrar usuários
```bash
# Endpoint
[POST] /api/user/register

# Payload
{
    "name": "João Teste ",
    "document": "634.489.640-00", #Documento - CPF para clientes / CNPJ para lojas
    "email": "email_2@email.com",
    "password": "123456"
}

# Response
Status: 200
Body:
{
    "success": true,
    "messages": {
        "name": "João Teste",
        "email": "email_2@email.com",
        "document": "63448964000",
        "type_users_id": 1,
        "updated_at": "2020-08-25 00:16:21",
        "created_at": "2020-08-25 00:16:21",
        "id": 1,
        "account": {
            "value": 0,
            "user_id": 1,
            "updated_at": "2020-08-25 00:16:21",
            "created_at": "2020-08-25 00:16:21",
            "id": 1
        }
    }
}
```

------------

###### Transações
```bash
# Endpoint
[POST] /api/public/transaction

# Payload
{
    "value" : 100, #númerico
    "payer" : 2,
    "payee" : 3
}

# Response
Status: 200
Body:
{
    "success": true,
    "messages": "Transação efetuada com sucesso."
}
```