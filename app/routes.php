<?php

$app->get('/users/{userId}', [\App\Controller\UserController::class, 'show']);