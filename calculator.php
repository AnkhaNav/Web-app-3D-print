<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulačka</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <section class="form-section">
            <h2>Vypočítejte si cenu tisku</h2>
            <form>
                <div class="form-group">           
                    <label for="material">Materiál:</label>
                    <select id="material" name="material" required>
                        <option value="pla">PLA (0.50 Kč/cm³)</option>
                        <option value="abs">ABS (0.70 Kč/cm³)</option>
                        <option value="petg">PETG (0.60 Kč/cm³)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="model">Nahrát STL model:</label>
                    <input type="file" id="model" name="model" accept=".stl" required>
                </div>     
                <button type="button" onclick="calculatePrice()">Spočítat cenu</button>                
            </form>            
        </section>
    </main>
    <?php include 'footer.php'; ?>    
</body>
</html>