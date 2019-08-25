Yii 2 Chulakov Project Template
===============================

 [Setup Docker container environment](docs/docker.md)

Yii 2 Chulakov Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, api and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both admin and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
api
    config/              contains api configurations
    controllers/         contains Web controller classes
    models/              contains api-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for api application
    web/                 contains the entry script and Web resources
paymentsystem
    config/              contains api configurations
    controllers/         contains Web controller classes
    models/              contains api-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for api application
    web/                 contains the entry script and Web resources
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
