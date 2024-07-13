SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `Data` (
  `Nombre` varchar(20) NOT NULL,
  `Apellidos` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `Data` (`Nombre`, `Apellidos`) VALUES  ('Nacho','Gonzalez'),('Laura','Martinez'),('Juan','Puig'),('Antonio','Moreno'),('Elena','Boronat');

