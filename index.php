<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon Select</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .pokemon-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 10px;
            width: 200px;
            cursor: pointer; /* Cambiamos el cursor a mano */
        }

        .pokemon-image {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .pokemon-name {
            font-weight: bold;
        }

        nav {
            position: fixed;
            left: 0;
            top: 0;
            width: 200px;
            background-color: #333;
            padding-top: 20px;
            height: 100%;
            box-sizing: border-box;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin-bottom: 10px;
        }

        nav ul li a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px;
        }

        nav ul li a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="#" id="inicio">Inicio</a></li>
            <li><a href="#" id="ordenar-alfabeticamente">Ordenar Alfabeticamente</a></li>
            <li><a href="#" id="orden-inverso">Orden Inverso</a></li>
            <li><a href="#" id="mostrar-25">Mostrar 25</a></li>
        </ul>
    </nav>
    <div class="pokemon-content">
        <h1 style="text-align: center;">Pokemon Select</h1>
        <?php
        // Iterar para obtener 50 Pokémon
        for ($i = 1; $i <= 50; $i++) {
            // URL de la API de Pokémon para obtener un Pokémon aleatorio
            $url = 'https://pokeapi.co/api/v2/pokemon/' . rand(1, 898); // Hay 898 Pokémon en total hasta el momento

            // Obtener los datos del servicio web
            $data = file_get_contents($url);

            // Decodificar el JSON en un array de PHP
            $pokemon = json_decode($data, true);

            // Verificar si se obtuvieron los datos correctamente
            if ($pokemon && isset($pokemon['name']) && isset($pokemon['sprites']['front_default'])) {
                $name = ucfirst($pokemon['name']);
                $imageUrl = $pokemon['sprites']['front_default'];
            } else {
                $name = "Pokémon no encontrado";
                $imageUrl = "";
            }
            ?>
            <div class="pokemon-card" onclick="mostrarPokemon('<?php echo $name; ?>', '<?php echo $imageUrl; ?>')">
                <h3 class="pokemon-name"><?php echo $i . '. ' . $name; ?></h3>
                <img src="<?php echo $imageUrl; ?>" alt="<?php echo $name; ?>" class="pokemon-image">
            </div>
            <?php
        }
        ?>
    </div>
    <script>
        function mostrarPokemon(name, imageUrl) {
            var pokemonContent = document.querySelector('.pokemon-content');
            pokemonContent.innerHTML = '';

            var pokemonCard = document.createElement('div');
            pokemonCard.classList.add('pokemon-card');

            var pokemonName = document.createElement('h3');
            pokemonName.classList.add('pokemon-name');
            pokemonName.textContent = name;

            var pokemonImage = document.createElement('img');
            pokemonImage.classList.add('pokemon-image');
            pokemonImage.src = imageUrl;
            pokemonImage.alt = name;

            pokemonCard.appendChild(pokemonName);
            pokemonCard.appendChild(pokemonImage);

            pokemonContent.appendChild(pokemonCard);
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("inicio").addEventListener("click", function(event) {
                event.preventDefault();
                location.reload();
            });

            document.getElementById("ordenar-alfabeticamente").addEventListener("click", function(event) {
                event.preventDefault();
                ordenarAlfabeticamente();
            });

            document.getElementById("orden-inverso").addEventListener("click", function(event) {
                event.preventDefault();
                ordenarInverso();
            });

            document.getElementById("mostrar-25").addEventListener("click", function(event) {
                event.preventDefault();
                mostrar25();
            });

            document.getElementById("ordenar-por-tipo").addEventListener("click", function(event) {
                event.preventDefault();
                ordenarPorTipo();
            });

            function ordenarAlfabeticamente() {
                var pokemonCards = document.querySelectorAll('.pokemon-card');
                var sortedPokemonCards = Array.from(pokemonCards).sort((a, b) => {
                    var nameA = a.querySelector('.pokemon-name').textContent;
                    var nameB = b.querySelector('.pokemon-name').textContent;
                    return nameA.localeCompare(nameB);
                });

                var pokemonContent = document.querySelector('.pokemon-content');
                pokemonContent.innerHTML = '';
                sortedPokemonCards.forEach(card => {
                    pokemonContent.appendChild(card);
                });
            }

            function ordenarInverso() {
                var pokemonCards = document.querySelectorAll('.pokemon-card');
                var sortedPokemonCards = Array.from(pokemonCards).sort((a, b) => {
                    var nameA = a.querySelector('.pokemon-name').textContent;
                    var nameB = b.querySelector('.pokemon-name').textContent;
                    return nameB.localeCompare(nameA);
                });

                var pokemonContent = document.querySelector('.pokemon-content');
                pokemonContent.innerHTML = '';
                sortedPokemonCards.forEach(card => {
                    pokemonContent.appendChild(card);
                });
            }

            function mostrar25() {
                var pokemonCards = document.querySelectorAll('.pokemon-card');
                pokemonCards.forEach((card, index) => {
                    if (index >= 25) {
                        card.style.display = 'none';
                    } else {
                        card.style.display = 'block';
                    }
                });
            }
        });
    </script>
</body>
</html>
