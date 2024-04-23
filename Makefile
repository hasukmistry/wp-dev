.DEFAULT_GOAL := help
BASE_DIR 	:= $(shell pwd | xargs basename)

build: ## Build the WordPress plugin archive
	@./bin/wp.sh

############################
# GENERIC HELP
############################
.PHONY: help # Print help screen
help: SHELL := /bin/sh
help:
	@echo
	@echo "\033[1m\033[7m                                                                 \033[0m"
	@echo "\033[1m\033[7m                          Wp Dev Plugin                          \033[0m"
	@echo "\033[1m\033[7m                                                                 \033[0m"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-25s\033[0m %s\n", $$1, $$2}'