# Lawyers

## Требования
1) PHP >= 7.1

## Wiki
1. [Краткое описание структуры базы данных](http://git.devbrains.me/team/lawyers/wikis/db_tables)

## Библиотеки / модули подключенные к проекту
1. [Doctrine ORM](https://symfony.com/doc/current/doctrine.html) - для работы с БД. Включена по умолчанию.
2. [DoctrineMigrationsBundle](https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html) - для миграций и автогенерации таблиц с Entities
3. [AliceBundle](https://github.com/hautelook/AliceBundle/tree/1.x) - для генерации фикстур
4. [StofDoctrineExtensionsBundle](https://symfony.com/doc/current/bundles/StofDoctrineExtensionsBundle/index.html) - полезные дополнения для Doctrine ORM (timestampable, sluggable, etc.)
5. [SonataAdminBundle](https://sonata-project.org/bundles/admin/3-x/doc/getting_started/installation.html) - для админки

## Автогенерация базы данных с Entities
`php bin/console doctrine:migrations:diff` - проверяет различия между базой данных и Entities в проекте. Создает миграцию, если они есть.

`php bin/console doctrine:migrations:migrate` - запускает миграции

## Запуск фикстур
`php ./bin/console doctrine:fixtures:load` - **ВНИМАНИЕ** - применение фикстур сотрет все записи из бд

## Очистить кеш
`php ./bin/consoler cache:clear`