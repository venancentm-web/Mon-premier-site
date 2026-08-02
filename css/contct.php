<?php
$message_envoye = false;
$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envoyer'])) {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($nom)) {
        $erreurs['nom'] = 'Veuillez entrer votre nom.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email'] = 'Veuillez entrer un email valide.';
    }
    if (empty($sujet)) {
        $erreurs['sujet'] = 'Veuillez indiquer un sujet.';
    }
    if (empty($message)) {
        $erreurs['message'] = 'Veuillez écrire votre message.';
    }
    if (empty($erreurs)) {
        $destinataire = 'venancentm@gmail.com';
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $corps = "Nom : $nom\n";
        $corps .= "Email : $email\n";
        $corps .= "Sujet : $sujet\n\n";
        $corps .= "Message :\n$message";

        if (mail($destinataire, $sujet, $corps, $headers)) {
            $message_envoye = true;
            $nom = $email = $sujet = $message = '';
        } else {
            $erreurs['general'] = 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon site - Contact</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="/">
            <img src="img/logo.png" alt="Logo du site">
        </a>
        <a href="/">Mon site</a>
        <nav>
            <ul>
                <li><a href="#accueil">Accueil</a></li>
                <li><a href="#a-propos">À propos</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="accueil">
            <h1>Bienvenue</h1>
            <p>Test d'affichage</p>
        </section>
        <section id="a-propos">
            <h2>À propos</h2>
            <p>Ce site est un exemple de page dynamique avec formulaire de contact.</p>
        </section>
        <section id="contact">
            <h2>Contactez-moi</h2>

            <?php if ($message_envoye) : ?>
                <p style="color: green; font-weight: bold;">✅ Votre message a bien été envoyé. Merci !</p>
            <?php endif; ?>

            <?php if (!empty($erreurs['general'])) : ?>
                <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($erreurs['general']); ?></p>
            <?php endif; ?>

            <form method="post" action="#contact">
                <div>
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom ?? ''); ?>" required>
                    <?php if (!empty($erreurs['nom'])) : ?>
                        <span style="color: red;"><?php echo htmlspecialchars($erreurs['nom']); ?></span>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                    <?php if (!empty($erreurs['email'])) : ?>
                        <span style="color: red;"><?php echo htmlspecialchars($erreurs['email']); ?></span>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="sujet">Sujet *</label>
                    <input type="text" id="sujet" name="sujet" value="<?php echo htmlspecialchars($sujet ?? ''); ?>" required>
                    <?php if (!empty($erreurs['sujet'])) : ?>
                        <span style="color: red;"><?php echo htmlspecialchars($erreurs['sujet']); ?></span>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" rows="5" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                    <?php if (!empty($erreurs['message'])) : ?>
                        <span style="color: red;"><?php echo htmlspecialchars($erreurs['message']); ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" name="envoyer">Envoyer</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Mon site - Tous droits réservés.</p>
    </footer>
</body>
</html>