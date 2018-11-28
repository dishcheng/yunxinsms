# 网易云信短信sdk
For laravel >= 5.5

[官方文档](https://dev.yunxin.163.com/docs/product/%E7%9F%AD%E4%BF%A1/%E7%9F%AD%E4%BF%A1%E6%8E%A5%E5%8F%A3%E6%8C%87%E5%8D%97)


> composer require dishcheng/yunxinsms:~1.0 

> php artisan vendor:publish --provider="DishCheng\\YunXinSms\\YunXinSmsProvider" --tag=yunxinsms


## Usage:
use DishCheng\YunXinSms\YunXinSms;

### 验证码类短信
```php
$params = ['mobile' => 'xxxxxxx', 'templateid' => 'xxxxxxx', 'authCode' => '1111'];
var_dump(YunXinSms::code_post($params));
```


### 通知类短信
```php
$params = ['mobiles' => json_encode([xxxxxxx]), 'templateid' => 'xxxxxxx', 'params' => json_encode([xxxx, xxxx, xxxx])];
$response = self::notice_post($params);
var_dump($response);
```
