<?php include('includes/header.php'); ?>

<main class="content-wrapper">
    <section class="glam-section">
        <h2>Member Login</h2>
        
        <?php if(isset($_GET['signup'])): ?>
            <p style="color:#DAA520;">Welcome! Please login to your new account.</p>
        <?php endif; ?>

        <?php if(isset($_GET['reset']) && $_GET['reset'] == 'sent'): ?>
            <p style="color: #28a745; background: #e8f5e9; padding: 10px; border-radius: 5px; font-size: 0.9rem;">📩 If that email is registered, instructions have been sent!</p>
        <?php endif; ?>

        <form action="process-login.php" method="POST" class="profile-form">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="password" name="password" id="loginPass" required style="width: 100%; padding-right: 60px;">
                    <span onclick="togglePass('loginPass')" 
                          style="position: absolute; right: 15px; cursor: pointer; font-size: 0.75rem; color: #DAA520; font-weight: bold; user-select: none;">
                          SHOW
                    </span>
                </div>
                <p style="text-align: right; margin-top: 5px;">
                    <a href="javascript:void(0)" onclick="openResetModal()" style="color: #888; text-decoration: none; font-size: 0.8rem;">Forgot Password?</a>
                </p>
            </div>

            <button type="submit" class="btn-gold">Enter Navy Glam</button>
        </form>

        <p style="margin-top:20px; font-size: 0.9rem;">
            New to the collection? <a href="signup.php" style="color:#DAA520; text-decoration: none; font-weight: bold;">Create an Account</a>
        </p>
    </section>
</main>

<div id="resetModal" style="display:none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 8px; width: 90%; max-width: 400px; text-align: center; position: relative; border-top: 5px solid #DAA520;">
        <h3 style="margin-bottom: 15px;">Account Recovery</h3>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">Please enter your registered email address to receive reset instructions.</p>
        
        <form action="process-reset-request.php" method="POST">
            <input type="email" name="reset_email" placeholder="Enter your email" required style="width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">
            <button type="submit" class="btn-gold" style="width: 100%;">Send Request</button>
        </form>
        
        <button onclick="closeResetModal()" style="margin-top: 15px; background: none; border: none; color: #DAA520; cursor: pointer; font-weight: bold;">Cancel</button>
    </div>
</div>

<script>
function togglePass(id) {
    const field = document.getElementById(id);
    const btn = field.nextElementSibling; 
    if (field.type === "password") {
        field.type = "text";
        btn.innerText = "HIDE";
    } else {
        field.type = "password";
        btn.innerText = "SHOW";
    }
}

function openResetModal() {
    document.getElementById('resetModal').style.display = 'flex';
}

function closeResetModal() {
    document.getElementById('resetModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('resetModal');
    if (event.target == modal) {
        closeResetModal();
    }
}
</script>

<?php include('includes/footer.php'); ?>