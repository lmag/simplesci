<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notre Catalogue de Biens</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="contact-header">
        <div class="horaires">Nos horaires :</div>
        Lundi au Vendredi<br>
        10h00 - 14h00 | 14h00 - 17h00<br>
        <a href="tel:+33749151080" class="phone-link">07 49 15 10 80</a>
    </div>

    <h1 class="main-title">Nos Biens en Location</h1>

    <div class="catalog-container">
        <?php
        $fichier_csv = '/datas/data_property.csv';
        $is_header = true;

        if (($handle = fopen($fichier_csv, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if ($is_header) {
                    $is_header = false;
                    continue;
                }
                $reference        = $data[1];
                $titre            = $data[2];
                $annonceur        = $data[3];
                $description      = $data[4];
                $loyer            = $data[5];
                $loyer_type       = $data[6];
                $charges          = $data[7];
                $surface          = $data[8];
                $type_bien        = $data[9];
                $colocation       = $data[10];
                $image_file       = $data[11];
                $virtual_tour_url = $data[12];
                $status           = $data[13];
                
                $status_class = ($status == 'a_venir') ? 'coming-soon' : '';
                
                echo '<div class="property-card ' . htmlspecialchars($status_class) . '">';
                echo '    <img src="medias/' . htmlspecialchars($image_file) . '" alt="Photo du bien ' . htmlspecialchars($titre) . '" class="card-image">';
                echo '    <div class="card-content">';
                
                echo '        <h2 class="title">' . htmlspecialchars($titre) . '</h2>';
                echo '        <p class="ad-reference">' . htmlspecialchars($reference) . '</p>';
                echo '        <p class="annonceur">Proposé par : ' . htmlspecialchars($annonceur) . '</p>';

                if ($status == 'a_venir') {
                    echo '<p class="description coming-soon-text">Informations à venir prochainement.</p>';
                } else {
                    
                    // 1. Description
                    echo '        <p class="description">' . htmlspecialchars($description) . '</p>';

                    // 2. BLOC PRIX (DÉPLACÉ ICI, SOUS LA DESCRIPTION)
                    if (!empty($loyer)) {
                        echo '    <div class="price-container">';
                        echo '        <div class="price-main">' . htmlspecialchars($loyer) . ' €</div>';
                        echo '        <div class="price-type">/ mois ' . htmlspecialchars($loyer_type) . '</div>';
                        if (!empty($charges) && $charges > 0) {
                            echo '    <div class="price-charges">+ ' . htmlspecialchars($charges) . ' € de charges</div>';
                        }
                        echo '    </div>';
                    }
                    
                    // 3. Bloc de spécifications
                    echo '        <div class="property-specs">';
                    if (!empty($surface)) echo '<div class="spec-item">📐<span>' . htmlspecialchars($surface) . ' m²</span></div>';
                    if (!empty($type_bien)) echo '<div class="spec-item">🏢<span>' . htmlspecialchars($type_bien) . '</span></div>';
                    if ($colocation == 'Oui') echo '<div class="spec-item">👥<span>Colocation possible</span></div>';
                    echo '        </div>';

                    // 4. Bouton de visite virtuelle
                    if (!empty($virtual_tour_url)) {
                        echo '<a href="' . htmlspecialchars($virtual_tour_url) . '" target="_blank" rel="noopener noreferrer" class="cta-button" style="margin-top: 1.5em;">Visite Virtuelle 360°</a>';
                    }
                }
                
                echo '    </div>';
                echo '</div>';
            }
            fclose($handle);
        } else {
            echo "<p style='text-align:center; color:red;'>Erreur : Impossible de trouver le fichier des annonces (annonces.csv).</p>";
        }
        ?>
    </div>

</body>
</html>