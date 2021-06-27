CREATE TABLE `registrations` (
  `id` int NOT NULL,
  `email` varchar(150) NOT NULL,
  `birthdate` date NOT NULL,
  `reigstration_number` int NOT NULL,
  `registration_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `registrations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;
