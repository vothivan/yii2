<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>