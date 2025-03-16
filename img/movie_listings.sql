-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2024 at 02:12 PM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `HNDCSSA17`
--

-- --------------------------------------------------------

--
-- Table structure for table `movie_listings`
--

CREATE TABLE IF NOT EXISTS `movie_listings` (
  `movie_id` int(20) NOT NULL,
  `movie_title` varchar(30) NOT NULL,
  `genre` varchar(30) NOT NULL,
  `age_rating` varchar(30) NOT NULL,
  `show1` varchar(6) NOT NULL,
  `show2` varchar(6) NOT NULL,
  `show3` varchar(6) NOT NULL,
  `theatre` varchar(20) NOT NULL,
  `further_info` varchar(1000) NOT NULL,
  `release` varchar(30) NOT NULL,
  `img` varchar(30) NOT NULL,
  `preview` varchar(300) NOT NULL,
  `mov_price` decimal(4,2) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '160',
  `id` int(10) DEFAULT NULL,
  PRIMARY KEY (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movie_listings`
--

INSERT INTO `movie_listings` (`movie_id`, `movie_title`, `genre`, `age_rating`, `show1`, `show2`, `show3`, `theatre`, `further_info`, `release`, `img`, `preview`, `mov_price`, `duration`, `id`) VALUES
(1, 'Star Wars: A New Hope', 'Sci-Fi', 'img\\pg.JPG', '14:00', '17:30', '20:45', 'I-Cinema room 1', 'A long time ago in a galaxy far, far away, a young farm boy named Luke Skywalker discovers his destiny when he joins a rebellion against the tyrannical Galactic Empire. Guided by the wisdom of Jedi Master Obi-Wan Kenobi, and accompanied by a roguish smuggler, Han Solo, and the fearless Princess Leia, Luke embarks on a perilous mission to destroy the Death Star, a planet-destroying weapon. Along the way, he discovers the power of the Force, confronts the sinister Darth Vader, and takes the first steps towards becoming a Jedi Knight. This epic adventure is a timeless tale of courage, hope, and the enduring fight for freedom.', '1977-05-25', 'img/1.jpg', 'https://www.youtube.com/embed/vZ734NWnAHA?si=JI2LMMBNupp0731N', 12.99, 160, NULL),
(2, 'Star Wars: The Empire Strikes ', 'Sci-Fi', 'img\\pg.JPG', '14:15', '17:45', '21:00', 'I-Cinema room 2', 'Star Wars: The Empire Strikes Back continues the legendary Star Wars saga, delving deeper into the eternal struggle between the forces of light and darkness. Set against a backdrop of intergalactic intrigue and breathtaking battles, this installment introduces new challenges for its heroes while unveiling shocking revelations about their pasts. Packed with thrilling action, heartfelt moments, and a narrative that keeps audiences on the edge of their seats, Star Wars: The Empire Strikes Back is a masterclass in storytelling. With stunning visuals and a sweeping score, this chapter cements its place as a fan favorite in the Star Wars universe.', '1980-05-21', 'img/2.jpg', 'https://www.youtube.com/embed/JNwNXF9Y6kY?si=PanEaotqVGKjgZvZ', 13.99, 160, NULL),
(3, 'Star Wars: Return of the Jedi', 'Sci-Fi', 'img\\pg.JPG', '13:30', '17:00', '20:30', 'Galaxy Cinema', 'Star Wars: Return of the Jedi delivers a spectacular conclusion to the original Star Wars trilogy, bringing the epic battle between the Rebel Alliance and the Galactic Empire to a thrilling climax. As Luke Skywalker confronts his destiny, he faces the ultimate test of courage and loyalty, pitting him against Darth Vader and the Emperor in a final showdown. With breathtaking battles, heartfelt reunions, and moments of profound sacrifice, Star Wars: Return of the Jedi is a celebration of hope and redemption. This film solidifies its place as a timeless classic, captivating audiences with its unforgettable characters, stunning visuals, and masterful storytelling.', '1983-05-25', 'img/3.jpg', 'https://www.youtube.com/embed/EcQKTTwLA-Y?si=YIB4pent4fYhD6-1" title=', 14.99, 160, NULL),
(4, 'Star Wars: The Phantom Menace', 'Sci-Fi', 'img\\pg.JPG', '12:00', '15:30', '19:00', 'Galaxy Cinema', 'A long-awaited prequel to the beloved Star Wars saga, Star Wars: The Phantom Menace takes audiences back to the beginning of the epic journey. Set in a time of political turmoil and rising tensions in the galaxy, the story follows Jedi Knights Qui-Gon Jinn and Obi-Wan Kenobi as they uncover a sinister plot orchestrated by the shadowy Sith. Introducing young Anakin Skywalker, a gifted child destined for greatness, the film explores themes of fate, power, and the fragile balance between light and darkness. Packed with dazzling visuals, iconic battles, and the legendary podrace, this chapter lays the foundation for an unforgettable galactic tale.', '1999-05-19', 'img/4.jpg', 'https://www.youtube.com/embed/J3kyYFHdRsM?si=jyEYpDTDfc6nC0aN" title=', 15.99, 160, NULL),
(5, 'Star Wars: Attack of the Clone', 'Sci-Fi', 'img\\pg.JPG', '14:30', '18:00', '21:30', 'Galaxy Cinema', 'The galaxy teeters on the brink of war in Star Wars: Attack of the Clones, as the Republic faces the growing threat of the Separatist movement led by Count Dooku. Amidst the chaos, Jedi Knight Obi-Wan Kenobi investigates a mysterious plot involving a secret army of clones, while Anakin Skywalker struggles with forbidden love and inner turmoil. As political intrigue deepens and alliances are tested, the film delivers breathtaking battles, thrilling chases, and pivotal moments that shape the destiny of the Star Wars saga. A tale of romance, betrayal, and the rise of darkness, this chapter sets the stage for the fall of the Republic and the emergence of the Empire.', '2002-05-16', 'img/5.jpg', 'https://www.youtube.com/embed/Wqtlf_A4cOc?si=tydnTqbo0zU1YNcb" title=', 16.99, 160, NULL),
(6, 'Star Wars: Revenge of the Sith', 'Sci-Fi', 'img\\12a.JPG', '13:00', '16:30', '20:00', 'Galaxy Cinema', 'Star Wars: Revenge of the Sith marks the dramatic and heartbreaking culmination of the prequel trilogy, chronicling the fall of Anakin Skywalker and the rise of Darth Vader. As the Clone Wars rage across the galaxy, Anakin is torn between his loyalty to the Jedi Order and his growing connection to the dark side under the influence of Chancellor Palpatine, who is revealed as the Sith Lord Darth Sidious. With stunning battles, emotional betrayals, and the tragic destruction of the Jedi, this chapter delivers a powerful narrative of loss, transformation, and the origins of the Galactic Empire. A masterpiece of action and drama, it is a pivotal moment in the Star Wars saga.', '2005-05-19', 'img/6.jpg', 'https://www.youtube.com/embed/P7PSSFq5F8w?si=YWx1R0h6iHPCMk_T" title=', 17.99, 160, NULL),
(7, 'Star Wars: The Force Awakens', 'Sci-Fi', 'img\\12a.JPG', '12:30', '16:00', '19:30', 'Galaxy Cinema', 'Set decades after the fall of the Galactic Empire, Star Wars: The Force Awakens introduces a new generation of heroes and villains while honoring the legacy of the original trilogy. Rey, a scavenger with a mysterious past, embarks on a journey of self-discovery and destiny as she crosses paths with Finn, a former stormtrooper, and Poe Dameron, a daring pilot of the Resistance. Together, they face the sinister First Order, led by the menacing Kylo Ren. With thrilling action, heartfelt reunions, and the search for the legendary Luke Skywalker, this chapter reignites the magic of Star Wars, capturing the spirit of adventure and hope for a new era.', '2015-12-18', 'img/7.jpg', 'https://www.youtube.com/embed/sGbxmsDFVnE?si=8ZZ9gGBU0leEMZqw" title=', 18.99, 160, NULL),
(8, 'Star Wars: The Last Jedi', 'Sci-Fi', 'img\\12a.JPG', '13:30', '17:00', '20:30', 'Galaxy Cinema', 'Star Wars: The Last Jedi delves deep into the conflict between the Resistance and the First Order, pushing beloved characters to their limits while exploring the complex legacy of the Jedi. Rey seeks guidance from the reclusive Luke Skywalker, grappling with her newfound powers and the mysteries of the Force. Meanwhile, Kylo Ren wrestles with his own identity, torn between light and darkness. With breathtaking battles, surprising twists, and emotional revelations, this chapter challenges expectations and redefines the boundaries of the Star Wars saga. A tale of sacrifice, redemption, and the enduring fight for freedom, The Last Jedi is both bold and unforgettable.', '2017-12-15', 'img/8.jpg', 'https://www.youtube.com/embed/Q0CbN8sfihY?si=rhtIxuhyG9C7Pnlf" title=', 19.99, 160, NULL),
(9, 'Star Wars: The Rise of Skywalk', 'Sci-Fi', 'img\\12a.JPG', '12:00', '15:30', '19:00', 'Galaxy Cinema', 'The Rise of Skywalker brings the epic Skywalker saga to a thrilling conclusion, as the Resistance faces its ultimate battle against the revived Emperor Palpatine and the overwhelming forces of the Final Order. Rey, now a fully realized Jedi, confronts her destiny and uncovers shocking truths about her lineage, while Kylo Ren grapples with the pull of redemption. Packed with stunning visuals, emotional reunions, and high-stakes action, this chapter weaves together threads from across the saga to deliver a powerful finale. A story of hope, courage, and the enduring strength of legacy, The Rise of Skywalker cements its place as a defining moment in the Star Wars universe.', '2019-12-20', 'img/9.jpg', 'https://www.youtube.com/embed/8Qn_spdM5Zg?si=0iFbEXnP9bE6UCRv" title=', 20.99, 160, NULL),
(101, 'Back to the Future', 'Sci-Fi', 'img\\12a.JPG', '10:00', '14:00', '18:00', 'Main Theatre', 'Marty McFly, a high school student, accidentally travels 30 years into the past in Doc Brown''s DeLorean time machine.', '1985-07-03', 'img/bttf1.jpg', 'https://www.youtube.com/embed/qvsgGtivCgs?si=nuxaz4QgGpPmhNvo', 10.99, 116, NULL),
(102, 'Back to the Future Part II', 'Sci-Fi', 'img\\12a.JPG', '11:00', '15:00', '19:00', 'Main Theatre', 'Marty and Doc travel to the future to prevent his son''s downfall, only to return to a darker 1985.', '1989-11-22', 'img/bttf2.jpg', 'https://www.youtube.com/embed/MdENmefJRpw?si=kHD4KOKRtRPztj7s', 11.99, 108, NULL),
(103, 'Back to the Future Part III', 'Sci-Fi', 'img\\12a.JPG', '12:00', '16:00', '20:00', 'Main Theatre', 'Marty travels to 1885 to save Doc Brown, but they face trouble in the Wild West.', '1990-05-25', 'img/bttf3.jpg', 'https://www.youtube.com/embed/EYkguxpqsrg?si=F3AWhKC7g4tCGm0y', 12.99, 118, NULL),
(204, 'A Beautiful Mind', 'Drama', 'img\\12a.JPG', '12:00', '16:00', '20:00', 'Drama Room', 'A brilliant mathematician, John Nash, struggles with schizophrenia and the challenges of living a normal life.', '2001-12-21', 'img/abeautifulmind.jpg', 'https://www.youtube.com/embed/aS_d0Ayjw4o?si=70afdL2TwqJyGHCc', 10.50, 135, NULL),
(205, 'The Pursuit of Happyness', 'Drama', 'img\\12a.JPG', '10:30', '14:30', '18:30', 'Inspiration Theatre', 'A struggling salesman takes custody of his son as he''s poised to begin a life-changing professional endeavor.', '2006-12-15', 'img/pursuitofhappyness.jpg', 'https://www.youtube.com/embed/89Kq8SDyvfg?si=RFDfv8DgIzDm9B5a', 9.99, 117, NULL),
(206, 'Slumdog Millionaire', 'Drama', 'img\\18.JPG', '13:00', '17:00', '21:00', 'City Cinema', 'A Mumbai teenager reflects on his life after being accused of cheating on the Indian version of "Who Wants to Be a Millionaire?".', '2008-11-12', 'img/slumdog.jpg', 'https://www.youtube.com/embed/AIzbwV7on6Q?si=7Jyxxj7xqN7rplXg', 11.99, 120, NULL),
(304, 'Monty Python and the Holy Grai', 'Comedy', 'img\\pg.JPG', '13:00', '17:00', '21:00', 'Classic Comedy Theat', 'A satirical take on the legend of King Arthur and his knights, filled with absurd humor and unforgettable scenes.', '1975-05-25', 'img/montypython.jpg', 'https://www.youtube.com/embed/urRkGvhXc8w?si=lZDXwyygzpM4S566', 8.50, 91, NULL),
(305, 'Airplane!', 'Comedy', 'img\\pg.JPG', '12:00', '16:00', '20:00', 'Laugh Classics Hall', 'A spoof of disaster movies where an ex-pilot is forced to land a plane after the crew falls ill. Iconic slapstick comedy!', '1980-07-02', 'img/airplane.jpg', 'https://www.youtube.com/embed/07pPmCfKi3U?si=rgk4p4SmPtB2Hl9U', 9.00, 88, NULL),
(310, 'Borat', 'Comedy', 'img\\18.JPG', '12:00', '16:00', '20:00', 'Laugh Lounge', 'A Kazakh journalist travels to the United States to make a documentary, encountering absurd situations along the way.', '2006-11-03', 'img/borat.jpg', 'https://www.youtube.com/embed/dL6_G1z6ymw?si=Jh_V6_sb5j3s3fR6', 10.00, 84, NULL),
(313, 'The Dictator', 'Comedy', 'img\\18.JPG', '11:30', '15:30', '19:30', 'Main Cinema', 'A ruthless dictator risks everything to prevent democracy from reaching his oppressed country, with hilarious consequences.', '2012-05-16', 'img/dictator.jpg', 'https://www.youtube.com/embed/cYplvwBvGA4?si=AEYXce0911UqPIsD', 11.00, 83, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
