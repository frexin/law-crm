# Lawyers

## Требования
1) PHP >= 7.0.9

## Wiki
1. [Краткое описание структуры базы данных](http://git.devbrains.me/team/lawyers/wikis/db_tables)

## Библиотеки / модули подключенные к проекту
1. [Doctrine ORM](https://symfony.com/doc/current/doctrine.html) - для работы с БД. Включена по умолчанию.
2. [DoctrineMigrationsBundle](https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html) - для миграций и автогенерации таблиц с Entities
3. [AliceBundle](https://github.com/hautelook/AliceBundle/tree/1.x) - для генерации фикстур

## Автогенерация базы данных с Entities
`php bin/console doctrine:migrations:diff` - проверяет различия между базой данных и Entities в проекте. Создает миграцию, если они есть.

`php bin/console doctrine:migrations:migrate` - запускает миграции

## Запуск фикстур
`php ./bin/console doctrine:fixtures:load` - **ВНИМАНИЕ** - применение фикстур сотрет все записи из бд