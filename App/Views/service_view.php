<?php include __DIR__ . '/../../header.html'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($service['title']); ?> | Service Details</title>
    <link rel="stylesheet" href="/assets/css/service.css">
</head>
<body>
<div class="service-details-container">
    <h1 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h1>
    <div class="service-meta">
        <span class="freelancer-name">By: <?php echo htmlspecialchars($freelancerName); ?></span>
        <span class="service-price">Base Price: $<?php echo htmlspecialchars($service['base_price']); ?></span>
    </div>
    <div class="service-images">
        <?php if ($media): ?>
            <?php foreach ($media as $m): ?>
                <img src="<?php echo htmlspecialchars($m['path']); ?>" alt="Service Image" class="service-img">
            <?php endforeach; ?>
        <?php else: ?>
            <p>No images for this service.</p>
        <?php endif; ?>
    </div>
    <div class="service-description">
        <h2>Description</h2>
        <p><?php echo nl2br(htmlspecialchars($service['description'])); ?></p>
    </div>
    <div class="service-actions">
        <a href="/App/Controllers/paymentController.php?service_id=<?php echo $service_id; ?>" class="order-btn">Order Now</a>
        <a href="/App/Controllers/chatController.php?freelancer_id=<?php echo $freelancer_id; ?>" class="chat-btn">Contact Freelancer</a>
    </div>
</div>
</body>
</html>