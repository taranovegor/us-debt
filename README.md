# US Debt

Wow! That's really big!

## Configuring and startup

Copy `.env.example` file as `.env` and configure [.env variables](#env) which do you need.

To run application use command below
```shell
./deploy.sh
```

## Tools

### composer.sh

Application dependencies management via Composer

```shell
./composer.sh command [options] [arguments]
```

**Additional options:**

| Option             | Description                                                                                             |
|--------------------|---------------------------------------------------------------------------------------------------------|
| `-u` `--user`      | Username or id from which the command will be launched. Default value: `www-data` similar to `HOST_UID` |
| `-c` `--container` | Name of the php container in which the command will be executed. Default value: `php_cron`              |

### console.sh

Application console

```shell
./console.sh command [options] [arguments]
```

**Additional options:**

| Option             | Description                                                                                             |
|--------------------|---------------------------------------------------------------------------------------------------------|
| `-u` `--user`      | Username or id from which the command will be launched. Default value: `www-data` similar to `HOST_UID` |
| `-c` `--container` | Name of the php container in which the command will be executed. Default value: `php_cron`              |

### deploy.sh

Application state management

```shell
./deploy.sh command [options]
```

**Additional options:**

| Option          | Description                                 |
|-----------------|---------------------------------------------|
| -s --stop       | Stop application containers                 |
| -p --production | Build application in production environment |

## Environments

### .env
| Variable                                        | Description                                                                                   |
|-------------------------------------------------|-----------------------------------------------------------------------------------------------|
| TZ                                              | Working timezone of application                                                               |
| HOST_UID                                        | Uid of the user from which the application is launched and runs. **Affects file permissions** |
| HOST_GID                                        | Gid of the user from which the application is launched and runs. **Affects file permissions** |
| HOST_MACHINE                                    | Accessible IP address for container access to localhost                                       |
| NGINX_EXPOSE_PORT                               | Port on which the nginx container will be launched and available                              |
| APP_ENV                                         | Environment of application                                                                    |
| APP_TELEGRAM_BOT_API_TOKEN                      | Token to access Telegram bot API                                                              |
| APP_PUBLISHER_US_DEBT_TELEGRAM_STICKER_USER_ID  | Stickerpack owner id                                                                          |
| APP_PUBLISHER_US_DEBT_TELEGRAM_STICKER_SET_NAME | Sitkerpack prefix                                                                             |
