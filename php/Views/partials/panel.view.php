<div class="panel">
    <h2>Estadístiques del Joc</h2>
    <div class="scores">
        <div class="player-score player1">
            <h3><?php echo $players[1]->getName(); ?></h3>
            <p>Victòries: <?php echo $scores[1]; ?></p>
        </div>
        <div class="player-score player2">
            <h3><?php echo $players[2]->getName(); ?></h3>
            <p>Victòries: <?php echo $scores[2]; ?></p>
        </div>
    </div>
</div>

<style>
    .panel {
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .scores {
        display: flex;
        justify-content: space-between;
    }

    .player-score {
        flex: 1;
        padding: 10px;
        margin: 0 10px;
        text-align: center;
    }

    .player1 {
        background-color: <?= $players[1]->getColor() ?>;
    }

    .player2 {
        background-color: <?= $players[2]->getColor() ?>;
    }
</style>
