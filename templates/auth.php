<form method="POST" id="auth_form">
    <div class="form_container">
        <div class="form_title">Login</div>
        <input type="text" id="username" name="username" placeholder="Login" autocomplete="username" required>
        <input type="password" id="password" name="password" placeholder="Password" autocomplete="current-password"
            required>
        <button type="submit" id="submit">Log in</button>
        <div id="form_error"></div>
    </div>
</form>