ifneq ($(MAKECMDGOALS),dotenv-dump)
-include .env
export
endif

.PHONY: help

DOCKER_COMPOSE_OPTIONS = -f docker-compose.yaml
ifeq ($(BUILD), true)
	DOCKER_COMPOSE_OPTIONS := $(DOCKER_COMPOSE_OPTIONS) -f docker-compose.build.yaml
endif
DOCKER_COMPOSE = docker-compose $(DOCKER_COMPOSE_OPTIONS)

help: ## Displays help for a command
	@printf "\033[33mUsage:\033[0m\n  make [options] [target] ...\n\n\033[33mAvailable targets:%-13s\033[0m\n"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' 'Makefile' | awk 'BEGIN {FS = ":.*?## "}; {printf "%-2s\033[32m%-17s\033[0m %s\n", "", $$1, $$2}'

container-build: ## Builds the application's docker containers
	$(DOCKER_COMPOSE) build --compress --force-rm --no-cache

container-down: ## Shuts down application containers
	$(DOCKER_COMPOSE) down

container-pull:
	$(DOCKER_COMPOSE) pull

container-up: ## Launch application containers
	$(DOCKER_COMPOSE) up --detach --remove-orphans --force-recreate
	$(DOCKER_COMPOSE) ps

dotenv-dump: ## Merge two environments to destination file. Arguments: 'src' - source file, 'dist' - destination file
	@[ "$(wildcard $(src))" ] || (echo "Please, specify existing environment file in 'src' argument"; exit 22)
	@[ "$(dest)" ] || (echo "Please, specify 'dest' argument"; exit 22)
	printenv | awk '/^[^#].+$$/ {sub(/=/," ");c[$$1]++;if(2==c[$$1]){print $$1"="$$2}}' $(src) - $(src) > $(dest)

start: ## Launch the application
	$(MAKE) container-pull
	$(MAKE) container-up

stop: ## Stops the application
	$(MAKE) container-down
