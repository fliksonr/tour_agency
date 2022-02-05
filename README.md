<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Tour agency on Yii 2 Basic Project Template</h1>
    <br>
</p>

# Развертывание
У вас должен быть установлен docker и утилита docker-compose. Из корня проекта запустить команду:
```bash
$ docker-compose up -d
```

## Демо

```
GET /tour/list - Список туров
```
![alt text](docs/list.png)

```
GET /tour/view?tourId={tourId} - Получение данных определенного тура
```
![alt text](docs/view.png)

```
POST /tour/create - Создание записи нового тура
form-data:
    from - Город отправления (обязательное поле)
    to - Город прибытия (обязательное поле)
    date - Дата отъезда (обязательное поле)
    days - Продолжительность тура
```
![alt text](docs/create.png)