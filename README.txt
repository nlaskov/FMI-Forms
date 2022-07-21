Система за събиране и визуализиране на данни
Никола Ласков фн:62429 СИ курс:3


Във втора версия:
- Добавена възможност за качване на файлове във формите.
- Добавена възможност за сваляне на качените във форми файлове.


Работещият проект може да се намери и на: nikola.laskov.us/WEB_Project

Съдържание на архива:
Документация.docx - документация на проекта, във .docx формат
Документация.pdf - документация на проекта във .pdf формат
WEB-Project - папка със проекта
README.txt - този файл :)

Във папката WEB-Project:

WEB-Project
├── add
│   ├── add_text.php - страница за добавяне на text, date, week, number и други input
│   ├── add_multi.php - страница за добавяне на checkbox и radio input
│   ├── add_range.php - страница за добавяне на range input
│   └── add_file.php
├── answers -               
│   ├── JSON -                  
│   │   └── $mail_$formid.json - отговор на формата с уникален номер $formid попълнена от профила $mail
│   └── files -    
│       └── $filename - файлове качени във различните форми
├── genearted -                 
│   ├── $formid.json - json файл за форма със номер $formid
│   └── $formid.txt - txt файл за форма със номер $formid
├── css -   
│   ├── add_element.css - css файл за страниците от папка add
│   ├── add_form.css - css файл за страницата add_form.php
│   ├── form.css - css файл за страницата form.php
│   ├── form_with_pass.css - css файл за страницата form_with_pass.php
│   ├── index.css - css файл за страницата index.php
│   ├── login_and_regis.css css файл за страниците login.php и register.php
│   ├── new_form_info.css - css файл за страницата new_form_info.php
│   ├── new_form_text.css - css файл за страницата new_form_text.php
│   ├── new_form_UI.css - css файл за страницата new_form_UI.php
│   └── show_data.css - css файл за страницата show_data.php
├── js -                        
│   ├── delete_form.js - функция за изтриване на форма
│   ├── new_form.js - функция за създаване на нова форма
│   ├── show_data.js - функция за показване и скриване на данни
│   └── transition.js - функции за прехвърляне между страниците
├── php_scripts - 
│   ├── auth.php - функции за работа със JWT(JSON Web Tokens)
│   ├── form_delete.php - скрипт за изтриване на форма
│   ├── generate.php - функции за генериране, попълване и четене на файлове
│   ├── generate_answear.php - функции свързани със въпроси и отговори
│   ├── load.php - скрипт за създаване на файлове за формите
│   ├── parser.php - функции за анализ на данни
│   └── queries.php - функции работещи с базата данни
├── add_form.php - страница за добавяне на споделени форми
├── config.php - конфигурационен файл (за свързване със базата данни)
├── env.php - файл с глобални променливи (данни за свързване с базата данни)
├── form.php - страница за попълване на форми
├── form_with_pass.php - страница за попълване на парола за форма
├── index.php - главна страница
├── login.php - страница за вход
├── new_form_info.php - страница за попълване на информация за нова форма
├── new_form_text.php - страница за създаване на форми чрез текс
├── new_form_UI.php - основна страница за създаване на форми с потребителски интерфейс
├── register.php - страница за регистрация 
├── show_data.php - страница за показване на събрани данни (и свалянето им)
└── webproject_db.sql - SQL скрипт за създаване на база данни и попълване на начална(примерна) информация