<?php
session_start();
require 'db_connection.php';

$name = $email = $phone = $address = '';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT user_name, email, phone_number, address FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        $name = $user['user_name'];
        $email = $user['email'];
        $phone = $user['phone_number'];
        $address = $user['address'];
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objednávka</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .order-form {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .order-form h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            font-family: inherit;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0097a7;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <section class="order-form">
        <h2>Formulář objednávky</h2>
        <form action="process_order.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Jméno a příjmení:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="form-group">
                <label for="material">Materiál:</label>
                <select id="material" name="material" required>
                    <option value="">Vyberte materiál</option>
                    <option value="PLA">PLA</option>
                    <option value="ASA/ABS">ASA/ABS</option>
                    <option value="PETG">PETG</option>
                </select>
            </div>
            <div class="form-group">
                <label for="color">Barva:</label>
                <select id="color" name="color" required>
                    <option value="">Vyberte barvu</option>
                    <option value="Černá">Černá</option>
                    <option value="Bílá">Bílá</option>
                    <option value="Červená">Červená</option>
                    <option value="Modrá">Modrá</option>
                    <option value="Zelená">Zelená</option>
                    <option value="Žlutá">Žlutá</option>
                </select>
            </div>
            <div class="form-group">
                <label for="model">Nahrát STL model:</label>
                <input type="file" id="model" name="model" accept=".stl" required>
            </div>
            <div class="form-group">
                <label for="comments">Poznámky:</label>
                <textarea id="comments" name="comments" rows="4" placeholder="Další specifikace nebo požadavky"></textarea>
                <small style="display: block; margin-top: 5px; color: #666;">
                    Pokud odesíláte více objednávek najednou, napište prosím, zda je chcete kompletovat dohromady. Můžete zde uvést i jiné upřesnění k tisku.
                </small>
            </div>
            <button type="submit">Odeslat objednávku</button>
        </form>
    </section>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
