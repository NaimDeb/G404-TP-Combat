<?php
include_once "./assets/components/htmlstart.php";
?>

<!-- Main Content -->
<main class="min-h-screen px-4 py-10">


        <!-- Créer un Héros -->
    <section class="mt-12">
        <a href="./createYourHero.php">
            <h2 class="text-3xl  m-auto font-bold text-center w-fit px-8 py-2 text-slate-100 mb-8 outline outline-2 outline-purple-600 bg-purple-500 hover:bg-purple-600 hover:outline-purple-700 hover:scale-125 transition-all rounded-full">Commencez votre aventure</h2>
        </a>
    </section>

    <!-- Hall of fame of the fallen heroes -->
    <section>
        <h2 class="text-3xl font-bold text-center text-red-500 mb-8">Hall of the fallen heroes</h2>
        <div class="bg-gray-800 p-6 rounded-lg shadow-xl flex gap-4 overflow-x-scroll">
            <?php
            $heroRepo = new HeroRepository;
            $allHeroes = $heroRepo->fetchAllHeroes();

            if (empty($allHeroes)) {
            ?>
                <h3 class="text-2xl text-white">No fallen heroes yet...</h3>
                <?php
            } else {
                foreach ($allHeroes as $hero) {
                ?>
                    <div class="group hero-card min-w-[200px] max-w-[200px] w-[200px] p-4 bg-gray-800 rounded-lg shadow-lg h-[250px] hover:h-[350px] transition-all overflow-y-hidden ">
                        <img src="<?php echo $hero->getImage_Url(); ?>" alt="<?php echo $hero->getName(); ?>" class="hero-image w-full h-[150px] object-cover rounded-md">
                        <h3 class="hero-name text-xl text-white font-bold mt-2 truncate" title="<?php echo $hero->getName(); ?>">
                            <?php echo $hero->getName(); ?>
                        </h3>
                        <p class="hero-level text-sm text-gray-300">Level: <?php echo $hero->getLevel(); ?></p>
                        <div class="stats-container mt-3 space-y-2 opacity-0 group-hover:opacity-100 transition-all duration-300 ease-in-out">
                            <?php foreach ($hero->getAllStats() as $name => $stat): ?>
                                <div class="stat-item flex justify-between text-sm">
                                    <span class="font-semibold text-gray-400 capitalize"><?= htmlspecialchars($name) ?>:</span>
                                    <span class="text-gray-200"><?= htmlspecialchars($stat) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

            <?php
                }
            }
            ?>
        </div>
    </section>



</main>


<?php
include_once "./assets/components/htmlend.php";
?>