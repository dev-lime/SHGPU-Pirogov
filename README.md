# SHGPU-Pirogov: Система управления транспортной компанией

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-13+-4169E1?logo=postgresql&logoColor=white)
![XAMPP](https://img.shields.io/badge/XAMPP-7.4+-FB7A24?logo=xampp&logoColor=white)

Учебный проект по разработке веб-приложения для управления транспортной компанией с использованием PHP и PostgreSQL.

## 📌 О проекте

Этот проект разработан в рамках учебного курса SHGPU (Название учебного заведения) под руководством преподавателя Пирогова. Система предоставляет полный функционал для управления:

- Клиентами
- Диспетчерами
- Водителями
- Транспортными средствами
- Заказами на перевозку

## 🌟 Особенности

- **Полноценный CRUD** для всех сущностей
- **Массовое удаление** записей
- **Связи между таблицами** с переходом по ссылкам
- **Адаптивный интерфейс** для разных устройств
- **Защита** от **SQL-инъекций**

## 🛠 Технологии

- **Backend**: PHP 8.0+
- **Database**: PostgreSQL 13+
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Сервер**: XAMPP/Apache
- **Архитектура**: MVC-подобная структура

## 🚀 Установка

1. **Установите XAMPP** с PHP 8.0+ и Apache
2. **Установите PostgreSQL** и создайте БД:
   ```sql
   CREATE DATABASE tk;
   CREATE USER postgres WITH PASSWORD '123';
   GRANT ALL PRIVILEGES ON DATABASE tk TO postgres;
   ```
3. **Импортируйте схему** из файла
4. **Клонируйте репозиторий** в папку `htdocs`:
   ```bash
   git clone https://github.com/dev-lime/SHGPU-Pirogov.git
   ```
5. **Настройте подключение** в `config/database.php`

## 📄 Лицензия

Учебный проект SHGPU © 2025. Открытый код для образовательных целей.

---

> **Note**: Проект разработан в учебных целях и может содержать упрощенные решения для демонстрации основных концепций.
