<?php
$pdo = new PDO("mysql:host=localhost;dbname=GalaxyAI", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Recupero tutte le abilità
$query = $pdo->query("SELECT * FROM skill_tree");
$skills = $query->fetchAll(PDO::FETCH_ASSOC);

// Recupero i requisiti per ogni abilità
$requirements = [];
$reqStmt = $pdo->query("
    SELECT sr.skill_id, st.name AS required_name, sr.min_level_required
    FROM skill_requirements sr
    JOIN skill_tree st ON sr.required_skill_id = st.id
");

foreach ($reqStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $requirements[$row['skill_id']][] = $row['required_name'] . " (Lv: " . $row['min_level_required'] . ")";
}

// Aggiungo i requisiti alla lista delle abilità
foreach ($skills as &$skill) {
    $skill['requirements'] = $requirements[$skill['id']] ?? [];
}

echo json_encode($skills);
?>
