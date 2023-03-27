<?php
require_once("db.php");

try{
    $db->query('DROP TABLE IF EXISTS board');
    $db->query('DROP TABLE IF EXISTS incident_img');
    //створення таблиці films
    $db->query("CREATE TABLE incident_img(
        img_id int PRIMARY KEY AUTO_INCREMENT,
        img_name VARCHAR(250) NOT NULL
    );");
    $db->query("CREATE TABLE board(
        incident_id int PRIMARY KEY AUTO_INCREMENT,
        img_id int NOT NULL,
        lat FLOAT NOT NULL,
        lon FLOAT NOT NULL,
        incident_text text Not Null,
        FOREIGN KEY (img_id) 
        REFERENCES incident_img(img_id) 
        ON DELETE CASCADE
    );");
}
catch(PDOException $e){
    echo "Помилка: ".$e->getMessage();
}
echo "Таблиці успішно створені";