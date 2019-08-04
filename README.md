# php-login

## install 

```bash
composer require josegonzalez/dotenv 
```

## usage 


### sign up
```php
$userInfo = $login->signup("username","xxx@example.com", "12345678");
```

### login
```php
$userInfo = $login->login("xxx@example.com", "12345678");

```

### login check
```php
$userInfo = $login->check();
```

### logout
```php
$userInfo = $login->logout();
```