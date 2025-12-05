<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Інформація про систему</title>
</head>
<body>
    <h1>Системні змінні</h1>
    
    <div class="card">
        <p>
            <strong>Операційна система сервера:</strong> <br> 
            <?php 
                // Отримання даних про веб-сервер
                echo $_SERVER['SERVER_SOFTWARE']; 
            ?>
        </p>
        
        <p>
            <strong>Ваша IP адреса:</strong> <br> 
            <?php 
                // Визначення IP-адреси, з якої підключився користувач
                echo $_SERVER['REMOTE_ADDR']; 
            ?>
        </p>
        
        <p>
            <strong>Ваш браузер:</strong> <br> 
            <?php 
                // Відображення інформації про браузер клієнта
                echo $_SERVER['HTTP_USER_AGENT']; 
            ?>
        </p>
    </div>

    <h2>Повна конфігурація PHP (phpinfo)</h2>
    <hr>
    
    <?php
        // 4. Виклик стандартної функції для показу детальної конфігурації PHP та модулів
        phpinfo(); 
    ?>
</body>
</html>