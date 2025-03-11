<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/assets/sass/admin/admin.css"> <!--//TODO: Mettre ça dans un sous dossier "admin"-->
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
</head>

<body class="login_body">
    <main class="login_main">
        <section class="login_section">
            <div class="login_header">
                <h1 id="login_form_title">PANEL ADMINISTRATEUR<br>GLOBULE FACTORY FIGHTERS</h1>
                <img src="/public/assets/img/GFF_high_quality_transparent.png" alt="logo_team">
            </div>


            <form method="post" action="/admin/login" class="login_form">
                <label class="login_label">Nom d'utilisateur</label>
                <input type="text" name="username" class="login_input" required>

                <label class="login_label">Mot de passe</label>
                <input type="password" name="password" class="login_input" required>

                <?php if (isset($_GET['error'])): ?>
                    <p class="error-message">Identifiants incorrects, veuillez réessayer.</p>
                <?php endif; ?>

                <button class="login_submit_button" type="submit">CONNEXION</button>
            </form>
        </section>
    </main>
</body>

</html>
