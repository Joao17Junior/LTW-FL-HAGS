<?php include __DIR__ . '/../../header.html'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <link rel="stylesheet" href="/assets/css/order.css">
</head>
<body>
<div class="order-details-container">
    <h2><?= htmlspecialchars($service['title']) ?></h2>
    <p><?= nl2br(htmlspecialchars($service['description'])) ?></p>
    <div class="service-images" style="display:flex;gap:10px;">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $img): ?>
                <img src="<?= htmlspecialchars($img['path']) ?>" alt="Service Image" style="width:100px;height:100px;object-fit:cover;border-radius:6px;">
            <?php endforeach; ?>
        <?php else: ?>
            <div style="width:100px;height:100px;background:#eee;border-radius:6px;display:flex;align-items:center;justify-content:center;">No Image</div>
        <?php endif; ?>
    </div>
    <p><strong>Freelancer:</strong> <?= htmlspecialchars($freelancerName) ?></p>

    <?php if ($canReview): ?>
        <h3>Rate this Service</h3>
        <?php if ($existingReview): ?>
            <p>You already reviewed this service. Your rating: <?= htmlspecialchars($existingReview['rating']) ?> ★</p>
            <p><?= nl2br(htmlspecialchars($existingReview['comment'])) ?></p>
        <?php else: ?>
            <form id="reviewForm" action="index.php?page=review&order_id=<?= $order['order_id'] ?>" method="post">
                <label for="rating">Rating:</label>
                <div id="starRating" style="display:inline-block;">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <span class="star" data-value="<?= $i ?>">&#9733;</span>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="rating" id="rating" required>
                <br>
                <label for="comment">Comment:</label><br>
                <textarea name="comment" id="comment" rows="4" cols="40"></textarea>
                <br>
                <button type="submit" class="main-btn">Submit Review</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <p>This order is not completed yet. You can review after completion.</p>
    <?php endif; ?>

    <form action="index.php?page=user" method="post" style="margin-top:20px;">
        <button type="submit" class="main-btn">Back to Profile</button>
    </form>
    <script src="/assets/js/order.js"></script>
</div>
</body>
</html>