<?php include '../App/Views/admin/layout/header.php'; ?>

<section class="section_scrolling_messages">
    <h1>Gestion des messages défilants</h1>

    <?php foreach ($messages as $message) : ?>
        <div class="message-container">
            <!-- Affichage du message actuel -->
            <div class="current-message">
                Message actuel ( <?= $message['id'] ?> ) | " <?= htmlspecialchars($message['content']) ?> "
            </div>

            <!-- Formulaire de modification -->
            <form action="/admin/messages/update" method="post">
                <input type="hidden" name="id" value="<?= $message['id'] ?>">
                <label for="message-<?= $message['id'] ?>">Nouveau message :</label><br>
                <input type="text" id="message-<?= $message['id'] ?>" class="message-input" name="content"
                    value="<?= htmlspecialchars($message['content']) ?>" required>
                <button type="submit" class="msg_submit_buttons"><i class="fa-solid fa-floppy-disk"></i></button>
            </form>
        </div>
    <?php endforeach; ?>
</section>

<?php include '../App/Views/admin/layout/footer.php'; ?>
