
<?php
    include_once "./assets/components/htmlstart.php";
?>
   
   <!-- Main Content -->
    <main class="min-h-screen px-4 py-10">

        <!-- Liste des Héros -->
        <section>
            <h2 class="text-3xl font-bold text-center text-red-500 mb-8">Liste des Héros</h2>
            <div class="bg-gray-800 p-6 rounded-lg shadow-xl">
                <h3 class="text-2xl text-white">Aucun héros pour l'instant...</h3>
                <p class="text-gray-400">Ajoutez votre héros à l'arène pour combattre.</p>
            </div>
        </section>

        <!-- Créer un Héros -->
        <section class="mt-12">
            <h2 class="text-3xl font-bold text-center text-red-500 mb-8">Créer un Héros</h2>
            <form action="create_hero.php" method="POST" class="space-y-6 max-w-lg mx-auto">
                <div>
                    <label for="hero-name" class="block text-lg text-white">Nom du Héros</label>
                    <input type="text" id="hero-name" name="hero_name" placeholder="Nom du héros" class="bg-gray-800 text-white border-2 border-red-600 rounded-lg py-3 px-4 w-full focus:outline-none focus:border-red-500">
                </div>
                <button type="submit" class="bg-gradient-to-r from-red-500 to-red-700 text-white px-6 py-3 rounded-full font-bold w-full shadow-lg transition-transform hover:scale-105">Créer Héros</button>
            </form>
        </section>

    </main>


<?php
    include_once "./assets/components/htmlend.php";
?>

