# 📂 Servidor Web para desenvolvimento em PHP em Docker

## 🚀 Tecnologias

- Docker
- PHP
- MySQL
- phpMyAdmin

## 💻 Estrutura de pastas
- `src`: armazena arquivos do projeto web
- `storage`: armazena informações dos bancos de dados

## 📃 Orientações

Existem duas maneiras de configurar seu ambiente, com ou sem o DOCKER-COMPOSE.YML (gerenciador de contêineres).

#### 1º CASO - Utilizando DOCKER-COMPOSE.YML

Vá até a raiz do projeto onde encontra-se o arquivo `docker-compose.yml` e execute:

`$ docker-compose up -d --build`

> Tendo como saída esperada:
<pre>
Creating network "www_wagnerdev-network" with the default driver
Creating network "www_database-network" with the default driver

Building php
[+] Building 19.8s (10/10) FINISHED
 => [internal] load build definition from Dockerfile                                                                                                               0.1s
 => => transferring dockerfile: 32B                                                                                                                                0.0s
 => [internal] load .dockerignore                                                                                                                                  0.0s
 => => transferring context: 2B                                                                                                                                    0.0s
 => [internal] load metadata for docker.io/library/php:7.4-apache                                                                                                  3.4s
 => [auth] library/php:pull token for registry-1.docker.io                                                                                                         0.0s
 => [internal] load build context                                                                                                                                  0.1s
 => => transferring context: 588B                                                                                                                                  0.0s
 => CACHED [1/4] FROM docker.io/library/php:7.4-apache@sha256:f13ec39145c766c1ff6043843994d1467e5d8e3f86f48664889ddcd4a2f40b5a                                     0.0s
 => [2/4] COPY src /var/www/html                                                                                                                                   0.1s
 => [3/4] WORKDIR /var/www/html                                                                                                                                    0.1s
 => [4/4] RUN docker-php-ext-install pdo pdo_mysql                                                                                                                15.5s
 => exporting to image                                                                                                                                             0.4s
 => => exporting layers                                                                                                                                            0.2s
 => => writing image sha256:e88ee7cbe28ef5cf5d3bb511c7c9a885e64a85fc924c9159312643c7d8f6cbe1                                                                       0.0s
 => => naming to docker.io/library/www_php                                                                                                                         0.0s

Use 'docker scan' to run Snyk tests against images to find vulnerabilities and learn how to fix them

Creating mysql ... done
Creating phpmyadmin ... done
Creating php        ... done
</pre>

----

#### 2º CASO - Manualmente SEM DOCKER-COMPOSE.YML

Vá até a raiz do projeto e a partir de lá, siga os passos:

> Criação das imagens com base nos arquivos "Dockerfile" localizados em "images/<local>":
<pre>
$ docker build -t php-image -f images/php/Dockerfile .
$ docker build -t phpmyadmin-image -f images/phpmyadmin/Dockerfile .
$ docker build -t mysql-image -f images/mysql/Dockerfile .
</pre>

> Criação das redes para comunicação entre os contêineres:
<pre>
$ docker network create --driver=bridge database-network
$ docker network create --driver=bridge wagnerdev-network
</pre>

> Subir o MYSQL SERVER como primeiro container, visto que os demais dependem dele para conexão:
<pre>
$ docker run -d --name mysql mysql-image
</pre>

> Adicionar redes específicas ao MYSQL SERVER:
<pre>
$ docker network connect wagnerdev-network mysql
$ docker network connect database-network mysql
</pre>

> Subir o PHPMYADMIN SERVER na mesma rede (database) do MYSQL e com acesso através da porta 3305:
<pre>
$ docker run -d \
	--name phpmyadmin \
	--network database-network -p 3305:80 \
phpmyadmin-image
</pre>

> Subir o PHP SERVER na mesma rede (wagnerdev) do MYSQL e com acesso através da porta 8080:
<pre>
$ docker run -d --name php -p 8080:80 \
	--network wagnerdev-network \
	--mount src="$(pwd)/src",target=/var/www/html,type=bind \
php-image
</pre>

----

🧑‍💻​ Urls para acessar o projeto
- `http://localhost:8080/`: Servidor Web
- `http://localhost:3305/`: phpMyAdmin

---
---
## 📧 Contato
[LinkedIn](https://www.linkedin.com/in/wsawebmaster/)

wsawebmaster@yahoo.com.br
