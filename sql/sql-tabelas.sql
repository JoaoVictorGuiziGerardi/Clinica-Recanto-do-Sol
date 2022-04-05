CREATE TABLE base_enderecos
(
   id int PRIMARY KEY auto_increment,
   cep varchar(10),
   logradouro char(100),
   cidade varchar(50),
   estado varchar(3)
) ENGINE=InnoDB;

CREATE TABLE pessoa
(
   id int PRIMARY KEY auto_increment,
   nome varchar(50),
   sexo char(15),
   email varchar(50) UNIQUE,
   telefone varchar(16),
   cep varchar(10),
   logradouro char(100),
   cidade varchar(50),
   estado varchar(3)
) ENGINE=InnoDB;

CREATE TABLE paciente
(
   id_paciente int not null,
   peso float,
   altura int,
   tipo_sanguineo varchar(4),
   FOREIGN KEY (id_paciente) REFERENCES pessoa(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE funcionario
(
   id_funcionario int not null,
   data_contrato date,
   salario float,
   hash_senha varchar(255),
   FOREIGN KEY (id_funcionario) REFERENCES pessoa(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE medico
(
   id_medico int not null,
   especialidade varchar(20),
   crm varchar(15),
   FOREIGN KEY (id_medico) REFERENCES funcionario(id_funcionario) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE agenda
(
   id int PRIMARY KEY auto_increment,
   data_consulta date,
   horario_consulta time,
   nome_paciente varchar(50),
   sexo_paciente varchar(15),
   email varchar(50),
   id_medico int not null,
   FOREIGN KEY (id_medico) REFERENCES medico(id_medico) ON DELETE CASCADE
) ENGINE=InnoDB;

