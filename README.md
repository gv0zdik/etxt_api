# Etxt API

Класс реализует API биржи контента www.etxt.ru.

### Использование

На странице "Личная информация" -> "Настройки интерфейса" нужно указать пароль API и получить token.

```php
require_once('./src/Etxt.php');

$params = ['online' => '1'];

$etxt = new Etxt\Etxt('token_api', 'pass_api');
$result = $etxt->api('users.getList', $params);

print_r($result);
```