-- StadiaGame - Script de création de la base de données
-- Ce script crée la structure de base de données pour le site StadiaGame

-- Suppression des tables si elles existent déjà
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS cart_items;
DROP TABLE IF EXISTS games;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- Création de la table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Création de la table des catégories de jeux
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Création de la table des jeux
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    release_date DATE,
    category_id INT NOT NULL,
    developer VARCHAR(100),
    publisher VARCHAR(100),
    platform VARCHAR(50),
    rating DECIMAL(3, 1) DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    min_requirements TEXT,
    rec_requirements TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Création de la table des commandes
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('en attente', 'traitee', 'expédiée', 'livree', 'annulee') NOT NULL DEFAULT 'livree',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Création de la table des articles de commande
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    game_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion des données de base

-- Insertion des catégories
INSERT INTO categories (name, description, image) VALUES
('Action & Aventure', 'Jeux d''action et d''aventure avec des defis physiques et des enigmes.', '/images/categories/action.jpg'),
('RPG', 'Jeux de role ou vous incarnez un personnage dans un monde fantastique.', '/images/categories/rpg.jpg'),
('Strategie', 'Jeux necessitant des competences tactiques et de planification.', '/images/categories/strategy.jpg'),
('FPS', 'Jeux de tir à la premiere personne avec des combats intenses.', '/images/categories/fps.jpg'),
('Sport', 'Jeux bases sur des sports reels comme le football, le basketball, etc.', '/images/categories/sport.jpg'),
('Simulation', 'Jeux simulant des activites reelles comme la conduite ou la gestion.', '/images/categories/simulation.jpg'),
('Jeux a choix multiples', 'Jeux ou les choix du joueur influencent l''histoire et les evenements', '/images/categories/qte.jpg'),
('Horreur', 'Jeux immersifs plongeant le joueur dans une atmosphere angoissante, avec des creatures terrifiantes et des moments de pure terreur.', '/images/categories/horreur.jpg');

-- Insertion d'un utilisateur administrateur (mot de passe: admin123)
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@stadiagame.com', '$2y$10$7s7RTUFKtL6QCYlYIFazZeZwLcZA4PQCFcn8xwrJlPP3W4pCGJlYG', 'admin');

-- Insertion de quelques jeux
INSERT INTO games (title, description, price, image, release_date, category_id, developer, publisher, platform, rating, stock, min_requirements, rec_requirements) VALUES
('Horizon Zero Dawn', 'Dans un monde ouvert post-apocalyptique luxuriant, des machines hostiles dominent la planete. Incarnez Aloy, une chasseuse qui cherche a devoiler son passe et a stopper une menace catastrophique.', 39.99, '/images/games/horizon.jpg', '2020-08-07', 1, 'Guerrilla Games', 'Sony Interactive Entertainment', 'PC', 4.7, 25, 'OS: Windows 10, CPU: Intel Core i5-2500K, RAM: 8 GB, GPU: NVIDIA GeForce GTX 780', 'OS: Windows 10, CPU: Intel Core i7-4770K, RAM: 16 GB, GPU: NVIDIA GeForce GTX 1060'),
('The Witcher 3: Wild Hunt', 'Un jeu de role en monde ouvert base sur l''action et se deroulant dans un univers de fantasy. Suivez Geralt de Riv, un chasseur de monstres a la recherche de sa fille adoptive.', 29.99, '/images/games/witcher3.jpg', '2015-05-19', 2, 'CD Projekt RED', 'CD Projekt', 'PC, PlayStation, Xbox', 4.9, 30, 'OS: Windows 7, CPU: Intel Core i5-2500K, RAM: 6 GB, GPU: NVIDIA GeForce GTX 660', 'OS: Windows 10, CPU: Intel Core i7-3770, RAM: 8 GB, GPU: NVIDIA GeForce GTX 1060'),
('Civilization VI', 'Construisez votre empire a travers les ages dans ce jeu de strategie au tour par tour. Etablissez votre civilisation, recherchez des technologies, et dominez le monde.', 59.99, '/images/games/civ6.jpg', '2016-10-21', 3, 'Firaxis Games', '2K Games', 'PC, Mac', 4.5, 15, 'OS: Windows 7, CPU: Intel Core i3-2.5 GHz, RAM: 4 GB, GPU: Intel HD 530', 'OS: Windows 10, CPU: Intel Core i5-2.5 GHz, RAM: 8 GB, GPU: NVIDIA GeForce GTX 960'),
('FIFA 23', 'Le plus recent opus de la serie FIFA avec des graphismes ameliorees, des controles plus precis et de nouveaux modes de jeu pour vivre l''experience ultime du football.', 69.99, '/images/games/fifa23.jpg', '2022-09-30', 5, 'EA Sports', 'Electronic Arts', 'PC, PlayStation, Xbox', 4.3, 50, 'OS: Windows 10, CPU: Intel Core i5-3550, RAM: 8 GB, GPU: NVIDIA GeForce GTX 670', 'OS: Windows 10, CPU: Intel Core i7-6700, RAM: 12 GB, GPU: NVIDIA GeForce GTX 1660'),
('Cyberpunk 2077', 'Une aventure futuriste dans le monde dystopique de Night City. Explorez un vaste monde ouvert et faites evoluer votre personnage grace a des ameliorations cybernetiques.', 49.99, '/images/games/cyberpunk.jpg', '2020-12-10', 2, 'CD Projekt RED', 'CD Projekt', 'PC, PlayStation, Xbox', 4.0, 35, 'OS: Windows 10, CPU: Intel Core i5-3570K, RAM: 8 GB, GPU: NVIDIA GeForce GTX 780', 'OS: Windows 10, CPU: Intel Core i7-4790, RAM: 12 GB, GPU: NVIDIA GeForce RTX 2060'),
('Flight Simulator 2020', 'Explorez le monde en detail dans ce simulateur de vol ultra-realiste. Pilotez une grande variete d''avions et decouvrez des destinations a travers le globe.', 59.99, '/images/games/flightsim.jpg', '2020-08-18', 6, 'Asobo Studio', 'Xbox Game Studios', 'PC', 4.8, 10, 'OS: Windows 10, CPU: Intel Core i5-4460, RAM: 8 GB, GPU: NVIDIA GeForce GTX 770', 'OS: Windows 10, CPU: Intel Core i7-9800X, RAM: 32 GB, GPU: NVIDIA GeForce RTX 2080'),
('Call of Duty: Modern Warfare', 'Plongez dans une guerre moderne intense avec des graphismes photorealistes et une campagne captivante. Profitez egalement du mode multijoueur competitif.', 49.99, '/images/games/codmw.jpg', '2019-10-25', 4, 'Infinity Ward', 'Activision', 'PC, PlayStation, Xbox', 4.6, 40, 'OS: Windows 10, CPU: Intel Core i3-4340, RAM: 8 GB, GPU: NVIDIA GeForce GTX 670', 'OS: Windows 10, CPU: Intel Core i7-6700K, RAM: 12 GB, GPU: NVIDIA GeForce GTX 1080'),
('Assassin''s Creed Valhalla', 'Incarnez un guerrier Viking et menez votre clan des rivages gaces de Norvege jusqu''aux royaumes d''Angleterre. Construisez votre colonie et conquetez de nouveaux territoires.', 59.99, '/images/games/acvalhalla.jpg', '2020-11-10', 1, 'Ubisoft Montreal', 'Ubisoft', 'PC, PlayStation, Xbox', 4.4, 30, 'OS: Windows 10, CPU: Intel Core i5-4460, RAM: 8 GB, GPU: NVIDIA GeForce GTX 960', 'OS: Windows 10, CPU: Intel Core i7-6700, RAM: 16 GB, GPU: NVIDIA GeForce RTX 2080'),
('Grand Theft Auto V', 'Explorez la ville tentaculaire de Los Santos dans ce jeu d''action-aventure en monde ouvert. Suivez trois criminels differents dans leur quete de richesse et de pouvoir.', 29.99, '/images/games/gtav.jpg', '2015-04-14', 1, 'Rockstar North', 'Rockstar Games', 'PC, PlayStation, Xbox', 4.9, 45, 'OS: Windows 7, CPU: Intel Core i5-3470, RAM: 8 GB, GPU: NVIDIA GeForce GTX 660', 'OS: Windows 10, CPU: Intel Core i7-4770K, RAM: 16 GB, GPU: NVIDIA GeForce GTX 1060'),
('Cities: Skylines', 'Construisez la ville de vos reves dans ce simulateur de gestion urbaine. Gerez les transports, l''economy, les services publics et bien plus encore.', 29.99, '/images/games/cities.jpg', '2015-03-10', 6, 'Colossal Order', 'Paradox Interactive', 'PC, Mac', 4.7, 20, 'OS: Windows 7, CPU: Intel Core i3-3210, RAM: 4 GB, GPU: NVIDIA GeForce GTX 660', 'OS: Windows 10, CPU: Intel Core i5-3470, RAM: 8 GB, GPU: NVIDIA GeForce GTX 1060'),
('Elden Ring', 'Un RPG d''action epique se deroulant dans un vaste monde ouvert. Explorez des royaumes interconnectes, affrontez des boss legendaires et decouvrez une histoire fascinante.', 59.99, '/images/games/eldenring.jpg', '2022-02-25', 2, 'FromSoftware', 'Bandai Namco', 'PC, PlayStation, Xbox', 4.9, 15, 'OS: Windows 10, CPU: Intel Core i5-8400, RAM: 12 GB, GPU: NVIDIA GeForce GTX 1060', 'OS: Windows 10, CPU: Intel Core i7-8700K, RAM: 16 GB, GPU: NVIDIA GeForce GTX 1070'),
('Minecraft', 'Un jeu bac a sable ou vous pouvez construire et explorer des mondes generes aleatoirement. Laissez libre cours a votre creativite ou survivez dans le mode survie. Et pour les gros geeks du gros PVP , avec des sceaux de lave .', 19.99, '/images/games/minecraft.jpg', '2011-11-18', 1, 'Mojang Studios', 'Xbox Game Studios', 'PC, Mac, PlayStation, Xbox, Mobile', 4.8, 100, 'OS: Windows 7, CPU: Intel Core i3-3210, RAM: 4 GB, GPU: Intel HD Graphics', 'OS: Windows 10, CPU: Intel Core i5-4690, RAM: 8 GB, GPU: NVIDIA GeForce GTX 700'),
('Detroit: Become Human', 'Un jeu de role en monde ouvert base sur l''action et se deroulant dans un univers de fantasy. Suivez les aventuriers de la ville de Detroit, un groupe de mercenaires qui cherchent a devoiler leur histoire.', 29.99, '/images/games/detroit.jpg', '2015-05-19', 7, 'CD Projekt RED', 'CD Projekt', 'PC, PlayStation, Xbox', 4.9, 30, 'OS: Windows 7, CPU: Intel Core i5-2500K, RAM: 6 GB, GPU: NVIDIA GeForce GTX 660', 'OS: Windows 10, CPU: Intel Core i7-3770, RAM: 8 GB, GPU: NVIDIA GeForce GTX 1060'),
('The Quarry', 'Un jeu d''horreur interactif ou vous devez prendre des decisions cruciales pour guider un groupe d''adolescents pendant une nuit dans un camp de vacances. Chaque choix a des consequences fatales.', 49.99, '/images/games/thequarry.jpg', '2022-06-10', 7, 'Supermassive Games', '2K Games', 'PC, PlayStation, Xbox', 4.5, 25, 'OS: Windows 10, CPU: Intel Core i5-4460, RAM: 8 GB, GPU: NVIDIA GeForce GTX 970', 'OS: Windows 10, CPU: Intel Core i7-6700K, RAM: 16 GB, GPU: NVIDIA GeForce GTX 1080'),
('The Last of Us', 'Un jeu d''action-aventure se deroulant dans un monde post-apocalyptique. Suivez Joel et Ellie dans leur periple a travers un Etats-Unis ravage par une epidemie.', 39.99, '/images/games/lastofus.jpg', '2013-06-14', 7, 'Naughty Dog', 'Sony Computer Entertainment', 'PlayStation, PC', 4.9, 50, 'OS: Windows 7, CPU: Intel Core i3-2310M, RAM: 4 GB, GPU: NVIDIA GeForce GTX 660', 'OS: Windows 10, CPU: Intel Core i7-3770, RAM: 8 GB, GPU: NVIDIA GeForce GTX 1060'),
('Call of Duty: Black Ops 2', 'Le jeu de tir a la premiere personne se deroule dans un futur proche avec une campagne palpitante et un mode multijoueur competitif. Combattez a travers le monde pour empecher une catastrophe mondiale.', 19.99, '/images/games/blackops2.jpg', '2012-11-13', 4, 'Treyarch', 'Activision', 'PC, PlayStation, Xbox', 4.7, 100, 'OS: Windows 7, CPU: Intel Core i3-530, RAM: 4 GB, GPU: NVIDIA GeForce GTX 460', 'OS: Windows 10, CPU: Intel Core i7-3770, RAM: 8 GB, GPU: NVIDIA GeForce GTX 760'),
('Call of Duty: Black Ops 3', 'Plongez dans un monde futuriste avec une campagne pleine d''action et un mode multijoueur evolue. L''avenir de la guerre est entre vos mains.', 29.99, '/images/games/blackops3.jpg', '2015-11-06', 4, 'Treyarch', 'Activision', 'PC, PlayStation, Xbox', 4.6, 75, 'OS: Windows 7, CPU: Intel Core i3-530, RAM: 8 GB, GPU: NVIDIA GeForce GTX 460', 'OS: Windows 10, CPU: Intel Core i7-6700K, RAM: 16 GB, GPU: NVIDIA GeForce GTX 1080'),
('Fall Guys', 'Un jeu multijoueur en ligne ou des joueurs s''affrontent dans des courses et des mini-jeux pour atteindre la victoire ultime. Le but est de rester le dernier en vie dans un univers colore et fun.', 19.99, '/images/games/fallguys.jpg', '2020-08-04', 1, 'Mediatonic', 'Devolver Digital', 'PC, PlayStation', 4.8, 150, 'OS: Windows 10, CPU: Intel Core i5-2300, RAM: 8 GB, GPU: NVIDIA GeForce GTX 660', 'OS: Windows 10, CPU: Intel Core i7-6700, RAM: 16 GB, GPU: NVIDIA GeForce GTX 1060'),
('FC24', 'Le dernier opus de la serie FIFA, avec des graphismes realistes, des controles fluides et des modes de jeu renouveles pour une experience de football immersive.', 59.99, '/images/games/fc25.jpg', '2024-09-29', 5, 'EA Sports', 'Electronic Arts', 'PC, PlayStation, Xbox', 4.8, 50, 'OS: Windows 10, CPU: Intel Core i5-3550, RAM: 8 GB, GPU: NVIDIA GeForce GTX 670', 'OS: Windows 10, CPU: Intel Core i7-6700, RAM: 12 GB, GPU: NVIDIA GeForce GTX 1660'),
('Far Cry', 'Un jeu d''action-aventure en monde ouvert. Combattez dans des environnements vastes et varies, tout en affrontant des ennemis dangereux et en explorant des territoires inconnus.', 39.99, '/images/games/farcry.jpg', '2004-03-23', 1, 'Crytek', 'Ubisoft', 'PC, PlayStation, Xbox', 4.7, 40, 'OS: Windows 2000, CPU: Intel Pentium 4 2.0 GHz, RAM: 512 MB, GPU: NVIDIA GeForce 3', 'OS: Windows 10, CPU: Intel Core i7-3770, RAM: 8 GB, GPU: NVIDIA GeForce GTX 1060'),
('Among Us', 'Un jeu multijoueur en ligne ou les joueurs travaillent ensemble pour accomplir des taches tout en essayant de decouvrir qui parmi eux est l''imposteur.', 19.99, '/images/games/amongus.jpg', '2018-06-15', 3, 'Innersloth', 'Innersloth', 'PC, Mobile, Nintendo Switch', 4.5, 150, 'OS: Windows 7, CPU: Intel Core i3-530, RAM: 4 GB, GPU: NVIDIA GeForce 310M', 'OS: Windows 10, CPU: Intel Core i5-4460, RAM: 8 GB, GPU: NVIDIA GeForce GTX 660'),
('Resident Evil 7', 'Un jeu d''horreur en vue a la premiere personne. Explorez une maison hantée et survivez aux horreurs qui s''y trouvent.', 39.99, '/images/games/residentevil7.jpg', '2017-01-24', 8, 'Capcom', 'Capcom', 'PC, PlayStation, Xbox', 4.8, 50, 'OS: Windows 7, CPU: Intel Core i5-4460, RAM: 8 GB, GPU: NVIDIA GeForce GTX 760', 'OS: Windows 10, CPU: Intel Core i7-6700K, RAM: 16 GB, GPU: NVIDIA GeForce GTX 1060'),
('Amnesia: The Dark Descent', 'Un jeu d''horreur psychologique ou vous incarnez un homme amnesique qui explore un chateau en proie a des forces surnaturelles.', 19.99, '/images/games/amnesia.jpg', '2010-09-08', 8, 'Frictional Games', 'Frictional Games', 'PC, PlayStation', 4.6, 75, 'OS: Windows XP, CPU: Intel Core 2 Duo 2.4 GHz, RAM: 2 GB, GPU: NVIDIA GeForce 8600', 'OS: Windows 10, CPU: Intel Core i7-4770K, RAM: 8 GB, GPU: NVIDIA GeForce GTX 1070'),
('Outlast', 'Un jeu d''horreur a la premiere personne ou vous devez explorer un hopital psychiatrique abandonné tout en echappant aux dangers et en evitant les monstres.', 19.99, '/images/games/outlast.jpg', '2013-09-04', 8, 'Red Barrels', 'Red Barrels', 'PC, PlayStation, Xbox', 4.7, 60, 'OS: Windows 7, CPU: Intel Core i3-530, RAM: 4 GB, GPU: NVIDIA GeForce GTX 460', 'OS: Windows 10, CPU: Intel Core i7-4770K, RAM: 8 GB, GPU: NVIDIA GeForce GTX 1080'),
('Metal Gear Solid 2', 'Pour vous Mr Belkhir , je vous remercie deja pour le 20/20 .', 29.99, '/images/games/metal_gear_solid.jpg', '1998-10-21', 1, 'Konami', 'Mr Belkhir', 'PlayStation', 9.8, 30, 'OS: PlayStation, CPU: N/A, RAM: N/A, GPU: N/A', 'OS: PlayStation 4, CPU: Intel Core i7-7700K, RAM: 16 GB, GPU: NVIDIA GeForce GTX 1060'),
('Grand Fantasia', 'Un jeu specialement dedie a William  .', 5, '/images/games/GrandFantasia.jpeg', '2009-03-04', 8, 'X-LEGEND', 'Bougado', 'PC', 3, 1000, 'OS: Windows 1, CPU: Intel Core i3-530, RAM: 4 GB, GPU: NVIDIA GeForce GTX 460', 'OS: Windows 10, CPU: Intel Core i7-4770K, RAM: 8 GB, GPU: NVIDIA GeForce GTX 1080');
-- Insertion de quelques commandes de test


