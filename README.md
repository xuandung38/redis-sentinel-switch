## Redis Sentinel Switch

> Package dùng để tự động switch giữa redis standalone qua sentinel cho laravel.

**Nguyên lý hoạt động: **

>Package này đơn giản chỉ over-write lại config mặc định của laravel để predis nhận biết được các cụm sentinel

### Hướng dẫn

**Cài đặt package:**
```shell
composer require hxd/redis-sentinel-switch
```


Bạn cần config các biến môi trường sau vào `.env`:

```dotenv
# Nếu bạn để null thì mặc định laravel sử dụng standalone
REDIS_REPLICATION=sentinel

#Cụm sentinel master hoặc standalone
REDIS_HOST=_master_sentinel_host_
REDIS_PORT=26379
REDIS_PASSWORD=
REDIS_TIMEOUT=0.1

# Cluster name
REDIS_SENTINEL_SERVICE=mymaster
REDIS_SENTINEL_TIMEOUT=0.1
# Các cụm Sentinel Slave
REDIS_SENTINEL=tcp://slave_sentinel_1:26379,tcp://slave_sentinel_2:26379
```

