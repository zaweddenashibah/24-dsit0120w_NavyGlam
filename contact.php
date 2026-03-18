<?php include('includes/header.php'); ?>

<main class="content-wrapper">
    <section class="glam-section">
        <h2>Get In Touch</h2>
        <p>Have a question about an order or a specific piece? Our stylists are here to help.</p>
        
        <?php if(isset($_GET['sent'])): ?>
            <p style="color: #DAA520; font-weight: bold;">✓ Message sent. We will get back to you within 24 hours.</p>
        <?php endif; ?>

        <form action="process-contact.php" method="POST" class="profile-form" style="margin-top: 30px;">
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" name="name" required placeholder="Full Name">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="Where can we reach you?">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" rows="5" style="width: 100%; border: 1px solid #000; padding: 10px;" required></textarea>
            </div>
            <button type="submit" class="btn-gold">Send Message</button>
        </form>
    </section>
</main>

<?php include('includes/footer.php'); ?>