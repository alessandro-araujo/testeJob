<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Documentation

## ➡️ Requisitos.

- **Docker** 27.5.1 ou superior
- **DevContainer** Extencion VSCODE


## ➡️ Usando o projeto pela **primeira vez**.
### Inicie o projeto no DevContainer
* Portas como **(80/9000/5432/8080)** devem estar disponiveis.

### O arquivo **.env** já esta configurado.

### Instalando depêdencias
- **Instale as depêndencias:**
```shell
composer install
```
### Instalando **Packages NPM**
```shell
npm install
```

### Criando banco de dados
- **Executar as migrations**
* Após configurar o .env, execute:
```shell
php artisan migrate
```
* Obs: Caso, não tenha um banco, `laravel`, digite sim:
```shell
WARN  The database 'laravel' does not exist on the 'mysql' connection.
Would you like to create it? (yes/no) [yes]
❯ yes
```

### Inicie o **Job** para hospedar as planilhas. 
```shell
php artisan queue:work --queue=SpreadsheetJob
```

- **Entre no sistema e crie seu cadastro.**
    - **Acesse: [http://localhost/](http://localhost/)**

- **Entre no adminer.**
    - **Acesse: [http://localhost:8080](http://localhost:8080)**

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
