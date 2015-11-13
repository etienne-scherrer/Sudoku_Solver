<main>
    <?php if(isset($_SESSION['user'])): ?>
    <h2>Logged in</h2>
    <div>You are already logged in</div>
    <?php else: ?>
    <h2>Login</h2>

    <form id="login-form">
        <label for="log-username">Username</label><input type="text" id="log-username" name="username" required><br>
        <label for="log-password">Password</label><input type="password" id="log-password" name="password" required><br>
        <button type="button" onclick="caller.login($('#log-username').val(), $('#log-password').val())">Send</button>
    </form>

    <h2>Register</h2>

    <form id="register-form">
        <label for="reg-username">Username</label><input type="text" id="reg-username" name="username" required><br>
        <label for="reg-password">Password</label><input type="password" id="reg-password" name="password" required><br>
        <label for="reg-password2">Repeat password</label><input type="password" id="reg-password2" name="password2" required><br>
        <button type="button" onclick="caller.register($('#reg-username').val(), $('#reg-password').val(), $('#reg-password2').val())">Send</button>
    </form>
    <?php endif; ?>
</main>