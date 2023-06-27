Собрать образ -> docker build -t application-backend . <br>
Запустить докер -> docker compose up <br>
Подгрузить дамп таблицы бд -> cat dump.sql | docker exec -i {containers-id} /usr/bin/mysql -u root --password=admin note_db <br>
Методы тестированы в файле test_rest.php с помощью плагина HTTP client <br>
Методы описаны в NoteRestControlle.php <br>
Пагинация реализвана в файле list.php <br>
