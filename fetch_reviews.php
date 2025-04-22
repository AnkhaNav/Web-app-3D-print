<?php
require 'db_connection.php';
session_start();

$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total = $conn->query("SELECT COUNT(*) AS total FROM REVIEWS")->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

$stmt = $conn->prepare("SELECT r.*, u.user_name, u.profile_picture 
                        FROM REVIEWS r
                        LEFT JOIN USERS u ON r.user_id = u.user_id
                        ORDER BY r.review_date DESC
                        LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$reviews = $stmt->get_result();

ob_start();
while ($row = $reviews->fetch_assoc()):
?>
  <div class="review-card">
    <div class="review-header">
      <div class="left">
        <img src="<?= htmlspecialchars($row['profile_picture']) ?>" alt="Profilovka" class="profile-img">
        <strong><?= htmlspecialchars($row['user_name']) ?></strong>
      </div>
      <span class="stars">
        <?php for ($i = 1; $i <= 5; $i++): echo $i <= $row['rating'] ? '★' : '☆'; endfor; ?>
      </span>
    </div>
    <p class="review-comment"><?= nl2br(htmlspecialchars($row['comment'])) ?></p>
    <p class="review-date"><?= date("j. n. Y H:i", strtotime($row['review_date'])) ?></p>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']): ?>
      <form method="POST" action="delete_review.php" onsubmit="return confirm('Opravdu smazat recenzi?');">
        <input type="hidden" name="review_id" value="<?= $row['review_id'] ?>">
        <button type="submit" class="delete-btn">Smazat</button>
      </form>
    <?php endif; ?>
  </div>
<?php endwhile; ?>

<?php if ($totalPages > 1): ?>
  <div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a href="#" class="page-link <?= ($i == $page) ? 'active' : '' ?>" data-page="<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
<?php endif; ?>

<?php
echo ob_get_clean();