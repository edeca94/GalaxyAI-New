CREATE DATABASE IF NOT EXISTS GalaxyAI;
USE GalaxyAI;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    authLevel INT NOT NULL DEFAULT 0,
    homePlanetId INT,
    currentPlanetId INT,
    lastIp VARCHAR(45) NOT NULL,
    registrationIp VARCHAR(45) NOT NULL,
    agent VARCHAR(255),
    currentPage VARCHAR(50),
    registrationTime TIMESTAMP NOT NULL,
    onlineTime TIMESTAMP NULL,
    fleetShortcutId INT NULL,
    allyId INT NULL,
    allyRequest INT NULL,
    allyRequestText TEXT NULL,
    allyRegistrationTime TIMESTAMP NULL,
    allyRankId INT NULL,
    isBanned INT NOT NULL DEFAULT 0,
    INDEX idx_id (id)
);

CREATE TABLE IF NOT EXISTS planets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    type INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    galaxy INT NOT NULL,
    system INT NOT NULL,
    position INT NOT NULL,
    lastUpdate TIMESTAMP NOT NULL,
    destroyed INT NOT NULL DEFAULT 0,
    fields INT NOT NULL,
    totalFields INT NOT NULL,
    diameter INT NOT NULL,
    minTemp INT NOT NULL,
    maxTemp INT NOT NULL,
    metal BIGINT NOT NULL,
    metalPerHour BIGINT NOT NULL,
    crystal BIGINT NOT NULL,
    crystalPerHour BIGINT NOT NULL,
    deuterium BIGINT NOT NULL,
    deuteriumPerHour BIGINT NOT NULL,
    energyUsed BIGINT NOT NULL,
    energyMax BIGINT NOT NULL,
    metalMinePercent INT NOT NULL DEFAULT 10,
    crystalMinePercent INT NOT NULL DEFAULT 10,
    deuteriumSynthesizerPercent INT NOT NULL DEFAULT 10,
    solarPlantPercent INT NOT NULL DEFAULT 10,
    fusionReactorPercent INT NOT NULL DEFAULT 10,
    solarSatellitePercent INT NOT NULL DEFAULT 10,
    lastJumpTime TIMESTAMP NULL,
    debrisMetal BIGINT NULL,
    debrisCrystal BIGINT NULL,
    INDEX idx_id (id),
    INDEX idx_id_userId (id, userId),
    INDEX idx_userId (userId),
    INDEX idx_galaxy_system_position (galaxy, system, position),
    FOREIGN KEY (userId) REFERENCES users(id)
);

ALTER TABLE users
ADD CONSTRAINT fk_homePlanetId
FOREIGN KEY (homePlanetId) REFERENCES planets(id);

ALTER TABLE users
ADD CONSTRAINT fk_currentPlanetId
FOREIGN KEY (currentPlanetId) REFERENCES planets(id);

CREATE TABLE IF NOT EXISTS buildings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    planetId INT,
    metalMine INT DEFAULT 0,
    crystalMine INT DEFAULT 0,
    deuteriumSynthesizer INT DEFAULT 0,
    solarPlant INT DEFAULT 0,
    fusionReactor INT DEFAULT 0,
    robotFactory INT DEFAULT 0,
    naniteFactory INT DEFAULT 0,
    hangar INT DEFAULT 0,
    metalStore INT DEFAULT 0,
    crystalStore INT DEFAULT 0,
    deuteriumTank INT DEFAULT 0,
    researchLab INT DEFAULT 0,
    university INT DEFAULT 0,
    terraformer INT DEFAULT 0,
    allianceDepot INT DEFAULT 0,
    missileBase INT DEFAULT 0,
    lunarOutpost INT DEFAULT 0,
    phalanx INT DEFAULT 0,
    hyperspacePortal INT DEFAULT 0,
    INDEX idx_planetId (planetId),
    FOREIGN KEY (planetId) REFERENCES planets(id)
);

CREATE TABLE IF NOT EXISTS colonized (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    planetId INT NOT NULL,
    galaxy INT NOT NULL,
    system INT NOT NULL,
    position INT NOT NULL,
    INDEX idx_id (id),
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (planetId) REFERENCES planets(id)
);

CREATE TABLE IF NOT EXISTS ships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    planetId INT NOT NULL,
    smallCargo INT NOT NULL DEFAULT 0,
    largeCargo INT NOT NULL DEFAULT 0,
    lightFighter INT NOT NULL DEFAULT 0,
    heavyFighter INT NOT NULL DEFAULT 0,
    cruiser INT NOT NULL DEFAULT 0,
    battleship INT NOT NULL DEFAULT 0,
    colonyShip INT NOT NULL DEFAULT 0,
    recycler INT NOT NULL DEFAULT 0,
    espionageProbe INT NOT NULL DEFAULT 0,
    bomber INT NOT NULL DEFAULT 0,
    solarSatellite INT NOT NULL DEFAULT 0,
    destroyer INT NOT NULL DEFAULT 0,
    battlecruiser INT NOT NULL DEFAULT 0,
    deathStar INT NOT NULL DEFAULT 0,
    INDEX idx_planetId (planetId),
    FOREIGN KEY (planetId) REFERENCES planets(id)
);

CREATE TABLE IF NOT EXISTS defenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    planetId INT NOT NULL,
    rocketLauncher INT NOT NULL DEFAULT 0,
    lightLaser INT NOT NULL DEFAULT 0,
    heavyLaser INT NOT NULL DEFAULT 0,
    gaussCannon INT NOT NULL DEFAULT 0,
    ionCannon INT NOT NULL DEFAULT 0,
    plasmaTurret INT NOT NULL DEFAULT 0,
    smallShieldDome INT NOT NULL DEFAULT 0,
    largeShieldDome INT NOT NULL DEFAULT 0,
    antiBallisticMissile INT NOT NULL DEFAULT 0,
    interplanetaryMissile INT NOT NULL DEFAULT 0,
    INDEX idx_planetId (planetId),
    FOREIGN KEY (planetId) REFERENCES planets(id)
);

CREATE TABLE IF NOT EXISTS researches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    currentResearchId INT,
    espionageTech INT NOT NULL DEFAULT 0,
    computerTech INT NOT NULL DEFAULT 0,
    weaponTech INT NOT NULL DEFAULT 0,
    armourTech INT NOT NULL DEFAULT 0,
    shieldingTech INT NOT NULL DEFAULT 0,
    energyTech INT NOT NULL DEFAULT 0,
    hyperspaceTech INT NOT NULL DEFAULT 0,
    combustionDriveTech INT NOT NULL DEFAULT 0,
    impulseDriveTech INT NOT NULL DEFAULT 0,
    hyperspaceDriveTech INT NOT NULL DEFAULT 0,
    laserTech INT NOT NULL DEFAULT 0,
    ionTech INT NOT NULL DEFAULT 0,
    plasmaTech INT NOT NULL DEFAULT 0,
    intergalacticResearchTech INT NOT NULL DEFAULT 0,
    gravitonTech INT NOT NULL DEFAULT 0,
    INDEX idx_userId (userId),
    FOREIGN KEY (userId) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS messages (
    messageId INT AUTO_INCREMENT PRIMARY KEY,
    messageSenderId INT NOT NULL,
    messageReceiverId INT NOT NULL,
    messageTime TIMESTAMP NOT NULL,
    messageFrom VARCHAR(255) NOT NULL,
    messageSubject VARCHAR(255) NOT NULL,
    messageText TEXT NOT NULL,
    messageRead BOOLEAN NOT NULL DEFAULT false,
    INDEX idx_id (messageId),
    INDEX idx_receiver (messageReceiverId),
    FOREIGN KEY (messageSenderId) REFERENCES users(id),
    FOREIGN KEY (messageReceiverId) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS alliances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    allianceName VARCHAR(255) NOT NULL,
    allianceTag VARCHAR(10) NOT NULL,
    allianceOwnerId INT NOT NULL,
    allianceRegisterTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    allianceDescription TEXT,
    allianceWebsite VARCHAR(255),
    allianceText TEXT,
    allianceImage VARCHAR(255),
    allianceRequestDefaultText TEXT,
    allianceClosed BOOLEAN DEFAULT 0,
    allianceRanks TEXT,
    INDEX idx_id (id),
    FOREIGN KEY (allianceOwnerId) REFERENCES users(id)
);

ALTER TABLE users
ADD CONSTRAINT fk_allyId
FOREIGN KEY (allyId) REFERENCES alliances(id);

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KYE,
    userId INT NOT NULL,
    planetId INT,
    [status] ENUM('pending', 'completed', 'canceled') DEFAULT 'pending',
    [type] ENUM('building', 'research', 'ship', 'defense', 'mission') NOT NULL,
    startTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    endTime TIMESTAMP NOT NULL,
    INDEX idx_id (id),
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (planetId) REFERENCES planets(id)
)

CREATE TABLE buildingQueue(
    id INT AUTO_INCREMENT PRIMARY KEY,
    eventId INT NOT NULL,
    buildingId INT NOT NULL,
    startLevel INT NOT NULL,
    endLevel INT NOT NULL,
    [type] ENUM('building', 'research')
    INDEX idx_id (id),
    FOREIGN KEY (eventId) REFERENCES events(id)
)