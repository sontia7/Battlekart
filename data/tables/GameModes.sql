SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

INSERT INTO `GameModes` (`Id`, `Name`) VALUES
(2, 'BattleRace'),
(4, 'BattleColor'),
(5, 'BattleFoot'),
(7, 'BattleSnake'),
(9, 'BattleVirus');

COMMIT;
