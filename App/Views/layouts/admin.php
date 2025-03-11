<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Admin</title>
    <link rel="stylesheet" href="/public/css/admin-style.css">
</head>

<body>
    <main>
        <div class="admin-container">
            <header id="index_header">
                <span>Dashboard</span>
                <button>
                    <a href="/admin/logout">Déconnexion</a>
                </button>
            </header>

            <section class="welcome_section">
               
                <h3>Panel d'administration du site Globule Factory Fighters.</h3>
            </section>


            <section id="messages">
                <?php include __DIR__ . '/../admin/messages.php'; ?>
            </section>
            <section id="schedule">
                <?php include __DIR__ . '/../admin/schedule.php'; ?>
            </section>
            <section id="competitors">
                <?php include __DIR__ . '/../admin/competitors.php'; ?>
            </section>
    </main>
    </div>
</body>

</html>