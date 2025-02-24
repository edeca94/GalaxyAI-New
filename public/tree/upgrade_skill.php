<?php
$pdo = new PDO("mysql:host=localhost;dbname=GalaxyAI", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skill_id = $_POST['skill_id'];

    // Recupero skill selezionata
    $stmt = $pdo->prepare("SELECT * FROM skill_tree WHERE id = ?");
    $stmt->execute([$skill_id]);
    $skill = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$skill) {
        echo json_encode(["status" => "error", "message" => "Skill non trovata"]);
        exit;
    }

    if ($skill['level'] >= $skill['max_level']) {
        echo json_encode(["status" => "error", "message" => "Skill al massimo livello"]);
        exit;
    }

    // Controllo i requisiti
    $reqStmt = $pdo->prepare("
        SELECT r.required_skill_id, st.level, r.min_level_required
        FROM skill_requirements r
        JOIN skill_tree st ON r.required_skill_id = st.id
        WHERE r.skill_id = ?
    ");
    $reqStmt->execute([$skill_id]);
    $requirements = $reqStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($requirements as $req) {
        if ($req['level'] < $req['min_level_required']) {
            echo json_encode([
                "status" => "error", 
                "message" => "Requisiti non soddisfatti: '" . $req['required_skill_id'] . "' deve essere almeno al livello " . $req['min_level_required']
            ]);
            exit;
        }
    }

    // Se i requisiti sono soddisfatti, aggiorno il livello
    $updateStmt = $pdo->prepare("UPDATE skill_tree SET level = level + 1 WHERE id = ?");
    $updateStmt->execute([$skill_id]);

    echo json_encode(["status" => "success", "message" => "Skill potenziata con successo!"]);
}
?>
