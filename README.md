```bash
# első install
docker run --rm -u $(id -u):$(id -g) \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer create-project --ignore-platform-reqs
    
# sail indítása
./vendor/bin/sail up

# migrációk futtatása
sail artisan migrate
```
