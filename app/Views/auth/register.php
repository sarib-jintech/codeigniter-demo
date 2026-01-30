<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Auction Method</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Auction Method</h1>
            <p>Create your bidder account.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/auth/store" method="post">
            <div class="row">
                <div class="form-group">
                    <label for="username">First name</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First name" required>
                </div>

                <div class="form-group">
                    <label for="username">Last name</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-primary">Register</button>
        </form>
    </div>
</body>
</html>