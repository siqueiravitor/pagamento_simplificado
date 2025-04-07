CREATE TABLE users (
	id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    cpf_cnpj VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    type ENUM('usuario', 'lojista') NOT NULL,
	created_at timestamp NULL DEFAULT current_timestamp(),
	updated_at timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);

CREATE TABLE transactions (
	id INT PRIMARY KEY AUTO_INCREMENT,
    id_payer INT NOT NULL,
	id_payee INT NOT NULL,
    value FLOAT(11,2) NOT NULL,
	created_at timestamp NULL DEFAULT current_timestamp(),
	updated_at timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  
	FOREIGN KEY (id_payer) REFERENCES users(id),
	FOREIGN KEY (id_payee) REFERENCES users(id)
);

CREATE TABLE wallets (
	id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    balance FLOAT(11,2) NOT NULL DEFAULT 0,
	created_at timestamp NULL DEFAULT current_timestamp(),
	updated_at timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  
	FOREIGN KEY (id_user) REFERENCES users(id)
);

INSERT INTO users (name, cpf_cnpj, email, password, type) VALUES (
    'Vitor Siqueira', '12345678912', 'vitor@email.com', '$2y$10$WehX6.lwCaL.DWoepm6brOw/dSBvMdvHnS1JE/EUrGrpJ.Bw8bmRC', 'usuario'
);