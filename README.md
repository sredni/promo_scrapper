# Promo scrapper

## Dev installation

### Requirements:
1. [Docker](https://www.docker.com/)
2. [Docker compose](https://docs.docker.com/compose/install/)

### Installation
```
git clone https://github.com/sredni/promo_scrapper.git
cd promo_scrapper
cp .env.dist .env
# modify .env as you neeed
docker-compose up -d
```

## Building production
```
docker build --target scrapper-app -f docker/scrapper/Dockerfile -t <YOUR_CONTAINER_REPOSITORY>:<YOUR_TAG> .
docker push <YOUR_CONTAINER_REPOSITORY>:<YOUR_TAG>
```