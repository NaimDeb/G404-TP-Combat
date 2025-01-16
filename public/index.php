
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
            <a href="./createYourHero.php"><h2 class="text-3xl font-bold text-center text-red-500 mb-8">Créer votre héros dès maintenant !</h2></a>
        </section>

    </main>


<?php
    include_once "./assets/components/htmlend.php";
?>

