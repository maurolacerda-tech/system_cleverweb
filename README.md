<p align="center">
<a href="https://cleverweb.com.br/servicos/sistemas-web" target="_blank">
<img src="https://cleverweb.com.br/app2019/includes/images/logo.png" width="222" alt="Desenvolvimento de sistemas Web | Clever Web">
</a>
</p>


## Sistema Clever Web

Sistema modelo Clever Web desenvolvido em Laravel 11 e Livewire 3, para facilitar a implementação de novos projetos de sistemas.

## Subir nova aplicação em desenvolvimento

- Criar pasta docker-compose/postgres
- Renomear arquivo  docker-compose/ngnix/sitemodelo.conf
- Substituir palavra system_cleverweb em docker-compose-dev.yml pelo nome do projeto
- Arquivo .env colocar conexão com o banco
- Rodar

```
    docker-compose -f docker-compose-dev.yml build app
    docker-compose -f docker-compose-dev.yml up -d

    #já no container
    composer update
    php artisan key:generate
    php artisan migrate --seed
```
