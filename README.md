# yii2-rules
Rules module for Yii Framework 2.x gives ability to create and manage reactions for events

## Установка
Предпочтительно через composer:
```
composer require pantera-digital/yii2-rules "@dev"
```
Или добавьте в composer.json
```
"pantera-digital/yii2-rules": "@dev"
```

## Миграции
```
php yii migrate/up --migrationPath=@pantera/rules/migrations
```

## Подключение

Добавить в ```frontend/config/config.php```
```
...

'bootstrap' => ['rules']

...

'modules' => [
    'rules' => [
        'class' => 'pantera\rules\Module',
    ],
]

...
```

Добавить в ```backend/config/config.php```
```
...

'modules' => [
    'rules' => [
        'class' => 'pantera\rules\admin\Module',
    ],
]

...
```

## Использование
В бекенде управление осуществляется по адресу index.php?r=rules/rules
