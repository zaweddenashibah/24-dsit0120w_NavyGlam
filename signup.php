<?php include('includes/header.php'); ?>

<main class="content-wrapper">
    <section class="glam-section">
        <h2>Become a Glam Member</h2>
        <form action="process-signup.php" method="POST" class="profile-form">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="password" name="password" id="signupPass" required style="width: 100%; padding-right: 60px;">
                    <span onclick="togglePass('signupPass')" 
                          style="position: absolute; right: 15px; cursor: pointer; font-size: 0.75rem; color: #DAA520; font-weight: bold; user-select: none;">
                          SHOW
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-gold">Join the Elite</button>
        </form>

        <p style="margin-top:20px; font-size: 0.9rem;">
            Already a member? <a href="login.php" style="color:#DAA520; text-decoration: none; font-weight: bold;">Login Here</a>
        </p>
    </section>
</main>

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
</script>

<?php include('includes/footer.php'); ?>