document.addEventListener("DOMContentLoaded", function() {
    const btnStartFight = document.getElementById('btnStartFight');
    // const actionSection = document.getElementById('actionSection');
    const attackButton = document.querySelector('.btn-attack');
    // const defendButton = document.querySelector('.btn-defend');
    // const skillButton = document.querySelector('.btn-skill');
    const combatLog = document.getElementById('log');
    const inventoryList = document.getElementById('inventoryList');

    const turnDiv = document.getElementById('turnDiv');


    // Progress bar
    const heroBar = document.getElementById("heroBar");
    const heroMarker = document.getElementById("heroMarker");
    const heroProgress = document.getElementById("heroProgress");
    const enemyBar = document.getElementById("enemyBar");
    const enemyMarker = document.getElementById("enemyMarker");
    const enemyProgress = document.getElementById("enemyProgress");


    attackButton.addEventListener("click", heroAttack);
    // defendButton.addEventListener("click", heroDefend);
    // skillButton.addEventListener("click", heroSkill);
    // todo : add it.
    btnStartFight.addEventListener("click", startFight)


    // AJAX Request to combat_action.php
    async function performAction(action, entity = "hero") {
        return fetch('combat_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    "action": action,
                    "entity": entity
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                updateCombatLog(data.message);
                refreshEntities(data.hero, data.enemy);

                turnDiv.innerHTML = ''
                
                heroBar.style.width =  "0%";
                heroMarker.style.left =  "0%";
                heroProgress.style.left =  "0%";

                if (data.gameOver) {
                    console.log("game over");
                    updateCombatLog(data.gameOverMessage);
                    showNextButton(data.gameOverHasHeroWon);
                    console.log(data.gameOverHasHeroWon);
                    
                    stopActions();
                    clearInterval(fightInterval);
                }
            })
            .catch(error => console.error('Error:', error));
    }



    // Sends a update action.
    function updateEntity(entity) {
        performAction('update', entity)
    }

    function refreshEntities(hero, enemy) {
        document.getElementById('heroDiv').innerHTML = hero;
        document.getElementById('enemyDiv').innerHTML = enemy;
    }




    function startFight() {
            btnStartFight.style.display = "none";
            heroTicks = 0;
            enemyTicks = 0;
            isFightPaused = false;
    }

    // CSS Update
    function showNextButton(hasHeroWon) {
        if (hasHeroWon == true) {
            console.log("win");

            nextButton.innerHTML = `
            <a href="prepareForNextFight.php" class="text-2xl text-white text-center ">
                <div class=" text-white px-4 py-2 w-full text-center bg-green-600">
                    Vous avez gagné le combat ! <br> Préparez vous -->
                </div>
            </a>
        `
        } else {
            console.log('lose');

            nextButton.innerHTML = `
            <a href="youAreDead.php" class="text-2xl text-white text-center ">
                <div class=" text-white px-4 py-2 w-full text-center bg-red-700">
                    Vous avez perdu <br> --> Score final
                </div>
            </a>
        `
        }
    }

    // CSS Update
    function updateCombatLog(message) {
        const logEntry = document.createElement('div');
        logEntry.innerHTML = message;
        combatLog.appendChild(logEntry);
        // Scroll en bas todo : pas faire un getElement a chaque fois
        document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
    }


    // Remove event listeners when it's not your turn
    function stopActions() {
        attackButton.removeEventListener("click", heroAttack);
        // defendButton.removeEventListener("click", heroDefend);
        // skillButton.removeEventListener("click", heroSkill);
    }

    // Add back event listeners when it's your turn
    function startActions() {
        attackButton.addEventListener("click", heroAttack);
        // defendButton.addEventListener("click", heroDefend);
        // skillButton.addEventListener("click", heroSkill);
    }





    //  --------Implémentation tour par tour--------

    // Vitesse d'attaque des participants

    // Accumulateurs de ticks pour le héros et l'ennemi
    let heroTicks = 0;
    let enemyTicks = 0;

    // Nombre de ticks dans un tour
    const turnSpeed = 1000;

    let isFightPaused = true;

    const fightInterval = setInterval(fightLogic, 10)


    function fightLogic() {
        if (isFightPaused) {
            return;
        };

        heroTicks += heroAttackSpeed;
        enemyTicks += enemyAttackSpeed;

        // // ! Log to remove
        // console.log("hero ticks : " + heroTicks);
        // console.log("enemy ticks : " + enemyTicks);


         // Remplir la barre du héros en fonction des ticks
         const heroProgressWidth = Math.min((heroTicks / turnSpeed) * 100, 100); // Ne pas dépasser 100%
         heroBar.style.width = heroProgressWidth + "%";
         heroMarker.style.left = heroProgressWidth + "%";
         heroProgress.style.left = heroProgressWidth + "%";
 
         // Remplir la barre de l'ennemi en fonction des ticks
         const enemyProgressWidth = Math.min((enemyTicks / turnSpeed) * 100, 100); // Ne pas dépasser 100%
         enemyBar.style.width = enemyProgressWidth + "%";
         enemyMarker.style.left = enemyProgressWidth + "%";
         enemyProgress.style.left = enemyProgressWidth + "%";
 




        //  Quand c'est le tour du héros
        if (heroTicks >= turnSpeed) {
            console.log("----------------Hero's turn !----------------");

            heroTicks -= turnSpeed; // On réinitialise les ticks
            // On remet la barre a 0
            turnDiv.innerHTML = "C'est votre tour !";
            startActions();
            isFightPaused = true
        }

        // Quand c'ets le tour de l'ennemi
        if (enemyTicks >= turnSpeed) {
            console.log("----------------Enemy's turn !----------------");

            enemyBar.style.width =  "0%";
            enemyMarker.style.left =  "0%";
            enemyProgress.style.left =  "0%";

            enemyAction();
            enemyTicks -= turnSpeed; // On réinitialise les ticks
        }
    }


    // --------ACTIONS--------

    // todo : more actions, it only attacks for now
    
    
    
    function enemyAction() {
        performAction('enemyAttack');
    }


    // Fonction pour gérer l'attaque du héros
    function heroAttack() {
        performAction('heroAttack')

            .then(() => {
                isFightPaused = false; // Reprendre la simulation de combat après l'action
                stopActions();
            })
            .catch(error => {
                console.error("Erreur lors de l'attaque du héros :", error);
            });
    }



    // --------INVENTAIRE --------

    // Example inventory items
    // const inventoryItems = ["Potion de soin", "Élixir de mana", "Pierre magique"];


    // inventoryItems.forEach(item => {
    //     const li = document.createElement('li');
    //     li.textContent = item;
    //     inventoryList.appendChild(li);

    // })


});
