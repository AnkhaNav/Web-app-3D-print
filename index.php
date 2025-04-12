<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Vítejte na naší stránce!</h2>
        <p>Nabízíme profesionální 3D tisk na zakázku.</p>

        <div class="section">
            <h2>Kdo jsme?</h2>
            <p>Jsme tým nadšenců do 3D tisku s cílem nabídnout ty nejlepší služby našim zákazníkům.</p>
        </div>
        <div id="about" class="section">
            <h2>Proč my?</h2>
            <ul>
                <li>Nejmodernější technologie 3D tisku</li>
                <li>Rychlé a spolehlivé zpracování objednávek</li>
                <li>Individuální přístup ke každému projektu</li>
                <li>Kvalitní materiály a profesionální výsledky</li>
            </ul>
        </div>
        <div class="section">
            <h2>Časté dotazy (FAQ)</h2>
            <div class="faq-item">Kolik stojí 3D tisk? <span>+</span></div>
            <div class="faq-answer">Cena závisí na objemu, povrchu a zvoleném materiálu. Použijte naši kalkulačku pro odhad.</div>

            <div class="faq-item">Jaké soubory podporujete? <span>+</span></div>
            <div class="faq-answer">Podporujeme formáty STL, OBJ a 3MF.</div>

            <div class="faq-item">Jak dlouho trvá zpracování objednávky? <span>+</span></div>
            <div class="faq-answer">Záleží na složitosti projektu, obvykle do 3-5 pracovních dnů.</div>        
        </div>
        <div id="contact">
            <h2>Kontaktujte nás</h2>
            <p>Email: info@3dprintingservices.com</p>
            <p>Telefon: +420 123 456 789</p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3270.238469647248!2d16.64743107689289!3d49.2321334743319!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDnCsDEzJzU1LjciTiAxNsKwMzknMDAuMCJF!5e1!3m2!1scs!2scz!4v1744471042500!5m2!1scs!2scz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="section gallery">
            <h2>Fotogalerie</h2>
            <img src="img\IMG_20240808_222711.jpg" alt="Trojúhelníček" title="Ukázka tisku 1" onclick="openModal(this)">
            <img src="img\IMG_20240809_123754.jpg" alt="Jedna z našich zakázek" title="Ukázka tisku 2" onclick="openModal(this)">
            <img src="img\IMG_20240903_235735.jpg" alt="Šuplík" title="Ukázka tisku 3" onclick="openModal(this)">
        </div>
        
        <div id="modal" class="modal" onclick="closeModal()">
            <span class="close">&times;</span>
            <img id="modalImg" class="modal-content">
            <div id="caption"></div>
        </div>

        <div class="section">
            <h2>Recenze</h2>
            
            <div id="reviewSection">
                <textarea id="reviewText" placeholder="Napište svou recenzi..."></textarea>
                <button id="submitReview">Odeslat recenzi</button>
            </div>
            <div id="reviewsOutput">
                <h3>Recenze:</h3>
            </div>
        </div>
        <script>
            document.querySelectorAll('.faq-item').forEach(item => {
                item.addEventListener('click', () => {
                    const answer = item.nextElementSibling;
                    answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
                });
            });
                   
            function openModal(imgElement) {
                const modal = document.getElementById('modal');
                const modalImg = document.getElementById('modalImg');
                const caption = document.getElementById('caption');

                modal.style.display = 'block';
                modalImg.src = imgElement.src;
                caption.innerHTML = imgElement.alt;
            }
            function closeModal() {
                const modal = document.getElementById('modal');
                modal.style.display = 'none';
            }
        </script>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>