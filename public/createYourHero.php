<?php
include_once "./assets/components/htmlstart.php";
?>

<h2 class="text-3xl font-bold text-center text-red-500 mb-8">Créez votre nouvel héros</h2>

<form action="../process/create_user_process.php" method="POST" enctype="multipart/form-data" class="max-w-[50%] mx-auto flex flex-col items-center gap-6 my-8">
    <div class="flex justify-center items-center gap-6 w-full">
        
        <!-- Image Optionnelle -->
        <div class="relative flex-shrink-0 flex flex-col justify-center items-center border-2 border-red-600 rounded-lg p-0 w-[300px] h-[300px] bg-gray-800">
            <!-- Texte -->
            <label for="hero-image" class="absolute z-10 bg-black bg-opacity-45 text-gray-200 px-2 py-1 top-0 left-0 w-full text-center font-bold text-xl">Image du Héros (Optionnel)</label>

            <!-- Hidden file input -->
            <input type="file" id="hero-image" name="hero_image" accept="image/*" class="hidden" optional>

            <!-- Image preview container -->bb
            <div class="relative w-full h-full">
                <img id="image-preview" src="./assets/image/Heroes/defaultHero.png" alt="Preview" class="w-full h-full object-cover object-center rounded-lg">

                <!-- Clear Image X button (absolute positioning) -->
                <button type="button" id="clear-image" class="absolute bottom-2 left-2 bg-gray-800 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-700 transition-all">
                    X
                </button>

                <!-- Upload button (absolute positioning) -->
                <button type="button" id="upload-button" class="absolute bottom-2 right-2 bg-gray-800 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-700 transition-all">
                    +
                </button>
            </div>
        </div>

        <!-- Formulaire Principal -->
        <div class="flex-grow flex flex-col justify-between w-full">

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
                            "str" => "Force",
                            "int" => "Intelligence",
                            "dex" => "Dextérité",
                            "con" => "Constitution"
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
                        <button type='button' class='hover:bg-gray-500 outline outline-2 outline-gray-500 hover:outline-gray-700 w-10 h-10 flex items-center justify-center rounded-full group' onclick=\"adjustStat('{$id}', -1)\">
                        <svg class='bg-gray-500 group-hover:bg-slate-300 ' width='12' height='2' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
                            </button>

                        <input type='text' id='{$id}' name='{$id}' value='10' class='stat bg-transparent text-white text-center placeholder-gray-500 border-none text-lg focus:outline-none w-20 font-medium' readonly>

                        <button type='button' class='hover:bg-gray-500 outline outline-2 outline-gray-500 hover:outline-gray-700 w-10 h-10 flex items-center justify-center rounded-full group' onclick=\"adjustStat('{$id}', 1)\">
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
            </div>
        </div>
    </div>

    <button type="submit" class="bg-gradient-to-r from-red-500 to-red-700 text-white px-6 py-3 rounded-full font-bold w-full shadow-lg transition-transform hover:scale-105 mt-6">Créer Héro</button>

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


    // Image preview

    // Update the preview when a file is selected
    document.getElementById('hero-image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('image-preview');
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Change the preview image to default on "X" button click
    document.getElementById('clear-image').addEventListener('click', function() {
        const previewImage = document.getElementById('image-preview');
        previewImage.src = './assets/image/Heroes/defaultHero.png'; // Default image path
        document.getElementById('hero-image').value = ""; // Clear the file input
    });

    // Trigger file input when "+" button is clicked
    document.getElementById('upload-button').addEventListener('click', function() {
        document.getElementById('hero-image').click(); // Trigger file input click
    });
</script>

    

<?php
include_once "./assets/components/htmlend.php";
?>