<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
     
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        @keyframes bounce {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .bounce {
            animation: bounce 1.5s ease infinite;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }
    </style>
</head>

<body class="gradient-bg h-screen flex items-center justify-center">

    <div class="text-center text-white fade-in">
        <h1 class="text-8xl font-extrabold mb-6 animate__animated animate__fadeIn">404</h1>
        <p class="text-3xl mb-6 animate__animated animate__fadeIn animate__delay-1s">
            Oops! La page que vous recherchez n'existe pas.
        </p>
        <a href="index.php" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-full text-lg transition-all duration-300 ease-in-out bounce">
            Retour à l'accueil
        </a>
    </div>

</body>

</html>
