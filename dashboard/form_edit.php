<?php
    require 'auth_check.php';
    $planets = json_decode(file_get_contents("../data/planets.json"), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Planet Editor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f8f9fa;
        }

        h1 {
            text-align: center;
        }

        .planet-list {
            max-width: 700px;
            margin: auto;
        }

        .planet-header {
            background-color: #e2e6ea;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 8px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .planet-details {
            display: none;
            padding: 15px 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: 600;
        }

        input, textarea {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
        }

        .submit-btn {
            margin: 30px auto;
            display: block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .add-new {
            background-color: #f1f3f5;
            padding: 20px;
            border-radius: 8px;
            margin-top: 40px;
        }
    </style>
    <script>
        function toggleDetails(id) {
            const detail = document.getElementById(id);
            detail.style.display = detail.style.display === "block" ? "none" : "block";
        }
    </script>
</head>
<body>

<h1>Planet Data Editor</h1>

<form action="save.php" method="post" class="planet-list">

    <?php foreach ($planets as $index => $planet): ?>
        <div class="planet-header" onclick="toggleDetails('planet-<?= $index ?>')">
            <?= htmlspecialchars(ucfirst($planet['name'])) ?>
        </div>

        <div class="planet-details" id="planet-<?= $index ?>">
            <input type="hidden" name="planets[<?= $index ?>][name]" value="<?= htmlspecialchars($planet['name']) ?>">

            <label>Cost</label>
            <input type="text" name="planets[<?= $index ?>][cost]" value="<?= htmlspecialchars($planet['cost']) ?>">

            <label>Distance</label>
            <input type="text" name="planets[<?= $index ?>][distance]" value="<?= htmlspecialchars($planet['distance']) ?>">

            <label>Estimasi</label>
            <input type="text" name="planets[<?= $index ?>][estimasi]" value="<?= htmlspecialchars($planet['estimasi']) ?>">

            <label>Description</label>
            <textarea name="planets[<?= $index ?>][description]"><?= htmlspecialchars($planet['description']) ?></textarea>

            <label>Detail Description</label>
            <textarea name="planets[<?= $index ?>][detailDescription]"><?= htmlspecialchars($planet['detailDescription']) ?></textarea>

            <label>Position (x, y, z)</label>
            <input type="text" name="planets[<?= $index ?>][position]" value="<?= $planet['position']['x'] . ',' . $planet['position']['y'] . ',' . $planet['position']['z'] ?>">

            <label>File</label>
            <input type="text" name="planets[<?= $index ?>][file]" value="<?= htmlspecialchars($planet['file']) ?>">

            <label>Scale</label>
            <input type="text" name="planets[<?= $index ?>][scale]" value="<?= htmlspecialchars($planet['scale']) ?>">
        </div>
    <?php endforeach; ?>

    <div class="add-new">
        <h2>Add New Planet</h2>

        <label>Name</label>
        <input type="text" name="new[name]">

        <label>File</label>
        <input type="text" name="new[file]">

        <label>Scale</label>
        <input type="text" name="new[scale]" value="0.0025">

        <label>Position (x, y, z)</label>
        <input type="text" name="new[position]" placeholder="e.g. 10,0,-50">

        <label>Description</label>
        <textarea name="new[description]"></textarea>

        <label>Detail Description</label>
        <textarea name="new[detailDescription]"></textarea>

        <label>Distance</label>
        <input type="text" name="new[distance]">

        <label>Estimasi</label>
        <input type="text" name="new[estimasi]">

        <label>Cost</label>
        <input type="text" name="new[cost]">
    </div>

    <button class="submit-btn" type="submit">Save All Changes</button>
</form>

</body>
</html>
