<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objednávka</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <section class="form-section">
            <h2>Formulář objednávky</h2>
            <form action="process_order.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Jméno a příjmení:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Telefon:</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="material">Materiál:</label>
                    <select id="material" name="material" required>
                        <option value="">Vyberte materiál</option>
                        <option value="pla">PLA</option>
                        <option value="abs">ABS</option>
                        <option value="petg">PETG</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="model">Nahrát STL model:</label>
                    <input type="file" id="model" name="model" accept=".stl" required>
                </div>
                <div class="form-group">
                    <label for="comments">Poznámky:</label>
                    <textarea id="comments" name="comments" rows="4" placeholder="Další specifikace nebo požadavky"></textarea>
                </div>
                <button type="submit">Odeslat objednávku</button>                
            </form>            
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>