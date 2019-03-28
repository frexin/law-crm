# Lawyers
CRM for law firm. 

## Requirements
1. PHP >= 7.1
2. MySQL
3. Symfony >= 3.2

## Used libraries / modules
1. [Doctrine ORM](https://symfony.com/doc/current/doctrine.html) - for interaction with Database. Enabled by default
2. [DoctrineMigrationsBundle](https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html) - for migrations and entities autogeneration
3. [AliceBundle](https://github.com/hautelook/AliceBundle/tree/1.x) - for fixtures generation
4. [StofDoctrineExtensionsBundle](https://symfony.com/doc/current/bundles/StofDoctrineExtensionsBundle/index.html) - usefull additions for Doctrine ORM (timestampable, sluggable, etc.)
5. [SonataAdminBundle](https://sonata-project.org/bundles/admin/3-x/doc/getting_started/installation.html) - for admin dashboard


## Database autogeneration using Entities
`php bin/console doctrine:migrations:diff` - checks difference between database and entities. Creates migration in case of such difference

`php bin/console doctrine:migrations:migrate` - launches migrations

## Launch fixtures
`php ./bin/console doctrine:fixtures:load` - **Attention!** - this command is erasing all records from DB

## Clear cache
`php ./bin/consoler cache:clear`

## TODO
- Admin dasboard. List of attached documents to the order.
- Add simple users auth
