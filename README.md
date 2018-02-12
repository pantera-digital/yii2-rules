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
и выполните:
```
composer update
```

## Миграции
```
php yii migrate/up --migrationPath=@pantera/rules/migrations
```

## Подключение

Добавить в ```frontend/config/main.php```
```
...

'bootstrap' => ['rules']

...

'modules' => [
    'rules' => [
        'class' => 'pantera\rules\Module',
        'classes' => [
            namespace\to\YourClassName::className() => [
                namespace\to\YourClassName::YOUR_CLASS1_EVENT_KEY_1,
                namespace\to\YourClassName::YOUR_CLASS1_EVENT_KEY_2,
                ...
            ],
            namespace\to\YourClassName2::className() => [
                namespace\to\YourClassName2::YOUR_CLASS2_EVENT_KEY_1,
                namespace\to\YourClassName2::YOUR_CLASS2_EVENT_KEY_2,
                ...
            ],
        ],
    ],
]

...
```

Добавить в ```backend/config/main.php```
```
...

'modules' => [
    'rules' => [
        'class' => 'pantera\rules\admin\Module',
        'permissions' => ['admin'],
    ],
]

...
```

## Использование
В бекенде управление осуществляется по адресу index.php?r=rules/rules. Необходимо добавить требуемые вам rule и в них задать actions на события.

В коде action доступны переменные:

```$model``` - объект который сгенерировал событие;

```$user``` - текущий пользователь системы, при котором событие сгенерировано.

Пример action, который отправляет уведомление на email администратора при запросе обратного звонка от пользователя на сайте (событие сохранения в БД запроса на обратный звонок):

```

common\models\CallMe::EVENT_AFTER_INSERT

Yii::$app->mailer->compose('call-me', ['model' => $model])
    ->setFrom('your_mail@domain.com')
    ->setTo(Yii::$app->params['managerEmail'])
    ->setSubject('Запрос звонка на сайте')
    ->send();
```
