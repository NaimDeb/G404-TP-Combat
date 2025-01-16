<?php
    include_once "./assets/components/htmlstart.php";
?>

<h2 class="text-3xl font-bold text-center text-red-500 mb-8">Créez votre nouvel héros</h2>

<form action="../process/create_user_process.php" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-[50%] mx-auto flex items-stretch gap-6 my-8">
    <!-- Image Optionnelle -->
    <div class="flex-shrink-0 flex flex-col justify-center items-center border-2 border-red-600 rounded-lg p-4 min-h-full">
        <label for="hero-image" class="block text-lg text-white mb-2">Image du Héros</label>
        <input type="file" id="hero-image" name="hero_image" accept="image/*" class="bg-gray-800 text-white border-2 border-red-600 rounded-lg py-3 px-4 min-w-[300px] focus:outline-none focus:border-red-500">
    </div>

    <!-- Formulaire Principal -->
    <div class="flex-grow flex flex-col justify-between">
        <div>
            <label for="hero-name" class="block text-lg text-white">Nom du Héros</label>
            <input type="text" id="hero-name" name="hero_name" placeholder="Nom du héros" class="bg-gray-800 text-white border-2 border-red-600 rounded-lg py-3 px-4 w-full focus:outline-none focus:border-red-500">
        </div>

        <!-- Statistiques -->
        <div class="space-y-4 mt-6">
            <!-- Force -->
            <div class="flex items-center gap-4">
                <label for="hero-str" class="text-white text-lg w-32">Force</label>
                <button type="button" class="bg-red-600 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold" onclick="adjustStat('hero-str', -1)">-</button>
                <input type="number" id="hero-str" name="str" value="10" class="bg-gray-800 text-white border-2 border-red-600 rounded-lg py-2 px-4 w-20 text-center focus:outline-none focus:border-red-500 appearance-none" readonly>
                <button type="button" class="bg-green-600 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold" onclick="adjustStat('hero-str', 1)">+</button>
            </div>

            <!-- Intelligence -->
            <div class="flex items-center gap-4">
                <label for="hero-int" class="text-white text-lg w-32">Intelligence</label>
                <button type="button" class="bg-red-600 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold" onclick="adjustStat('hero-int', -1)">-</button>
                <input type="number" id="hero-int" name="int" value="10" class="bg-gray-800 text-white border-2 border-red-600 rounded-lg py-2 px-4 w-20 text-center focus:outline-none focus:border-red-500 appearance-none" readonly>
                <button type="button" class="bg-green-600 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold" onclick="adjustStat('hero-int', 1)">+</button>
            </div>

            <!-- Dextérité -->
            <div class="flex items-center gap-4">
                <label for="hero-dex" class="text-white text-lg w-32">Dextérité</label>
                <button type="button" class="bg-red-600 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold" onclick="adjustStat('hero-dex', -1)">-</button>
                <input type="number" id="hero-dex" name="dex" value="10" class="bg-gray-800 text-white border-2 border-red-600 rounded-lg py-2 px-4 w-20 text-center focus:outline-none focus:border-red-500 appearance-none" readonly>
                <button type="button" class="bg-green-600 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold" onclick="adjustStat('hero-dex', 1)">+</button>
            </div>

            <!-- Constitution -->
            <div class="flex items-center gap-4">
                <label for="hero-con" class="text-white text-lg w-32">Constitution</label>
                <button type="button" class="bg-red-600 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold" onclick="adjustStat('hero-con', -1)">-</button>
                <input type="number" id="hero-con" name="con" value="10" class="bg-gray-800 text-white border-2 border-red-600 rounded-lg py-2 px-4 w-20 text-center focus:outline-none focus:border-red-500 appearance-none" readonly>
                <button type="button" class="bg-green-600 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold" onclick="adjustStat('hero-con', 1)">+</button>
            </div>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="bg-gradient-to-r from-red-500 to-red-700 text-white px-6 py-3 rounded-full font-bold w-full shadow-lg transition-transform hover:scale-105 mt-6">Créer Héros</button>
    </div>
</form>

<script>
    function adjustStat(statId, delta) {
        const statInput = document.getElementById(statId);
        const currentValue = parseInt(statInput.value, 10);
        const newValue = Math.max(0, currentValue + delta); // Empêche les valeurs négatives
        statInput.value = newValue;
    }
</script>





<?php
    include_once "./assets/components/htmlend.php";
?>