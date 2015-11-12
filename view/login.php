<main>
    <?php if(isset($_SESSION['user'])): ?>
    <h2>Logged in</h2>
    <div>You are already logged in</div>
    <?php else: ?>
    <h2>Login</h2>

    <form id="login-form">
        <label for="username">Username</label><input type="text" id="username" name="username" required><br>
        <label for="password">Password</label><input type="password" id="password" name="password" required><br>
        <button type="submit">Send</button>
    </form>

    <h2>Register</h2>

    <form id="register-form">
        <label for="username">Username</label><input type="text" id="username" name="username" required><br>
        <label for="password">Password</label><input type="password" id="password" name="password" required><br>
        <label for="password2">Repeat password</label><input type="password" id="password2" name="password2" required><br>
        <button type="submit">Send</button>
    </form>
    <?php endif; ?>
</main>