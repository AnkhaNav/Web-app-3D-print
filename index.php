<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domácí stránka</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <section class="hero">
            <h2>Vítejte na naší stránce!</h2>
            <p>Specializujeme se na profesionální 3D tisk na zakázku – od návrhu až po realizaci.</p>
        </section>
        <section class="section split left-text" id="about">
            <div class="text">
                <h2>Kdo jsme?</h2>
                <p>Jsme skupina nadšených techniků, designérů a inovátorů, kteří sdílí vášeň pro moderní technologie a precizní výrobu. Naším cílem je poskytovat kvalitní a dostupný 3D tisk pro každého – ať už jde o prototypy, dekorace, náhradní díly, nebo personalizované dárky.</p>
                <p>Na trhu působíme již několik let a neustále rozšiřujeme své know-how i technologické zázemí, abychom dokázali splnit i ty nejnáročnější požadavky.</p>
            </div>
            <div class="image">
                <img src="img/IMG_20240907_114650_025106.jpg" alt="Tým 3D tiskařů">
            </div>
        </section>
        <section class="section split right-text">
            <div class="image">
                <img src="img/IMG_20240810_151850.jpg" alt="3D tisk detail">
            </div>
            <div class="text">
                <h2>Proč právě my?</h2>
                <ul>
                    <li><strong>Špičkové technologie:</strong> Používáme profesionální 3D tiskárny a kvalitní materiály pro precizní výstupy.</li>
                    <li><strong>Rychlé dodání:</strong> Většinu zakázek zvládneme vyřídit do několika pracovních dní.</li>
                    <li><strong>Osobní přístup:</strong> Každý projekt konzultujeme individuálně, aby odpovídal vašim potřebám.</li>
                    <li><strong>Důraz na kvalitu:</strong> Každý výtisk prochází kontrolou, abyste byli 100% spokojeni.</li>
                </ul>
            </div>
        </section>
        <section class="section split left-text">
            <div class="text">
                <h2>Časté dotazy (FAQ)</h2>

                <div class="faq-item">Kolik stojí 3D tisk? <span>+</span></div>
                <div class="faq-answer">Cena se odvíjí od použitého materiálu, složitosti modelu a jeho objemu. Pro rychlý odhad použijte naši online kalkulačku.</div>

                <div class="faq-item">Jaké soubory podporujete? <span>+</span></div>
                <div class="faq-answer">Nejčastěji přijímáme formát STL. Pokud máte jiný formát, kontaktujte nás – pokusíme se jej převést.</div>

                <div class="faq-item">Jak dlouho trvá zpracování objednávky? <span>+</span></div>
                <div class="faq-answer">Standardní doba zpracování je 3–5 pracovních dní v závislosti na náročnosti zakázky. Expresní tisk je možný po domluvě.</div>
            </div>
            <div class="image">
                <img src="img/IMG_20240811_163828.jpg" alt="Často kladené dotazy">
            </div>
        </section>
        <section class="section split left-text" id="contact">
            <div class="opening-hours" style="text-align: center; margin-top: 20px;">
                <h3>Otevírací doba</h3>
                <p>Pondělí – Pátek: <strong>9:00 – 17:00</strong></p>
                <p>Sobota: <strong>10:00 – 14:00</strong></p>
                <p>Neděle: <strong>Zavřeno</strong></p>
            </div>
            <div class="text">
                <h2>Kontaktujte nás</h2>
                <p>Máte dotaz nebo zájem o spolupráci? Jsme tu pro vás!</p>
                <p><strong>Email:</strong> info@brint.cz</p>
                <p><strong>Telefon:</strong> +420 732 681 250</p>
                <p>Navštivte nás také osobně – sídlíme v dostupné lokalitě s možností konzultace na místě.</p>
                <p>Kobližná 34/13,602 00 Brno-střed</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d693.7011134552638!2d16.611746369820562!3d49.195570728065285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1scs!2scz!4v1745341777992!5m2!1scs!2scz" width="100%" height="300" style="border:0;" allowfullscreen loading="lazy"></iframe>
                </div>
        </section>
        <section class="section gallery">
            <h2>Fotogalerie</h2>
            <img src="img\IMG_20240808_222711.jpg" alt="Trojúhelníček" title="Ukázka tisku 1" onclick="openModal(this)">
            <img src="img\IMG_20240809_123754.jpg" alt="Jedna z našich zakázek" title="Ukázka tisku 2" onclick="openModal(this)">
            <img src="img\IMG_20240903_235735.jpg" alt="Šuplík" title="Ukázka tisku 3" onclick="openModal(this)">
            <img src="img\7b661013-c7c9-413d-9cac-1f7854de5ff1.jpg" alt="Vločka" title="Ukázka tisku 4" onclick="openModal(this)">
            <img src="img\IMG_20240901_235012.jpg" alt="Čerstvě vytisklý šuplík" title="Ukázka tisku 5" onclick="openModal(this)">
            <img src="img\IMG_20241217_090212.jpg" alt="Stojan na telefon a nabíječku 1" title="Ukázka tisku 6" onclick="openModal(this)">
            <img src="img\IMG_20241217_090302.jpg" alt="Stojan na telefon a nabíječku 2" title="Ukázka tisku 7" onclick="openModal(this)">
            <img src="img\IMG_20240812_133224.jpg" alt="Zabaleno k odeslání" title="Ukázka tisku 8" onclick="openModal(this)">
            <img src="img\a412d30e-6df5-4b05-be98-1c84b1c3260e.jpg" alt="Návrh dílu pro elektroniku" title="Ukázka tisku 9" onclick="openModal(this)">
            <img src="img\IMG_20241220_091056.jpg" alt="Jmenovky" title="Ukázka tisku 10" onclick="openModal(this)">
            <img src="img\IMG_20240827_233235.jpg" alt="Čtyřlístek" title="Ukázka tisku 11" onclick="openModal(this)">
            <img src="img\IMG_20250131_180333.jpg" alt="Odznáček" title="Ukázka tisku 12" onclick="openModal(this)">
            <img src="img\IMG_20250212_203355.jpg" alt="Lithophane zebra" title="Ukázka tisku 13" onclick="openModal(this)">
            <img src="img\IMG_20250213_233859.jpg" alt="Lithophane krtek" title="Ukázka tisku 14" onclick="openModal(this)">
            <img src="img\IMG_20240810_151710.jpg" alt="Výrobek v procesu" title="Ukázka tisku 15" onclick="openModal(this)">
            <img src="img\IMG_20240808_155759.jpg" alt="Detail povrchu" title="Ukázka tisku 16" onclick="openModal(this)">
        </section>
        <div id="modal" class="modal" onclick="closeModal(event)">
            <span class="close" onclick="closeModal(event)">&times;</span>
            <span class="arrow left" onclick="prevImage(event)">&#10094;</span>
            <img id="modalImg" class="modal-content" alt="">
            <span id="caption" class="caption"></span>
            <span class="arrow right" onclick="nextImage(event)">&#10095;</span>
        </div>
        <div class="section">
            <?php
            require 'db_connection.php';

            $limit = 5;
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            $countResult = $conn->query("SELECT COUNT(*) AS total FROM REVIEWS");
            $totalReviews = $countResult->fetch_assoc()['total'];
            $totalPages = ceil($totalReviews / $limit);

            $stmt = $conn->prepare("SELECT r.*, u.user_name, u.profile_picture 
                                    FROM REVIEWS r
                                    LEFT JOIN USERS u ON r.user_id = u.user_id
                                    ORDER BY r.review_date DESC
                                    LIMIT ? OFFSET ?");
            $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            $reviews = $stmt->get_result();
            ?>


            <section id="reviews">
                <h2>Hodnocení zákazníků</h2>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="add_review.php" class="btn">Přidat recenzi</a>
                <?php else: ?>
                    <p><a href="login.php">Přihlaste se</a>, chcete-li přidat recenzi.</p>
                <?php endif; ?>

                <div id="review-container"> 
                </div>
            </section>
        </div>
    </main>
    <?php include 'footer.php'; ?>

    <script>
        document.querySelectorAll('.faq-item').forEach(item => {
            item.addEventListener('click', () => {
                const answer = item.nextElementSibling;
                answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
            });
        });

        const modal = document.getElementById('modal');
        const modalImg = document.getElementById('modalImg');
        const caption = document.getElementById('caption');
        const galleryImages = Array.from(document.querySelectorAll('.gallery img'));
        let currentIndex = 0;

        function openModal(imgElement) {
            currentIndex = galleryImages.indexOf(imgElement);
            showImage(currentIndex);
            modal.classList.add('show');
        }

        function closeModal(event) {
            if (event.target === modal || event.target.classList.contains('close')) {
                modal.classList.remove('show');
            }
        }

        function showImage(index) {
            const image = galleryImages[index];
            modalImg.src = image.src;
            caption.textContent = image.alt || '';
        }

        function prevImage(event) {
            event.stopPropagation();
            currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
            showImage(currentIndex);
        }

        function nextImage(event) {
            event.stopPropagation();
            currentIndex = (currentIndex + 1) % galleryImages.length;
            showImage(currentIndex);
        }

        function loadReviews(page = 1) {
            fetch(`fetch_reviews.php?page=${page}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById("review-container").innerHTML = html;
                    document.querySelectorAll('.page-link').forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            loadReviews(this.dataset.page);
                        });
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadReviews();
        });
    </script>
</body>
</html>
