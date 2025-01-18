<?php
include_once "./assets/components/htmlstart.php";
?>

<h2 class="text-3xl font-bold text-center text-red-500 mb-8">Créez votre nouvel héros</h2>

<form action="../process/create_user_process.php" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-[50%] mx-auto flex items-stretch gap-6 my-8">
    <!-- Image Optionnelle -->
    <div class="flex-shrink-0 flex flex-col justify-center items-center border-2 border-red-600 rounded-lg p-4 min-h-full">
        <label for="hero-image" class="block text-lg text-white mb-2">Image du Héros (Optionnel)</label>
        <input type="file" id="hero-image" name="hero_image" accept="image/*" class="bg-gray-800 text-white border-2 border-red-600 rounded-lg py-3 px-4 min-w-[300px] focus:outline-none focus:border-red-500">
    </div>

    <!-- Formulaire Principal -->
    <div class="flex-grow flex flex-col justify-between">
        <!-- Nom du héros -->
        <div>
            <label for="hero-name" class="block text-lg text-white text-center">Nom du Héros</label>
            <input type="text" id="hero-name" name="hero_name" placeholder="Entrez le nom du héros" class="bg-transparent text-white text-center placeholder-gray-500 border-none text-4xl focus:outline-none w-full">
        </div>

        <!-- Statistiques -->
        <div class="space-y-4 mt-6">
            <h3 class="text-center text-white text-xl font-bold">Stats</h3>

            <!-- Points restants et Statistiques -->
            <div class="flex justify-between items-center mt-6">
                <!-- Statistiques -->
                <div class="space-y-4 w-3/4">

                    <?php
                    $stats = [
                        "hero-str" => "Force",
                        "hero-int" => "Intelligence",
                        "hero-dex" => "Dextérité",
                        "hero-con" => "Constitution"
                    ];
                    $stat_descriptions = [
                        "Force" => "Augmente les dégâts physiques.",
                        "Intelligence" => "Renforce les attaques magiques.",
                        "Dextérité" => "Améliore l'agilité et la vitesse.",
                        "Constitution" => "Augmente les points de vie."
                    ];

                    foreach ($stats as $id => $name) {
                        echo "
                    <div class='flex items-center gap-4'>
                    <label for='{$id}' class='text-white text-lg w-32 relative group'>
                        {$name}
                        <div class='absolute top-8 left-0 bg-gray-800 text-white text-sm p-2 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity'>
                            {$stat_descriptions[$name]}
                        </div>
                    </label>
                    <button type='button' class=' hover:bg-gray-500 outline outline-2 outline-gray-500 hover:outline-gray-700 w-10 h-10 flex items-center justify-center rounded-full group' onclick=\"adjustStat('{$id}', -1)\">
                    <svg class='bg-gray-500 group-hover:bg-slate-300 ' width='12' height='2' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        </button>

                    <input type='text' id='{$id}' name='{$id}' value='10' class='stat bg-transparent text-white text-center placeholder-gray-500 border-none text-lg focus:outline-none w-20 font-medium' readonly>

                    <button type='button' class=' hover:bg-gray-500 outline outline-2 outline-gray-500 hover:outline-gray-700 w-10 h-10 flex items-center justify-center rounded-full group' onclick=\"adjustStat('{$id}', 1)\">
                        <svg class='' 
                            width='16' height='16' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
                            <rect x='7' y='1' width='2' height='14' class='fill-gray-500 group-hover:fill-slate-300 ' />
                            <rect x='1' y='7' width='14' height='2' class='fill-gray-500 group-hover:fill-slate-300 ' />
                        </svg>
                    </button>
                    </div>";
                    }
                    ?>
                </div>

                <!-- Points Restants & Reset button -->
                <div class="text-right text-white text-lg font-semibold flex flex-col gap-4">
                    <div id="points-remaining" class="text-center outline outline-1 outline-gray-500 p-2 text-gray-400 rounded-md">
                        Points restants : <br>
                        <span id="remaining-points" class="font-bold text-gray-300 text-xl">10</span>
                    </div>
                    <button type="button" onclick="resetStats()" id="reset-stats" class="px-4 py-2 text-gray-500 bg-transparent outline outline-2 outline-gray-500 hover:bg-gray-500 hover:text-slate-200 m-auto rounded-full">Reset stats</button>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="bg-gradient-to-r from-red-500 to-red-700 text-white px-6 py-3 rounded-full font-bold w-full shadow-lg transition-transform hover:scale-105 mt-6">Créer Héros</button>
        </div>
</form>

<script>
    let totalGivenPoints = 10;
    let totalBaseStats = 40

    // Fix remainingPoints not accounting the current points when refreshing the page
    let remainingPointsDiv = document.querySelector("#remaining-points")
    let currentStats = 0;
    document.querySelectorAll(".stat").forEach(singlestat => {

        currentStats += parseInt(singlestat.value)

    })

    remainingPoints = totalGivenPoints - (currentStats - totalBaseStats)


    remainingPointsDiv.innerHTML = remainingPoints




    function adjustStat(statId, delta) {
        const statInput = document.getElementById(statId);
        const currentValue = parseInt(statInput.value, 10);
        const newValue = currentValue + delta;

        // Bloque les stats à 5 minimum et vérifie les points restants
        if (newValue >= 5 && (remainingPoints > 0 || delta < 0)) {
            statInput.value = newValue;
            remainingPoints -= delta;
            document.getElementById("remaining-points").textContent = remainingPoints;
        }
        statInput.style.fontWeight = newValue >= 20 ? '900' : newValue >= 15 ? '700' : newValue <= 9 ? '100' : '500';
    }

    function resetStats(event) {
        document.querySelectorAll(".stat").forEach(singlestat => {
            singlestat.value = 10;
            singlestat.style.fontWeight = "500"
        });
        remainingPoints = totalGivenPoints;
        document.getElementById("remaining-points").textContent = remainingPoints;

    };


    // todo : if stat below 10, font slim, if more than 15, font bold
</script>

<?php
include_once "./assets/components/htmlend.php";
?>