Разработать REST API для записной книжки . Примерная структура методов:

1.1. GET /api/v1/notebook/ <br>
1.2. POST /api/v1/notebook/ <br>
1.3. GET /api/v1/notebook/id/ <br>
1.4. POST /api/v1/notebook/id/ <br>
1.5. DELETE /api/v1/notebook/id/ <br>
Поля для POST запискной книжки: <br>

1. ФИО (обязательное)
2. Компания
3. Телефон (обязательное)
4. Email (обязательное)
5. Дата рождения 
6. Фото

Нужна возможность выводить информацию в списке по странично

Собрать образ -> docker build -t application-backend . <br>
Запустить докер -> docker compose up <br>
Методы тестированы в файле test_rest.php с помощью плагина HTTP client <br>
Методы описаны в NoteRestControlle.php <br>
Пагинация реализвана в файле list.php <br>
