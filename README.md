# Test

## Запуск с нуля
- docker-compose up -d

чтобы накатит миграци делаем

- docker exec -it football-tournament-manager_php_1 bash


когда уже находимся  внутри  контейнера делмаем 

- bin/console doctrine:migrations:migrate 

Doctrine попросит вас подтвердить выполнение миграции, так как это может изменить вашу базу данных. После подтверждения миграция будет выполнена.

для того чтобы сделать запросы в Postman делаем следующее

- docker inspect football-tournament-manager_nginx_1

после чего капируем IPAddress например  172.30.0.2




- Достпуна по адресу [http://172.30.0.2:81](http://localhost:81)

## Доступы к бд

сначала нужно получить IPAddress  Postgres для этого запускаем следующую команду

- docker inspect football-tournament-manager_postgres_1

аналагичном образом  кампируем IPAddress  и этот IP вставляем  вместо localhost




БД: test

Юзер: user

Пароль: password

Порт: 5432