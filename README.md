## ПЕРЕД НАЧАЛОМ


## Требования
- PHP 8.2+
- Composer 2+

## Установка

1) Клонируйте проект и установите зависимости:

```bash
composer install
```


3) Примените миграции, чтобы создать таблицы и тестовые данные:

```bash
php vendor/bin/phinx migrate
```

## Запуск

В корне проекта запустите встроенный PHP‑сервер:
```bash
php -S localhost:8765 -t webroot
```

Откройте в браузере `http://localhost:8765`.


### Маршруты
- Список: `/posts`
- Добавить: `/posts/add`
- Просмотр: `/posts/view/{id}`
- Редактировать: `/posts/edit/{id}`
- Удалить: `/posts/delete/{id}` (POST через форму)

### Показ
<img width="936" height="383" alt="Снимок экрана 2025-09-17 122305" src="https://github.com/user-attachments/assets/41ce9fb3-60fc-42cb-ba7a-79b6d5cf131e" />

<img width="939" height="436" alt="Снимок экрана 2025-09-17 122313" src="https://github.com/user-attachments/assets/ac395164-b59d-4ffd-99e9-9a6efc1dd662" />

<img width="925" height="330" alt="image" src="https://github.com/user-attachments/assets/52e45880-8e21-4f3e-9729-17207d63a89b" />

<img width="913" height="428" alt="Снимок экрана 2025-09-17 122525" src="https://github.com/user-attachments/assets/9a608c01-d2be-4591-a4e1-6398633880fa" />

<img width="931" height="360" alt="Снимок экрана 2025-09-17 122401" src="https://github.com/user-attachments/assets/98f4d448-7162-4123-9581-ec2e673131b7" />

<img width="916" height="419" alt="Снимок экрана 2025-09-17 122535" src="https://github.com/user-attachments/assets/ea4fa51d-cd6a-48d9-a8e2-55aff78a83f9" />

