<?php
// 1. НАЛАШТУВАННЯ ПІДКЛЮЧЕННЯ
$host = "localhost";
$user = "root";
$pass = "";
$db   = "university";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// 2. ОБРОБКА ФОРМИ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $group = $_POST['group_name'];
    $hobby = $_POST['hobby'];
    
    // Обробка чекбоксів (мов програмування)
    // Якщо нічого не вибрано, записуємо порожній рядок
    if (isset($_POST['programming_languages'])) {
        // implode перетворює масив ["PHP", "C#"] у рядок "PHP, C#"
        $langs = implode(", ", $_POST['programming_languages']);
    } else {
        $langs = "";
    }

    // Захист від SQL-ін'єкцій (базовий)
    $fname = $conn->real_escape_string($fname);
    $lname = $conn->real_escape_string($lname);
    $group = $conn->real_escape_string($group);
    $hobby = $conn->real_escape_string($hobby);
    $langs = $conn->real_escape_string($langs);

    $sql_insert = "INSERT INTO students (first_name, last_name, group_name, hobby, programming_languages) 
                   VALUES ('$fname', '$lname', '$group', '$hobby', '$langs')";

    if ($conn->query($sql_insert) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Помилка: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>База студентів</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background-color: #f4f7f6; }
        .container { display: flex; gap: 30px; flex-wrap: wrap; }
        
        /* Стилі форми */
        .form-section { background: white; padding: 25px; border-radius: 10px; width: 300px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-section h3 { margin-top: 0; color: #333; }
        input[type="text"] { width: 93%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        label { font-weight: bold; font-size: 0.9em; display: block; margin-bottom: 5px; }
        
        /* Стилі чекбоксів */
        .checkbox-group { margin-bottom: 15px; border: 1px solid #eee; padding: 10px; border-radius: 4px; }
        .checkbox-group label { font-weight: normal; display: block; margin-bottom: 5px; cursor: pointer; }
        .checkbox-group input { margin-right: 10px; }

        input[type="submit"] { width: 100%; padding: 10px; background: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; transition: background 0.3s;}
        input[type="submit"]:hover { background: #0056b3; }

        /* Стилі таблиці */
        .table-section { flex-grow: 1; min-width: 400px; }
        table { border-collapse: collapse; width: 100%; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007BFF; color: white; }
        tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>

<h1>Облік студентів</h1>

<div class="container">
    <div class="form-section">
        <h3>Додати студента</h3>
        <form method="POST">
            <label>Ім'я:</label>
            <input type="text" name="first_name" required placeholder="Наприклад: Вікторія">
            
            <label>Прізвище:</label>
            <input type="text" name="last_name" required placeholder="Наприклад: Семенякіна">
            
            <label>Група:</label>
            <input type="text" name="group_name" required placeholder="СА, МА">
            
            <label>Хобі:</label>
            <input type="text" name="hobby" placeholder="Футбол, малювання...">
            
            <label>Мови програмування:</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="programming_languages[]" value="C++"> C++</label>
                <label><input type="checkbox" name="programming_languages[]" value="C#"> C#</label>
                <label><input type="checkbox" name="programming_languages[]" value="Java"> Java</label>
                <label><input type="checkbox" name="programming_languages[]" value="Python"> Python</label>
                <label><input type="checkbox" name="programming_languages[]" value="PHP"> PHP</label>
                <label><input type="checkbox" name="programming_languages[]" value="JavaScript"> JavaScript</label>
                <label><input type="checkbox" name="programming_languages[]" value="SQL"> SQL</label>
            </div>
            
            <input type="submit" value="Зберегти дані">
        </form>
    </div>

    <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ім'я</th>
                    <th>Прізвище</th>
                    <th>Група</th>
                    <th>Хобі</th>
                    <th>Мови</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql_select = "SELECT * FROM students ORDER BY student_id DESC";
            $result = $conn->query($sql_select);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['student_id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['group_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['hobby']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['programming_languages']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>База даних порожня</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>